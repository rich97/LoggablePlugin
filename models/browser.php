<?php
class LoggableBrowser extends LoggableAppModel {

    var $name = 'LoggableBrowser';
    var $hasMany = array(
        'LoggableUserAgent' => array(
            'className'     => 'Loggable.LoggableUserAgent',
            'foreignKey'    => 'browser_id'
        )
    );

    function uniqueId($useragent) {
        $browser = $this->getBrowser($useragent);
        return parent::uniqueId($browser);
    }
    
    function getBrowser($useragent) {
        $browsers = array(
            'ABrowse', 'Acoo Browser', 'Amaya', 'America Online Browser',
            'Amiga Voyager' => 'AmigaVoyager', 'AOL', 'Arora', 'Avant Browser', 'Beonex',
            'BlackBerry', 'Blazer', 'Bolt', 'BonEcho', 'Camino', 'Cayman Browser',
            'Cheshire', 'Chimera', 'Chrome', 'CometBird', 'Crazy Browser', 'Cruz',
            'Cyberdog', 'Deepnet Explorer', 'Dillo', 'Elinks', 'Enigma Browser',
            'Epiphany', 'Fennec', 'Firebird', 'Flock', 'Fluid', 'Galaxy', 'Galeon',
            'GoSurf', 'GranParadiso', 'GreenBrowser', 'Hana', 'HotJava',
            'IBM WebExplorer', 'IBrowse', 'iCab', 'IceApe', 'IceCat', 'IceWeasel',
            'IEMobile', 'Iron', 'K-Meleon', 'K-Ninja', 'Kapiko', 'Kazehakase', 'KKman',
            'KMail', 'KMLite', 'Konqueror', 'Links', 'Lobo', 'Lolifox', 'Lunascape',
            'Lynx', 'Maxthon', 'MIB', 'Midori', 'Minefield', 'Minimo', 'Mosaic',
            'MultiZilla', 'MyIE2', 'Navigator', 'NetFront', 'NetNewsWire',
            'NetPositive', 'Netscape', 'NetSurf', 'NetFront' => 'NF-Browser', 'Obigo',
            'OmniWeb', 'Opera', 'Orca', 'Oregano', 'Pre', 'Phoenix', 'Polaris',
            'QtWeb Internet Browser', 'retawq', 'Safari', 'SeaMonkey',
            'SEMC Browser' => 'SEMC-Browser', 'Shiira', 'Shiretoko', 'Sleipnir',
            'SlimBrowser', 'Songbird', 'Stainless', 'Sunrise', 'Swiftfox', 'TeaShark',
            'TheWorld', 'Thunderbird', 'uBrowser', 'UC Browser' => 'UCWEB',
            'Openwave Mobile Browser' => 'UP.Browser', 'w3m', 'WorldWideWeb', 'Wyzo'
        );
        $return = $this->getBrowserInfo($useragent, $browsers);
        if ($return !== false) {
            return $return;
        }
        $browsers = array(
            'Firefox', 'Internet Explorer' => 'MSIE'
        );
        $return = $this->getBrowserInfo($useragent, $browsers);
        if ($return !== false) {
            return $return;
        }
        if (preg_match('/Mozilla/i', $useragent)) {
            $title="Mozilla Compatible";
            $version = "Unknown";
            if (preg_match('/rv:([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) {
                $title="Mozilla";
                $version = $regmatch[1];
            }
            return array('browser' => $title, 'version' => $version);
        }
        return array('browser' => 'Unknown', 'version' => 'Unknown');
    }

    function getBrowserInfo($useragent, $browsers) {
        foreach ($browsers as $display => $browser) {
            if (preg_match('#' . preg_quote($browser) . '#i', $useragent)) {
                $version = $this->getBrowserVersion($useragent, $browser);
                if (is_int($display)) {
                    $title = $browser;
                } else {
                    $title = $display;
                }
                return array('browser' => $title, 'version' => $version);
            }
        }
        return false;
    }

    function getBrowserVersion($useragent, $browser) {
        $useragent = strtolower($useragent);
        $browser = strtolower($browser);
        if ($browser === 'maxthon' && preg_match('/Maxthon;/i', $useragent)) {
            return 'Unknown';
        }
        if (preg_match('#Version#i', $useragent) && ($browser === 'opera' || $browser === 'safari' || $browser === 'pre')) {
            $start = 'version';
        } else {
            $start = $browser;
        }
        $version = substr($useragent,strpos($useragent,$start)+strlen($start)+1);
        if (strpos($version,";")) {
            $version = substr($version,0,strpos($version,";"));
        } elseif (strpos($version,")")) {
            $version = substr($version,0,strpos($version,")"));
        }
        if (strpos($version," ")) {
            $version = substr($version,0,strpos($version," "));
        }
        return $version;
    }

}
