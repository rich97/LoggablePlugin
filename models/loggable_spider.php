<?php
class LoggableSpider extends LoggableAppModel {
    var $name = 'LoggableSpider';

    var $hasMany = array(
        'LoggableUserAgent' => array(
            'className'     => 'Loggable.LoggableUserAgent',
            'foreignKey'    => 'spider_id'
        )
    );

    function uniqueId($useragent) {
        $spider = $this->getSpider($useragent);
        return parent::uniqueId($spider);
    }

    function getSpider($useragent) {
        $spiders = array(
            'Google Images' => 'Googlebot-Image', 'Google' => 'Googlebot',
            'Bing' => 'msnbot', 'Yahoo!' => 'Yahoo!', 'Yandex' => 'Yandex',
            'Speedy Spider' => 'Speedy Spider', 'AiHit' => 'www.aihit.com',
            'Purity Search' => 'www.puritysearch.net',
        );
        foreach ($spiders as $return=>$value) {
            if (preg_match('#' . preg_quote($value) . '#i', $useragent)) {
                return array('spider' => $return);
            }
        }
        return array();
    }

}
