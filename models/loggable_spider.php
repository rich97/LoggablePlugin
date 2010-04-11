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
            'Purity Search' => 'www.puritysearch.net', 'Alexa' => 'ia_archiver',
            'Panscient' => 'panscient.com', 'Thunder Stone', 'search.thunderstone.com',
            'Discovery' => 'discoveryengine.com', 'Blecko' => 'ScoutJet',
            'Baidu' => 'Baiduspider', '80 Legs' => '008/0.83', 'SEO Profiler' => 'spbot',
            'Linguee' => 'Linguee', 'DotNetDotCom' => 'DotBot', 'Cuil' => 'Twiceler'
        );
        foreach ($spiders as $return=>$value) {
            if (preg_match('#' . preg_quote($value) . '#i', $useragent)) {
                return array('spider' => $return);
            }
        }
        return array();
    }

}
