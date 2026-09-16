CREATE TABLE IF NOT EXISTS `#__kwpsolarsystem` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`created_by` INT(11) NOT NULL,
	`state` INT(11) NOT NULL DEFAULT 1,	  
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',  
  `visual` text,
  `description` text,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text ,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;