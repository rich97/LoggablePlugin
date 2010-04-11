<?php
class LogsController extends LoggableAppController {

    var $name = 'Logs';
    var $components = array('Cookie');

    function index() {
        $startDate = date('Y-m-d H:i:s', $this->Session->read('Loggable.startDate'));
        $endDate = date('Y-m-d H:i:s', $this->Session->read('Loggable.endDate'));

        $results = array();
        $this->Log->recursive = -1;
        $tmp = $this->Log->find('all', array(
            'contain' => array('UserAgent'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0
            ),
            'fields' => array(
                "DATE_FORMAT(Log.created, '%Y-%c-%e') AS `date`",
                'COUNT(Log.id) AS `pages`',
            ),
            'group' => "DATE_FORMAT(Log.created, '%Y-%c-%e')",
        ));
        $pages = array();
        foreach ($tmp as $array) {
            $pages[$array[0]['date']] = $array[0]['pages'];
        }
        $tmp = $this->Log->find('all', array(
            'contain' => array('UserAgent'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1
            ),
            'fields' => array(
                "DATE_FORMAT(Log.created, '%Y-%c-%e') AS `date`",
                'COUNT(Log.id) AS `pages`'
            ),
            'group' => "DATE_FORMAT(Log.created, '%Y-%c-%e')"
        ));
        $visits = array();
        foreach ($tmp as $array) {
            $visits[$array[0]['date']] = $array[0]['pages'];
        }
        $tmp = $this->Log->find('all', array(
            'contain' => array('UserAgent'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1,
                'Log.returning' => 1
            ),
            'fields' => array(
                "DATE_FORMAT(Log.created, '%Y-%c-%e') AS `date`",
                'COUNT(Log.id) AS `pages`'
            ),
            'group' => "DATE_FORMAT(Log.created, '%Y-%c-%e')"
        ));
        $returns = array();
        foreach ($tmp as $array) {
            $returns[$array[0]['date']] = $array[0]['pages'];
        }
        $start = $this->Session->read('Loggable.startDate');
        $end = (int)date('Ymd', $this->Session->read('Loggable.endDate'));
        $results = array();
        while ((int)date('Ymd', $start) <= $end) {
            $array = array();
            $day1 = date('Y-n-j', $start);
            $day2 = date('j-n-Y', $start);
            foreach (array('pages', 'visits', 'returns') as $var) {
                if (isset(${$var}[$day1])) {
                    $array[$var] = (int)${$var}[$day1];
                }
            }
            $results[$day2] = array_merge(array('pages' => 0, 'visits' => 0, 'returns' => 0), $array);
            $start += DAY;
        }
        $this->set('mainresults', $results);
        $this->Log->bindModel(array(
            'belongsTo' => array(
                'Browser' => array(
                    'foreignKey' => false,
                    'conditions' => 'UserAgent.browser_id = Browser.id'
                )
            )
        ));
        $browsers = $this->Log->find('all', array(
            'contain' => array('UserAgent', 'Browser'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1
            ),
            'order' => 'CONCAT(Browser.browser, ": ", Browser.version) ASC',
            'fields' => array(
                'COUNT(Log.id) as `count`',
                'CONCAT(Browser.browser, ": ", Browser.version) AS `browser`'
            ),
            'group' => 'CONCAT(Browser.browser, ": ", Browser.version)'
        ));
        $this->set('browserresults', $browsers);
        $this->Log->unbindModel(array(
            'hasOne' => array(
                'Browser'
            )
        ));
        $this->Log->bindModel(array(
            'belongsTo' => array(
                'OperatingSystem' => array(
                    'foreignKey' => false,
                    'conditions' => 'UserAgent.operating_system_id = OperatingSystem.id'
                )
            )
        ));
        $oss = $this->Log->find('all', array(
            'contain' => array('UserAgent', 'OperatingSystem'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1
            ),
            'order' => 'CONCAT(OperatingSystem.operating_system, ": ", OperatingSystem.version) ASC',
            'fields' => array(
                'COUNT(Log.id) as `count`',
                'CONCAT(OperatingSystem.operating_system, ": ", OperatingSystem.version) AS `system`'
            ),
            'group' => 'CONCAT(OperatingSystem.operating_system, ": ", OperatingSystem.version)'
        ));
        $this->set('osresults', $oss);
        $results = array();
        $results['views'] = $this->Log->find('count', array(
            'contain' => 'UserAgent',
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0
            )
        ));
        $results['visits'] = $this->Log->find('count', array(
            'contain' => 'UserAgent',
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1
            )
        ));
        $results['bounces'] = ($results['visits'] - $this->Log->find('count', array(
            'contain' => 'UserAgent',
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 2
            )
        )));
        $results['new'] = $this->Log->find('first', array(
            'contain' => 'UserAgent',
            'fields' => 'COUNT(DISTINCT Log.cookie_id) AS `count`',
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1,
                'Log.returning' => 0
            )
        ));
        $results['new'] = $results['new'][0]['count'];
        $results['unique'] = $this->Log->find('first', array(
            'contain' => 'UserAgent',
            'fields' => 'COUNT(DISTINCT Log.cookie_id) AS `count`',
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0
            )
        ));
        $results['unique'] = $results['unique'][0]['count'];
        $this->set('results', $results);
        $this->Log->unbindModel(array(
            'hasOne' => array(
                'OperatingSystem'
            )
        ));
        $referrers = $this->Log->find('all', array(
            'contain' => array('Referrer', 'UserAgent'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0,
                'Log.page_no' => 1
            ),
            'fields' => array(
                'COUNT(Log.id) as `count`',
                'Referrer.referrer'
            ),
            'group' => 'Referrer.referrer',
            'order' => array(
                'COUNT(Log.id) DESC',
                'Log.created DESC'
            ),
            'limit' => 10
        ));
        $this->set('referrerresults', $referrers);
        $urls = $this->Log->find('all', array(
            'contain' => array('Url', 'Host', 'UserAgent'),
            'conditions' => array(
                'Log.created <' => $endDate,
                'Log.created >' => $startDate,
                'UserAgent.spider_id' => 0
            ),
            'fields' => array(
                'COUNT(Log.id) as `count`',
                'CONCAT(Host.host, Url.url) as `url`'
            ),
            'group' => 'CONCAT(Host.host, Url.url)',
            'order' => array(
                'COUNT(Log.id) DESC',
                'Log.created DESC'
            ),
            'limit' => 10
        ));
        $this->set('urlresults', $urls);
    }

    function recent($filter = null, $id = null) {
        $this->paginate['Log'] = array(
            'limit' => 15,
            'order' => array(
                'Log.created' => 'DESC'
            ),
            'contain' => array(
                'Browser',
                'City',
                'Continent',
                'Country',
                'Host',
                'OperatingSystem',
                'Referrer',
                'Region',
                'Url',
                'UserAgent'
            ),
            'conditions' => array(
                'Log.created <' => date('Y-m-d H:i:s', $this->Session->read('Loggable.endDate')),
                'Log.created >' => date('Y-m-d H:i:s', $this->Session->read('Loggable.startDate')),
                'UserAgent.spider_id' => 0
            ),
            'fields' => array(
                'Log.created',
                'Log.returning',
                'Log.page_no',
                'Log.ip',
                'Log.user_id',
                'Log.javascript',
                'Log.latitude',
                'Log.longitude',
                'Host.host',
                'Referrer.referrer',
                'Url.url',
                'UserAgent.user_agent',
                'Continent.continent',
                'Country.country',
                'Region.region',
                'City.city',
                'Browser.browser',
                'Browser.version',
                'OperatingSystem.operating_system',
                'OperatingSystem.version'
            )
        );
        if ($filter !== null && is_numeric($id)) {
            switch ($filter) {
                case 'url':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'ip':
                    $this->paginate['Log']['conditions']['Log.ip'] = $id;
                    break;
                case 'type':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'javascript':
                    $this->paginate['Log']['conditions']['Log.javascript'] = $id;
                    break;
                case 'referrer':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'useragent':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'continent':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'country':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'city':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'region':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'browser':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
                case 'system':
//                    $this->paginate['Log']['conditions']['ip'] => $id;
                    break;
            }
        }
        $this->Log->bindModel(array(
            'belongsTo' => array(
                'Browser' => array(
                    'foreignKey' => false,
                    'conditions' => 'UserAgent.browser_id = Browser.id'
                ),
                'OperatingSystem' => array(
                    'foreignKey' => false,
                    'conditions' => 'UserAgent.operating_system_id = OperatingSystem.id'
                ),
                'SearchEngine' => array(
                    'foreignKey' => false,
                    'conditions' => 'Referrer.search_engine_id = SearchEngine.id'
                )
            )
        ));
        $views = $this->paginate('Log');
        $this->set('views', $views);
    }

    function js() {
        foreach ($this->passedArgs as $key=>$val) {
            if (substr($key, 0, 2) === '64') {
                $this->passedArgs[substr($key, 2)] = base64_decode($val);
                unset($this->passedArgs[$key]);
            }
        }
        if (!isset($this->passedArgs['code']) || empty($this->passedArgs['code'])) {
            die();
        }
        $pass = array_merge(
            array(
                'lang' => null,
                'width' => null,
                'height' => null,
                'avwidth' => null,
                'avheight' => null,
                'colour' => null
            ), $this->passedArgs
        );
        $log = $this->Log->find('first', array(
            'conditions' => array(
                'code' => $pass['code'],
                'page_no' => $this->Session->read('Loggable.page'),
                'ip' => env('REMOTE_ADDR'),
                'created >' => date('Y-m-d H:i:s', strtotime('-1 min'))
            ),
            'fields' => 'id',
            'recursive' => -1
        ));
        if ($log !== false) {
            $this->Log->save(array(
                'Log' => array(
                    'id' => $log['Log']['id'],
                    'javascript' => 1,
                    'code' => '',
                    'language_id' => $this->Log->Language->uniqueId(array('language' => $pass['lang'])),
                    'screen_id' => $this->Log->Screen->uniqueId(array('width' => $pass['width'], 'height' => $pass['height'])),
                    'available_id' => $this->Log->Available->uniqueId(array('width' => $pass['avwidth'], 'height' => $pass['avheight'])),
                    'colour' => $pass['colour']
                )
            ));
        }
        die();
    }
}
