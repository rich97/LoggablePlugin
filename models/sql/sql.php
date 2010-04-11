CREATE TABLE IF NOT EXISTS `loggable_areas` (
  `id` int(11) NOT NULL auto_increment,
  `area` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_availables` (
  `id` int(11) NOT NULL auto_increment,
  `width` smallint(4) NOT NULL,
  `height` smallint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `resolution` (`width`,`height`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_browsers` (
  `id` int(11) NOT NULL auto_increment,
  `browser` varchar(50) NOT NULL,
  `version` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `browser` (`browser`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_cities` (
  `id` int(11) NOT NULL auto_increment,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_continents` (
  `id` int(11) NOT NULL auto_increment,
  `continent` char(2) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `continent` (`continent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_cookies` (
  `id` int(11) NOT NULL auto_increment,
  `cookie` char(64) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cookie` (`cookie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_countries` (
  `id` int(11) NOT NULL auto_increment,
  `code` char(2) NOT NULL,
  `country` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `country` (`code`,`country`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_hosts` (
  `id` int(11) NOT NULL auto_increment,
  `host` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `host` (`host`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_keywords` (
  `id` int(11) NOT NULL auto_increment,
  `keyword` varchar(50) NOT NULL,
  `ignore` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_keyword_orders` (
  `id` int(11) NOT NULL auto_increment,
  `referrer_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_languages` (
  `id` int(11) NOT NULL auto_increment,
  `language` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_logs` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `session_id` int(11) NOT NULL,
  `returning` tinyint(1) NOT NULL default '0',
  `page_no` int(11) NOT NULL,
  `ip` int(11) NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `javascript` tinyint(1) NOT NULL default '0',
  `code` char(64) NOT NULL,
  `cookie_id` int(11) NOT NULL default '0',
  `host_id` int(11) NOT NULL default '0',
  `referrer_id` int(11) NOT NULL default '0',
  `url_id` int(11) NOT NULL default '0',
  `user_agent_id` int(11) NOT NULL default '0',
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `dma` smallint(3) NOT NULL default '0',
  `continent_id` int(11) NOT NULL default '0',
  `country_id` int(11) NOT NULL default '0',
  `region_id` int(11) NOT NULL default '0',
  `city_id` int(11) NOT NULL default '0',
  `area_id` int(11) NOT NULL default '0',
  `colour` smallint(6) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '0',
  `screen_id` int(11) NOT NULL default '0',
  `available_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_operating_systems` (
  `id` int(11) NOT NULL auto_increment,
  `operating_system` varchar(50) NOT NULL,
  `version` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `operating_system` (`operating_system`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_referrers` (
  `id` int(11) NOT NULL auto_increment,
  `referrer` varchar(255) NOT NULL,
  `search_engine_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `referrer` (`referrer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_regions` (
  `id` int(11) NOT NULL auto_increment,
  `code` char(5) NOT NULL,
  `region` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`,`region`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_screens` (
  `id` int(11) NOT NULL auto_increment,
  `width` smallint(4) NOT NULL,
  `height` smallint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `resolution` (`width`,`height`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_search_engines` (
  `id` int(11) NOT NULL auto_increment,
  `search_engine` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `search_engine` (`search_engine`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `session` char(74) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `session` (`session`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_spiders` (
  `id` int(11) NOT NULL auto_increment,
  `spider` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_urls` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `loggable_user_agents` (
  `id` int(11) NOT NULL auto_increment,
  `user_agent` varchar(255) NOT NULL,
  `browser_id` int(11) NOT NULL,
  `operating_system_id` int(11) NOT NULL,
  `spider_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_agent` (`user_agent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
