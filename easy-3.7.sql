-- phpMyAdmin SQL Dump
-- version 2.6.4-pl4
-- http://www.phpmyadmin.net
-- 
-- Darbinė stotis: localhost
-- Atlikimo laikas:  2011 m. Liepos 20 d.  19:40
-- Serverio versija: 5.0.51
-- PHP versija: 5.2.17
-- 
-- Duombazė: `temp`
-- 

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_admin_lang_rights`
-- 

CREATE TABLE `cms_admin_lang_rights` (
  `lng` varchar(255) NOT NULL default '',
  `admin_id` bigint(20) NOT NULL default '0',
  `rights` tinyint(4) NOT NULL default '0',
  KEY `lng` (`lng`,`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Sukurta duomenų kopija lentelei `cms_admin_lang_rights`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_admin_module_rights`
-- 

CREATE TABLE `cms_admin_module_rights` (
  `id` int(11) NOT NULL auto_increment,
  `record_id` int(11) NOT NULL default '0',
  `admin_id` int(11) NOT NULL default '0',
  `rights` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `admin_id` (`admin_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_admin_module_rights`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_admin_stat`
-- 

CREATE TABLE `cms_admin_stat` (
  `id` int(11) NOT NULL auto_increment,
  `admin_id` int(11) NOT NULL default '0',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `logout_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `session` varchar(255) NOT NULL default '',
  `ipaddress` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_admin_stat`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_admins`
-- 

CREATE TABLE `cms_admins` (
  `id` int(11) NOT NULL auto_increment,
  `record_id` int(11) NOT NULL default '0',
  `lng` varchar(255) NOT NULL default '',
  `login` varchar(255) default NULL,
  `pass` varchar(255) default NULL,
  `permission` tinyint(4) default NULL,
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `submit` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `lng_rights` varchar(255) NOT NULL default '',
  `mod_rights` varchar(255) NOT NULL default '',
  `lng_saved` tinyint(1) NOT NULL default '0',
  `confirm_code` varchar(255) default NULL,
  `confirm_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 AUTO_INCREMENT=150 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_admins`
-- 

INSERT INTO `cms_admins` VALUES (1, 2, 'lt', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'Vytautas', '', 'info@easywebmanager.lt', '', '', 'admin (Vytautas )', 1, '', '', 1, '30629173176f839e664484c606a43462', '2011-05-02 17:56:00');

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_banners`
-- 

CREATE TABLE `cms_banners` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `submit` tinyint(1) default NULL,
  `file` varchar(255) default NULL,
  `view_count` int(11) default NULL,
  `click_count` int(11) default NULL,
  `banner_size` varchar(255) default NULL,
  `hiperlink` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_banners`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_blocks`
-- 

CREATE TABLE `cms_blocks` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `description` text,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `page_id` int(11) default NULL,
  `block_name` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `page_id` (`page_id`),
  KEY `block_name` (`block_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_blocks`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_comments`
-- 

CREATE TABLE `cms_comments` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `category_id` int(11) default NULL,
  `category_column` varchar(255) default NULL,
  `author` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_comments`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_conversion`
-- 

CREATE TABLE `cms_conversion` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `url` varchar(255) collate utf8_unicode_ci default NULL,
  `conversion_list` varchar(255) collate utf8_unicode_ci default NULL,
  `category_column` varchar(255) collate utf8_unicode_ci default NULL,
  `category_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_conversion`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_currency`
-- 

CREATE TABLE `cms_currency` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `lng` varchar(255) default NULL,
  `short_title` varchar(255) default NULL,
  `currency_by_lt` varchar(255) default NULL,
  `submit` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_currency`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_diskusijos`
-- 

CREATE TABLE `cms_diskusijos` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `description` text,
  `author` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_diskusijos`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_fields`
-- 

CREATE TABLE `cms_fields` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `short_description` text collate utf8_unicode_ci,
  `elm_type` int(11) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `column_name` varchar(255) collate utf8_unicode_ci default NULL,
  `list_values` tinyint(1) default NULL,
  `category_id` int(11) default NULL,
  `category_column` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `category_id` (`category_id`),
  KEY `category_column` (`category_column`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_fields`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_filters`
-- 

CREATE TABLE `cms_filters` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `lng` varchar(255) default NULL,
  `submit` varchar(255) default NULL,
  `value` int(11) default NULL,
  `active` tinyint(4) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `mod_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1768 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1768 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_filters`
-- 

INSERT INTO `cms_filters` VALUES (1065, 1746, 'Komentarai', NULL, 'Saugoti', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1189, 2138, NULL, 'en', 'Saugoti', NULL, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1190, 2138, NULL, 'ru', 'Saugoti', NULL, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1188, 2138, 'Bendri', 'lt', 'Saugoti', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1272, 2543, NULL, 'lt', 'Saugoti', NULL, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1274, 2543, NULL, 'de', 'Saugoti', NULL, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1281, 3429, 'kitas', 'lt', '', 0, 1, 1, NULL);
INSERT INTO `cms_filters` VALUES (1282, 3429, 'kitas', 'en', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1283, 3429, 'kitas', 'ru', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1284, 3429, 'kitas', 'de', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1305, 3451, 'AmiloPro.jpg', 'lt', '', 0, 1, 1, NULL);
INSERT INTO `cms_filters` VALUES (1306, 3452, 'AmiloPro00.jpg', 'lt', '', 0, 1, 1, NULL);
INSERT INTO `cms_filters` VALUES (1307, 3456, 'aoc_LM731.jpg', 'lt', '', 0, 1, 1, 59);
INSERT INTO `cms_filters` VALUES (1316, 3567, 'Prenumeratorių kategorijos', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1317, 3567, 'Prenumeratorių kategorijos', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1318, 3567, 'Prenumeratorių kategorijos', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1319, 3567, 'Prenumeratorių kategorijos', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1320, 3568, '1 kategorija', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1321, 3568, '1 kategorija', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1322, 3568, '1 kategorija', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1323, 3568, '1 kategorija', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1324, 3569, '2 kategorija', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1325, 3569, '2 kategorija', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1326, 3569, '2 kategorija', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1327, 3569, '2 kategorija', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1328, 3575, 'Test', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1329, 3575, 'Test', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1330, 3575, 'Test', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1331, 3575, 'Test', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1352, 3803, 'Miestai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1353, 3803, 'Miestai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1354, 3803, 'Miestai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1355, 3804, 'Vilnius', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1356, 3804, 'Vilnius', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1357, 3804, 'Vilnius', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1358, 3805, 'Kaunas', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1359, 3805, 'Kaunas', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1360, 3805, 'Kaunas', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1361, 3806, 'Klaipėda', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1362, 3806, 'Klaipėda', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1363, 3806, 'Klaipėda', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1364, 3807, 'Šiauliai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1365, 3807, 'Šiauliai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1366, 3807, 'Šiauliai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1367, 3808, 'Panevėžys', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1368, 3808, 'Panevėžys', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1369, 3808, 'Panevėžys', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1370, 3809, 'Alytus', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1371, 3809, 'Alytus', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1372, 3809, 'Alytus', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1373, 3810, 'Marijampolė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1374, 3810, 'Marijampolė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1375, 3810, 'Marijampolė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1376, 3811, 'Mažeikiai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1377, 3811, 'Mažeikiai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1378, 3811, 'Mažeikiai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1379, 3812, 'Jonava', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1380, 3812, 'Jonava', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1381, 3812, 'Jonava', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1382, 3813, 'Utena', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1383, 3813, 'Utena', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1384, 3813, 'Utena', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1385, 3814, 'Kėdainiai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1386, 3814, 'Kėdainiai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1387, 3814, 'Kėdainiai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1388, 3815, 'Telšiai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1389, 3815, 'Telšiai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1390, 3815, 'Telšiai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1391, 3816, 'Tauragė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1392, 3816, 'Tauragė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1393, 3816, 'Tauragė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1394, 3817, 'Visaginas', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1395, 3817, 'Visaginas', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1396, 3817, 'Visaginas', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1397, 3818, 'Ukmergė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1398, 3818, 'Ukmergė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1399, 3818, 'Ukmergė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1400, 3819, 'Plungė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1401, 3819, 'Plungė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1402, 3819, 'Plungė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1403, 3820, 'Kretinga', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1404, 3820, 'Kretinga', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1405, 3820, 'Kretinga', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1406, 3821, 'Šilutė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1407, 3821, 'Šilutė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1408, 3821, 'Šilutė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1409, 3822, 'Radviliškis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1410, 3822, 'Radviliškis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1411, 3822, 'Radviliškis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1412, 3823, 'Palanga', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1413, 3823, 'Palanga', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1414, 3823, 'Palanga', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1415, 3824, 'Druskininkai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1416, 3824, 'Druskininkai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1417, 3824, 'Druskininkai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1418, 3825, 'Rokiškis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1419, 3825, 'Rokiškis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1420, 3825, 'Rokiškis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1421, 3826, 'Gargždai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1422, 3826, 'Gargždai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1423, 3826, 'Gargždai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1424, 3827, 'Biržai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1425, 3827, 'Biržai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1426, 3827, 'Biržai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1427, 3828, 'Kuršėnai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1428, 3828, 'Kuršėnai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1429, 3828, 'Kuršėnai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1430, 3829, 'Elektrėnai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1431, 3829, 'Elektrėnai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1432, 3829, 'Elektrėnai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1433, 3830, 'Jurbarkas', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1434, 3830, 'Jurbarkas', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1435, 3830, 'Jurbarkas', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1436, 3831, 'Vilkaviškis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1437, 3831, 'Vilkaviškis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1438, 3831, 'Vilkaviškis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1439, 3832, 'Raseiniai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1440, 3832, 'Raseiniai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1441, 3832, 'Raseiniai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1442, 3833, 'Anykščiai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1443, 3833, 'Anykščiai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1444, 3833, 'Anykščiai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1445, 3834, 'Naujoji Akmenė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1446, 3834, 'Naujoji Akmenė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1447, 3834, 'Naujoji Akmenė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1448, 3835, 'Prienai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1449, 3835, 'Prienai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1450, 3835, 'Prienai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1451, 3836, 'Joniškis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1452, 3836, 'Joniškis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1453, 3836, 'Joniškis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1454, 3837, 'Kelmė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1455, 3837, 'Kelmė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1456, 3837, 'Kelmė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1457, 3838, 'Varėna', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1458, 3838, 'Varėna', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1459, 3838, 'Varėna', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1460, 3839, 'Kaišiadorys', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1461, 3839, 'Kaišiadorys', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1462, 3839, 'Kaišiadorys', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1463, 3840, 'Pasvalys', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1464, 3840, 'Pasvalys', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1465, 3840, 'Pasvalys', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1466, 3841, 'Kupiškis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1467, 3841, 'Kupiškis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1468, 3841, 'Kupiškis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1469, 3842, 'Zarasai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1470, 3842, 'Zarasai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1471, 3842, 'Zarasai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1472, 3843, 'Skuodas', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1473, 3843, 'Skuodas', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1474, 3843, 'Skuodas', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1475, 3844, 'Kazlų Rūda', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1476, 3844, 'Kazlų Rūda', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1477, 3844, 'Kazlų Rūda', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1478, 3845, 'Širvintos', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1479, 3845, 'Širvintos', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1480, 3845, 'Širvintos', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1481, 3846, 'Molėtai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1482, 3846, 'Molėtai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1483, 3846, 'Molėtai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1484, 3847, 'Šalčininkai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1485, 3847, 'Šalčininkai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1486, 3847, 'Šalčininkai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1487, 3848, 'Šakiai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1488, 3848, 'Šakiai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1489, 3848, 'Šakiai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1490, 3849, 'Kybartai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1491, 3849, 'Kybartai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1492, 3849, 'Kybartai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1493, 3850, 'Ignalina', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1494, 3850, 'Ignalina', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1495, 3850, 'Ignalina', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1496, 3851, 'Šilalė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1497, 3851, 'Šilalė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1498, 3851, 'Šilalė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1499, 3852, 'Pakruojis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1500, 3852, 'Pakruojis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1501, 3852, 'Pakruojis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1502, 3853, 'Nemenčinė', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1503, 3853, 'Nemenčinė', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1504, 3853, 'Nemenčinė', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1505, 3854, 'Švenčionys', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1506, 3854, 'Švenčionys', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1507, 3854, 'Švenčionys', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1508, 3855, 'Trakai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1509, 3855, 'Trakai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1510, 3855, 'Trakai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1511, 3856, 'Vievis', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1512, 3856, 'Vievis', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1513, 3856, 'Vievis', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1514, 3857, 'Kalvarija', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1515, 3857, 'Kalvarija', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1516, 3857, 'Kalvarija', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1517, 3858, 'Lazdijai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1518, 3858, 'Lazdijai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1519, 3858, 'Lazdijai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1520, 3859, 'Rietavas', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1521, 3859, 'Rietavas', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1522, 3859, 'Rietavas', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1523, 3860, 'Ariogala', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1524, 3860, 'Ariogala', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1525, 3860, 'Ariogala', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1526, 3861, 'Šeduva', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1527, 3861, 'Šeduva', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1528, 3861, 'Šeduva', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1529, 3862, 'Birštonas', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1530, 3862, 'Birštonas', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1531, 3862, 'Birštonas', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1532, 3863, 'Neringa', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1533, 3863, 'Neringa', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1534, 3863, 'Neringa', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1535, 3864, 'Pagėgiai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1536, 3864, 'Pagėgiai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1537, 3864, 'Pagėgiai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1538, 3920, 'Laukų tipai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1539, 3920, 'Laukų tipai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1540, 3920, 'Laukų tipai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1541, 3921, 'text', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1542, 3921, 'text', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1543, 3921, 'text', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1544, 3922, 'textarea', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1545, 3922, 'textarea', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1546, 3922, 'textarea', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1547, 3923, 'select', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1548, 3923, 'select', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1549, 3923, 'select', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1550, 3924, 'checkbox', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1551, 3924, 'checkbox', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1552, 3924, 'checkbox', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1556, 4138, 'mokejimu tipai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1557, 4138, 'types of payment', 'en', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1558, 4138, 'mokejimu tipai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1559, 4138, 'mokejimu tipai', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1560, 4139, 'Lietuvos bankinės sistemos', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1561, 4139, 'Lietuvos bankinės sistemos', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1562, 4139, 'Lietuvos bankinės sistemos', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1563, 4139, 'Lietuvos bankinės sistemos', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1564, 4140, 'Kreditinės kortelės', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1565, 4140, 'Kreditinės kortelės', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1566, 4140, 'Kreditinės kortelės', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1567, 4140, 'Kreditinės kortelės', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1568, 4141, 'Virtualios ipniginės operacijos', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1569, 4141, 'Virtualios ipniginės operacijos', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1570, 4141, 'Virtualios ipniginės operacijos', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1571, 4141, 'Virtualios ipniginės operacijos', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1572, 4142, 'Kiti būdai', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1573, 4142, 'Kiti būdai', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1574, 4142, 'Kiti būdai', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1575, 4142, 'Kiti būdai', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1576, 14153, 'checkbox_group', 'lt', '', 0, 1, 1, 0);
INSERT INTO `cms_filters` VALUES (1577, 14153, 'checkbox_group', 'en', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1578, 14153, 'checkbox_group', 'ru', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1579, 14153, 'checkbox_group', 'de', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1589, 2138, 'Bendri', 'fr', 'Saugoti', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1593, 2543, NULL, 'fr', 'Saugoti', NULL, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1594, 3429, 'kitas', 'fr', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1595, 3451, 'AmiloPro.jpg', 'fr', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1596, 3452, 'AmiloPro00.jpg', 'fr', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1597, 3456, 'aoc_LM731.jpg', 'fr', '', 0, 1, 0, 59);
INSERT INTO `cms_filters` VALUES (1598, 3567, 'Prenumeratorių kategorijos', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1599, 3568, '1 kategorija', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1600, 3569, '2 kategorija', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1601, 3575, 'Test', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1602, 3803, 'Miestai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1603, 3804, 'Vilnius', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1604, 3805, 'Kaunas', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1605, 3806, 'Klaipėda', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1606, 3807, 'Šiauliai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1607, 3808, 'Panevėžys', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1608, 3809, 'Alytus', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1609, 3810, 'Marijampolė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1610, 3811, 'Mažeikiai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1611, 3812, 'Jonava', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1612, 3813, 'Utena', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1613, 3814, 'Kėdainiai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1614, 3815, 'Telšiai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1615, 3816, 'Tauragė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1616, 3817, 'Visaginas', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1617, 3818, 'Ukmergė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1618, 3819, 'Plungė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1619, 3820, 'Kretinga', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1620, 3821, 'Šilutė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1621, 3822, 'Radviliškis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1622, 3823, 'Palanga', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1623, 3824, 'Druskininkai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1624, 3825, 'Rokiškis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1625, 3826, 'Gargždai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1626, 3827, 'Biržai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1627, 3828, 'Kuršėnai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1628, 3829, 'Elektrėnai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1629, 3830, 'Jurbarkas', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1630, 3831, 'Vilkaviškis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1631, 3832, 'Raseiniai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1632, 3833, 'Anykščiai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1633, 3834, 'Naujoji Akmenė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1634, 3835, 'Prienai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1635, 3836, 'Joniškis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1636, 3837, 'Kelmė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1637, 3838, 'Varėna', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1638, 3839, 'Kaišiadorys', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1639, 3840, 'Pasvalys', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1640, 3841, 'Kupiškis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1641, 3842, 'Zarasai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1642, 3843, 'Skuodas', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1643, 3844, 'Kazlų Rūda', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1644, 3845, 'Širvintos', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1645, 3846, 'Molėtai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1646, 3847, 'Šalčininkai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1647, 3848, 'Šakiai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1648, 3849, 'Kybartai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1649, 3850, 'Ignalina', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1650, 3851, 'Šilalė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1651, 3852, 'Pakruojis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1652, 3853, 'Nemenčinė', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1653, 3854, 'Švenčionys', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1654, 3855, 'Trakai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1655, 3856, 'Vievis', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1656, 3857, 'Kalvarija', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1657, 3858, 'Lazdijai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1658, 3859, 'Rietavas', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1659, 3860, 'Ariogala', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1660, 3861, 'Šeduva', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1661, 3862, 'Birštonas', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1662, 3863, 'Neringa', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1663, 3864, 'Pagėgiai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1664, 3920, 'Laukų tipai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1665, 3921, 'text', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1666, 3922, 'textarea', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1667, 3923, 'select', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1668, 3924, 'checkbox', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1669, 4138, 'mokejimu tipai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1670, 4139, 'Lietuvos bankinės sistemos', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1671, 4140, 'Kreditinės kortelės', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1672, 4141, 'Virtualios ipniginės operacijos', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1673, 4142, 'Kiti būdai', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1674, 14153, 'checkbox_group', 'fr', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1681, 2138, 'Bendri', 'no', 'Saugoti', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1685, 2543, NULL, 'no', 'Saugoti', NULL, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1686, 3429, 'kitas', 'no', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1687, 3451, 'AmiloPro.jpg', 'no', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1688, 3452, 'AmiloPro00.jpg', 'no', '', 0, 1, 0, NULL);
INSERT INTO `cms_filters` VALUES (1689, 3456, 'aoc_LM731.jpg', 'no', '', 0, 1, 0, 59);
INSERT INTO `cms_filters` VALUES (1690, 3567, 'Prenumeratorių kategorijos', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1691, 3568, '1 kategorija', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1692, 3569, '2 kategorija', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1693, 3575, 'Test', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1694, 3803, 'Miestai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1695, 3804, 'Vilnius', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1696, 3805, 'Kaunas', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1697, 3806, 'Klaipėda', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1698, 3807, 'Šiauliai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1699, 3808, 'Panevėžys', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1700, 3809, 'Alytus', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1701, 3810, 'Marijampolė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1702, 3811, 'Mažeikiai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1703, 3812, 'Jonava', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1704, 3813, 'Utena', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1705, 3814, 'Kėdainiai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1706, 3815, 'Telšiai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1707, 3816, 'Tauragė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1708, 3817, 'Visaginas', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1709, 3818, 'Ukmergė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1710, 3819, 'Plungė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1711, 3820, 'Kretinga', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1712, 3821, 'Šilutė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1713, 3822, 'Radviliškis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1714, 3823, 'Palanga', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1715, 3824, 'Druskininkai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1716, 3825, 'Rokiškis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1717, 3826, 'Gargždai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1718, 3827, 'Biržai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1719, 3828, 'Kuršėnai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1720, 3829, 'Elektrėnai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1721, 3830, 'Jurbarkas', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1722, 3831, 'Vilkaviškis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1723, 3832, 'Raseiniai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1724, 3833, 'Anykščiai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1725, 3834, 'Naujoji Akmenė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1726, 3835, 'Prienai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1727, 3836, 'Joniškis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1728, 3837, 'Kelmė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1729, 3838, 'Varėna', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1730, 3839, 'Kaišiadorys', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1731, 3840, 'Pasvalys', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1732, 3841, 'Kupiškis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1733, 3842, 'Zarasai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1734, 3843, 'Skuodas', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1735, 3844, 'Kazlų Rūda', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1736, 3845, 'Širvintos', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1737, 3846, 'Molėtai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1738, 3847, 'Šalčininkai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1739, 3848, 'Šakiai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1740, 3849, 'Kybartai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1741, 3850, 'Ignalina', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1742, 3851, 'Šilalė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1743, 3852, 'Pakruojis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1744, 3853, 'Nemenčinė', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1745, 3854, 'Švenčionys', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1746, 3855, 'Trakai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1747, 3856, 'Vievis', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1748, 3857, 'Kalvarija', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1749, 3858, 'Lazdijai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1750, 3859, 'Rietavas', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1751, 3860, 'Ariogala', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1752, 3861, 'Šeduva', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1753, 3862, 'Birštonas', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1754, 3863, 'Neringa', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1755, 3864, 'Pagėgiai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1756, 3920, 'Laukų tipai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1757, 3921, 'text', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1758, 3922, 'textarea', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1759, 3923, 'select', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1760, 3924, 'checkbox', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1761, 4138, 'mokejimu tipai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1762, 4139, 'Lietuvos bankinės sistemos', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1763, 4140, 'Kreditinės kortelės', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1764, 4141, 'Virtualios ipniginės operacijos', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1765, 4142, 'Kiti būdai', 'no', '', 0, 1, 0, 0);
INSERT INTO `cms_filters` VALUES (1766, 14153, 'checkbox_group', 'no', '', 0, 1, 0, 0);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_forms`
-- 

CREATE TABLE `cms_forms` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `targetEmailEmails` text collate utf8_unicode_ci,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `selType` varchar(255) collate utf8_unicode_ci default NULL,
  `targetEmailSubject` varchar(255) collate utf8_unicode_ci default NULL,
  `targetEmailFromemail` varchar(255) collate utf8_unicode_ci default NULL,
  `targetEmailFromname` varchar(255) collate utf8_unicode_ci default NULL,
  `targetEmailTemplate` text collate utf8_unicode_ci,
  `targetDatabaseModule` varchar(255) collate utf8_unicode_ci default NULL,
  `targetCustomModule` varchar(255) collate utf8_unicode_ci default NULL,
  `targetCustomMethod` varchar(255) collate utf8_unicode_ci default NULL,
  `required_fields` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_forms`
-- 

INSERT INTO `cms_forms` VALUES (6, 14090, NULL, 1, 'contacts', 'gavejo@el-pastas.lt', 1, 0, 'mail', 'Laiškas iš svetainės', '{email}', '{name}', '{content}', '', '', '', 'Name::');

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_keywords`
-- 

CREATE TABLE `cms_keywords` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_keywords`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_modifications`
-- 

CREATE TABLE `cms_modifications` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `short_description` text collate utf8_unicode_ci,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `list_values` tinyint(1) default NULL,
  `column_name` varchar(255) collate utf8_unicode_ci default NULL,
  `category_id` int(11) default NULL,
  `category_column` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_modifications`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_module`
-- 

CREATE TABLE `cms_module` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table_name` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `title_lt` varchar(255) NOT NULL default '',
  `title_en` varchar(255) NOT NULL default '',
  `tplico` varchar(255) NOT NULL default '',
  `multilng` tinyint(1) unsigned default NULL,
  `category` int(10) unsigned default NULL,
  `tree` tinyint(1) default NULL,
  `mod_pages` int(11) NOT NULL default '0',
  `cache` tinyint(1) NOT NULL default '0',
  `mail` varchar(255) NOT NULL default '0',
  `last_modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `default_sort` varchar(255) NOT NULL default '',
  `default_sort_direction` varchar(255) NOT NULL default '',
  `search` tinyint(1) NOT NULL default '0',
  `forbid_delete` tinyint(1) NOT NULL default '0',
  `forbid_sort` tinyint(1) NOT NULL default '0',
  `forbid_filter` tinyint(1) NOT NULL default '0',
  `sort_order` int(11) default NULL,
  `disabled` tinyint(1) NOT NULL default '0',
  `maxlevel` tinyint(4) NOT NULL default '0',
  `rss` tinyint(1) NOT NULL default '0',
  `additional_submit_action` varchar(255) NOT NULL default '',
  `additional_settings` text NOT NULL,
  `no_standart_tpl` tinyint(1) NOT NULL default '0',
  `area_html` text NOT NULL,
  `no_record_table` tinyint(1) NOT NULL default '0',
  `admin_catalog` tinyint(1) NOT NULL default '0',
  `html_tpl` text NOT NULL,
  `parent_module` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 AUTO_INCREMENT=120 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_module`
-- 

INSERT INTO `cms_module` VALUES (1, 'admins', 'Administratoriai', 'Administratoriai', 'Administrators', '', 0, 0, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 1, 0, 1, 0, 51, 0, 0, 0, 'http://manual.easywebmanager.com/files/video/admin.flv', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (3, 'news', 'Naujienos', 'Naujienos', 'News', '', 1, 0, 1, 0, 1, '0', '2010-09-08 12:33:29', 'T.news_date', 'DESC', 1, 0, 1, 0, 17, 1, 0, 1, '', '&lt;items&gt;\r\n&lt;items_paging&gt;\r\n		&lt;title_lt&gt;Naujienų skaičius puslapyje&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Items paging&lt;/title_en&gt;\r\n		&lt;value&gt;5&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/items_paging&gt;\r\n&lt;/items&gt;', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (5, 'phrases', 'Frazės', 'Žodynas', 'Wordbook', '', 1, 0, 1, 5, 1, '0', '2011-07-20 19:34:58', 'R.sort_order', 'ASC', 1, 0, 0, 0, 21, 0, 0, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (6, 'users', 'Registruoti lankytojai', 'Registruoti lankytojai', 'Registered users', '', 0, 0, 1, 0, 0, 'email', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 1, 0, 0, 0, 4, 0, 0, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (36, 'filters', 'Sąrašų modulis', 'Katalogas', 'Catalog', '', 1, 1, 1, 0, 1, '0', '2011-07-20 19:35:25', 'R.sort_order', 'ASC', 1, 0, 0, 0, 29, 0, 3, 0, '', '', 0, '', 0, 0, '', '94');
INSERT INTO `cms_module` VALUES (60, 'subscribers', 'Naujienų prenumeratoriai', 'Naujienų prenumeratoriai', 'News subscribers', '', 0, 0, 1, 66, 0, 'title', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 39, 1, 0, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (73, 'keywords', 'Raktniniai žodžiai', 'Raktniniai žodžiai', 'Keywords', '', 1, 0, 1, 0, 1, '', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 25, 1, 0, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (72, 'banners', 'Reklaminių antraščių modulis', 'Reklaminių antraščių modulis', 'Banners', '', 1, 1, 1, 0, 1, '', '2008-04-24 17:38:34', 'R.sort_order', 'ASC', 0, 0, 0, 0, 20, 1, 1, 0, 'object||record::method||changeFlashLink', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (66, 'newsletters', 'Naujienlaiškių siuntimas', 'Naujienlaiškių siuntimas', 'Newsletters', '', 0, 0, 1, 66, 0, '', '0000-00-00 00:00:00', 'T.sent_date', 'DESC', 0, 0, 1, 0, 45, 1, 0, 0, '', '', 1, '<table cellspacing="0" cellpadding="0" width="100%" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.title}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.sent_date}</div>\r\n            </td>\r\n            <td>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.email_from_name}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.email_from_email}</div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.mail_body}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.submit}</div>\r\n            {tpl.click_count}{tpl.view_count}</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (71, 'comments', 'Komentarai', 'Komentarai', 'Comments', '', 0, 0, 1, 0, 0, '', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 49, 1, 2, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (70, 'soap_users', 'SOAP vartotojai', 'SOAP vartotojai', 'SOAP users', '', 0, 0, 1, 0, 0, 'email', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 1, 0, 48, 1, 0, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (76, 'orders', 'Užsakymai', 'Užsakymai', 'Orders', '', 0, 0, 1, 76, 0, '', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 1, 0, 1, 0, 15, 0, 0, 0, '', '&lt;items&gt;	&lt;logo&gt;\r\n		&lt;title_lt&gt;Logotipas (tik .jpg formatas)&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Logo (only .jpg format)&lt;/title_en&gt;\r\n		&lt;value&gt;logo.jpg&lt;/value&gt;\r\n		&lt;type&gt;image&lt;/type&gt;\r\n		&lt;extra_params&gt;prefix=||size=300x300||quality=100||resize_type=0&lt;/extra_params&gt;\r\n	&lt;/logo&gt;\r\n	&lt;company&gt;\r\n		&lt;title_lt&gt;Įmonė sąskaitose&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company&lt;/title_en&gt;\r\n	&lt;value&gt;&lt;![CDATA[UAB &quot;Easywebmanager&quot;]]&gt;&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/company&gt;\r\n	&lt;company_code&gt;\r\n		&lt;title_lt&gt;Įmonės kodas&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company code&lt;/title_en&gt;\r\n		&lt;value&gt;xxxxxxxxx&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/company_code&gt;\r\n	&lt;company_pvm&gt;\r\n		&lt;title_lt&gt;Įmonės PVM kodas&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company VAT code&lt;/title_en&gt;\r\n		&lt;value&gt;-&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/company_pvm&gt;\r\n	&lt;company_address&gt;\r\n		&lt;title_lt&gt;Įmonės adresas&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company address&lt;/title_en&gt;\r\n		&lt;value&gt;Gatvinaukso 152a-23&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/company_address&gt;\r\n	&lt;company_bank&gt;\r\n		&lt;title_lt&gt;Įmonės bankas&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company bank&lt;/title_en&gt;\r\n		&lt;value&gt;Bankas&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/company_bank&gt;\r\n	&lt;company_saskaita&gt;\r\n		&lt;title_lt&gt;Įmonės sąskaitos nr&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Įmonės sąskaitos nr&lt;/title_en&gt;\r\n		&lt;value&gt;LTxxxxxxxxxxxx&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/company_saskaita&gt;\r\n	&lt;email&gt;\r\n		&lt;title_lt&gt;Įmonės el. paštas&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company email&lt;/title_en&gt;\r\n		&lt;value&gt;info@easywebmanager.lt&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/email&gt;\r\n	&lt;phone&gt;\r\n		&lt;title_lt&gt;Įmonės telefonas&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company phone&lt;/title_en&gt;\r\n		&lt;value&gt;+370 (xxx) xx-xxx&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/phone&gt;\r\n	&lt;website&gt;\r\n		&lt;title_lt&gt;Įmonės svetainė&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Company website&lt;/title_en&gt;\r\n		&lt;value&gt;http://www.easywebmanager.lt&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/website&gt;\r\n&lt;serija&gt;\r\n		&lt;title_lt&gt;Serija sąskaitose&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Invoice seria&lt;/title_en&gt;\r\n		&lt;value&gt;EWM-*******&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/serija&gt;\r\n&lt;/items&gt;', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (77, 'ordered_items', 'Užsakytos prekės', 'Užsakytos prekės', 'Ordered products', '', 0, 0, 1, 0, 0, '', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 1, 0, 16, 1, 1, 0, '', '', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (79, 'diskusijos', NULL, 'Diskusijos', 'Phorum', '', 1, 1, 1, 0, 0, '', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 19, 1, 2, 0, '', '&lt;items&gt;\r\n&lt;paging&gt;\r\n&lt;title_lt&gt;Komentarų skaičius puslapyje&lt;/title_lt&gt;\r\n&lt;title_en&gt;Comments paging&lt;/title_en&gt;\r\n&lt;type&gt;text&lt;/type&gt;\r\n&lt;value&gt;20&lt;/value&gt;\r\n&lt;/paging&gt;\r\n&lt;/items&gt;', 0, '', 0, 0, '', '0');
INSERT INTO `cms_module` VALUES (81, 'pages', NULL, 'Svetainės struktūra', 'Website structure', '', 1, 1, 1, 0, 1, '', '2011-05-12 15:54:35', 'R.sort_order', 'ASC', 1, 0, 0, 0, 1, 0, 5, 0, 'http://manual.easywebmanager.com/files/video/pages.flv', '', 1, '<table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.title}</div>\r\n            </td>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.page_title}</div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.page_redirect}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.template}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.public_page}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.active}</div>\r\n            {tpl.mod_id}</td>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.header_title}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.page_url}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.keywords}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.description}</div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td valign="top" colspan="2">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.submit}</div>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n{tpl.screenshot}   <script type="text/javascript">\r\ndocument.forms["save"].elements["title"].onkeyup = function()\r\n{\r\nif(document.getElementById("gen_header_title_auto_id").checked)\r\ndocument.forms["save"].elements["header_title"].value=document.forms["save"].elements["title"].value;\r\nif(document.getElementById("gen_page_title_auto_id").checked)\r\ndocument.forms["save"].elements["page_title"].value=document.forms["save"].elements["title"].value;\r\n}\r\n</script>', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (113, 'storage', 'Prekių sandėlis', 'Prekių sandėlis', 'Storage', '', 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 67, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (114, 'storage_reserved', 'Rezervuotos prekės', 'Rezervuotos prekės', 'Reserved items', '', 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 68, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (115, 'forms', NULL, 'Formos', 'Forms', '', NULL, NULL, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 69, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (116, 'conversion', NULL, 'Konversijos tikslai', 'Conversion goals', '', NULL, NULL, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 70, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (97, 'products', NULL, 'Produktai', 'Products', '', 1, NULL, 1, 0, 1, '0', '2011-06-16 11:24:52', 'R.sort_order', 'DESC', 1, 0, 0, 0, 3, 0, 0, 0, '', '&lt;items&gt;	&lt;items_paging&gt;\r\n		&lt;title_lt&gt;Įrašų skaičius puslapyje&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Items paging&lt;/title_en&gt;\r\n		&lt;value&gt;40&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/items_paging&gt;\r\n	&lt;items_paging_block&gt;\r\n		&lt;title_lt&gt;Įrašų skaičius blokuose&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Items paging&lt;/title_en&gt;\r\n		&lt;value&gt;20&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/items_paging_block&gt;\r\n	&lt;items_paging_main&gt;\r\n		&lt;title_lt&gt;Įrašų skaičius pagr. psl.&lt;/title_lt&gt;\r\n		&lt;title_en&gt;Items paging&lt;/title_en&gt;\r\n		&lt;value&gt;20&lt;/value&gt;\r\n		&lt;type&gt;text&lt;/type&gt;\r\n	&lt;/items_paging_main&gt;\r\n&lt;/items&gt;', 1, '<table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.category}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.title}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.price}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.old_price}</div>\r\n            </td>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.product_url}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.short_description}</div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.description}</div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.image}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.image2}</div>\r\n            </td>\r\n            <td valign="top">\r\n            <div class="formElementsFieldWYSIWYG">{tpl.image3}</div>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.image4}</div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.active}</div>\r\n            </td>\r\n            <td>\r\n            <div class="formElementsFieldWYSIWYG">{tpl.akcija}</div>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<div class="formElementsFieldWYSIWYG">{tpl.submit}</div>\r\n<p>{tpl.kiekis}{tpl.clicks}{tpl.views}{tpl.recommend}{tpl.antkainis}</p>', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (98, 'blocks', NULL, 'Blokai', 'Blocks', '', 1, NULL, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 1, 0, 0, 0, 59, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (104, 'fields', NULL, 'Kategorijos laukų sąrašas', 'Category fields list', '', 1, NULL, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 62, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (105, 'select_values', NULL, 'Select reikšmės', 'Select values', '', 1, NULL, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 64, 1, 1, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (106, 'modifications', NULL, 'Produktų modifikacijų sąrašas', 'Product modifications', '', 1, NULL, 1, 0, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 63, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (108, 'payments', NULL, 'Mokėjimo būdai', 'Payments', '', 1, NULL, 1, 76, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 1, 0, 0, 0, 65, 0, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (117, 'phrases_html', NULL, 'Žodynas HTML', 'Phrases HTML', '', 1, NULL, 1, 5, 1, '0', '0000-00-00 00:00:00', 'R.sort_order', 'ASC', 0, 0, 0, 0, 71, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (118, 'user_groups', 'Vartotojų grupės', 'Vartotojų grupės', 'User groups', '', 0, 0, 1, 6, 1, '0', '2011-07-20 08:19:18', 'R.sort_order', 'ASC', 0, 0, 0, 0, 72, 1, 0, 0, '', '', 0, '', 0, 0, '', '');
INSERT INTO `cms_module` VALUES (119, 'saskaitos', 'Sąskaitos', 'Sąskaitos', 'Invoices', '', 0, 0, 1, 76, 0, '0', '0000-00-00 00:00:00', 'R.sort_order', 'DESC', 0, 0, 1, 0, 73, 1, 0, 0, '', '&lt;items&gt;	&lt;serija&gt;\n		&lt;title_lt&gt;Serija sąskaitose&lt;/title_lt&gt;\n		&lt;title_en&gt;Invoice seria&lt;/title_en&gt;\n		&lt;value&gt;EWM-*******&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/serija&gt;\n&lt;/items&gt;', 0, '', 0, 0, '', '');

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_module_info`
-- 

CREATE TABLE `cms_module_info` (
  `id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `title_lt` varchar(255) NOT NULL default '',
  `title_en` varchar(255) NOT NULL default '',
  `title_ru` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `column_name` varchar(255) default NULL,
  `column_type` varchar(255) default NULL,
  `column_type_more` varchar(255) NOT NULL default '',
  `elm_type` varchar(255) default NULL,
  `default_value` text,
  `list_values` text NOT NULL,
  `function` varchar(255) default NULL,
  `class_method` varchar(255) default NULL,
  `error_message` varchar(255) NOT NULL default '',
  `require` tinyint(1) default '0',
  `super_user` tinyint(1) NOT NULL default '0',
  `list` tinyint(1) default '0',
  `editable` tinyint(1) default '1',
  `htmlspecialchars` tinyint(1) NOT NULL default '1',
  `multilng` tinyint(1) NOT NULL default '1',
  `index` tinyint(1) NOT NULL default '0',
  `CE` varchar(4) default '0',
  `lng` varchar(255) default NULL,
  `sort_order` int(11) NOT NULL default '0',
  `field_html` text NOT NULL,
  `extra_params` varchar(255) NOT NULL default '',
  `no_standart_tpl` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1027 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1027 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_module_info`
-- 

INSERT INTO `cms_module_info` VALUES (95, 5, 'Vertimas', 'Tekstas', 'Text', '', '', 'translation', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 1, 1, 1, 1, 0, '0', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (94, 5, 'Pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', 'object=record::method=checkDataExist::admin_error_msg=Toks įrašas jau yra', '', 1, 0, 1, 1, 1, 0, 0, '0', NULL, 0, '', '', 0);
INSERT INTO `cms_module_info` VALUES (93, 3, 'Paveikslėlis', 'Paveikslėlis', 'Image', '', '', 'image', 'varchar(255)', '255', 'image', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0', 'lt', 6, '', 'prefix=thumb_||size=90x50||quality=80::prefix=||size=500x500||quality=80||water_sign=1', 0);
INSERT INTO `cms_module_info` VALUES (92, 3, 'Aprašymas', 'Aprašymas', 'Description', '', '', 'description', 'text', '', 'html', '', '', '', '', '', 1, 0, 0, 1, 1, 1, 0, '0', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (82, 3, 'Pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '0', NULL, 0, '', '', 0);
INSERT INTO `cms_module_info` VALUES (91, 3, 'Santrauka', 'Santrauka', 'Short description', '', '', 'summary', 'text', '', 'textarea', '', '', '', '', '', 1, 0, 0, 1, 1, 1, 0, '0', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (90, 3, 'Paskelbimo data', 'Paskelbimo data', 'Public date', '', '', 'news_date', 'date', '', 'date', '', 'time=1', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (140, 6, 'Vartotojų grupės pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '1', NULL, 0, '', '', 0);
INSERT INTO `cms_module_info` VALUES (845, 6, NULL, 'confirm_code', 'confirm_code', '', '', 'confirm_code', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 34, '', '', 0);
INSERT INTO `cms_module_info` VALUES (847, 76, NULL, 'Įmonės pavadinimas', 'Company name', '', '', 'company_name', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', NULL, 16, '', '', 0);
INSERT INTO `cms_module_info` VALUES (848, 76, NULL, 'Įmonės kodas', 'Company code', '', '', 'company_code', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', NULL, 17, '', '', 0);
INSERT INTO `cms_module_info` VALUES (849, 76, NULL, 'Įmonės adresas', 'Company address', '', '', 'company_address', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 0, 1, 1, 0, 0, '0', NULL, 18, '', '', 0);
INSERT INTO `cms_module_info` VALUES (142, 6, 'Slaptažodis', 'Slaptažodis', 'Password', '', '', 'userpass', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', 'lt', 24, '', '', 0);
INSERT INTO `cms_module_info` VALUES (143, 6, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'varchar(255)', '255', 'submit', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0::1', 'lt', 33, '', '', 0);
INSERT INTO `cms_module_info` VALUES (153, 5, 'Saugoti', 'Saugoti', 'Saugoti', '', '', 'submit', 'varchar(255)', '', 'submit', NULL, '', NULL, NULL, '', 0, 0, 0, 0, 1, 0, 0, '0::1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (157, 1, 'Prisijungimo vardas', 'Prisijungimo vardas', 'Loginname', '', '', 'login', 'varchar(255)', '', 'text', '', '', 'function=valid_login::admin_error_msg=Neteisingas prisijungimo vardas', 'object=record::method=checkLoginData::admin_error_msg=Toks administratorius jau yra', '', 1, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (158, 1, 'Slaptažodis', 'Slaptažodis', 'Password', '', '', 'pass', 'varchar(255)', '255', 'password', '', 'md5=1', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (159, 1, 'Lygis', 'Lygis', 'Level', '', '', 'permission', 'tinyint(4)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (160, 1, 'Vardas', 'Vardas', 'Firstname', '', '', 'firstname', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (161, 1, 'Pavardė', 'Pavardė', 'Lastname', '', '', 'lastname', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (162, 1, 'El. paštas', 'El. paštas', 'E-mail', '', '', 'email', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', 'lt', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (163, 1, 'Telefonas', 'Telefonas', 'Phone', '', '', 'phone', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (164, 1, 'Saugoti', 'Saugoti', 'Save', '', '', 'submit', 'varchar(255)', '', 'submit', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0::1', 'lt', 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (165, 3, 'Saugoti', 'Saugoti', 'Saugoti', '', '', 'submit', 'varchar(255)', '', 'submit', NULL, '', NULL, NULL, '', 0, 0, 0, 0, 1, 0, 0, '0::1', 'lt', 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (178, 36, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'varchar(255)', '255', 'submit', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0::1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (177, 36, 'Pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '0::1', NULL, 0, '', '', 0);
INSERT INTO `cms_module_info` VALUES (438, 60, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (437, 60, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (204, 36, 'Reikšmė', 'Reikšmė', 'Value', '', '', 'value', 'int', '', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (713, 81, NULL, 'Dokumento raktažodžiai', 'Keywords', '', 'Raktažodžiuose nurodomi tie žodžiai, kuriais norima kad paieškos sistemos rastų jūsų dokumentą. Patartina surašyti tuos žodžius ar frazes, kurie atitinka dokumento turinį.\r\n\r\nRaktažodžių apribojimas yra 1000 simbolių.\r\nNenaudoti raktažodžių po 3 kartus. \r\nNaudoti sudėtinius raktažodžius. \r\nNaudoti tik tuos metatagus kurie duoda naudos dokumentui.', 'keywords', 'text', '', 'textarea', '', 'inc_file=pages/inc/page_keywords.php::tpl_file=pages/inc/page_keywords.tpl', '', '', '', 0, 0, 0, 1, 1, 1, 0, '0', NULL, 21, '', '', 0);
INSERT INTO `cms_module_info` VALUES (712, 81, NULL, 'Trumpas tinklalapio apibūdinimas', 'Description', '', 'Kai kurios paieškos sistemos naudoja šį tekstą, laip trumpą tinklalapio apibūdinima išvedant paieškos rezultatus.', 'description', 'text', '', 'textarea', '', 'inc_file=pages/inc/page_description.php::tpl_file=pages/inc/page_description.tpl', '', '', '', 0, 0, 0, 1, 1, 1, 0, '0', NULL, 20, '', '', 0);
INSERT INTO `cms_module_info` VALUES (964, 115, NULL, 'El. laiško siuntėjas (email)', 'E-mail sender (email)', '', '', 'targetEmailFromemail', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (838, 97, NULL, 'Perbraukta kaina', 'Striketrough price', '', '', 'old_price', 'decimal(10,2)', '10,2', 'text', '', '', 'function=valid_float::admin_error_msg=Wrong price', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 12, '', '', 0);
INSERT INTO `cms_module_info` VALUES (759, 97, NULL, 'Kategorija', 'Category', '', '', 'category', 'int(11)', '11', 'select', '', 'inc_file=extras/pr_category.php::tpl_file=extras/pr_category.tpl::source=DB::module=pages::parent_id=3757', '', '', '', 1, 0, 1, 1, 1, 0, 1, '0', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (758, 97, NULL, 'Aprašymas', 'Description', '', '', 'description', 'text', '', 'html', '', '', '', '', '', 1, 0, 0, 1, 1, 1, 0, '0', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (332, 6, 'Telefonas', 'Telefonas', 'Phone', '', '', 'phone', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', 'lt', 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (333, 6, 'El. paštas', 'El. paštas', 'E-mail', '', '', 'email', 'varchar(255)', '255', 'text', '', '', 'function=valid_email::site_error_msg=bad_email::admin_error_msg=Neteisingas el. paštas', 'user_object=record::object=record::method=checkDataExist::site_error_msg=value_exist::admin_error_msg=Toks el. paštas jau yra', '', 1, 0, 1, 1, 1, 0, 0, '0', 'lt', 12, '', '', 0);
INSERT INTO `cms_module_info` VALUES (342, 1, 'Title', 'Title', 'Title', '', '', 'title', 'tinyint(4)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '1', 'lt', 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (375, 36, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 0, 0, 0, '0::1', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (374, 6, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 0, 0, 0, '0::1', 'lt', 32, '', '', 0);
INSERT INTO `cms_module_info` VALUES (749, 98, NULL, 'Puslapio id', 'Page id', '', '', 'page_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (735, 98, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (956, 115, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (957, 115, NULL, 'El. paštai', 'E-mail', '', '', 'targetEmailEmails', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '2', NULL, 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (750, 98, NULL, 'Bloko id', 'Block id', '', '', 'block_name', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (369, 1, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 0, 0, 0, '0', 'lt', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (371, 3, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 0, 1, 0, '0::1', 'lt', 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (373, 5, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '4', 'hidden', '1', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (549, 6, 'Adresas', 'Adresas', 'Address', '', '', 'address', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 14, '', '', 0);
INSERT INTO `cms_module_info` VALUES (548, 6, 'Pavardė', 'Pavardė', 'Lastname', '', '', 'lastname', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 1, 0, 0, 0, '0', 'lt', 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (436, 60, 'El. paštas', 'El. paštas', 'E-mail', '', '', 'title', 'varchar(255)', '', 'text', '', '', 'function=valid_email::site_error_msg={phrases.bad_email}::admin_error_msg=Neteisingas el. paštas', 'object=record::method=checkDataExist::site_error_msg={phrases.value_exist}::admin_error_msg=Toks el. paštas jau yra', '', 1, 0, 1, 1, 1, 0, 0, '0', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (760, 97, NULL, 'Paspaudimai', 'Clicks', '', '', 'clicks', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 16, '', '', 0);
INSERT INTO `cms_module_info` VALUES (761, 6, NULL, 'Miestas', 'City', '', '', 'city', 'int(11)', '11', 'select', '', 'source=DB::module=filters::parent_id=3803', '', '', '', 1, 0, 1, 0, 1, 0, 0, '0', NULL, 13, '', '', 0);
INSERT INTO `cms_module_info` VALUES (840, 6, NULL, 'Pašto kodas', 'Post code', '', '', 'postcode', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 27, '', '', 0);
INSERT INTO `cms_module_info` VALUES (841, 6, NULL, 'Įmonės pavadinimas', 'Company name', '', '', 'company_name', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0', NULL, 28, '', '', 0);
INSERT INTO `cms_module_info` VALUES (544, 6, 'Vardas', 'Vardas', 'Firstname', '', '', 'firstname', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 0, 0, 0, '0', 'lt', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (765, 6, NULL, 'Google maps koordinatės', 'Google maps coords', '', '', 'kordinates', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 26, '', '', 0);
INSERT INTO `cms_module_info` VALUES (527, 73, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (525, 73, 'Raktinis žodis', 'Raktinis žodis', 'Keyword', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', 'object=record::method=checkDataExist::admin_error_msg=Toks įrašas jau yra', '', 1, 0, 1, 1, 1, 1, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (526, 73, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (524, 72, 'Raktinis žodis', 'Raktinis žodis', 'Keyword', '', '', 'keyword', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, '1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (522, 72, 'Nuoroda', 'Nuoroda', 'Hiperlink', '', '', 'hiperlink', 'varchar(255)', '', 'text', 'http://', '', 'function=valid_url::admin_error_msg=Neteisinga nuoroda', '', '', 1, 0, 0, 1, 0, 0, 0, '0', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (521, 72, 'Reklaminės antraštės ilgis x plotis', 'Reklaminės antraštės ilgis x plotis', 'Banner size width x height', '', '', 'banner_size', 'varchar(255)', '', 'text', '', '', 'function=valid_banner_size::admin_error_msg=Neteisingas įvestas parametras', '', '', 1, 0, 0, 1, 0, 0, 0, '0', 'lt', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (519, 72, 'Paspaudimų skaičius', 'Paspaudimų skaičius', 'Clicks', '', '', 'click_count', 'int(11)', '', 'text', '0', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (507, 70, 'Moduliai', 'Moduliai', 'Modules', '', '', 'modules', 'varchar(255)', '', 'checkbox_group', '', 'source=CALL::object=module::method=listSoapUsersRights::param1=cms_admin_module_rights::param2=$_SESSION[admin][id]', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (516, 72, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (518, 72, 'Parodymų skaičius', 'Parodymų skaičius', 'Show count', '', '', 'view_count', 'int(11)', '', 'text', '0', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (517, 72, 'Reklaminė antraštė (jpg, gif, png, swf)', 'Reklaminė antraštė (jpg, gif, png, swf)', 'Banner (jpg, gif, png, swf)', '', '', 'file', 'varchar(255)', '', 'file', '', '', 'function=valid_banner::admin_error_msg=Neteisingas bylos formatas', '', '', 1, 0, 1, 1, 0, 0, 0, '0', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (510, 71, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (511, 71, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (512, 71, 'Kategorijos id', 'Kategorijos id', 'Kategorijos id', '', '', 'category_id', 'int(11)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (513, 71, 'Kategorijos stulpelio pavadinimas', 'Kategorijos stulpelio pavadinimas', 'Kategorijos stulpelio pavadinimas', '', '', 'category_column', 'varchar(255)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (476, 66, 'Pavadinimas', 'Pavadinimas(subject)', 'Title(subject)', '', '', 'title', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (477, 66, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'hidden', '1', '', '', '', '', 0, 1, 0, 0, 1, 0, 0, '0::1', 'lt', 11, '', '', 0);
INSERT INTO `cms_module_info` VALUES (478, 66, 'Siųsti', 'Saugoti', 'Save', '', '', 'submit', 'tinyint(4)', '4', 'submit', 'Siųsti', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 12, '', '', 0);
INSERT INTO `cms_module_info` VALUES (479, 66, 'Laiško tekstas', 'Laiško tekstas', 'E-mail content', '', '', 'mail_body', 'text', '', 'html', '', 'tpl_file=extras/newsletter_content.tpl', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (754, 66, NULL, 'Paprastas tekstas', 'Plain text', '', '', 'plain_text', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (481, 66, 'Laiškas gautas nuo', 'Laiškas gautas nuo', 'Email from', '', '', 'email_from_name', 'varchar(255)', '255', 'text', 'Easywebmanager', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (482, 66, 'Laiškas nuo (el. paštas)', 'Laiškas nuo (el. paštas)', 'Email from (e-mail)', '', '', 'email_from_email', 'varchar(255)', '', 'text', '{config.pr_email}', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (483, 66, 'Siuntimo data', 'Siuntimo data', 'Sent date', '', '', 'sent_date', 'datetime', '', 'date', '', 'time=1', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (509, 71, 'Tekstas', 'Tekstas', 'Text', '', '', 'title', 'varchar(255)', '', 'textarea', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '0::1', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (508, 3, 'Komentarai', 'Komentarai', 'Comments', '', '', 'comments', 'tinyint(4)', '4', 'list', '', 'source=DB::module=comments::get_category=category_id::get_column_name=category_column::create_category_parent_id=2343', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (523, 72, 'Pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 1, 0, 1, 0, '0::1', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (515, 72, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (729, 81, NULL, 'Generuoti aprasyma', 'Generate description', '', '', 'generate_description', 'tinyint(1)', '1', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 23, '', '', 0);
INSERT INTO `cms_module_info` VALUES (731, 98, NULL, 'Turinys', 'Content', '', '', 'description', 'text', '', 'html', '', '', '', '', '', 1, 0, 0, 1, 1, 1, 1, '2', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (988, 104, NULL, 'category_column', 'category_column', '', '', 'category_column', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (728, 81, NULL, 'Generuoti raktinius zodzius', 'Generate keywords', '', '', 'generate_keywords', 'tinyint(1)', '1', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 22, '', '', 0);
INSERT INTO `cms_module_info` VALUES (752, 66, NULL, 'Perskaityta kartų', 'View count', '', '', 'view_count', 'int(11)', '11', 'hidden', '0', '', '', '', '', 0, 0, 1, 0, 1, 0, 0, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (753, 66, NULL, 'Paspausta nuoroda kartų', 'Click count', '', '', 'click_count', 'int(11)', '11', 'hidden', '0', '', '', '', '', 0, 0, 1, 0, 1, 0, 0, '0', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (528, 71, 'Autorius', 'Autorius', 'Author', '', '', 'author', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 1, 0, 0, 0, '0', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (501, 70, 'Atsakingas asmuo', 'Atsakingas asmuo', 'Person', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (502, 70, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (503, 70, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (504, 70, 'Prisijungimo vardas', 'Prisijungimo vardas', 'Loginname', '', '', 'loginname', 'varchar(255)', '', 'text', '', '', 'function=valid_login::admin_error_msg=Neteisingas prisijungimo vardas(min. 4 simboliai)', 'object=record::method=checkDataExist::admin_error_msg=Toks vartotojas jau yra sistemoje', '', 1, 0, 1, 1, 0, 0, 0, '0', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (505, 70, 'Slaptažodis', 'Slaptažodis', 'Password', '', '', 'userpass', 'varchar(255)', '', 'text', '', '', 'function=valid_login::admin_error_msg=Neteisingas slaptažodis(min. 4 simboliai)', '', '', 1, 0, 1, 1, 0, 0, 0, '0', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (506, 70, 'El. paštas', 'El. paštas', 'E-mail', '', '', 'email', 'varchar(255)', '', 'text', '', '', 'function=valid_email::admin_error_msg=Neteisingas el. paštas', '', '', 0, 0, 1, 1, 0, 0, 0, '0', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (554, 76, 'Vardas, pavardė', 'Vardas, pavardė', 'Firstname, lastname', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 0, 1, 0, 0, '0::1', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (555, 76, 'Įvykdytas užsakymas', 'Įvykdytas užsakymas', 'Done', '', '', 'active', 'tinyint(4)', '', 'checkbox', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 20, '', '', 0);
INSERT INTO `cms_module_info` VALUES (556, 76, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 21, '', '', 0);
INSERT INTO `cms_module_info` VALUES (557, 76, 'Užsakymo data', 'Užsakymo data', 'Order date', '', '', 'order_date', 'date', '', 'date', '', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (558, 76, 'Užsakymo suma', 'Užsakymo suma', 'Order sum', '', '', 'order_sum', 'decimal(11,2)', '', 'text', '', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (846, 76, NULL, 'Reikalinga sąskaita faktūra', 'Reikalinga sąskaita faktūra', '', '', 'saskaita', 'tinyint(1)', '1', 'checkbox', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 15, '', '', 0);
INSERT INTO `cms_module_info` VALUES (560, 76, 'Užsakytos prekės', 'Užsakytos prekės', 'Ordered products', '', '', 'ordered_items', 'tinyint(4)', '', 'list', '', 'source=DB::module=ordered_items::get_category=category_id::get_column_name=category_column::create_category_parent_id=0', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (561, 77, 'Pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 0, 1, 0, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (562, 77, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(4)', '', 'hidden', '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, '0::1', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (563, 77, 'Submit', 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (564, 77, 'Kiekis', 'Kiekis', 'Quantity', '', '', 'kiekis', 'int(11)', '11', 'text', '', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (565, 77, 'Vnt kaina', 'Vnt kaina', 'Unit price', '', '', 'price', 'decimal(11,2)', '', 'text', '', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, '0', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1024, 77, NULL, 'rel_id', 'rel_id', '', '', 'rel_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1025, 77, NULL, 'modif', 'modif', '', '', 'modif', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (567, 77, 'category_id', 'category_id', 'category_id', '', '', 'category_id', 'int(11)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 1, '0::1', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (568, 77, 'category_column', 'category_column', 'category_column', '', '', 'category_column', 'varchar(255)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (569, 76, 'Užsakovo informacija', 'Užsakovo informacija', 'Client information', '', '', 'sep1', 'tinyint(4)', '', 'separator', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (571, 76, 'Telefonas', 'Telefonas', 'Phone', '', '', 'phone', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 0, 0, 0, 0, '0', 'lt', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (572, 76, 'El. paštas', 'El. paštas', 'E-mail', '', '', 'email', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 0, 0, 0, 0, '0', 'lt', 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (573, 76, 'Adresas', 'Adresas', 'Address', '', '', 'address', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 0, 0, 0, 0, '0', 'lt', 11, '', '', 0);
INSERT INTO `cms_module_info` VALUES (576, 76, 'Registruoto lankytojo ID', 'Registruoto lankytojo ID', 'Registered user  ID', '', '', 'user_id', 'int(11)', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 1, '0', 'lt', 14, '', '', 0);
INSERT INTO `cms_module_info` VALUES (580, 79, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 1, 1, 1, 1, 0, '0::1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (581, 79, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0::1', 'lt', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (582, 79, NULL, 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0::1', 'lt', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (583, 79, NULL, 'Tekstas', 'Text', '', '', 'description', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0::1', 'lt', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (584, 79, NULL, 'Autorius', 'Author', '', '', 'author', 'varchar(255)', '', 'text', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '0::1', 'lt', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (594, 81, NULL, 'Pavadinimas (navigacija)', 'Title (menu)', '', '', 'title', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '1', 'lt', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (595, 81, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 1, 0, '1::0', 'lt', 15, '', '', 0);
INSERT INTO `cms_module_info` VALUES (596, 81, NULL, 'Saugoti', 'Save', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '1::0', 'lt', 25, '', '', 0);
INSERT INTO `cms_module_info` VALUES (598, 81, NULL, 'Puslapio URL', 'Page URL', '', '', 'page_url', 'varchar(255)', '', 'text', '', 'inc_file=pages/inc/page_url.php::tpl_file=pages/inc/page_url.tpl', 'function=valid_page_url::admin_error_msg=Wrong URL', 'object=record::method=validateUrl::admin_error_msg=URL exists', '', 1, 0, 1, 1, 0, 1, 0, '1', 'lt', 5, '<div class="formElementsField{block elm.edited} edited{-block elm.edited}" id="area_id_{elm.name}">\r\n<div class="t"><span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>  {block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error} </div>\r\n<div class="e"><input class="{style}_{elm.elm_type}{block elm.editorship no} readonly{-block elm.editorship no}" onchange="javascript: setEdited(''{elm.name}'');" elm.editorship="" name="{elm.name}" value="{elm.value}" /> {elm.field_extra_params} <input id="edited_field_{elm.name}" type="hidden" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" /> </div>\r\n</div>', '', 0);
INSERT INTO `cms_module_info` VALUES (599, 81, NULL, 'Puslapio nukreipimas (redirect)', 'Page redirect to', '', '', 'page_redirect', 'int(11)', '11', 'tree', '', 'module=pages::script=module_tree::checkbox=0::dragndrop=0::context=0::click_handler=redirect_field_click_function', '', '', '', 0, 0, 0, 1, 0, 1, 0, '1', 'lt', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (600, 81, NULL, 'Puslapio antraštė (title)', 'Page title', '', '', 'page_title', 'varchar(255)', '255', 'text', '', 'inc_file=pages/inc/page_title.php::tpl_file=pages/inc/page_title.tpl', '', '', '', 1, 0, 1, 1, 0, 1, 0, '1', 'lt', 3, '', 'style="width:300px;" onfocus="javascript: if(this.value==&#39;&#39;) { this.value=this.form.elements[&#39;title&#39;].value; setEdited(&#39;page_title&#39;); }"', 0);
INSERT INTO `cms_module_info` VALUES (953, 114, 'Kiekis', 'Kiekis', 'Quantity', '', '', 'kiekis', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', '', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (954, 114, 'Užsakymo ID', 'Užsakymo ID', 'Order ID', '', '', 'order_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', '', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (955, 81, NULL, 'screenshot', 'screenshot', '', '', 'screenshot', 'tinyint(1)', '1', 'hidden', '', 'inc_file=pages/inc/screenshot.php::tpl_file=pages/inc/screenshot.tpl', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 28, '', '', 0);
INSERT INTO `cms_module_info` VALUES (602, 81, NULL, 'Puslapio šablonas', 'Page template', '', '', 'template', 'varchar(255)', '255', 'select', 'inner', 'source=CALL::object=record::method=getTemplatesList_', '', '', '', 1, 0, 0, 1, 0, 1, 0, '1', 'lt', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (603, 81, NULL, 'Puslapio tipas', 'Page type', '', '', 'mod_id', 'int(11)', '11', 'hidden', '96', 'source=CALL::object=record::method=listModulesPages', '', '', '', 0, 0, 0, 1, 0, 1, 0, '1', 'lt', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (950, 114, 'Submit', 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', '', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (608, 81, NULL, 'Puslapis tik registruotiem vartotojam', 'Only fo registered users', '', '', 'public_page', 'tinyint(1)', '', 'checkbox', '', '', '', '', '', 0, 0, 1, 1, 0, 1, 0, '1', 'lt', 14, '', '', 0);
INSERT INTO `cms_module_info` VALUES (987, 104, NULL, 'category_id', 'category_id', '', '', 'category_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (986, 97, NULL, 'recommend', 'recommend', '', '', 'recommend', 'text', '', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 19, '', '', 0);
INSERT INTO `cms_module_info` VALUES (721, 97, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (722, 97, NULL, 'Trumpas aprašymas', 'Short description', '', '', 'short_description', 'text', '', 'textarea', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (723, 97, NULL, 'Paveikslėlis #1', 'Image #1', '', '', 'image', 'varchar(255)', '255', 'image', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 7, '', 'prefix=thumb_||size=150x150||quality=100||resize_type=1::prefix=big_||size=800x800||quality=100::prefix=||size=350x350||quality=100||resize_type=1', 0);
INSERT INTO `cms_module_info` VALUES (724, 97, NULL, 'Kaina', 'Price', '', '', 'price', 'decimal(10,2)', '', 'text', '', '', 'function=valid_float::admin_error_msg=Wrong price', '', '', 1, 0, 1, 1, 1, 0, 0, '2', NULL, 11, '', '', 0);
INSERT INTO `cms_module_info` VALUES (725, 97, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 14, '', '', 0);
INSERT INTO `cms_module_info` VALUES (726, 97, NULL, 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '2', NULL, 15, '', '', 0);
INSERT INTO `cms_module_info` VALUES (736, 98, NULL, 'Saugoti', 'Submit', '', '', 'submit', 'tinyint(1)', '1', 'submit', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '2', NULL, 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (636, 81, NULL, 'Generuoti URL', 'Generate URL', '', '', 'generate_url', 'tinyint(1)', '1', 'checkbox', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '1::0', 'lt', 19, '', '', 0);
INSERT INTO `cms_module_info` VALUES (951, 114, 'Prekės ID', 'Prekės ID', 'Item ID', '', '', 'item_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', '', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (952, 114, 'Kombinacija', 'Kombinacija', 'Combination', '', '', 'kombinacija', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', '', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (948, 113, 'Kiekis', 'Kiekis', 'Quantity', '', '', 'kiekis', 'int(11)', '11', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', '', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (949, 113, 'Submit', 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', '', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (998, 117, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '255', 'text', '', '', '', 'object=record::method=checkDataExist::admin_error_msg=Toks įrašas jau yra', '', 1, 0, 1, 1, 1, 0, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (999, 117, NULL, 'Trumpas aprašymas', 'Short description', '', '', 'short_description', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1000, 117, NULL, 'Turinys', 'Content', '', '', 'translation', 'text', '', 'html', '', '', '', '', '', 1, 0, 0, 1, 1, 1, 0, '2', NULL, 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1004, 6, NULL, 'Grupė', 'Group', '', '', 'group_id', 'int(11)', '11', 'select', '', 'source=DB::module=user_groups::parent_id=0', '', '', '', 1, 0, 1, 1, 1, 0, 1, '0', NULL, 23, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1002, 117, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '1', 'hidden', '1', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '2', NULL, 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1003, 117, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1005, 118, 'Pavadinimas', 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '2', '', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1006, 118, 'Nuolaida', 'Nuolaida', 'Discount', '', '', 'discount', 'decimal(10,2)', '10,2', 'text', '0', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', '', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1007, 118, 'Trumpas aprašymas', 'Trumpas aprašymas', 'Short description', '', '', 'short_description', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', '', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1008, 118, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '1', 'hidden', '1', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '2', '', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1009, 118, 'Submit', 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', '', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1010, 119, 'Sąskaitos Nr.', 'Sąskaitos Nr.', 'Invoice Num.', '', '', 'title', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 1, 0, 1, 0, 0, '2', '', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1011, 119, 'Sąskaita-faktūra', 'Sąskaita-faktūra', 'Invoice', '', '', 'invoice', 'varchar(255)', '255', 'file', '', 'dir=files/saskaitos/', '', '', '', 0, 0, 1, 0, 1, 0, 0, '2', '', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1012, 119, 'Data', 'Data', 'Date', '', '', 'invoice_date', 'date', '', 'date', '', '', '', '', '', 0, 0, 1, 0, 1, 0, 0, '0', '', 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1013, 119, 'Suma', 'Suma', 'Sum', '', '', 'sum', 'decimal(10,2)', '10,2', 'text', '', '', 'function=valid_float::admin_error_msg=Wrong sum', '', '', 0, 0, 1, 0, 1, 0, 0, '2', '', 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1014, 119, 'Aktyvus', 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '1', 'hidden', '1', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '2', '', 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1015, 119, 'Submit', 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', '', 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1016, 119, 'order_id', 'order_id', 'order_id', '', '', 'order_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', '', 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1017, 119, 'invoice_number', 'invoice_number', 'invoice_number', '', '', 'invoice_number', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', '', 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1018, 119, 'serija', 'serija', 'serija', '', '', 'serija', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', '', 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1019, 119, 'last_send_date', 'last_send_date', 'last_send_date', '', '', 'last_send_date', 'datetime', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', '', 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1020, 76, NULL, 'order_sum_no_pvm', 'order_sum_no_pvm', '', '', 'order_sum_no_pvm', 'decimal(10,2)', '10,2', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 22, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1021, 76, NULL, 'order_sum_pvm', 'order_sum_pvm', '', '', 'order_sum_pvm', 'decimal(10,2)', '10,2', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 23, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1022, 76, NULL, 'Sąskaitos numeracija', 'Invoice number', '', '', 'invoice_number', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 24, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1023, 76, NULL, 'last_send_date', 'last_send_date', '', '', 'last_send_date', 'datetime', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 25, '', '', 0);
INSERT INTO `cms_module_info` VALUES (1026, 97, NULL, 'antkainis', 'antkainis', '', '', 'antkainis', 'decimal(10,2)', '10,2', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 20, '', '', 0);
INSERT INTO `cms_module_info` VALUES (994, 81, NULL, 'generate_page_title', 'generate_page_title', '', '', 'generate_page_title', 'tinyint(1)', '1', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 29, '', '', 0);
INSERT INTO `cms_module_info` VALUES (947, 113, 'Kombinacija', 'Kombinacija', 'Comination', '', '', 'kombinacija', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', '', 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (730, 36, NULL, 'Moduliio id', 'Module id', '', '', 'mod_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (751, 81, NULL, 'Submeniu nerodomas', 'Sumenu hided', '', '', 'no_menu', 'tinyint(1)', '1', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 24, '', '', 0);
INSERT INTO `cms_module_info` VALUES (755, 60, NULL, 'Kategorija', 'Category', '', '', 'category', 'int(11)', '11', 'select', '', 'source=DB::module=filters::parent_id=3567', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (756, 66, NULL, 'El. pašto adresai', 'Emails', '', '', 'emails', 'varchar(255)', '255', 'textarea', '', 'tpl_file=extras/newsletters_emails.tpl::inc_file=extras/newsletters_emails.php', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 13, '', '', 0);
INSERT INTO `cms_module_info` VALUES (978, 116, NULL, 'list_values', 'list_values', '', '', 'conversion_list', 'varchar(255)', '255', 'list', '', 'source=DB::module=conversion::get_category=category_id::get_column_name=category_column::create_category_parent_id=0', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (793, 81, NULL, 'Kategorijos laukeliai', 'Category fields', '', '', 'fields', 'varchar(255)', '255', 'list', '', 'source=DB::module=fields::get_category=category_id::get_column_name=category_column', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 26, '', '', 0);
INSERT INTO `cms_module_info` VALUES (803, 104, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (990, 106, NULL, 'category_column', 'category_column', '', '', 'category_column', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (989, 106, NULL, 'category_id', 'category_id', '', '', 'category_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 1, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (804, 104, NULL, 'Trumpas aprašymas', 'Short description', '', '', 'short_description', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 1, 1, 1, 1, 0, '2', NULL, 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (805, 104, NULL, 'Lauko tipas', 'Field type', '', '', 'elm_type', 'int(11)', '11', 'select', '', 'source=DB::module=filters::parent_id=3920', '', '', '', 1, 0, 1, 1, 1, 0, 0, '2', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (809, 104, NULL, 'column_name', 'column_name', '', '', 'column_name', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (807, 104, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (808, 104, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (810, 104, NULL, 'Sąrašo reikšmės', 'List values', '', '', 'list_values', 'tinyint(1)', '1', 'list', '', 'source=DB::module=select_values::get_category=category_id::get_column_name=category_column::create_category_parent_id=0', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (811, 105, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (812, 105, NULL, 'category_id', 'category_id', '', '', 'category_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '2', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (813, 105, NULL, 'category_column', 'category_column', '', '', 'category_column', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '2', NULL, 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (815, 105, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (816, 105, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (817, 97, NULL, 'Paveikslėlis #2', 'Image #2', '', '', 'image2', 'varchar(255)', '255', 'image', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 8, '', 'prefix=thumb_||size=150x150||quality=100||resize_type=1::prefix=big_||size=800x800||quality=100::prefix=||size=350x350||quality=100||resize_type=1', 0);
INSERT INTO `cms_module_info` VALUES (818, 97, NULL, 'Paveikslėlis #3', 'Image #3', '', '', 'image3', 'varchar(255)', '255', 'image', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 9, '', 'prefix=thumb_||size=150x150||quality=100||resize_type=1::prefix=big_||size=800x800||quality=100::prefix=||size=350x350||quality=100||resize_type=1', 0);
INSERT INTO `cms_module_info` VALUES (819, 97, NULL, 'Paveikslėlis #4', 'Image #4', '', '', 'image4', 'varchar(255)', '255', 'image', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 10, '', 'prefix=thumb_||size=150x150||quality=100||resize_type=1::prefix=big_||size=800x800||quality=100::prefix=||size=350x350||quality=100||resize_type=1', 0);
INSERT INTO `cms_module_info` VALUES (820, 97, NULL, 'Parodymai', 'Views', '', '', 'views', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 17, '', '', 0);
INSERT INTO `cms_module_info` VALUES (821, 97, NULL, 'Akcija', 'Action', '', '', 'akcija', 'tinyint(1)', '1', 'checkbox', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0', NULL, 13, '', '', 0);
INSERT INTO `cms_module_info` VALUES (822, 106, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (823, 106, NULL, 'Trumpas aprašymas', 'Short description', '', '', 'short_description', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 3, '', '', 0);
INSERT INTO `cms_module_info` VALUES (829, 81, NULL, 'Produktų modifikacjios', 'Product modifications', '', '', 'modification', 'varchar(255)', '255', 'list', '', 'source=DB::module=modifications::get_category=category_id::get_column_name=category_column', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 27, '', '', 0);
INSERT INTO `cms_module_info` VALUES (826, 106, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (827, 106, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (828, 106, NULL, 'Sąrašo reikšmės', 'List values', '', '', 'list_values', 'tinyint(1)', '1', 'list', '', 'source=DB::module=select_values::get_category=category_id::get_column_name=category_column::create_category_parent_id=0', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (839, 106, NULL, 'column_name', 'column_name', '', '', 'column_name', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (842, 6, NULL, 'Įmonės kodas', 'Company code', '', '', 'company_code', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 29, '', '', 0);
INSERT INTO `cms_module_info` VALUES (843, 6, NULL, 'Įmonės adresas', 'Company address', '', '', 'company_address', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 30, '', '', 0);
INSERT INTO `cms_module_info` VALUES (844, 6, NULL, 'Įmonės PVM kodas', 'Company VAT code', '', '', 'company_pvm', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 31, '', '', 0);
INSERT INTO `cms_module_info` VALUES (850, 76, NULL, 'Įmonės PVM kodas', 'Company VAT code', '', '', 'company_pvm', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 0, 1, 1, 0, 0, '0', NULL, 19, '', '', 0);
INSERT INTO `cms_module_info` VALUES (851, 76, NULL, 'Miestas', 'City', '', '', 'city', 'int(11)', '11', 'select', '', 'source=DB::module=filters::parent_id=3803', '', '', '', 1, 0, 1, 1, 1, 0, 1, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (852, 108, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (853, 108, NULL, 'Trumpas aprašymas', 'Short description', '', '', 'short_description', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 0, 1, 1, 1, 0, '2', NULL, 2, '', '', 0);
INSERT INTO `cms_module_info` VALUES (854, 108, NULL, 'Paveikslėlis', 'Image', '', '', 'image', 'varchar(255)', '255', 'image', '', 'abs_dir=G:/localhost/1install/', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 3, '', 'prefix=thumb_||size=90x50||quality=80::prefix=||size=500x500||quality=80', 0);
INSERT INTO `cms_module_info` VALUES (858, 108, NULL, 'Būdas', 'Type', '', '', 'pay_type', 'int(11)', '11', 'select', '', 'source=DB::module=filters::parent_id=4138', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (856, 108, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (857, 108, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (996, 98, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 1, 0, 1, 0, 0, '0', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (997, 108, NULL, 'File', 'file', '', '', 'file', 'varchar(255)', '255', 'file', '', 'dir=files/temp/', '', '', '', 0, 0, 1, 1, 1, 0, 0, '0', NULL, 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (946, 113, 'Prekės ID', 'Prekės ID', 'Item ID', '', '', 'item_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 1, '2', '', 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (995, 81, NULL, 'generate_header_title', 'generate_header_title', '', '', 'generate_header_title', 'tinyint(1)', '1', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 30, '', '', 0);
INSERT INTO `cms_module_info` VALUES (991, 1, NULL, 'confirm_code', 'confirm_code', '', '', 'confirm_code', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 11, '', '', 0);
INSERT INTO `cms_module_info` VALUES (992, 1, NULL, 'confirm_date', 'confirm_date', '', '', 'confirm_date', 'datetime', '', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 12, '', '', 0);
INSERT INTO `cms_module_info` VALUES (993, 81, NULL, 'Puslapio pavadinimas(h1)', 'Page header', '', '', 'header_title', 'varchar(255)', '255', 'text', '', 'inc_file=pages/inc/header_title.php::tpl_file=pages/inc/header_title.tpl', '', '', '', 1, 0, 0, 1, 1, 1, 0, '0', NULL, 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (962, 115, NULL, 'Tipas', 'Type', '', '', 'selType', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (963, 115, NULL, 'El. laiško tema (subject)', 'E-mail subject', '', '', 'targetEmailSubject', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (960, 115, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 14, '', '', 0);
INSERT INTO `cms_module_info` VALUES (961, 115, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 15, '', '', 0);
INSERT INTO `cms_module_info` VALUES (965, 115, NULL, 'El. laiško siuntėjas (name)', 'E-mail sender (name)', '', '', 'targetEmailFromname', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 8, '', '', 0);
INSERT INTO `cms_module_info` VALUES (966, 115, NULL, 'El. laiško šablonas', 'e-mail template', '', '', 'targetEmailTemplate', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (967, 115, NULL, 'Modulis', 'module', '', '', 'targetDatabaseModule', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (968, 115, NULL, 'Modulis (custom)', 'Module (custom)', '', '', 'targetCustomModule', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 11, '', '', 0);
INSERT INTO `cms_module_info` VALUES (969, 115, NULL, 'Metodas', 'Method', '', '', 'targetCustomMethod', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 12, '', '', 0);
INSERT INTO `cms_module_info` VALUES (970, 115, NULL, 'Privalomi laukai', 'Required fields', '', '', 'required_fields', 'text', '', 'textarea', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 13, '', '', 0);
INSERT INTO `cms_module_info` VALUES (971, 116, NULL, 'Pavadinimas', 'Title', '', '', 'title', 'varchar(255)', '', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 1, 0, '2', NULL, 1, '', '', 0);
INSERT INTO `cms_module_info` VALUES (977, 116, NULL, 'Url', 'url', '', '', 'url', 'varchar(255)', '255', 'text', '', '', '', '', '', 1, 0, 1, 1, 1, 0, 0, '0', NULL, 5, '', '', 0);
INSERT INTO `cms_module_info` VALUES (979, 116, NULL, 'category_column', 'category_column', '', '', 'category_column', 'varchar(255)', '255', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 9, '', '', 0);
INSERT INTO `cms_module_info` VALUES (980, 116, NULL, 'category_id', 'category_id', '', '', 'category_id', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 10, '', '', 0);
INSERT INTO `cms_module_info` VALUES (981, 97, NULL, 'Kiekis', 'Quantity', '', '', 'kiekis', 'int(11)', '11', 'hidden', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 0, '0', NULL, 18, '', '', 0);
INSERT INTO `cms_module_info` VALUES (975, 116, NULL, 'Aktyvus', 'Active', '', '', 'active', 'tinyint(1)', '', 'checkbox', '1', '', '', '', '', 0, 0, 1, 1, 1, 0, 0, '2', NULL, 6, '', '', 0);
INSERT INTO `cms_module_info` VALUES (976, 116, NULL, 'Submit', 'Submit', '', '', 'submit', 'tinyint(1)', '', 'submit', '', '', '', '', '', 0, 0, 0, 1, 0, 0, 0, '2', NULL, 7, '', '', 0);
INSERT INTO `cms_module_info` VALUES (982, 97, NULL, 'Prekės url', 'Product url', '', '', 'product_url', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 1, 0, 1, 1, 0, '0', NULL, 4, '', '', 0);
INSERT INTO `cms_module_info` VALUES (983, 76, NULL, 'Pašto kodas', 'Post code', '', '', 'postcode', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 13, '', '', 0);
INSERT INTO `cms_module_info` VALUES (984, 6, NULL, 'Durų kodas', 'Duru kodas', '', '', 'duru_kodas', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 22, '', '', 0);
INSERT INTO `cms_module_info` VALUES (985, 76, NULL, 'Durų kodas', 'Duru kodas', '', '', 'duru_kodas', 'varchar(255)', '255', 'text', '', '', '', '', '', 0, 0, 0, 1, 1, 0, 0, '0', NULL, 12, '', '', 0);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_news`
-- 

CREATE TABLE `cms_news` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `lng` varchar(255) default NULL,
  `news_date` date default NULL,
  `summary` text,
  `description` text,
  `image` varchar(255) default NULL,
  `submit` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `comments` tinyint(4) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_news`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_newsletters`
-- 

CREATE TABLE `cms_newsletters` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `submit` tinyint(4) default NULL,
  `mail_body` text,
  `email_from_name` varchar(255) default NULL,
  `email_from_email` varchar(255) default NULL,
  `sent_date` datetime default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `view_count` int(11) default NULL,
  `click_count` int(11) default NULL,
  `plain_text` text,
  `emails` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_newsletters`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_newsletters_stat`
-- 

CREATE TABLE `cms_newsletters_stat` (
  `email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `n_id` int(11) NOT NULL default '0',
  `click` int(11) NOT NULL default '0',
  `view` int(11) NOT NULL default '0',
  KEY `email` (`email`,`n_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Sukurta duomenų kopija lentelei `cms_newsletters_stat`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_ordered_items`
-- 

CREATE TABLE `cms_ordered_items` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `submit` tinyint(1) default NULL,
  `kiekis` int(11) default NULL,
  `price` decimal(11,2) default NULL,
  `category_id` int(11) default NULL,
  `category_column` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `rel_id` int(11) default NULL,
  `modif` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `rel_id` (`rel_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_ordered_items`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_orders`
-- 

CREATE TABLE `cms_orders` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `submit` tinyint(1) default NULL,
  `order_date` date default NULL,
  `order_sum` decimal(11,2) default NULL,
  `ordered_items` tinyint(4) default NULL,
  `sep1` tinyint(4) default NULL,
  `phone` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `user_id` int(11) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `saskaita` tinyint(1) default NULL,
  `company_name` varchar(255) default NULL,
  `company_code` varchar(255) default NULL,
  `company_address` varchar(255) default NULL,
  `company_pvm` varchar(255) default NULL,
  `city` int(11) default NULL,
  `postcode` varchar(255) default NULL,
  `duru_kodas` varchar(255) default NULL,
  `order_sum_no_pvm` decimal(10,2) default NULL,
  `order_sum_pvm` decimal(10,2) default NULL,
  `invoice_number` int(11) default NULL,
  `last_send_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `city` (`city`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_orders`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_pages`
-- 

CREATE TABLE `cms_pages` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `page_url` varchar(255) default NULL,
  `page_redirect` int(11) default NULL,
  `page_title` varchar(255) default NULL,
  `template` varchar(255) default NULL,
  `mod_id` int(11) default NULL,
  `public_page` tinyint(1) default NULL,
  `generate_url` tinyint(1) default NULL,
  `description` text,
  `keywords` text,
  `generate_keywords` tinyint(1) default NULL,
  `generate_description` tinyint(1) default NULL,
  `no_menu` tinyint(1) default NULL,
  `fields` varchar(255) default NULL,
  `modification` varchar(255) default NULL,
  `screenshot` tinyint(1) default NULL,
  `header_title` varchar(255) default NULL,
  `generate_page_title` tinyint(1) default NULL,
  `generate_header_title` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1410 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1410 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_pages`
-- 

INSERT INTO `cms_pages` VALUES (569, 3345, 'lt', 1, 'Titulinis', 1, 0, '/', 3345, 'Titulinis', 'inner', 96, 0, 0, '', '', 0, 0, 0, '', '', 0, NULL, NULL, NULL);
INSERT INTO `cms_pages` VALUES (570, 3345, 'en', 1, 'Titulinis', 1, 0, '/', 3345, 'Titulinis', 'main', 96, 0, 0, '', '', 0, 0, 0, '', '', 0, NULL, NULL, NULL);
INSERT INTO `cms_pages` VALUES (571, 3345, 'ru', 1, 'Titulinis', 1, 0, '/', 0, 'Titulinis', 'inner', 0, 0, 0, '', '', 0, 0, 0, '', '', 0, NULL, NULL, NULL);
INSERT INTO `cms_pages` VALUES (572, 3345, 'de', 0, 'Titulinis', 1, 0, '/', 3345, 'Titulinis', 'inner', 96, 0, 0, '', '', 0, 0, 0, '', '', 0, NULL, NULL, NULL);
INSERT INTO `cms_pages` VALUES (1324, 3345, 'fr', 0, 'Titulinis', 1, 0, '/', 3345, 'Titulinis', 'inner', 96, 0, 0, '', '', 0, 0, 0, '', '', 0, NULL, NULL, NULL);
INSERT INTO `cms_pages` VALUES (1367, 3345, 'no', 0, 'Titulinis', 1, 0, '/', 3345, 'Titulinis', 'inner', 96, 0, 0, '', '', 0, 0, 0, '', '', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_payments`
-- 

CREATE TABLE `cms_payments` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `short_description` text collate utf8_unicode_ci,
  `image` varchar(255) collate utf8_unicode_ci default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `pay_type` int(11) default NULL,
  `file` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_payments`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_phrases`
-- 

CREATE TABLE `cms_phrases` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `lng` varchar(255) default NULL,
  `translation` text,
  `submit` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1628 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1628 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_phrases`
-- 

INSERT INTO `cms_phrases` VALUES (1143, 3778, 'solution', 'lt', 'Sprendimas', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1144, 3778, 'solution', 'en', 'Solution', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1145, 3778, 'solution', 'ru', 'Решение', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1146, 3779, 'copyrights', 'lt', '© 2009 Visos teisės saugomos', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1147, 3779, 'copyrights', 'en', '© 2009 All rights reserved', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1148, 3779, 'copyrights', 'ru', '© 2009 Все права защищены', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1549, 14092, 'search', 'fr', 'Paieška', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1548, 14168, 'page_disabled', 'fr', 'Informacija ruošiama. Apsilankykite vėliau.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1544, 14132, 'search_title', 'fr', 'Paieška', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1543, 14131, 'no_search_results', 'fr', 'Paieškos rezultatų nerasta. Patikslinkite paiešką.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1541, 3779, 'copyrights', 'fr', '© 2009 Visos teisės saugomos', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1540, 3778, 'solution', 'fr', 'Sprendimas', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1519, 14130, 'to_short_key', 'en', 'To short search keyword', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1520, 14130, 'to_short_key', 'de', 'Um kurz Suchwörter', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1521, 14131, 'no_search_results', 'en', 'Search results found. Refine your search.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1522, 14131, 'no_search_results', 'ru', 'Результаты поиска ненайдено. Уточните параметры поиска.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1523, 14131, 'no_search_results', 'de', 'Suchergebnisse gefunden. Verfeinern Sie Ihre Suche.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1524, 14132, 'search_title', 'en', 'Search', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1525, 14132, 'search_title', 'ru', 'Поиск', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1526, 14132, 'search_title', 'de', 'Suche', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1427, 14131, 'no_search_results', 'lt', 'Paieškos rezultatų nerasta. Patikslinkite paiešką.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1428, 14132, 'search_title', 'lt', 'Paieška', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1432, 14168, 'page_disabled', 'lt', 'Informacija ruošiama. Apsilankykite vėliau.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1433, 14168, 'page_disabled', 'en', 'Information will be available soon. Please visit later.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1434, 14168, 'page_disabled', 'ru', 'Информация будет доступна в ближайшее время. Пожалуйста, зайдите позже.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1435, 14168, 'page_disabled', 'de', 'Die Informationen werden in Kürze verfügbar sein. Bitte besuchen Sie später.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1436, 3779, 'copyrights', 'de', '© 2009 Alle Rechte vorbehalten', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1437, 3778, 'solution', 'de', 'Solution', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1438, 14094, 'search_submit', 'en', 'search', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1439, 14094, 'search_submit', 'ru', 'поиск', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1440, 14094, 'search_submit', 'de', 'Suche', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1389, 14092, 'search', 'en', 'Search', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1388, 14092, 'search', 'lt', 'Paieška', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1387, 14065, 'form_saved_success', 'de', 'Daten erfolgreich gespeichert.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1390, 14092, 'search', 'ru', 'Поиск', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1391, 14092, 'search', 'de', 'Suche', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1396, 14094, 'search_submit', 'lt', 'ieškoti', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1383, 14064, 'form_send_success', 'de', 'Anfrage wurde erfolgreich versendet.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1381, 14064, 'form_send_success', 'en', 'Request has been sent successfully.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1384, 14065, 'form_saved_success', 'lt', 'Duomenys išsaugoti sėkmingai.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1382, 14064, 'form_send_success', 'ru', 'Запрос был отправлен успешно.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1380, 14064, 'form_send_success', 'lt', 'Užklausa išsiųsta sėkmingai.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1426, 14130, 'to_short_key', 'lt', 'Per trupma paieškos frazė', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1386, 14065, 'form_saved_success', 'ru', 'Данные успешно сохранены.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1385, 14065, 'form_saved_success', 'en', 'Data saved successfully.', '', 1, 1);
INSERT INTO `cms_phrases` VALUES (1553, 14094, 'search_submit', 'fr', 'ieškoti', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1581, 14065, 'form_saved_success', 'fr', 'Duomenys išsaugoti sėkmingai.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1582, 14064, 'form_send_success', 'fr', 'Užklausa išsiųsta sėkmingai.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1583, 14130, 'to_short_key', 'fr', 'Per trupma paieškos frazė', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1584, 3778, 'solution', 'no', 'Sprendimas', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1585, 3779, 'copyrights', 'no', '© 2009 Visos teisės saugomos', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1587, 14131, 'no_search_results', 'no', 'Paieškos rezultatų nerasta. Patikslinkite paiešką.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1588, 14132, 'search_title', 'no', 'Paieška', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1592, 14168, 'page_disabled', 'no', 'Informacija ruošiama. Apsilankykite vėliau.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1593, 14092, 'search', 'no', 'Paieška', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1597, 14094, 'search_submit', 'no', 'ieškoti', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1625, 14065, 'form_saved_success', 'no', 'Duomenys išsaugoti sėkmingai.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1626, 14064, 'form_send_success', 'no', 'Užklausa išsiųsta sėkmingai.', '', 1, 0);
INSERT INTO `cms_phrases` VALUES (1627, 14130, 'to_short_key', 'no', 'Per trupma paieškos frazė', '', 1, 0);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_phrases_html`
-- 

CREATE TABLE `cms_phrases_html` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `short_description` text collate utf8_unicode_ci,
  `translation` text collate utf8_unicode_ci,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_phrases_html`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_products`
-- 

CREATE TABLE `cms_products` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `short_description` text,
  `image` varchar(255) default NULL,
  `price` decimal(10,2) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `description` text,
  `category` int(11) default NULL,
  `clicks` int(11) default NULL,
  `image2` varchar(255) default NULL,
  `image3` varchar(255) default NULL,
  `image4` varchar(255) default NULL,
  `views` int(11) default NULL,
  `akcija` tinyint(1) default NULL,
  `old_price` decimal(10,2) default NULL,
  `kiekis` int(11) default NULL,
  `product_url` varchar(255) default NULL,
  `recommend` text,
  `antkainis` decimal(10,2) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_products`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_products_fields`
-- 

CREATE TABLE `cms_products_fields` (
  `id` int(11) NOT NULL auto_increment,
  `record_id` int(11) NOT NULL,
  `lng` varchar(3) collate utf8_unicode_ci NOT NULL,
  `praba` varchar(255) collate utf8_unicode_ci default NULL,
  `made_in` varchar(255) collate utf8_unicode_ci default NULL,
  `daug_pasirinkimu` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_products_fields`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_products_modif`
-- 

CREATE TABLE `cms_products_modif` (
  `id` int(11) NOT NULL auto_increment,
  `record_id` int(11) NOT NULL,
  `lng` varchar(3) collate utf8_unicode_ci NOT NULL,
  `spalva_` varchar(255) collate utf8_unicode_ci default NULL,
  `dydis__` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_products_modif`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_record`
-- 

CREATE TABLE `cms_record` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module_id` int(10) unsigned NOT NULL default '0',
  `parent_id` int(10) unsigned default NULL,
  `sort_order` int(10) unsigned default NULL,
  `is_category` tinyint(1) unsigned default NULL,
  `create_by_ip` char(15) NOT NULL default '',
  `create_by_admin` int(11) NOT NULL default '0',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_modif_by_ip` char(15) NOT NULL default '',
  `last_modif_by_admin` int(11) NOT NULL default '0',
  `last_modif_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `trash` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`,`module_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14181 DEFAULT CHARSET=utf8 AUTO_INCREMENT=14181 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_record`
-- 

INSERT INTO `cms_record` VALUES (2, 1, 0, 1, 0, '', 0, '2006-02-20 14:12:57', '78.61.68.114', 2, '2011-06-29 13:37:36', 0);
INSERT INTO `cms_record` VALUES (3429, 36, 0, 1489, NULL, '192.168.130.50', 2, '2009-02-25 16:38:04', '192.168.130.50', 2, '2009-02-25 16:38:04', 0);
INSERT INTO `cms_record` VALUES (3345, 81, 0, 1554, NULL, '192.168.130.50', 2, '2008-11-14 19:44:02', '78.61.68.114', 2, '2011-05-11 13:32:05', 0);
INSERT INTO `cms_record` VALUES (1746, 36, 0, 703, 1, '', 2, '2006-10-27 15:06:42', '', 2, '2006-12-01 13:47:45', 0);
INSERT INTO `cms_record` VALUES (2138, 36, 0, 817, 1, '', 2, '2006-12-29 15:14:06', '', 2, '2006-12-29 15:14:06', 0);
INSERT INTO `cms_record` VALUES (2543, 36, 1, 3, 0, '192.168.0.102', 2, '2007-08-13 19:03:30', '192.168.0.102', 2, '2007-08-13 19:03:30', 0);
INSERT INTO `cms_record` VALUES (3575, 36, 3567, 3, NULL, '192.168.130.35', 2, '2009-05-29 12:23:03', '192.168.130.35', 2, '2009-05-29 12:23:03', 0);
INSERT INTO `cms_record` VALUES (3567, 36, 3429, 3, NULL, '192.168.130.35', 2, '2009-05-28 12:09:49', '192.168.130.35', 2, '2009-05-28 12:09:49', 0);
INSERT INTO `cms_record` VALUES (3568, 36, 3567, 1, NULL, '192.168.130.35', 2, '2009-05-28 12:10:07', '192.168.130.35', 2, '2009-05-28 12:10:07', 0);
INSERT INTO `cms_record` VALUES (3569, 36, 3567, 2, NULL, '192.168.130.35', 2, '2009-05-28 12:10:29', '192.168.130.35', 2, '2009-05-28 12:10:29', 0);
INSERT INTO `cms_record` VALUES (3778, 5, 0, 1583, NULL, '192.168.130.35', 2, '2009-09-04 18:42:22', '78.61.68.114', 2, '2011-04-14 16:06:38', 0);
INSERT INTO `cms_record` VALUES (3779, 5, 0, 1584, NULL, '192.168.130.35', 2, '2009-09-04 18:43:58', '78.61.68.114', 2, '2011-04-11 19:36:03', 0);
INSERT INTO `cms_record` VALUES (3803, 36, 3429, 4, NULL, '192.168.130.35', 2, '2009-09-07 13:03:28', '192.168.130.35', 2, '2009-09-07 13:03:28', 0);
INSERT INTO `cms_record` VALUES (3804, 36, 3803, 1, NULL, '192.168.130.35', 2, '2009-09-07 14:14:05', '192.168.130.35', 2, '2009-09-07 14:14:05', 0);
INSERT INTO `cms_record` VALUES (3805, 36, 3803, 2, NULL, '192.168.130.35', 2, '2009-09-07 14:14:05', '192.168.130.35', 2, '2009-09-07 14:14:05', 0);
INSERT INTO `cms_record` VALUES (3806, 36, 3803, 3, NULL, '192.168.130.35', 2, '2009-09-07 14:14:05', '192.168.130.35', 2, '2009-09-07 14:14:05', 0);
INSERT INTO `cms_record` VALUES (3807, 36, 3803, 4, NULL, '192.168.130.35', 2, '2009-09-07 14:14:05', '192.168.130.35', 2, '2009-09-07 14:14:05', 0);
INSERT INTO `cms_record` VALUES (3808, 36, 3803, 5, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3809, 36, 3803, 6, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3810, 36, 3803, 7, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3811, 36, 3803, 8, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3812, 36, 3803, 9, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3813, 36, 3803, 10, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3814, 36, 3803, 11, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3815, 36, 3803, 12, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3816, 36, 3803, 13, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3817, 36, 3803, 14, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3818, 36, 3803, 15, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3819, 36, 3803, 16, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3820, 36, 3803, 17, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3821, 36, 3803, 18, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3822, 36, 3803, 19, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3823, 36, 3803, 20, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3824, 36, 3803, 21, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3825, 36, 3803, 22, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3826, 36, 3803, 23, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3827, 36, 3803, 24, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3828, 36, 3803, 25, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3829, 36, 3803, 26, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3830, 36, 3803, 27, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3831, 36, 3803, 28, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3832, 36, 3803, 29, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3833, 36, 3803, 30, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3834, 36, 3803, 31, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3835, 36, 3803, 32, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3836, 36, 3803, 33, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3837, 36, 3803, 34, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3838, 36, 3803, 35, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3839, 36, 3803, 36, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3840, 36, 3803, 37, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3841, 36, 3803, 38, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3842, 36, 3803, 39, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3843, 36, 3803, 40, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3844, 36, 3803, 41, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3845, 36, 3803, 42, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3846, 36, 3803, 43, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3847, 36, 3803, 44, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3848, 36, 3803, 45, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3849, 36, 3803, 46, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3850, 36, 3803, 47, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3851, 36, 3803, 48, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3852, 36, 3803, 49, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3853, 36, 3803, 50, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3854, 36, 3803, 51, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3855, 36, 3803, 52, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3856, 36, 3803, 53, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3857, 36, 3803, 54, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3858, 36, 3803, 55, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3859, 36, 3803, 56, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3860, 36, 3803, 57, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3861, 36, 3803, 58, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3862, 36, 3803, 59, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3863, 36, 3803, 60, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (3864, 36, 3803, 61, NULL, '192.168.130.35', 2, '2009-09-07 14:14:06', '192.168.130.35', 2, '2009-09-07 14:14:06', 0);
INSERT INTO `cms_record` VALUES (4138, 36, 2138, 5, NULL, '78.61.68.114', 2, '2009-10-05 16:41:53', '78.61.68.114', 2, '2011-04-14 16:05:46', 0);
INSERT INTO `cms_record` VALUES (3920, 36, 2138, 4, NULL, '192.168.130.35', 2, '2009-09-17 14:46:22', '192.168.130.35', 2, '2009-09-17 14:46:22', 0);
INSERT INTO `cms_record` VALUES (3921, 36, 3920, 1, NULL, '192.168.130.35', 2, '2009-09-17 14:46:29', '192.168.130.35', 2, '2009-09-17 14:46:29', 0);
INSERT INTO `cms_record` VALUES (3922, 36, 3920, 2, NULL, '192.168.130.35', 2, '2009-09-17 14:46:36', '192.168.130.35', 2, '2009-09-17 14:46:36', 0);
INSERT INTO `cms_record` VALUES (3923, 36, 3920, 3, NULL, '192.168.130.35', 2, '2009-09-17 14:46:43', '192.168.130.35', 2, '2009-09-17 14:46:43', 0);
INSERT INTO `cms_record` VALUES (3924, 36, 3920, 4, NULL, '192.168.130.35', 2, '2009-09-17 14:46:49', '192.168.130.35', 2, '2009-09-17 14:46:49', 0);
INSERT INTO `cms_record` VALUES (4139, 36, 4138, 1, NULL, '78.61.68.114', 2, '2009-10-05 16:42:10', '78.61.68.114', 2, '2009-10-05 16:42:10', 0);
INSERT INTO `cms_record` VALUES (14168, 5, 0, 11606, NULL, '78.61.68.114', 2, '2011-04-11 19:14:45', '78.61.68.114', 2, '2011-04-11 19:18:46', 0);
INSERT INTO `cms_record` VALUES (4140, 36, 4138, 2, NULL, '78.61.68.114', 2, '2009-10-05 16:42:23', '78.61.68.114', 2, '2009-10-05 16:42:23', 0);
INSERT INTO `cms_record` VALUES (4141, 36, 4138, 3, NULL, '78.61.68.114', 2, '2009-10-05 16:43:15', '78.61.68.114', 2, '2009-10-05 16:43:15', 0);
INSERT INTO `cms_record` VALUES (4142, 36, 4138, 4, NULL, '78.61.68.114', 2, '2009-10-05 16:43:24', '78.61.68.114', 2, '2009-10-05 16:43:24', 0);
INSERT INTO `cms_record` VALUES (14153, 36, 3920, 5, NULL, '78.61.68.114', 2, '2011-04-04 18:39:01', '78.61.68.114', 2, '2011-04-04 18:39:01', 0);
INSERT INTO `cms_record` VALUES (14064, 5, 0, 11607, NULL, '78.61.68.114', 2, '2010-05-13 17:56:45', '78.61.68.114', 2, '2011-04-11 19:38:16', 0);
INSERT INTO `cms_record` VALUES (14065, 5, 0, 11609, NULL, '78.61.68.114', 2, '2010-05-13 17:57:05', '78.61.68.114', 2, '2011-04-11 19:38:39', 0);
INSERT INTO `cms_record` VALUES (14090, 115, 0, 11618, NULL, '78.61.68.114', 2, '2010-09-08 10:53:17', '78.61.68.114', 2, '2010-10-14 15:01:18', 0);
INSERT INTO `cms_record` VALUES (14092, 5, 0, 11622, NULL, '78.61.68.114', 2, '2010-09-13 13:09:41', '78.61.68.114', 2, '2011-04-14 16:07:01', 0);
INSERT INTO `cms_record` VALUES (14094, 5, 0, 11608, NULL, '78.61.68.114', 2, '2010-09-13 15:00:19', '78.61.68.114', 2, '2011-04-14 16:07:21', 0);
INSERT INTO `cms_record` VALUES (14130, 5, 0, 11655, NULL, '78.61.68.114', 2, '2010-09-17 17:32:28', '78.61.68.114', 2, '2011-04-14 16:21:25', 0);
INSERT INTO `cms_record` VALUES (14131, 5, 0, 11656, NULL, '78.61.68.114', 2, '2010-09-17 17:32:56', '78.61.68.114', 2, '2011-04-14 16:22:07', 0);
INSERT INTO `cms_record` VALUES (14132, 5, 0, 11657, NULL, '78.61.68.114', 2, '2010-09-17 17:33:34', '78.61.68.114', 2, '2011-04-14 16:22:27', 0);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_relations`
-- 

CREATE TABLE `cms_relations` (
  `item_id` bigint(20) NOT NULL default '0',
  `column_name` varchar(255) NOT NULL default '',
  `list_item_id` bigint(20) NOT NULL default '0',
  KEY `item_id` (`item_id`),
  KEY `list_item_id` (`list_item_id`),
  KEY `column_name` (`column_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Sukurta duomenų kopija lentelei `cms_relations`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_saskaitos`
-- 

CREATE TABLE `cms_saskaitos` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `invoice` varchar(255) collate utf8_unicode_ci default NULL,
  `invoice_date` date default NULL,
  `sum` decimal(10,2) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `order_id` int(11) default NULL,
  `invoice_number` int(11) default NULL,
  `serija` varchar(255) collate utf8_unicode_ci default NULL,
  `last_send_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_saskaitos`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_select_values`
-- 

CREATE TABLE `cms_select_values` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `category_id` int(11) default NULL,
  `category_column` varchar(255) collate utf8_unicode_ci default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_select_values`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_soap_users`
-- 

CREATE TABLE `cms_soap_users` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `loginname` varchar(255) default NULL,
  `userpass` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `modules` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_soap_users`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_stat_visitor_path`
-- 

CREATE TABLE `cms_stat_visitor_path` (
  `id` int(11) NOT NULL auto_increment,
  `visitor_id` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `visit_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `visitor_id` (`visitor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_stat_visitor_path`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_stat_visitors`
-- 

CREATE TABLE `cms_stat_visitors` (
  `id` int(11) NOT NULL auto_increment,
  `ipaddress` varchar(255) default NULL,
  `browser` varchar(255) default NULL,
  `browser_version` varchar(255) default NULL,
  `os` varchar(255) default NULL,
  `referer` varchar(255) default NULL,
  `referer_domain` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `country_code` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `region` varchar(255) default NULL,
  `latitude` varchar(255) default NULL,
  `longitude` varchar(255) default NULL,
  `user_agent` text,
  `visit_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `session_id` varchar(255) default NULL,
  `robot` tinyint(1) NOT NULL default '0',
  `page_count` int(11) default '0',
  `back_id` int(11) default NULL,
  `conversion_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `back_id` (`back_id`),
  KEY `conversion_id` (`conversion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_stat_visitors`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_stat_visitors_temp`
-- 

CREATE TABLE `cms_stat_visitors_temp` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `user_agent` text collate utf8_unicode_ci NOT NULL,
  `ipaddress` varchar(255) collate utf8_unicode_ci NOT NULL,
  `visit_time` datetime NOT NULL,
  KEY `session_id` (`session_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Sukurta duomenų kopija lentelei `cms_stat_visitors_temp`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_storage`
-- 

CREATE TABLE `cms_storage` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `item_id` int(11) default NULL,
  `kombinacija` varchar(255) collate utf8_unicode_ci default NULL,
  `kiekis` int(11) default NULL,
  `submit` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_storage`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_storage_reserved`
-- 

CREATE TABLE `cms_storage_reserved` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `submit` tinyint(1) default NULL,
  `item_id` int(11) default NULL,
  `kombinacija` varchar(255) collate utf8_unicode_ci default NULL,
  `kiekis` int(11) default NULL,
  `order_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_storage_reserved`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_subscribers`
-- 

CREATE TABLE `cms_subscribers` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `category` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_subscribers`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_template`
-- 

CREATE TABLE `cms_template` (
  `id` bigint(22) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `file1` varchar(255) NOT NULL default '',
  `tmpl_image_map` text NOT NULL,
  `defaultas` tinyint(4) NOT NULL default '0',
  `disabled` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_template`
-- 

INSERT INTO `cms_template` VALUES (1, 'inner', 'eshop.jpg', '<div style="left:54px;top:51px;width:134px;height:120px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=%page%&area=page'', ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:5px;top:0px;width:233px;height:15px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_top'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:8px;top:144px;width:34px;height:36px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_left'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:198px;top:106px;width:36px;height:28px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_right'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:5px;top:186px;width:233px;height:13px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_bottom'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:200px;top:19px;width:38px;height:20px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=call'',  ''EDIT_area__action'', ''edit'');"></div>', 1, 0);
INSERT INTO `cms_template` VALUES (2, 'main', 'eshop00.jpg', '<div style="left:54px;top:51px;width:134px;height:30px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=%page%&area=page'', ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:5px;top:0px;width:233px;height:15px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_top'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:8px;top:144px;width:34px;height:36px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_left'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:198px;top:106px;width:36px;height:28px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_right'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:5px;top:186px;width:233px;height:13px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_bottom'',  ''EDIT_area__action'', ''edit'');"></div>', 0, 0);
INSERT INTO `cms_template` VALUES (13, 'news', 'eshop01.jpg', '<div style="left:5px;top:0px;width:233px;height:15px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_top'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:8px;top:144px;width:34px;height:36px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_left'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:198px;top:106px;width:36px;height:28px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_right'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:5px;top:186px;width:233px;height:13px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_bottom'',  ''EDIT_area__action'', ''edit'');"></div>', 0, 0);
INSERT INTO `cms_template` VALUES (15, 'products', 'eshop.jpg', '<div style="left:5px;top:0px;width:233px;height:15px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_top'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:8px;top:144px;width:34px;height:36px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_left'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:198px;top:106px;width:36px;height:28px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_right'',  ''EDIT_area__action'', ''edit'');"></div>\r\n\r\n<div style="left:5px;top:186px;width:233px;height:13px;" onclick="javascript: PageClass.getPageContent_action(''ajax.php?get=pages/actions&action=block&content=pages&module=blocks&page_id=0&area=banners_bottom'',  ''EDIT_area__action'', ''edit'');"></div>', 0, 0);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_user_groups`
-- 

CREATE TABLE `cms_user_groups` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `lng` varchar(255) collate utf8_unicode_ci default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `discount` decimal(10,2) default NULL,
  `short_description` text collate utf8_unicode_ci,
  `active` tinyint(1) default NULL,
  `submit` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_user_groups`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `cms_users`
-- 

CREATE TABLE `cms_users` (
  `id` int(10) NOT NULL auto_increment,
  `record_id` int(10) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `lng` varchar(255) default NULL,
  `userpass` varchar(255) default NULL,
  `submit` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `active` tinyint(4) default NULL,
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `lng_saved` tinyint(1) NOT NULL default '0',
  `city` int(11) default NULL,
  `kordinates` varchar(255) default NULL,
  `postcode` varchar(255) default NULL,
  `company_name` varchar(255) default NULL,
  `company_code` varchar(255) default NULL,
  `company_address` varchar(255) default NULL,
  `company_pvm` varchar(255) default NULL,
  `confirm_code` varchar(255) default NULL,
  `duru_kodas` varchar(255) default NULL,
  `group_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `record_id` (`record_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=190 DEFAULT CHARSET=utf8 AUTO_INCREMENT=190 ;

-- 
-- Sukurta duomenų kopija lentelei `cms_users`
-- 

