<?php
class LoggableLog extends LoggableAppModel {

    var $name = 'LoggableLog';

    var $belongsTo = array(
        'LoggableCookie' => array(
            'className' => 'Loggable.LoggableCookie',
            'foreignKey' => 'cookie_id'
        ),
        'LoggableHost' => array(
            'className' => 'Loggable.LoggableHost',
            'foreignKey' => 'host_id'
        ),
        'LoggableReferrer' => array(
            'className' => 'Loggable.LoggableReferrer',
            'foreignKey' => 'referrer_id'
        ),
        'LoggableUrl' => array(
            'className' => 'Loggable.LoggableUrl',
            'foreignKey' => 'url_id'
        ),
        'LoggableUserAgent' => array(
            'className' => 'Loggable.LoggableUserAgent',
            'foreignKey' => 'user_agent_id'
        ),
        'LoggableContinent' => array(
            'className' => 'Loggable.LoggableContinent',
            'foreignKey' => 'continent_id'
        ),
        'LoggableCountry' => array(
            'className' => 'Loggable.LoggableCountry',
            'foreignKey' => 'country_id'
        ),
        'LoggableRegion' => array(
            'className' => 'Loggable.LoggableRegion',
            'foreignKey' => 'region_id'
        ),
        'LoggableCity' => array(
            'className' => 'Loggable.LoggableCity',
            'foreignKey' => 'city_id'
        ),
        'LoggableLanguage' => array(
            'className' => 'Loggable.LoggableLanguage',
            'foreignKey' => 'language_id'
        ),
        'LoggableScreen' => array(
            'className' => 'Loggable.LoggableScreen',
            'foreignKey' => 'Screen_id'
        ),
        'LoggableAvailable' => array(
            'className' => 'Loggable.LoggableAvailable',
            'foreignKey' => 'available_id'
        )
    );

    function beforeSave() {
        if(isset($this->data['LoggableLog']['ip'])) {
            $ip = explode('.', $this->data['LoggableLog']['ip']);
            $this->data['LoggableLog']['ip'] = (pow(256,3) * $ip[0]) + (pow(256,2) * $ip[1]) + (256 * $ip[2]) + $ip[3];
        }
        return true;
    }

    function afterFind($results, $primary) {
        if (isset($results['LoggableLog']['ip'])) {
            $ip = (float)$results['LoggableLog']['ip'];
            $results['LoggableLog']['ip'] = floor($ip / 16777216) % 256 . "." . floor($ip / 65536) % 256 . "." . floor($ip / 256) % 256 . "." . floor($ip) % 256;
        } elseif (is_array($results)) {
            foreach ($results as $key => $result) {
                if (isset($result['LoggableLog']['ip'])) {
                    $ip = (float)$result['LoggableLog']['ip'];
                    $results[$key]['LoggableLog']['ip'] = (int)($ip / 16777216) % 256 . "." . (int)($ip / 65536) % 256 . "." . (int)($ip / 256) % 256 . "." . (int)($ip) % 256;
                }
            }
        }
        return $results;
    }

    function beforeFind($data) {
        if (isset($data['conditions']['ip'])) {
            $ip = explode('.', $data['conditions']['ip']);
            $data['conditions']['ip'] = (pow(256,3) * $ip[0]) + (pow(256,2) * $ip[1]) + (256 * $ip[2]) + $ip[3];
        } elseif (isset($data['conditions']['LoggableLog.ip'])) {
            $ip = explode('.', $data['conditions']['LoggableLog.ip']);
            $data['conditions']['LoggableLog.ip'] = (pow(256,3) * $ip[0]) + (pow(256,2) * $ip[1]) + (256 * $ip[2]) + $ip[3];
        }
        return $data;
    }

}
