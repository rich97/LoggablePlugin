<?php
class LoggableOperatingSystem extends LoggableAppModel {

    var $name = 'LoggableOperatingSystem';
    var $hasMany = array(
        'LoggableUserAgent' => array(
            'className'     => 'Loggable.LoggableUserAgent',
            'foreignKey'    => 'operating_system_id'
        )
    );

    function uniqueId($useragent) {
        $OS = $this->getOS($useragent);
        return parent::uniqueId($OS);
    }

    function getOS($useragent) {
        if (preg_match('/Windows/i', $useragent) || preg_match('/WinNT/i', $useragent) || preg_match('/Win32/i', $useragent)) {
            $title = 'Windows';
            if (preg_match('/NT 6.1; Win64; x64;/i', $useragent) || preg_match('/NT 6.1; WOW64;/i', $useragent)) {
                $version = "7 x64 Edition";
            } elseif (preg_match('/NT 6.1/i', $useragent)) {
                $version = "7";
            } elseif (preg_match('/NT 6.0/i', $useragent)) {
                $version = "Vista";
            } elseif (preg_match('/NT 5.2 x64/i', $useragent)) {
                $version = "XP x64 Edition";
            } elseif (preg_match('/NT 5.2/i', $useragent)) {
                $version = "Server 2003";
            } elseif (preg_match('/NT 5.1/i', $useragent) || preg_match('/XP/i', $useragent)) {
                $version = "XP";
            } elseif (preg_match('/NT 5.01/i', $useragent)) {
                $version = "2000, Service Pack 1 (SP1)";
            } elseif (preg_match('/NT 5.0/i', $useragent) || preg_match('/2000/i', $useragent)) {
                $version = "2000";
            } elseif (preg_match('/NT 4.0/i', $useragent) || preg_match('/WinNT4.0/i', $useragent)) {
                $version = "NT 4.0";
            } elseif (preg_match('/NT 3.51/i', $useragent) || preg_match('/WinNT3.51/i', $useragent)) {
                $version = "NT 3.11";
            } elseif (preg_match('/3.11/i', $useragent) || preg_match('/Win3.11/i', $useragent) || preg_match('/Win16/i', $useragent)) {
                $version = "3.11";
            } elseif (preg_match('/3.1/i', $useragent)) {
                $version = "3.1";
            } elseif (preg_match('/98; Win 9x 4.90/i', $useragent) || preg_match('/Win 9x 4.90/i', $useragent) || preg_match('/ME/i', $useragent)) {
                $version = "Millennium Edition (Windows Me)";
            } elseif (preg_match('/Win98/i', $useragent)) {
                $version = "98 SE";
            } elseif (preg_match('/98/i', $useragent) || preg_match('/4.10/i', $useragent)) {
                $version = "98";
            } elseif (preg_match('/95/i', $useragent) || preg_match('/Win95/i', $useragent)) {
                $version = "95";
            } elseif (preg_match('/CE/i', $useragent)) {
                $version = "CE";
            } else {
                $version = "Unknown";
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/Mac/i', $useragent) || preg_match('/Darwin/i', $useragent)) {
            $title = 'Macintosh';
            if (preg_match('/OS X/i', $useragent)) {
                $version = substr($useragent, strpos(strtolower($useragent), strtolower("OS X")));
                $version = substr($version, 0, strpos($version, ";"));
                $version = str_replace("_", ".", $version); 
            } elseif (preg_match('/OSX/i', $useragent)){
                $version = substr($useragent, strpos(strtolower($useragent), strtolower("OSX")));
                $version = substr($version, 0, strpos($version, ";"));
                $version = str_replace("_", ".", $version); 
            } elseif (preg_match('/Darwin/i', $useragent)) {
                $version = "OS Darwin";
            } else {
                $version = "Unknown";
            }
            return array('operating_system' => $title, 'version' => $version);
        }
        $OS = array(
            'Android', 'Arch Linux' => 'Arch', 'BeOS', 'Debian GNU/Linux' => 'Debian',
            'DragonFly BSD' => 'DragonFly', 'FreeBSD', 'Gentoo', 'Kanotix', 'Knoppix',
            'LindowsOS', 'Linspire', 'Motorola' => 'MOT', 'Motorola' => 'MIB', 'NetBSD',
            'Nintendo DSi', 'Nintendo Wii', 'Nokia', 'OLPC (XO)' => 'OLPC', 'OpenBSD',
            'Palm', 'Sabayon', 'Slackware', 'Solaris', 'SunOS', 'SuSE' => 'Suse',
            'VectorLinux', 'Venenux', 'Palm webOS' => 'webOS', 'Zenwalk'
        );
        $return = $this->getOSInfo($useragent, $OS);
        if ($return !== false) {
            return $return;
        }
        if (preg_match('/\bCentOS/', $useragent)) {
            $title = "CentOS";
            if (preg_match('#\.el([.0-9a-zA-Z]+).centos#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bEdubuntu/', $useragent)) {
            $title = "Edubuntu";
            if (preg_match('#Edubuntu/([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bFedora/', $useragent)) {
            $title = "Fedora";
            if (preg_match('#\.fc([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\biPhone/', $useragent)) {
            $title = "iPhone";
            if (preg_match('#iPhone\ OS\ ([.\_0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $title = 'iPhone OS';
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bKubuntu/', $useragent)) {
            $title = "Kubuntu";
            if (preg_match('#Kubuntu/([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bLinux Mint/', $useragent)) {
            $title = "Linux Mint";
            if (preg_match('#Linux Mint/([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bMandriva/', $useragent)) {
            $title = "Mandriva";
            if (preg_match('#mdv([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bOracle/', $useragent)) {
            $title = "Oracle ";
            if(preg_match('#\.el([._0-9a-zA-Z]+)#i',$useragent,$regmatch)) {
                $title .= "Enterprise Linux";
                $version = str_replace("_", ".", $regmatch[1]);
            } else {
               $title .= "Linux";
               $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bPlaystation/', $useragent)) {
            if (preg_match('/Playstation 3/i', $useragent) || preg_match('/PS3/i', $useragent)) {
                $title = "Playstation 3";
            } elseif (preg_match('/Playstation Portable/i', $useragent) || preg_match('/PSP/i', $useragent)) {
                $title="Playstation Portable";
            }
            return array('operating_system' => $title, 'version' => 'Unknown');
        } elseif (preg_match('/\bRed Hat/', $useragent)) {
            $title = "Red Hat";
            if (preg_match('#\.el([._0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $title .= " Enterprise Linux";
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bSymbianOS/', $useragent)) {
            $title = "SymbianOS";
            if (preg_match('#SymbianOS/([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bXubuntu/', $useragent)) {
            $title = "Xubuntu";
            if (preg_match('#Xubuntu/([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('/\bUbuntu/', $useragent)) {
            $title = "Ubuntu";
            if (preg_match('#Ubuntu/([.0-9a-zA-Z]+)#i', $useragent, $regmatch)) {
                $version = $regmatch[1];
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } elseif (preg_match('#\bLinux#i', $useragent)) {
            $title = "GNU/Linux";
            if (preg_match('/x86_64/i', $useragent)) {
                $version = "x64";
            } else {
                $version = 'Unknown';
            }
            return array('operating_system' => $title, 'version' => $version);
        } else {
            return array('operating_system' => 'Unknown', 'version' => 'Unknown');
        }
        
    }
        
    function getOSInfo($useragent, $OSs) {
        foreach ($OSs as $display => $OS) {
            if (preg_match('#\b' . preg_quote($OS) . '#i', $useragent)) {
                if (is_int($display)) {
                    $title = $OS;
                } else {
                    $title = $display;
                }
                return array('operating_system' => $title, 'version' => 'Unknown');
            }
        }
        return false;
    }

}
