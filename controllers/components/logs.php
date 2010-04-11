<?php
class LogsComponent extends Object {

    var $components = array('Session', 'Cookie', 'RequestHandler');
    var $user = 0;
    var $enabled = true;

    function startup(&$controller) {
        $this->Session->delete('Loggable.code');
        if ($this->enabled && $this->isStandard()) {
            // Get the Log model
            $this->Log = ClassRegistry::init('Loggable.Log');

            // Is this a returning user?
            $this->returning = (int)($this->Cookie->read('Loggable.visitor') !== null &&
                $this->Session->check('Loggable.page') === false);

            // Add Cookie if it's not already there, else update cookie with new timeout
            if ($this->Cookie->read('Loggable.visitor') === null) {
                // Get and save a unique hash - microtime for quick changing, ip to try and reduce
                // clashes from simultaneous requests.
                $this->Log->Cookie->recursive = -1;
                do {
                    $visit = Security::hash(microtime() . env('REMOTE_ADDR'), 'sha256', true);
                } while ($this->Log->Cookie->find('count',
                    array(
                        'conditions' => array(
                            'Cookie.cookie' => $visit
                        )
                    )
                ) !== 0) ;
            } else {
                $visit = $this->Cookie->read('Loggable.visitor');
            }
            $this->Cookie->write('Loggable.visitor', $visit, false, '+1 month');

            // Check for page number and update
            if ($this->Session->check('Loggable.page') === false) {
                $this->Session->write('Loggable.page', 1);
            } else {
                $this->Session->write('Loggable.page', ($this->Session->read('Loggable.page') + 1));
            }

            $this->Log->recursive = -1;
            do {
                $visit = Security::hash('1' . microtime() . env('REMOTE_ADDR'), 'sha256', true);
            } while ($this->Log->find('count',
                array(
                    'conditions' => array(
                        'Log.code' => $visit
                    )
                )
            ) !== 0) ;
            $this->Session->write('Loggable.code', $visit);

            $this->user_agent = env('HTTP_USER_AGENT');
            if ($this->user_agent === null) {
                $this->user_agent = 'Unknown';
            }
            $this->referrer = env('HTTP_REFERER');
            if ($this->referrer === null) {
                $this->referrer = 'Direct';
            }

            $this->geo = json_decode(substr(file_get_contents('http://www.geoplugin.net/json.gp?ip=' . env('REMOTE_ADDR')), 10, -1), true);

            // Save variables
            $this->Log->save(array('Log' => array(
                'ip' => env('REMOTE_ADDR'),
                'session_id' => $this->getSessionId(),
                'user_id' => $this->user,
                'page_no' => $this->Session->read('Log.page'),
                'returning' => $this->returning,
                'code' => $visit,
                'cookie_id' => $this->Log->Cookie->uniqueId(array('cookie' => $this->Cookie->read('Loggable.visitor'))),
                'host_id' => $this->Log->Host->uniqueId(array('host' => env('HTTP_HOST') . Router::url('/'))),
                'referrer_id' => $this->Log->Referrer->uniqueId(array('referrer' => $this->referrer)),
                'url_id' => $this->Log->Url->uniqueId(array('url' => substr(env('REQUEST_URI'), strlen(Router::url('/'))))),
                'user_agent_id' => $this->Log->UserAgent->uniqueId(array('user_agent' => $this->user_agent)),
                'continent_id' => $this->Log->Continent->uniqueId(array('continent' => $this->geo['geoplugin_continentCode'])),
                'country_id' => $this->Log->Country->uniqueId(array('code' => $this->geo['geoplugin_countryCode'], 'country' => $this->geo['geoplugin_countryName'])),
                'region_id' => $this->Log->Region->uniqueId(array('code' => $this->geo['geoplugin_regionCode'], 'region' => $this->geo['geoplugin_regionName'])),
                'city_id' => $this->Log->City->uniqueId(array('city' => $this->geo['geoplugin_city'])),
                'latitude' => $this->geo['geoplugin_latitude'],
                'longitude' => $this->geo['geoplugin_longitude'],
            )));
        }
    }

    function userId($id) {
        if (!is_numeric($id)) {
            return false;
        } else {
            $this->user = (int)$id;
            return true;
        }
    }

    function isStandard() {
        return (!$this->RequestHandler->isAjax() &&
         !$this->RequestHandler->isAtom() &&
         !$this->RequestHandler->isRss());
    }

    function getSessionId() {
        if ($this->Session->check('Loggable.visit')) {
            return $this->Session->read('Loggable.visit');
        }
        $find = $this->Log->find('first', array(
            'fields' => array(
                'Log.session_id',
                'Log.page_no'
            ),
            'conditions' => array(
                'Log.ip' => env('REMOTE_ADDR'),
                'Log.user_agent_id' => $this->Log->UserAgent->uniqueId(array('user_agent' => $this->user_agent)),
                'Log.created >' => date('Y-m-d H:i:s', time() - 300)
            ),
            'order' => array(
                'Log.created' => 'DESC'
            )
        ));
        if ($find !== false) {
            $this->Session->write('Loggable.visit', (int)$find['Log']['session_id']);
            $this->Session->write('Loggable.page', ((int)$find['Log']['page_no'] + 1));
            return (int)$find['Log']['session_id'];
        }
        $find = $this->Log->find('first', array(
            'fields' => array(
                'Log.session_id'
            ),
            'order' => array(
                'Log.session_id' => 'DESC'
            )
        ));
        if ($find !== false) {
            $this->Session->write('Loggable.visit', ((int)$find['Log']['session_id'] + 1));
            return ((int)$find['Log']['session_id'] + 1);
        }
        $this->Session->write('Loggable.visit', 1);
        return 1;
    }
}
