<?php
class Log extends LoggableAppModel {

    var $name = 'Log';

    var $belongsTo = array(
        'Cookie' => array(
            'className' => 'Loggable.Cookie',
            'foreignKey' => 'cookie_id'
        ),
        'Host' => array(
            'className' => 'Loggable.Host',
            'foreignKey' => 'host_id'
        ),
        'Referrer' => array(
            'className' => 'Loggable.Referrer',
            'foreignKey' => 'referrer_id'
        ),
        'Url' => array(
            'className' => 'Loggable.Url',
            'foreignKey' => 'url_id'
        ),
        'UserAgent' => array(
            'className' => 'Loggable.UserAgent',
            'foreignKey' => 'user_agent_id'
        ),
        'Continent' => array(
            'className' => 'Loggable.Continent',
            'foreignKey' => 'continent_id'
        ),
        'Country' => array(
            'className' => 'Loggable.Country',
            'foreignKey' => 'country_id'
        ),
        'Region' => array(
            'className' => 'Loggable.Region',
            'foreignKey' => 'region_id'
        ),
        'City' => array(
            'className' => 'Loggable.city',
            'foreignKey' => 'city_id'
        ),
        'Language' => array(
            'className' => 'Loggable.Language',
            'foreignKey' => 'language_id'
        ),
        'Screen' => array(
            'className' => 'Loggable.Screen',
            'foreignKey' => 'Screen_id'
        ),
        'Available' => array(
            'className' => 'Loggable.Available',
            'foreignKey' => 'available_id'
        )
    );

    function beforeSave() {
        if(isset($this->data['Log']['ip'])) {
            $ip = explode('.', $this->data['Log']['ip']);
            $this->data['Log']['ip'] = (pow(256,3) * $ip[0]) + (pow(256,2) * $ip[1]) + (256 * $ip[2]) + $ip[3];
        }
        return true;
    }

    function afterFind($results, $primary) {
        if (isset($results['Log']['ip'])) {
            $ip = (float)$results['Log']['ip'];
            $results['Log']['ip'] = floor($ip / 16777216) % 256 . "." . floor($ip / 65536) % 256 . "." . floor($ip / 256) % 256 . "." . floor($ip) % 256;
        } elseif (is_array($results)) {
            foreach ($results as $key => $result) {
                if (isset($result['Log']['ip'])) {
                    $ip = (float)$result['Log']['ip'];
                    $results[$key]['Log']['ip'] = (int)($ip / 16777216) % 256 . "." . (int)($ip / 65536) % 256 . "." . (int)($ip / 256) % 256 . "." . (int)($ip) % 256;
                }
            }
        }
        return $results;
    }

    function beforeFind($data) {
        if (isset($data['conditions']['ip'])) {
            $ip = explode('.', $data['conditions']['ip']);
            $data['conditions']['ip'] = (pow(256,3) * $ip[0]) + (pow(256,2) * $ip[1]) + (256 * $ip[2]) + $ip[3];
        } elseif (isset($data['conditions']['Log.ip'])) {
            $ip = explode('.', $data['conditions']['Log.ip']);
            $data['conditions']['Log.ip'] = (pow(256,3) * $ip[0]) + (pow(256,2) * $ip[1]) + (256 * $ip[2]) + $ip[3];
        }
        return $data;
    }

}
