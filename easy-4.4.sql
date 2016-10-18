
CREATE TABLE IF NOT EXISTS `cms_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL DEFAULT '0',
  `lng` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `permission` tinyint(4) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `submit` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `lng_rights` varchar(255) NOT NULL DEFAULT '',
  `mod_rights` varchar(255) NOT NULL DEFAULT '',
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `confirm_code` varchar(255) DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Sukurta duomenų kopija lentelei `cms_admins`
--

INSERT INTO `cms_admins` (`id`, `record_id`, `lng`, `login`, `pass`, `permission`, `firstname`, `lastname`, `email`, `phone`, `submit`, `title`, `active`, `lng_rights`, `mod_rights`, `lng_saved`, `confirm_code`, `confirm_date`) VALUES
(1, 2, 'lt', 'easy', 'c783c7190dc47e70629ca80e96e559d5', 1, 'Easywebmanager', '', 'info@easywebmanager.lt', '', '', 'easy (Easywebmanager )', 1, '', '', 1, '11adbb6a5c7ff0ff8fee0384af769d4f', '2012-11-05 18:16:12');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_admin_lang_rights`
--

CREATE TABLE IF NOT EXISTS `cms_admin_lang_rights` (
  `lng` varchar(255) NOT NULL DEFAULT '',
  `admin_id` bigint(20) NOT NULL DEFAULT '0',
  `rights` tinyint(4) NOT NULL DEFAULT '0',
  KEY `lng` (`lng`,`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_admin_module_rights`
--

CREATE TABLE IF NOT EXISTS `cms_admin_module_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `rights` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`),
  KEY `admin_id` (`admin_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_admin_stat`
--

CREATE TABLE IF NOT EXISTS `cms_admin_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logout_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `session` varchar(255) NOT NULL DEFAULT '',
  `ipaddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Sukurta duomenų kopija lentelei `cms_admin_stat`
--

INSERT INTO `cms_admin_stat` (`id`, `admin_id`, `login_time`, `logout_time`, `session`, `ipaddress`) VALUES
(1, 2, '2015-12-15 17:38:38', '2015-12-15 17:38:38', 'h49cg4engbubkbcopallique01', '::1');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_apklausos`
--

CREATE TABLE IF NOT EXISTS `cms_apklausos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `answers` tinyint(1) DEFAULT NULL,
  `vote_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_apklausos_variantai`
--

CREATE TABLE IF NOT EXISTS `cms_apklausos_variantai` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `apklausa_id` int(11) DEFAULT NULL,
  `vote_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_articles`
--

CREATE TABLE IF NOT EXISTS `cms_articles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `short_description` text,
  `news_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext,
  `active` tinyint(1) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `organas` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `comments` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_blocks`
--

CREATE TABLE IF NOT EXISTS `cms_blocks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `description` longtext,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `block_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`),
  KEY `page_id` (`page_id`),
  KEY `block_name` (`block_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_comments`
--

CREATE TABLE IF NOT EXISTS `cms_comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` text,
  `active` tinyint(1) DEFAULT NULL,
  `c_date` datetime DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_conversion`
--

CREATE TABLE IF NOT EXISTS `cms_conversion` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conversion_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_column` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_currency`
--

CREATE TABLE IF NOT EXISTS `cms_currency` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `short_title` varchar(255) DEFAULT NULL,
  `currency_by_lt` varchar(255) DEFAULT NULL,
  `submit` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_forms`
--

CREATE TABLE IF NOT EXISTS `cms_forms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetEmailEmails` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `selType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetEmailSubject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetEmailFromemail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetEmailFromname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetEmailTemplate` text COLLATE utf8_unicode_ci,
  `targetDatabaseModule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetCustomModule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `targetCustomMethod` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `required_fields` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_keyboard_shortcuts`
--

CREATE TABLE IF NOT EXISTS `cms_keyboard_shortcuts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(1) DEFAULT NULL,
  `page_link` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_module`
--

CREATE TABLE IF NOT EXISTS `cms_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) DEFAULT NULL,
  `title_lt` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `tplico` varchar(255) NOT NULL DEFAULT '',
  `multilng` tinyint(1) unsigned DEFAULT NULL,
  `category` tinyint(1) unsigned DEFAULT NULL,
  `tree` tinyint(1) DEFAULT NULL,
  `folder_id` int(11) NOT NULL DEFAULT '0',
  `cache` tinyint(1) NOT NULL DEFAULT '0',
  `last_modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `default_sort` varchar(255) NOT NULL DEFAULT '',
  `default_sort_direction` varchar(255) NOT NULL DEFAULT '',
  `search` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `maxlevel` tinyint(4) NOT NULL DEFAULT '0',
  `additional_settings` text NOT NULL,
  `description` text NOT NULL,
  `form_tpl` text NOT NULL,
  `no_record_table` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=147 ;

--
-- Sukurta duomenų kopija lentelei `cms_module`
--

INSERT INTO `cms_module` (`id`, `table_name`, `title_lt`, `title_en`, `tplico`, `multilng`, `category`, `tree`, `folder_id`, `cache`, `last_modify_time`, `default_sort`, `default_sort_direction`, `search`, `sort_order`, `disabled`, `maxlevel`, `additional_settings`, `description`, `form_tpl`, `no_record_table`) VALUES
(1, 'admins', 'Administratoriai', 'Administrators', '', 0, 0, 1, 4, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 1, 52, 0, 0, '', '', '', 0),
(5, 'phrases', 'Žodynas', 'Wordbook', '', 1, 0, 1, 1, 1, '2014-10-20 16:32:32', 'R.sort_order ', 'ASC', 0, 21, 0, 0, '', '', '', 0),
(6, 'users', 'Registruoti lankytojai', 'Registered users', '', 0, 0, 1, 6, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 1, 5, 0, 0, '', '', '', 0),
(60, 'subscribers', 'Naujienų prenumeratoriai', 'News subscribers', '', 0, 0, 1, 3, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 0, 40, 0, 0, '', '', '', 0),
(66, 'newsletters', 'Naujienlaiškių siuntimas', 'Newsletters', '', 0, 0, 1, 3, 0, '0000-00-00 00:00:00', 'T.sent_date ', 'DESC', 0, 46, 0, 0, '', '', '', 0),
(139, 'apklausos', 'Apklausos', 'Polls', '', 1, 0, 1, 6, 0, '0000-00-00 00:00:00', 'R.sort_order ', '', 0, 73, 0, 0, '', '', '', 0),
(140, 'apklausos_variantai', 'Apklausos variantai', 'Polls answers', '', 1, 0, 1, 6, 0, '0000-00-00 00:00:00', 'R.sort_order ', '', 0, 73, 1, 0, '', '', '', 0),
(141, 'keyboard_shortcuts', 'Spartieji klavišai', 'Keyboard shortcuts', '', 0, 0, 1, 1, 0, '0000-00-00 00:00:00', 'R.sort_order ', '', 0, 73, 0, 0, '', '', '', 0),
(76, 'orders', 'Užsakymai', 'Orders', '', 0, 0, 1, 2, 0, '0000-00-00 00:00:00', 'R.sort_order DESC', 'ASC', 1, 16, 0, 0, '&lt;items&gt;	&lt;logo&gt;\n		&lt;title_lt&gt;Logotipas (tik .jpg formatas)&lt;/title_lt&gt;\n		&lt;title_en&gt;Logo (only .jpg format)&lt;/title_en&gt;\n		&lt;value&gt;orders-logo-0.png&lt;/value&gt;\n		&lt;type&gt;image&lt;/type&gt;\n		&lt;extra_params&gt;prefix=||size=300x300||quality=100||resize_type=0&lt;/extra_params&gt;\n	&lt;/logo&gt;\n	&lt;company&gt;\n		&lt;title_lt&gt;Įmonė sąskaitose&lt;/title_lt&gt;\n		&lt;title_en&gt;Company&lt;/title_en&gt;\n	&lt;value&gt;&lt;![CDATA[UAB &quot;Easywebmanager&quot;]]&gt;&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/company&gt;\n	&lt;company_code&gt;\n		&lt;title_lt&gt;Įmonės kodas&lt;/title_lt&gt;\n		&lt;title_en&gt;Company code&lt;/title_en&gt;\n		&lt;value&gt;xxxxxxxxx&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/company_code&gt;\n	&lt;company_pvm&gt;\n		&lt;title_lt&gt;Įmonės PVM kodas&lt;/title_lt&gt;\n		&lt;title_en&gt;Company VAT code&lt;/title_en&gt;\n		&lt;value&gt;&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/company_pvm&gt;\n	&lt;company_address&gt;\n		&lt;title_lt&gt;Įmonės adresas&lt;/title_lt&gt;\n		&lt;title_en&gt;Company address&lt;/title_en&gt;\n		&lt;value&gt;Gatvinaukso 152a-23&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/company_address&gt;\n	&lt;company_bank&gt;\n		&lt;title_lt&gt;Įmonės bankas&lt;/title_lt&gt;\n		&lt;title_en&gt;Company bank&lt;/title_en&gt;\n		&lt;value&gt;Bankas&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/company_bank&gt;\n	&lt;company_saskaita&gt;\n		&lt;title_lt&gt;Įmonės sąskaitos nr&lt;/title_lt&gt;\n		&lt;title_en&gt;Įmonės sąskaitos nr&lt;/title_en&gt;\n		&lt;value&gt;LTxxxxxxxxxxxx&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/company_saskaita&gt;\n	&lt;email&gt;\n		&lt;title_lt&gt;Įmonės el. paštas&lt;/title_lt&gt;\n		&lt;title_en&gt;Company email&lt;/title_en&gt;\n		&lt;value&gt;info@easywebmanager.lt&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/email&gt;\n	&lt;phone&gt;\n		&lt;title_lt&gt;Įmonės telefonas&lt;/title_lt&gt;\n		&lt;title_en&gt;Company phone&lt;/title_en&gt;\n		&lt;value&gt;+370 (xxx) xx-xxx&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/phone&gt;\n	&lt;website&gt;\n		&lt;title_lt&gt;Įmonės svetainė&lt;/title_lt&gt;\n		&lt;title_en&gt;Company website&lt;/title_en&gt;\n		&lt;value&gt;http://www.easywebmanager.lt&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/website&gt;\n	&lt;serija&gt;\n		&lt;title_lt&gt;Serija sąskaitose&lt;/title_lt&gt;\n		&lt;title_en&gt;Invoice seria&lt;/title_en&gt;\n		&lt;value&gt;EWM-*******&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/serija&gt;\n&lt;/items&gt;', '', '', 0),
(77, 'ordered_items', 'Užsakytos prekės', 'Ordered products', '', 0, 0, 1, 2, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 0, 17, 1, 1, '', '', '', 0),
(81, 'pages', 'Svetainės struktūra', 'Website structure', '', 1, 1, 1, 1, 1, '2015-12-15 17:39:00', 'R.sort_order ', 'ASC', 1, NULL, 0, 5, '<items>	<languages>\r\n		<title_lt>Svetainės kalbos</title_lt>\r\n		<title_en>Website languages</title_en>\r\n		<value>lt::en</value>\r\n		<type>checkbox_group</type>\r\n		<list_values>\r\n		<source>CALL</source>\r\n		<module>pages</module>\r\n		<method>get_languages</method>\r\n	</list_values>\r\n	</languages>\r\n	<page_title>\r\n		<title_lt>Svetainės pavadinimas</title_lt>\r\n		<title_en>Website title</title_en>\r\n		<value>Easywebmanager</value>\r\n		<type>text</type>\r\n	</page_title>\r\n	<email>\r\n		<title_lt>Pagrindinis el. paštas</title_lt>\r\n		<title_en>Main e-mail</title_en>\r\n		<value>info@adme.lt</value>\r\n		<type>text</type>\r\n	</email>\r\n	<google>\r\n		<title_lt>Google analytics kodas</title_lt>\r\n		<title_en>Google analytics code</title_en>\r\n		<value></value>\r\n		<type>textarea</type>\r\n	</google>\r\n</items>', '', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td style="vertical-align:top">\r\n			<div class="formElementsFieldWYSIWYG">{tpl.title}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.template}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.redirect}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.public_page}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.no_menu}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.active}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.image}</div>\r\n			</td>\r\n			<td style="vertical-align:top">\r\n			<div class="formElementsFieldWYSIWYG">{tpl.page_title}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.header_title}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.page_url}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.keywords}</div>\r\n\r\n			<div class="formElementsFieldWYSIWYG">{tpl.description}</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<script type="text/javascript">\r\ndocument.forms["save"].elements["title"].onkeyup = function()\r\n{\r\nif(document.getElementById("gen_header_title_auto_id").checked)\r\ndocument.forms["save"].elements["header_title"].value=document.forms["save"].elements["title"].value;\r\nif(document.getElementById("gen_page_title_auto_id").checked)\r\ndocument.forms["save"].elements["page_title"].value=document.forms["save"].elements["title"].value;\r\n}\r\n</script>', 0),
(115, 'forms', 'Formos', 'Forms', '', 0, 0, 1, 1, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 0, 69, 0, 0, '', '', '', 0),
(116, 'conversion', 'Konversijos tikslai', 'Conversion goals', '', NULL, NULL, 1, 6, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 0, 70, 1, 0, '', '', '', 0),
(97, 'products', 'Produktai', 'Products', '', 1, 0, 1, 2, 1, '2015-09-10 16:27:32', 'R.sort_order ', 'DESC', 1, 4, 0, 0, '&lt;items&gt;	&lt;items_paging&gt;\n		&lt;title_lt&gt;Produktų skaičius puslapyje&lt;/title_lt&gt;\n		&lt;title_en&gt;Items paging&lt;/title_en&gt;\n		&lt;value&gt;4&lt;/value&gt;\n		&lt;type&gt;text&lt;/type&gt;\n	&lt;/items_paging&gt;\n&lt;/items&gt;', '', '', 0),
(98, 'blocks', 'Blokai', 'Blocks', '', 1, NULL, 1, 0, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 1, 29, 0, 0, '', '', '', 0),
(108, 'payments', 'Mokėjimo būdai', 'Payments', '', 1, NULL, 1, 2, 0, '0000-00-00 00:00:00', 'R.sort_order ', 'ASC', 1, 65, 0, 0, '', '', '', 0),
(118, 'user_groups', 'Vartotojų grupės', 'User groups', '', 0, 0, 1, 6, 1, '2013-04-26 12:08:36', 'R.sort_order ', 'ASC', 0, 72, 1, 0, '', '', '', 0),
(125, 'stat_visitors', 'Statistika', 'Statistics', '', 0, 0, 1, 5, 0, '0000-00-00 00:00:00', 'T.visit_time', '', 0, 74, 0, 0, '', '', '', 1),
(132, 'articles', 'Strapsniai', 'Articles', '', 1, 0, 1, 7, 0, '0000-00-00 00:00:00', 'R.sort_order DESC', '', 1, NULL, 0, 0, '', '', '', 0),
(143, 'products_images', 'Produkto iliustracijos', 'Product images', '', 1, 0, 1, 2, 0, '0000-00-00 00:00:00', 'R.sort_order', '', 0, NULL, 1, 0, '', '', '', 0),
(138, 'subscribers_group', 'Prenumeratorių grupės', 'Subscribers groups', '', 0, 0, 1, 3, 0, '0000-00-00 00:00:00', 'R.sort_order ', '', 0, 46, 0, 0, '', '', '', 0),
(144, 'tags', 'Tag''ai', 'Tags', '', 1, 0, 1, 7, 0, '0000-00-00 00:00:00', 'R.sort_order ASC', '', 0, NULL, 0, 0, '', '', '', 0),
(145, 'comments', 'Komentarai', 'Comments', '', 0, 0, 1, 7, 0, '0000-00-00 00:00:00', 'T.c_date DESC', '', 0, NULL, 1, 0, '', '', '', 0),
(146, 'site_blocks', 'Svetainės blokai', 'Website blocks', '', 1, 0, 1, 1, 1, '0000-00-00 00:00:00', 'R.sort_order', '', 0, NULL, 0, 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_module_category`
--

CREATE TABLE IF NOT EXISTS `cms_module_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_lt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lng` int(1) NOT NULL,
  `lng_saved` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `record_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Sukurta duomenų kopija lentelei `cms_module_category`
--

INSERT INTO `cms_module_category` (`id`, `title_lt`, `title_en`, `title`, `lng`, `lng_saved`, `active`, `record_id`) VALUES
(1, 'Svetainės administravimas', 'Website ', '', 0, 0, 0, 0),
(2, 'E-komercija', 'E-commerce', '', 0, 0, 0, 0),
(3, 'Naujienlaiškiai', 'Newsletters', '', 0, 0, 0, 0),
(4, 'Administravimas', 'Admin', '', 0, 0, 0, 0),
(5, 'Statistika', 'Statistics', '', 0, 0, 0, 0),
(6, 'Papildomi moduliai', 'Additional modules', '', 0, 0, 0, 0),
(7, 'Blog''as', '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_module_info`
--

CREATE TABLE IF NOT EXISTS `cms_module_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `title_lt` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `column_name` varchar(255) DEFAULT NULL,
  `column_type` varchar(255) DEFAULT NULL,
  `elm_type` varchar(255) DEFAULT NULL,
  `default_value` text,
  `list_values` text NOT NULL,
  `required` tinyint(1) DEFAULT '0',
  `validator` varchar(255) NOT NULL,
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  `list` tinyint(1) DEFAULT '0',
  `editable` tinyint(1) DEFAULT '1',
  `multilng` tinyint(1) NOT NULL DEFAULT '1',
  `index` tinyint(1) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1105 ;

--
-- Sukurta duomenų kopija lentelei `cms_module_info`
--

INSERT INTO `cms_module_info` (`id`, `module_id`, `title`, `title_lt`, `title_en`, `description`, `column_name`, `column_type`, `elm_type`, `default_value`, `list_values`, `required`, `validator`, `super_user`, `list`, `editable`, `multilng`, `index`, `lng`, `sort_order`) VALUES
(95, 5, 'Vertimas', 'Tekstas', 'Text', '', 'translation', 'text', 'textarea', '', '', 0, '', 0, 1, 1, 1, 0, 'lt', 1),
(94, 5, 'Pavadinimas', 'Raktas', 'Key', '', 'title', 'varchar(255)', 'text', '', '', 1, 'object=record\nmodule=phrases\nmethod=checkDataExist\nadmin_error_msg=Toks įrašas jau yra', 0, 1, 1, 0, 0, NULL, 0),
(140, 6, 'Vartotojų grupės pavadinimas', 'Vardas, pavardė', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 0, 0, NULL, -2),
(142, 6, 'Slaptažodis', 'Slaptažodis', 'Password', '', 'pswd', 'varchar(255)', 'password', '', 'encrypt=md5\r\nmd5=1', 1, '', 0, 0, 1, 0, 0, 'lt', 22),
(157, 1, 'Prisijungimo vardas', 'Prisijungimo vardas', 'Loginname', '', 'login', 'varchar(255)', 'text', '', '', 1, 'object=record\nmodule=admins\nmethod=checkLoginData\nadmin_error_msg=Toks administratorius jau yra\nfunction=valid_login\nadmin_error_msg=Neteisingas prisijungimo vardas', 0, 1, 1, 0, 0, 'lt', 1),
(158, 1, 'Slaptažodis', 'Slaptažodis', 'Password', '', 'pass', 'varchar(255)', 'password', '', 'md5=1', 0, '', 0, 0, 1, 0, 0, 'lt', 2),
(159, 1, 'Lygis', 'Lygis', 'Level', '', 'permission', 'tinyint(4)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, 'lt', 3),
(160, 1, 'Vardas', 'Vardas', 'Firstname', '', 'firstname', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, 'lt', 4),
(161, 1, 'Pavardė', 'Pavardė', 'Lastname', '', 'lastname', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, 'lt', 5),
(162, 1, 'El. paštas', 'El. paštas', 'E-mail', '', 'email', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, 'lt', 6),
(163, 1, 'Telefonas', 'Telefonas', 'Phone', '', 'phone', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, 'lt', 7),
(1091, 132, NULL, 'Tag''ai', 'Tags', '', 'tags', 'varchar(255)', 'autocomplete', '', 'source=DB\r\nmodule=tags\r\ncreate_new=1\r\nmultiple=1', 0, '', 0, 0, 1, 0, 0, NULL, 2),
(437, 60, 'Aktyvus', 'Aktyvuotas', 'Activated', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 1, '', 0, 1, 1, 0, 0, 'lt', 3),
(1055, 139, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 1, 0, NULL, 0),
(713, 81, NULL, 'Puslapio raktiniai žodžiai(keywords)', 'Keywords', 'Raktažodžiuose nurodomi tie žodžiai, kuriais norima kad paieškos sistemos rastų jūsų dokumentą. Patartina surašyti tuos žodžius ar frazes, kurie atitinka dokumento turinį.\r\n\r\nRaktažodžių apribojimas yra 1000 simbolių.\r\nNenaudoti raktažodžių po 3 kartus. \r\nNaudoti sudėtinius raktažodžius. \r\nNaudoti tik tuos metatagus kurie duoda naudos dokumentui.', 'keywords', 'text', 'textarea', '', 'inc_file=/forms/custom/page_keywords.php\ntpl_file=/forms/custom/page_keywords.tpl', 0, '', 0, 0, 1, 1, 0, NULL, 20),
(712, 81, NULL, 'Trumpas puslapio apibūdinimas(description)', 'Description', 'Kai kurios paieškos sistemos naudoja šį tekstą, laip trumpą tinklalapio apibūdinima išvedant paieškos rezultatus.', 'description', 'text', 'textarea', '', 'inc_file=/forms/custom/page_description.php\ntpl_file=/forms/custom/page_description.tpl', 0, '', 0, 0, 1, 1, 0, NULL, 19),
(964, 115, NULL, 'El. laiško siuntėjas (email)', 'E-mail sender (email)', '', 'targetEmailFromemail', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 7),
(758, 97, NULL, 'Aprašymas', 'Description', '', 'description', 'text', 'textarea', '', '', 0, '', 0, 0, 1, 1, 0, NULL, 8),
(332, 6, 'Telefonas', 'Telefonas', 'Phone', '', 'phone', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 0, 0, 'lt', 7),
(333, 6, 'El. paštas', 'El. paštas', 'E-mail', '', 'email', 'varchar(255)', 'text', '', '', 1, 'user_object=record\nobject=record\nmodule=users\nmethod=checkDataExist\nsite_error_msg=value_exist\nadmin_error_msg=Toks el. paštas jau yra\nfunction=valid_email\nsite_error_msg=bad_email\nadmin_error_msg=Neteisingas el. paštas', 0, 1, 1, 0, 0, 'lt', 9),
(342, 1, 'Title', 'Title', 'Title', '', 'title', 'tinyint(4)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, 'lt', 10),
(374, 6, 'Aktyvus', 'Aktyvus', 'Active', '', 'active', 'tinyint(4)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, 'lt', 30),
(749, 98, NULL, 'Puslapio id', 'Page id', '', 'page_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, NULL, 8),
(735, 98, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 6),
(956, 115, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, NULL, 1),
(957, 115, NULL, 'El. paštai', 'E-mail', '', 'targetEmailEmails', 'text', 'textarea', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 5),
(750, 98, NULL, 'Bloko id', 'Block id', '', 'block_name', 'varchar(255)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, NULL, 9),
(369, 1, 'Aktyvus', 'Aktyvus', 'Active', '', 'active', 'tinyint(4)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, 'lt', 8),
(373, 5, 'Aktyvus', 'Aktyvus', 'Active', '', 'active', 'tinyint(4)', 'hidden', '1', '', 0, '', 0, 0, 0, 0, 0, 'lt', 2),
(549, 6, 'Adresas', 'Adresas', 'Address', '', 'address', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, 'lt', 12),
(436, 60, 'El. paštas', 'El. paštas', 'E-mail', '', 'title', 'varchar(255)', 'text', '', '', 1, 'object=record\r\nmodule=subscribers\r\nmethod=checkDataExist\r\nadmin_error_msg=Toks el. paštas jau yra\r\nfunction=valid_email\r\nadmin_error_msg=Neteisingas el. paštas', 0, 1, 1, 0, 0, 'lt', 1),
(1076, 140, NULL, 'Balsavimų skaičius', 'Votes', '', 'vote_count', 'int(11)', 'hidden', '', '', 0, '', 0, 1, 0, 0, 0, NULL, 1),
(1092, 145, NULL, 'Komentaras', 'Comment', '', 'title', 'text', 'textarea', '', '', 1, '', 0, 1, 1, 0, 0, NULL, 4),
(1087, 144, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 1, 0, NULL, 1),
(1085, 143, NULL, 'product_id', 'product_id', '', 'product_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, NULL, 5),
(1086, 132, NULL, 'Byla', 'File', '', 'file', 'varchar(255)', 'file', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 3),
(476, 66, 'Pavadinimas', 'Pavadinimas(subject)', 'Title(subject)', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 0, 0, 'lt', 1),
(477, 66, 'Aktyvus', 'Aktyvus', 'Active', '', 'active', 'tinyint(4)', 'hidden', '1', '', 0, '', 1, 0, 0, 0, 0, 'lt', 11),
(479, 66, 'Laiško tekstas', 'Laiško tekstas', 'E-mail content', '', 'mail_body', 'text', 'html', '', 'tpl_file=extras/newsletter_content.tpl', 0, '', 0, 0, 1, 0, 0, 'lt', 7),
(754, 66, NULL, 'Paprastas tekstas', 'Plain text', '', 'plain_text', 'text', 'hidden', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 10),
(481, 66, 'Laiškas gautas nuo', 'Laiškas gautas nuo', 'Email from', '', 'email_from_name', 'varchar(255)', 'text', 'Easywebmanager', '', 0, '', 0, 0, 1, 0, 0, 'lt', 4),
(482, 66, 'Laiškas nuo (el. paštas)', 'Laiškas nuo (el. paštas)', 'Email from (e-mail)', '', 'email_from_email', 'varchar(255)', 'text', 'info@easywebmanager.com', '', 0, '', 0, 0, 1, 0, 0, 'lt', 5),
(483, 66, 'Siuntimo data', 'Siuntimo data', 'Sent date', '', 'sent_date', 'datetime', 'hidden', '', 'time=1', 0, '', 0, 1, 0, 0, 0, 'lt', 2),
(1084, 143, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 4),
(729, 81, NULL, 'Generuoti aprasyma', 'Generate description', '', 'generate_description', 'tinyint(1)', 'hidden', '1', '', 0, '', 0, 0, 1, 0, 0, NULL, 23),
(731, 98, NULL, 'Turinys', 'Content', '', 'description', 'text', 'html', '', '', 1, '', 0, 0, 1, 1, 1, NULL, 2),
(1083, 143, NULL, 'Paveikslėlis', 'Image', '', 'image', 'varchar(255)', 'image', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 2),
(728, 81, NULL, 'Generuoti raktinius zodzius', 'Generate keywords', '', 'generate_keywords', 'tinyint(1)', 'hidden', '1', '', 0, '', 0, 0, 1, 0, 0, NULL, 21),
(752, 66, NULL, 'Perskaityta kartų', 'View count', '', 'view_count', 'int(11)', 'hidden', '0', '', 0, '', 0, 1, 0, 0, 0, NULL, 9),
(753, 66, NULL, 'Paspausta nuoroda kartų', 'Click count', '', 'click_count', 'int(11)', 'hidden', '0', '', 0, '', 0, 1, 0, 0, 0, NULL, 8),
(554, 76, 'Vardas, pavardė', 'Vardas, pavardė', 'Firstname, lastname', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 0, 0, 0, 'lt', 6),
(555, 76, 'Įvykdytas užsakymas', 'Apmokėta', 'Done', '', 'active', 'tinyint(4)', 'checkbox', '', '', 1, '', 0, 1, 1, 0, 0, 'lt', 20),
(557, 76, 'Užsakymo data', 'Užsakymo data', 'Order date', '', 'order_date', 'date', 'date', '', '', 0, '', 0, 1, 0, 0, 0, 'lt', 0),
(558, 76, 'Užsakymo suma', 'Užsakymo suma', 'Order sum', '', 'order_sum', 'decimal(11,2)', 'text', '', '', 0, '', 0, 1, 0, 0, 0, 'lt', 1),
(560, 76, 'Užsakytos prekės', 'Užsakytos prekės', 'Ordered products', '', 'ordered_items', 'tinyint(4)', 'list', '', 'source=DB\nmodule=ordered_items\nget_category=category_id\nget_column_name=category_column\ncreate_category_parent_id=0', 0, '', 0, 0, 1, 0, 0, 'lt', 3),
(561, 77, 'Pavadinimas', 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 0, 0, 0, 'lt', 1),
(562, 77, 'Aktyvus', 'Aktyvus', 'Active', '', 'active', 'tinyint(4)', 'hidden', '', '', 0, '', 1, 0, 0, 0, 0, 'lt', 5),
(564, 77, 'Kiekis', 'Kiekis', 'Quantity', '', 'kiekis', 'int(11)', 'text', '', '', 0, '', 0, 1, 0, 0, 0, 'lt', 2),
(565, 77, 'Vnt kaina', 'Vnt kaina', 'Unit price', '', 'price', 'decimal(11,2)', 'text', '', '', 0, '', 0, 1, 0, 0, 0, 'lt', 3),
(1024, 77, NULL, 'rel_id', 'rel_id', '', 'rel_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, NULL, 9),
(1025, 77, NULL, 'modif', 'modif', '', 'modif', 'varchar(255)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 10),
(567, 77, 'category_id', 'category_id', 'category_id', '', 'category_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, 'lt', 7),
(568, 77, 'category_column', 'category_column', 'category_column', '', 'category_column', 'varchar(255)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, 'lt', 8),
(1033, 6, NULL, 'confirm_code', 'confirm_code', '', 'confirm_code', 'varchar(255)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 31),
(571, 76, 'Telefonas', 'Telefonas', 'Phone', '', 'phone', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 0, 0, 0, 'lt', 7),
(572, 76, 'El. paštas', 'El. paštas', 'E-mail', '', 'email', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 0, 0, 0, 'lt', 8),
(573, 76, 'Adresas', 'Adresas', 'Address', '', 'address', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 0, 0, 0, 'lt', 10),
(576, 76, 'Registruoto lankytojo ID', 'Registruoto lankytojo ID', 'Registered user  ID', '', 'user_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, 'lt', 14),
(1098, 145, NULL, 'El. paštas', 'E-mail', '', 'email', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 3),
(1099, 145, NULL, 'category_id', 'category_id', '', 'category_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, NULL, 7),
(1090, 144, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 4),
(594, 81, NULL, 'Pavadinimas (navigacija)', 'Title (menu)', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, 'lt', 1),
(595, 81, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 1, 0, 'lt', 15),
(598, 81, NULL, 'Puslapio URL', 'Page URL', '', 'page_url', 'varchar(255)', 'text', '/', 'tpl_file=/forms/custom/page_url.tpl', 1, 'module=pages\r\nmethod=validateUrl\r\nadmin_error_msg=URL exists\r\nfunction=valid_page_url\r\nadmin_error_msg=Wrong URL', 0, 1, 1, 1, 0, 'lt', 3),
(599, 81, NULL, 'Puslapio nukreipimas (redirect)', 'Page redirect to', '', 'page_redirect', 'varchar(255)', 'hidden', '', 'tpl_file=/forms/custom/page_redirect.tpl', 0, '', 0, 0, 1, 1, 0, 'lt', 4),
(600, 81, NULL, 'Puslapio antraštė (title)', 'Page title', '', 'page_title', 'varchar(255)', 'text', '', 'inc_file=/forms/custom/page_title.php\ntpl_file=/forms/custom/page_title.tpl', 1, '', 0, 1, 1, 1, 0, 'lt', 0),
(1065, 141, NULL, 'Alt + [raidė] kombinacija', 'Alt + [character] combination', '', 'title', 'varchar(1)', 'text', '', '', 1, 'module=keyboard_shortcuts\r\nmethod=checkDataExist\r\nsite_error_msg=value_exist\r\nadmin_error_msg=Tokia kombinacija jau yra', 0, 1, 1, 0, 0, NULL, 0),
(1050, 97, NULL, 'Sena kaina', 'Old price', '', 'old_price', 'decimal(10,2)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 6),
(602, 81, NULL, 'Puslapio tipas', 'Page type', '', 'template', 'varchar(255)', 'select', 'inner', 'source=CALL\r\nmodule=templates\r\nmethod=listPageSelect', 1, '', 0, 1, 1, 1, 0, 'lt', 5),
(608, 81, NULL, 'Puslapis tik registruotiem vartotojam', 'Only fo registered users', '', 'public_page', 'tinyint(1)', 'checkbox', '', '', 0, '', 0, 1, 1, 1, 0, 'lt', 14),
(1082, 143, NULL, 'Trumpas aprašymas', 'Short description', '', 'short_description', 'text', 'textarea', '', '', 0, '', 0, 0, 1, 1, 0, NULL, 3),
(721, 97, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, NULL, 2),
(722, 97, NULL, 'Trumpas aprašymas', 'Short description', '', 'short_description', 'text', 'textarea', '', '', 0, '', 0, 1, 1, 1, 0, NULL, 7),
(723, 97, NULL, 'Paveikslėliai', 'Images', '', 'image', 'varchar(255)', 'list', '', 'module=products_images\r\nmethod=listing\r\ncolumn=product_id', 0, '', 0, 1, 1, 0, 0, NULL, 4),
(724, 97, NULL, 'Kaina', 'Price', '', 'price', 'decimal(10,2)', 'text', '', '', 1, '\nfunction=valid_float\nadmin_error_msg=Wrong price', 0, 1, 1, 0, 0, NULL, 5),
(725, 97, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 14),
(636, 81, NULL, 'Generuoti URL', 'Generate URL', '', 'generate_url', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 0, 1, 0, 0, 'lt', 22),
(1049, 97, NULL, 'Kategorija', 'Category', '', 'category', 'int(11)', 'select', '', 'source=DB\r\nmodule=pages\r\nparent_id=14632\r\ntpl_file=/forms/custom/select_category.tpl\r\ntpl_controller=products\r\ntpl_method=category_select_element', 1, '', 0, 1, 1, 0, 0, NULL, -1),
(1005, 118, 'Pavadinimas', 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 0, 0, '', 1),
(1006, 118, 'Nuolaida', 'Nuolaida', 'Discount', '', 'discount', 'decimal(10,2)', 'text', '0', '', 1, '', 0, 1, 1, 0, 0, '', 2),
(1007, 118, 'Trumpas aprašymas', 'Trumpas aprašymas', 'Short description', '', 'short_description', 'text', 'textarea', '', '', 0, '', 0, 1, 1, 0, 0, '', 3),
(1008, 118, 'Aktyvus', 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'hidden', '1', '', 0, '', 0, 0, 1, 0, 0, '', 4),
(1031, 76, NULL, 'Apmokėjimas', 'Payment', '', 'payment', 'int(11)', 'select', '', 'source=DB\r\nmodule=payments\r\nmethod=listSearchItems', 0, '', 0, 1, 1, 0, 0, NULL, 11),
(994, 81, NULL, 'generate_page_title', 'generate_page_title', '', 'generate_page_title', 'tinyint(1)', 'hidden', '1', '', 0, '', 0, 0, 0, 0, 0, NULL, 29),
(1066, 141, NULL, 'Nuoroda į puslapį', 'Link to website page', '', 'page_link', 'int(11)', 'autocomplete', '', 'source=DB\r\nmodule=pages\r\nmethod=listAutocompleteItems\r\ncolumns=title,page_url,page_title,header_title', 1, '', 0, 1, 1, 0, 1, NULL, 0),
(751, 81, NULL, 'Submeniu nerodomas', 'Sumenu hided', '', 'no_menu', 'tinyint(1)', 'checkbox', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 24),
(755, 60, NULL, 'Kategorija', 'Category', '', 'category', 'int(11)', 'select', '', 'source=DB\r\nmodule=subscribers_group\r\nparent_id=0\r\nno_rel=1', 1, '', 0, 1, 1, 0, 0, NULL, 2),
(978, 116, NULL, 'list_values', 'list_values', '', 'conversion_list', 'varchar(255)', 'list', '', 'source=DB\nmodule=conversion\nget_category=category_id\nget_column_name=category_column\ncreate_category_parent_id=0', 0, '', 0, 0, 0, 0, 0, NULL, 8),
(1081, 143, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 1, 0, NULL, 1),
(1077, 6, NULL, 'Įmonė', 'Company', '', 'company', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, NULL, -1),
(1078, 6, NULL, 'Įmonės kodas', 'Company code', '', 'company_code', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, NULL, -1),
(1079, 6, NULL, 'Įmonės PVM kodas', 'Company VAT code', '', 'company_vat', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, -1),
(1080, 6, NULL, 'Miestas', 'City', '', 'city', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 10),
(1068, 141, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 0),
(1064, 140, NULL, 'category_id', 'category_id', '', 'apklausa_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 1, NULL, -1),
(1063, 140, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 2),
(817, 97, NULL, 'Paveikslėlis #2', 'Image #2', '', 'image2', 'varchar(255)', 'image', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 9),
(818, 97, NULL, 'Paveikslėlis #3', 'Image #3', '', 'image3', 'varchar(255)', 'image', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 10),
(819, 97, NULL, 'Paveikslėlis #4', 'Image #4', '', 'image4', 'varchar(255)', 'image', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 11),
(852, 108, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, NULL, 1),
(853, 108, NULL, 'Info', 'Info', '', 'code', 'text', 'textarea', '', '', 1, '', 0, 0, 1, 0, 0, NULL, 2),
(854, 108, NULL, 'Paveikslėlis', 'Image', '', 'image', 'varchar(255)', 'image', '', 'abs_dir=G:/localhost/1install/', 0, '', 0, 1, 1, 0, 0, NULL, 3),
(856, 108, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 7),
(996, 98, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'hidden', '', '', 0, '', 0, 1, 0, 0, 0, NULL, 1),
(1060, 140, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, NULL, 0),
(995, 81, NULL, 'generate_header_title', 'generate_header_title', '', 'generate_header_title', 'tinyint(1)', 'hidden', '1', '', 0, '', 0, 0, 0, 0, 0, NULL, 30),
(991, 1, NULL, 'confirm_code', 'confirm_code', '', 'confirm_code', 'varchar(255)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 11),
(992, 1, NULL, 'confirm_date', 'confirm_date', '', 'confirm_date', 'datetime', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 12),
(993, 81, NULL, 'Puslapio pavadinimas(h1)', 'Page header', '', 'header_title', 'varchar(255)', 'text', '', 'tpl_file=/forms/custom/header_title.tpl', 1, '', 0, 0, 1, 1, 0, NULL, 2),
(962, 115, NULL, 'Tipas', 'Type', '', 'selType', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 4),
(963, 115, NULL, 'El. laiško tema (subject)', 'E-mail subject', '', 'targetEmailSubject', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 6),
(960, 115, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 14),
(965, 115, NULL, 'El. laiško siuntėjas (name)', 'E-mail sender (name)', '', 'targetEmailFromname', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 8),
(966, 115, NULL, 'El. laiško šablonas', 'e-mail template', '', 'targetEmailTemplate', 'text', 'textarea', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 9),
(967, 115, NULL, 'Modulis', 'module', '', 'targetDatabaseModule', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 10),
(968, 115, NULL, 'Modulis (custom)', 'Module (custom)', '', 'targetCustomModule', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 11),
(969, 115, NULL, 'Metodas', 'Method', '', 'targetCustomMethod', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 12),
(970, 115, NULL, 'Privalomi laukai', 'Required fields', '', 'required_fields', 'text', 'textarea', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 13),
(971, 116, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, NULL, 1),
(977, 116, NULL, 'Url', 'url', '', 'url', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 0, 0, NULL, 5),
(979, 116, NULL, 'category_column', 'category_column', '', 'category_column', 'varchar(255)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 9),
(980, 116, NULL, 'category_id', 'category_id', '', 'category_id', 'int(11)', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 10),
(975, 116, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 6),
(1030, 81, NULL, 'Iliustracija', 'Image', '', 'image', 'varchar(255)', 'image', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 12),
(1032, 81, NULL, 'Nukreipimo URL', 'Redirect URl', '', 'redirect', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 1, 1, 0, NULL, 13),
(1034, 6, NULL, 'confirm_date', 'confirm_date', '', 'confirm_date', 'datetime', 'hidden', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 32),
(1035, 132, NULL, 'Antraštė', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, '', 0, 1, 1, 1, 0, NULL, 1),
(1036, 132, NULL, 'Straipsnio URL', 'Article URL', '', 'page_url', 'varchar(255)', 'text', '', '', 0, '', 0, 0, 0, 0, 0, NULL, 2),
(1037, 132, NULL, 'Trumpas Aprašas', 'Short Description', '', 'short_description', 'text', 'textarea', '', '', 0, '', 0, 1, 1, 1, 0, NULL, 2),
(1038, 132, NULL, 'Paskelbimo data', 'Create date', '', 'news_date', 'date', 'date', '', '', 1, '', 0, 1, 1, 0, 0, NULL, 2),
(1039, 132, NULL, 'Paveikslėlis', 'Image', '', 'image', 'varchar(255)', 'image', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 2),
(1040, 132, NULL, 'Turinys', 'Description', '', 'description', 'longtext', 'html', '', '', 0, '', 0, 0, 1, 1, 0, NULL, 2),
(1041, 132, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 4),
(1051, 138, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 1, 0, NULL, 0),
(1052, 138, NULL, 'Trumpas aprašymas', 'Short description', '', 'short_description', 'text', 'textarea', '', '', 0, '', 0, 0, 1, 0, 0, NULL, 0),
(1054, 138, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 0),
(1075, 139, NULL, 'Balsavimų skaičius', 'Votes', '', 'vote_count', 'int(11)', 'hidden', '', '', 0, '', 0, 1, 0, 0, 0, NULL, 0),
(1058, 139, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 0),
(1059, 139, NULL, 'Atsakymai', 'Answers', '', 'answers', 'tinyint(1)', 'list', '', 'module=apklausos_variantai\r\nmethod=listing\r\ncolumn=category_id', 0, '', 0, 0, 1, 0, 0, NULL, 0),
(1097, 145, NULL, 'Autorius', 'Author', '', 'author', 'varchar(255)', 'text', '', '', 0, '', 0, 1, 1, 0, 0, NULL, 2),
(1095, 145, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 8),
(1096, 145, NULL, 'Data', 'Date', '', 'c_date', 'datetime', 'date', '', 'time=1', 0, '', 0, 1, 0, 0, 0, NULL, 1),
(1100, 132, NULL, 'Komentarai', 'Comments', '', 'comments', 'tinyint(1)', 'list', '', 'module=comments\r\nmethod=listing\r\ncolumn=category_id', 0, '', 0, 0, 1, 0, 0, NULL, 5),
(1101, 146, NULL, 'Pavadinimas', 'Title', '', 'title', 'varchar(255)', 'text', '', '', 1, 'object=record\r\nmodule=site_blocks\r\nmethod=checkDataExist\r\nadmin_error_msg=Toks įrašas jau yra', 0, 1, 1, 0, 0, NULL, 1),
(1102, 146, NULL, 'Turinys', 'Content', '', 'block_content', 'longtext', 'html', '', 'mode=Full', 0, '', 0, 0, 1, 1, 0, NULL, 2),
(1104, 146, NULL, 'Aktyvus', 'Active', '', 'active', 'tinyint(1)', 'checkbox', '1', '', 0, '', 0, 1, 1, 0, 0, NULL, 4);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_newsletters`
--

CREATE TABLE IF NOT EXISTS `cms_newsletters` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `submit` tinyint(4) DEFAULT NULL,
  `mail_body` text,
  `email_from_name` varchar(255) DEFAULT NULL,
  `email_from_email` varchar(255) DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `view_count` int(11) DEFAULT NULL,
  `click_count` int(11) DEFAULT NULL,
  `plain_text` text,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_newsletters_stat`
--

CREATE TABLE IF NOT EXISTS `cms_newsletters_stat` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `n_id` int(11) NOT NULL DEFAULT '0',
  `click` int(11) NOT NULL DEFAULT '0',
  `view` int(11) NOT NULL DEFAULT '0',
  KEY `email` (`email`,`n_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_ordered_items`
--

CREATE TABLE IF NOT EXISTS `cms_ordered_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `kiekis` int(11) DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_column` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `rel_id` int(11) DEFAULT NULL,
  `modif` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`),
  KEY `rel_id` (`rel_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_orders`
--

CREATE TABLE IF NOT EXISTS `cms_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_sum` decimal(11,2) DEFAULT NULL,
  `ordered_items` tinyint(4) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `payment` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_pages`
--

CREATE TABLE IF NOT EXISTS `cms_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `page_redirect` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `mod_id` int(11) DEFAULT NULL,
  `public_page` tinyint(1) DEFAULT NULL,
  `generate_url` tinyint(1) DEFAULT NULL,
  `description` text,
  `keywords` text,
  `generate_keywords` tinyint(1) DEFAULT NULL,
  `generate_description` tinyint(1) DEFAULT NULL,
  `no_menu` tinyint(1) DEFAULT NULL,
  `fields` varchar(255) DEFAULT NULL,
  `modification` varchar(255) DEFAULT NULL,
  `screenshot` tinyint(1) DEFAULT NULL,
  `header_title` varchar(255) DEFAULT NULL,
  `generate_page_title` tinyint(1) DEFAULT NULL,
  `generate_header_title` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1814 ;

--
-- Sukurta duomenų kopija lentelei `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `record_id`, `lng`, `lng_saved`, `title`, `active`, `submit`, `page_url`, `page_redirect`, `page_title`, `template`, `mod_id`, `public_page`, `generate_url`, `description`, `keywords`, `generate_keywords`, `generate_description`, `no_menu`, `fields`, `modification`, `screenshot`, `header_title`, `generate_page_title`, `generate_header_title`, `image`, `redirect`) VALUES
(1559, 14274, 'lt', 1, 'Home', 1, NULL, '/', NULL, 'Home', 'inner', NULL, 0, NULL, '', '', 1, 1, 0, NULL, NULL, NULL, 'Home', 1, 1, '', ''),
(1560, 14274, 'en', 0, 'Home', 1, NULL, '/', NULL, 'Home', 'inner', NULL, 0, NULL, '', '', 1, 1, 0, NULL, NULL, NULL, 'Home', 1, 1, '', ''),
(1561, 14274, 'ru', 0, 'Home', 1, NULL, '/', NULL, 'Home', 'inner', NULL, 0, NULL, '', '', 1, 1, 0, NULL, NULL, NULL, 'Home', 1, 1, '', '');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_payments`
--

CREATE TABLE IF NOT EXISTS `cms_payments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `pay_type` int(11) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=149 ;

--
-- Sukurta duomenų kopija lentelei `cms_payments`
--

INSERT INTO `cms_payments` (`id`, `record_id`, `lng`, `lng_saved`, `title`, `code`, `image`, `active`, `submit`, `pay_type`, `file`) VALUES
(7, 4061, 'de', 0, 'Swedbank', 'type=paysera\r\nbank=hanza', 'payments-image-4061.png', 1, 0, 4139, NULL),
(6, 4061, 'ru', 0, 'AB bankas "Swedbank"', 'type=paysera\r\nbank=hanza', 'payments-image-4061.png', 1, 0, 4139, NULL),
(5, 4061, 'en', 0, 'AB bankas "Swedbank"', 'type=paysera\r\nbank=hanza', 'payments-image-4061.png', 1, 0, 4139, NULL),
(4, 4061, 'lt', 1, 'AB bankas "Swedbank"', 'type=paysera\r\nbank=hanza', 'payments-image-4061.png', 1, 0, 4139, NULL),
(50, 4127, 'ru', 0, 'AB Nordea bankas', 'type=paysera\r\nbank=nordealt', 'payments-image-4127.png', 1, 0, 4139, NULL),
(48, 4127, 'lt', 1, 'AB Nordea bankas', 'type=paysera\r\nbank=nordealt', 'payments-image-4127.png', 1, 0, 4139, NULL),
(49, 4127, 'en', 0, 'AB Nordea bankas', 'type=paysera\r\nbank=nordealt', 'payments-image-4127.png', 1, 0, 4139, NULL),
(47, 4126, 'de', 0, 'SEB', 'type=paysera\r\nbank=vb2', 'payments-image-4126.png', 1, 0, 4139, NULL),
(45, 4126, 'en', 1, 'SEB', 'type=paysera\r\nbank=vb2', 'payments-image-4126.png', 1, 0, 4139, NULL),
(46, 4126, 'ru', 0, 'SEB', 'type=paysera\r\nbank=vb2', 'payments-image-4126.png', 1, 0, 4139, NULL),
(44, 4126, 'lt', 1, 'AB SEB bankas', 'type=paysera\r\nbank=vb2', 'payments-image-4126.png', 1, 0, 4139, NULL),
(16, 4064, 'lt', 1, 'AB Danske bankas', 'type=paysera\r\nbank=sampo', 'payments-image-4064.png', 1, 0, 4139, NULL),
(17, 4064, 'en', 0, 'AB Danske bankas', 'type=paysera\r\nbank=sampo', 'payments-image-4064.png', 1, 0, 4139, NULL),
(18, 4064, 'ru', 0, 'AB Danske bankas', 'type=paysera\r\nbank=sampo', 'payments-image-4064.png', 1, 0, 4139, NULL),
(19, 4064, 'de', 0, 'Danske', 'type=paysera\r\nbank=sampo', 'payments-image-4064.png', 1, 0, 4139, NULL),
(20, 4065, 'lt', 1, 'AB bankas "DNB"', 'type=paysera\r\nbank=nord', 'payments-image-4065.png', 1, 0, 4139, NULL),
(21, 4065, 'en', 0, 'AB bankas "DNB"', 'type=paysera\r\nbank=nord', 'payments-image-4065.png', 1, 0, 4139, NULL),
(22, 4065, 'ru', 0, 'AB bankas "DNB"', 'type=paysera\r\nbank=nord', 'payments-image-4065.png', 1, 0, 4139, NULL),
(23, 4065, 'de', 0, 'DNB Nord', 'type=paysera\r\nbank=nord', 'payments-image-4065.png', 1, 0, 4139, NULL),
(91, 4137, 'de', 0, 'Paypal', 'type=paypal', 'payments-image-4137.png', 1, 0, 4141, NULL),
(90, 4137, 'ru', 0, 'Paypal', 'type=paypal', 'payments-image-4137.png', 1, 0, 4141, NULL),
(89, 4137, 'en', 0, 'Paypal', 'type=paypal', 'payments-image-4137.png', 1, 0, 4141, NULL),
(88, 4137, 'lt', 1, 'Paypal', 'type=paypal', 'payments-image-4137.png', 1, 0, 4141, NULL),
(28, 4067, 'lt', 1, 'AB Citadele bankas', 'type=paysera\r\nbank=parex', 'payments-image-4067.png', 1, 0, 4139, NULL),
(29, 4067, 'en', 0, 'AB Citadele bankas', 'type=paysera\r\nbank=parex', 'payments-image-4067.png', 1, 0, 4139, NULL),
(30, 4067, 'ru', 0, 'AB Citadele bankas', 'type=paysera\r\nbank=parex', 'payments-image-4067.png', 1, 0, 4139, NULL),
(31, 4067, 'de', 0, 'Parex', 'type=paysera\r\nbank=parex', 'payments-image-4067.png', 1, 0, 4139, NULL),
(32, 4068, 'lt', 1, 'AB Šiaulių bankas', 'type=paysera\r\nbank=sb', 'payments-image-4068.png', 1, 0, 4139, NULL),
(33, 4068, 'en', 0, 'AB Šiaulių bankas', 'type=paysera\r\nbank=sb', 'payments-image-4068.png', 1, 0, 4139, NULL),
(34, 4068, 'ru', 0, 'AB Šiaulių bankas', 'type=paysera\r\nbank=sb', 'payments-image-4068.png', 1, 0, 4139, NULL),
(35, 4068, 'de', 0, 'Šiaulių bankas', 'type=paysera\r\nbank=sb', 'payments-image-4068.png', 1, 0, 4139, NULL),
(51, 4127, 'de', 0, 'Nordea', 'type=paysera\r\nbank=nordealt', 'payments-image-4127.png', 1, 0, 4139, NULL),
(106, 14175, 'ru', 0, 'fasfasf', '', 'facebook-logo103.png', 1, 0, 4140, '05_mano00.doc'),
(107, 14175, 'de', 0, 'fasfasf', '', 'facebook-logo103.png', 1, 0, 4140, '05_mano00.doc'),
(104, 14175, 'lt', 1, 'fasfasf', '', 'facebook-logo103.png', 1, 0, 4140, '05_mano00.doc'),
(105, 14175, 'en', 0, 'fasfasf', '', 'facebook-logo103.png', 1, 0, 4140, '05_mano00.doc'),
(100, 4265, 'lt', 1, 'bvbhgfh', '', 'logoMN.png', 1, 0, 4142, NULL),
(101, 4265, 'en', 0, 'bvbhgfh', '', 'logoMN.png', 1, 0, 4142, NULL),
(102, 4265, 'ru', 0, 'bvbhgfh', '', 'logoMN.png', 1, 0, 4142, NULL),
(103, 4265, 'de', 0, 'bvbhgfh', '', 'logoMN.png', 1, 0, 4142, NULL),
(108, 4061, 'fr', 0, 'Swedbank', 'type=paysera\r\nbank=hanza', 'payments-image-4061.png', 1, 0, 4139, NULL),
(109, 4127, 'fr', 0, 'Nordea', 'type=paysera\r\nbank=nordealt', 'payments-image-4127.png', 1, 0, 4139, NULL),
(110, 4126, 'fr', 0, 'SEB', 'type=paysera\r\nbank=vb2', 'payments-image-4126.png', 1, 0, 4139, NULL),
(111, 4064, 'fr', 0, 'Danske', 'type=paysera\r\nbank=sampo', 'payments-image-4064.png', 1, 0, 4139, NULL),
(112, 4065, 'fr', 0, 'DNB Nord', 'type=paysera\r\nbank=nord', 'payments-image-4065.png', 1, 0, 4139, NULL),
(113, 4137, 'fr', 0, 'Paypal', 'type=paypal', 'payments-image-4137.png', 1, 0, 4141, NULL),
(114, 4067, 'fr', 0, 'Parex', 'type=paysera\r\nbank=parex', 'payments-image-4067.png', 1, 0, 4139, NULL),
(115, 4068, 'fr', 0, 'Šiaulių bankas', 'type=paysera\r\nbank=sb', 'payments-image-4068.png', 1, 0, 4139, NULL),
(125, 14175, 'fr', 0, 'fasfasf', '', 'facebook-logo103.png', 1, 0, 4140, '05_mano00.doc'),
(126, 4265, 'fr', 0, 'bvbhgfh', '', 'logoMN.png', 1, 0, 4142, NULL),
(127, 4061, 'no', 0, 'Swedbank', 'type=paysera\r\nbank=hanza', 'payments-image-4061.png', 1, 0, 4139, NULL),
(128, 4127, 'no', 0, 'Nordea', 'type=paysera\r\nbank=nordealt', 'payments-image-4127.png', 1, 0, 4139, NULL),
(129, 4126, 'no', 0, 'SEB', 'type=paysera\r\nbank=vb2', 'payments-image-4126.png', 1, 0, 4139, NULL),
(130, 4064, 'no', 0, 'Danske', 'type=paysera\r\nbank=sampo', 'payments-image-4064.png', 1, 0, 4139, NULL),
(131, 4065, 'no', 0, 'DNB Nord', 'type=paysera\r\nbank=nord', 'payments-image-4065.png', 1, 0, 4139, NULL),
(132, 4137, 'no', 0, 'Paypal', 'type=paypal', 'payments-image-4137.png', 1, 0, 4141, NULL),
(133, 4067, 'no', 0, 'Parex', 'type=paysera\r\nbank=parex', 'payments-image-4067.png', 1, 0, 4139, NULL),
(134, 4068, 'no', 0, 'Šiaulių bankas', 'type=paysera\r\nbank=sb', 'payments-image-4068.png', 1, 0, 4139, NULL),
(144, 14175, 'no', 0, 'fasfasf', '', 'facebook-logo103.png', 1, 0, 4140, '05_mano00.doc'),
(145, 4265, 'no', 0, 'bvbhgfh', '', 'logoMN.png', 1, 0, 4142, NULL),
(146, 14413, 'lt', 1, 'Mokėjimai.lt sąskaita', 'type=paysera\r\nbank=wallet', 'payments-image-14413.png', 1, NULL, NULL, NULL),
(147, 14413, 'en', 0, 'Mokėjimai.lt sąskaita', 'type=paysera\r\nbank=wallet', 'payments-image-14413.png', 1, NULL, NULL, NULL),
(148, 14413, 'ru', 0, 'Mokėjimai.lt sąskaita', 'type=paysera\r\nbank=wallet', 'payments-image-14413.png', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_phrases`
--

CREATE TABLE IF NOT EXISTS `cms_phrases` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `translation` text,
  `submit` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1863 ;

--
-- Sukurta duomenų kopija lentelei `cms_phrases`
--

INSERT INTO `cms_phrases` (`id`, `record_id`, `title`, `lng`, `translation`, `submit`, `active`, `lng_saved`) VALUES
(1477, 14113, 'order_next_step', 'en', 'Next »»»', '', 1, 1),
(1478, 14113, 'order_next_step', 'ru', 'Следующие »»»', '', 1, 1),
(1143, 3778, 'solution', 'lt', 'Sprendimas', '', 1, 1),
(1144, 3778, 'solution', 'en', 'Solution', '', 1, 1),
(1145, 3778, 'solution', 'ru', 'Решение', '', 1, 1),
(1856, 14673, 'category', 'de', 'Kategorija', NULL, 1, 0),
(1857, 14674, 'price', 'lt', 'Kaina', NULL, 1, 1),
(1858, 14674, 'price', 'en', 'Kaina', NULL, 1, 0),
(1859, 14674, 'price', 'de', 'Kaina', NULL, 1, 0),
(1860, 14675, 'old_price', 'lt', 'Sena kaina', NULL, 1, 1),
(1861, 14675, 'old_price', 'en', 'Sena kaina', NULL, 1, 0),
(1862, 14675, 'old_price', 'de', 'Sena kaina', NULL, 1, 0),
(1855, 14673, 'category', 'en', 'Kategorija', NULL, 1, 0),
(1854, 14673, 'category', 'lt', 'Kategorija', NULL, 1, 1),
(1549, 14092, 'search', 'fr', 'Paieška', NULL, 1, 0),
(1548, 14168, 'page_disabled', 'fr', 'Informacija ruošiama. Apsilankykite vėliau.', '', 1, 0),
(1547, 14136, 'register_block_title', 'fr', 'Pirkti be registracijos', '', 1, 0),
(1542, 14173, 'sdfgdsg', 'fr', 'sd gsdg dsgsd', '', 1, 0),
(1540, 3778, 'solution', 'fr', 'Sprendimas', '', 1, 0),
(1539, 14173, 'sdfgdsg', 'de', 'sd gsdg dsgsd', '', 1, 0),
(1538, 14173, 'sdfgdsg', 'ru', 'sd gsdg dsgsd', '', 1, 0),
(1537, 14173, 'sdfgdsg', 'en', 'sd gsdg dsgsd', '', 1, 0),
(1536, 14173, 'sdfgdsg', 'lt', 'sd gsdg dsgsd', '', 1, 1),
(1535, 14136, 'register_block_title', 'de', 'Kaufen ohne Registrierung', '', 1, 1),
(1534, 14136, 'register_block_title', 'ru', 'Купить без регистрации', '', 1, 1),
(1533, 14136, 'register_block_title', 'en', 'Buy without registering', '', 1, 1),
(1479, 14113, 'order_next_step', 'de', 'Weiter »»»', '', 1, 1),
(1431, 14136, 'register_block_title', 'lt', 'Pirkti be registracijos', '', 1, 1),
(1432, 14168, 'page_disabled', 'lt', 'Informacija ruošiama. Apsilankykite vėliau.', '', 1, 1),
(1433, 14168, 'page_disabled', 'en', 'Information will be available soon. Please visit later.', '', 1, 1),
(1434, 14168, 'page_disabled', 'ru', 'Информация будет доступна в ближайшее время. Пожалуйста, зайдите позже.', '', 1, 1),
(1435, 14168, 'page_disabled', 'de', 'Die Informationen werden in Kürze verfügbar sein. Bitte besuchen Sie später.', '', 1, 1),
(1853, 14672, 'add2cart', 'de', 'Į krepšelį', NULL, 1, 0),
(1437, 3778, 'solution', 'de', 'Solution', '', 1, 1),
(1438, 14094, 'search_submit', 'en', 'search', NULL, 1, 1),
(1439, 14094, 'search_submit', 'ru', 'поиск', NULL, 1, 1),
(1440, 14094, 'search_submit', 'de', 'Suche', NULL, 1, 1),
(1441, 14095, 'siulome', 'en', 'We offer', '', 1, 1),
(1442, 14095, 'siulome', 'ru', 'Мы предлагаем', '', 1, 1),
(1443, 14095, 'siulome', 'de', 'Wir bieten', '', 1, 1),
(1453, 14100, 'new_user', 'en', 'register', '', 1, 1),
(1454, 14100, 'new_user', 'ru', 'Регистрация', '', 1, 1),
(1455, 14100, 'new_user', 'de', 'Register', '', 1, 1),
(1456, 14102, 'select_modification', 'en', '- Select -', '', 1, 1),
(1457, 14102, 'select_modification', 'ru', '- Выбор -', '', 1, 1),
(1458, 14102, 'select_modification', 'de', '- Wählen Sie -', '', 1, 1),
(1389, 14092, 'search', 'en', 'Search', NULL, 1, 1),
(1388, 14092, 'search', 'lt', 'Paieška', NULL, 1, 1),
(1387, 14065, 'form_saved_success', 'de', 'Daten erfolgreich gespeichert.', '', 1, 1),
(1392, 14093, 'products_menu', 'lt', 'Vaikiški drabužiai', '', 1, 1),
(1390, 14092, 'search', 'ru', 'Поиск', NULL, 1, 1),
(1391, 14092, 'search', 'de', 'Suche', NULL, 1, 1),
(1393, 14093, 'products_menu', 'en', 'Vaikiški drabužiai', '', 1, 0),
(1394, 14093, 'products_menu', 'ru', 'Vaikiški drabužiai', '', 1, 0),
(1395, 14093, 'products_menu', 'de', 'Vaikiški drabužiai', '', 1, 0),
(1396, 14094, 'search_submit', 'lt', 'ieškoti', NULL, 1, 1),
(1397, 14095, 'siulome', 'lt', 'Siūlome', '', 1, 1),
(1401, 14100, 'new_user', 'lt', 'registruotis', '', 1, 1),
(1402, 14102, 'select_modification', 'lt', '--pasirinkite--', '', 1, 1),
(1409, 14113, 'order_next_step', 'lt', 'Toliau »»»', '', 1, 1),
(1383, 14064, 'form_send_success', 'de', 'Anfrage wurde erfolgreich versendet.', '', 1, 1),
(1381, 14064, 'form_send_success', 'en', 'Request has been sent successfully.', '', 1, 1),
(1384, 14065, 'form_saved_success', 'lt', 'Duomenys išsaugoti sėkmingai.', '', 1, 1),
(1382, 14064, 'form_send_success', 'ru', 'Запрос был отправлен успешно.', '', 1, 1),
(1380, 14064, 'form_send_success', 'lt', 'Užklausa išsiųsta sėkmingai.', '', 1, 1),
(1386, 14065, 'form_saved_success', 'ru', 'Данные успешно сохранены.', '', 1, 1),
(1385, 14065, 'form_saved_success', 'en', 'Data saved successfully.', '', 1, 1),
(1550, 14093, 'products_menu', 'fr', 'Vaikiški drabužiai', '', 1, 0),
(1553, 14094, 'search_submit', 'fr', 'ieškoti', NULL, 1, 0),
(1554, 14095, 'siulome', 'fr', 'Siūlome', '', 1, 0),
(1558, 14100, 'new_user', 'fr', 'registruotis', '', 1, 0),
(1559, 14102, 'select_modification', 'fr', '--pasirinkite--', '', 1, 0),
(1566, 14113, 'order_next_step', 'fr', 'Toliau »»»', '', 1, 0),
(1644, 14285, 'no_search_results', 'lt', 'Paieškos rezultatų nėra. Patikslinkite paiešką.', NULL, 1, 1),
(1645, 14285, 'no_search_results', 'en', 'Paieškos rezultatų nėra. Patikslinkite paiešką.', NULL, 1, 0),
(1646, 14285, 'no_search_results', 'ru', 'Ничего не найдено. Уточните ваш поиск.', NULL, 1, 0),
(1581, 14065, 'form_saved_success', 'fr', 'Duomenys išsaugoti sėkmingai.', '', 1, 0),
(1582, 14064, 'form_send_success', 'fr', 'Užklausa išsiųsta sėkmingai.', '', 1, 0),
(1584, 3778, 'solution', 'no', 'Sprendimas', '', 1, 0),
(1851, 14672, 'add2cart', 'lt', 'Į krepšelį', NULL, 1, 1),
(1852, 14672, 'add2cart', 'en', 'Į krepšelį', NULL, 1, 0),
(1586, 14173, 'sdfgdsg', 'no', 'sd gsdg dsgsd', '', 1, 0),
(1591, 14136, 'register_block_title', 'no', 'Pirkti be registracijos', '', 1, 0),
(1592, 14168, 'page_disabled', 'no', 'Informacija ruošiama. Apsilankykite vėliau.', '', 1, 0),
(1593, 14092, 'search', 'no', 'Paieška', NULL, 1, 0),
(1594, 14093, 'products_menu', 'no', 'Vaikiški drabužiai', '', 1, 0),
(1597, 14094, 'search_submit', 'no', 'ieškoti', NULL, 1, 0),
(1598, 14095, 'siulome', 'no', 'Siūlome', '', 1, 0),
(1602, 14100, 'new_user', 'no', 'registruotis', '', 1, 0),
(1603, 14102, 'select_modification', 'no', '--pasirinkite--', '', 1, 0),
(1610, 14113, 'order_next_step', 'no', 'Toliau »»»', '', 1, 0),
(1635, 14268, 'important_info', 'lt', 'Kontaktinė informacija', NULL, 1, 1),
(1636, 14268, 'important_info', 'en', 'Kontaktinė informacija', NULL, 1, 0),
(1637, 14268, 'important_info', 'ru', 'Kontaktinė informacija', NULL, 1, 0),
(1638, 14272, 'do_search', 'lt', 'ieškoti', NULL, 1, 1),
(1639, 14272, 'do_search', 'en', 'ieškoti', NULL, 1, 0),
(1640, 14272, 'do_search', 'ru', 'ieškoti', NULL, 1, 0),
(1641, 14284, 'to_short_key', 'lt', 'Per trumpas paieškos žodis', NULL, 1, 1),
(1642, 14284, 'to_short_key', 'en', 'Per trumpas paieškos žodis', NULL, 1, 0),
(1643, 14284, 'to_short_key', 'ru', 'Поиск слово слишком короткое.', NULL, 1, 0),
(1625, 14065, 'form_saved_success', 'no', 'Duomenys išsaugoti sėkmingai.', '', 1, 0),
(1626, 14064, 'form_send_success', 'no', 'Užklausa išsiųsta sėkmingai.', '', 1, 0);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products`
--

CREATE TABLE IF NOT EXISTS `cms_products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `short_description` text,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `description` text,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `akcija` tinyint(1) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_fields`
--

CREATE TABLE IF NOT EXISTS `cms_products_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `short_description` text,
  `active` tinyint(1) DEFAULT NULL,
  `elm_type` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `column_id` int(11) DEFAULT NULL,
  `product_field_options` varchar(1) DEFAULT NULL,
  `list_values` text,
  `multilng` tinyint(1) DEFAULT NULL,
  `use_filter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_fields_options`
--

CREATE TABLE IF NOT EXISTS `cms_products_fields_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `product_field_value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_fields_values`
--

CREATE TABLE IF NOT EXISTS `cms_products_fields_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_images`
--

CREATE TABLE IF NOT EXISTS `cms_products_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `short_description` text,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_modifications`
--

CREATE TABLE IF NOT EXISTS `cms_products_modifications` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title_visible` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `modification_values` tinyint(1) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_modifications_options`
--

CREATE TABLE IF NOT EXISTS `cms_products_modifications_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_column` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_products_modifications_values`
--

CREATE TABLE IF NOT EXISTS `cms_products_modifications_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` int(11) DEFAULT NULL,
  `modif` text,
  `active` tinyint(1) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_record`
--

CREATE TABLE IF NOT EXISTS `cms_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(10) unsigned DEFAULT NULL,
  `is_category` tinyint(1) unsigned DEFAULT NULL,
  `create_by_ip` char(15) NOT NULL DEFAULT '',
  `create_by_admin` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modif_by_ip` char(15) NOT NULL DEFAULT '',
  `last_modif_by_admin` int(11) NOT NULL DEFAULT '0',
  `last_modif_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `session_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`module_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14771 ;

--
-- Sukurta duomenų kopija lentelei `cms_record`
--

INSERT INTO `cms_record` (`id`, `module_id`, `parent_id`, `sort_order`, `is_category`, `create_by_ip`, `create_by_admin`, `create_date`, `last_modif_by_ip`, `last_modif_by_admin`, `last_modif_date`, `trash`, `session_id`) VALUES
(2, 1, 0, 1, 0, '', 0, '2006-02-20 14:12:57', '86.100.151.68', 2, '2012-11-02 19:11:18', 0, ''),
(3778, 5, 0, 1583, NULL, '192.168.130.35', 2, '2009-09-04 18:42:22', '192.168.1.101', 2, '2012-01-26 00:09:08', 1, ''),
(14672, 5, 0, 11882, NULL, '::1', 2, '2014-09-29 13:34:51', '::1', 2, '2014-09-29 13:34:51', 0, ''),
(4127, 108, 0, 1764, NULL, '78.61.68.114', 2, '2009-10-05 13:26:43', '88.119.136.122', 2, '2014-06-14 15:52:52', 0, ''),
(4126, 108, 0, 1740, NULL, '78.61.68.114', 2, '2009-10-05 13:21:19', '88.119.136.122', 2, '2014-06-16 12:56:56', 0, ''),
(14168, 5, 0, 11616, NULL, '78.61.68.114', 2, '2011-04-11 19:14:45', '78.61.68.114', 2, '2011-04-11 19:18:46', 0, ''),
(4061, 108, 0, 1741, NULL, '78.61.68.114', 2, '2009-09-30 12:58:28', '88.119.136.122', 2, '2014-06-14 15:51:58', 0, ''),
(4065, 108, 0, 1750, NULL, '78.61.68.114', 2, '2009-09-30 13:15:12', '88.119.136.122', 2, '2014-06-14 15:52:42', 0, ''),
(4064, 108, 0, 1744, NULL, '78.61.68.114', 2, '2009-09-30 13:15:03', '88.119.136.122', 2, '2014-06-14 15:52:10', 0, ''),
(4137, 108, 0, 1775, NULL, '78.61.68.114', 2, '2009-10-05 16:29:48', '88.119.136.122', 2, '2014-06-14 15:53:08', 0, ''),
(4067, 108, 0, 1746, NULL, '78.61.68.114', 2, '2009-09-30 13:15:39', '88.119.136.122', 2, '2014-06-14 15:52:22', 0, ''),
(4068, 108, 0, 1747, NULL, '78.61.68.114', 2, '2009-09-30 13:15:55', '88.119.136.122', 2, '2014-06-14 15:52:32', 0, ''),
(14413, 108, 0, 1774, NULL, '88.119.136.122', 2, '2014-06-14 14:50:51', '88.119.136.122', 2, '2014-06-14 15:53:01', 0, ''),
(14175, 108, 0, 1739, NULL, '78.61.68.114', 2, '2011-05-12 16:43:08', '78.61.68.114', 2, '2011-05-17 20:01:31', 1, ''),
(14173, 5, 0, 11689, NULL, '78.61.68.114', 2, '2011-05-11 18:30:50', '192.168.1.101', 2, '2012-02-07 18:43:38', 1, ''),
(4265, 108, 0, 1845, NULL, '78.61.68.114', 2, '2009-10-19 17:40:42', '86.100.151.68', 2, '2012-10-13 18:53:03', 1, ''),
(14064, 5, 0, 1591, NULL, '78.61.68.114', 2, '2010-05-13 17:56:45', '78.61.68.114', 2, '2011-04-11 19:38:16', 0, ''),
(14065, 5, 0, 1594, NULL, '78.61.68.114', 2, '2010-05-13 17:57:05', '78.61.68.114', 2, '2011-04-11 19:38:39', 0, ''),
(14092, 5, 0, 1585, NULL, '78.61.68.114', 2, '2010-09-13 13:09:41', '88.119.138.222', 2, '2012-09-06 16:30:27', 1, ''),
(14093, 5, 0, 11629, NULL, '78.61.68.114', 2, '2010-09-13 14:29:00', '78.61.68.114', 2, '2011-04-14 16:08:00', 1, ''),
(14094, 5, 0, 1588, NULL, '78.61.68.114', 2, '2010-09-13 15:00:19', '::1', 2, '2014-04-27 12:27:05', 0, ''),
(14095, 5, 0, 11630, NULL, '78.61.68.114', 2, '2010-09-13 17:19:00', '192.168.1.101', 2, '2012-01-26 00:03:04', 1, ''),
(14100, 5, 0, 1584, NULL, '78.61.68.114', 2, '2010-09-14 11:28:02', '88.119.138.222', 2, '2012-08-17 12:42:26', 1, ''),
(14102, 5, 0, 11633, NULL, '78.61.68.114', 2, '2010-09-14 13:38:37', '78.61.68.114', 2, '2011-04-14 16:10:07', 1, ''),
(14272, 5, 0, 11726, NULL, '::1', 2, '2014-04-19 16:42:12', '::1', 2, '2014-04-19 16:42:12', 0, ''),
(14113, 5, 0, 11640, NULL, '78.61.68.114', 2, '2010-09-15 17:34:02', '192.168.1.101', 2, '2012-01-26 00:09:23', 1, ''),
(14268, 5, 0, 11722, NULL, '::1', 2, '2014-04-19 14:32:23', '::1', 2, '2014-04-19 14:32:23', 0, ''),
(14274, 81, 0, 11727, NULL, '::1', 2, '2014-04-22 17:13:30', '::1', 2, '2015-12-15 17:39:00', 0, 'h49cg4engbubkbcopallique01'),
(14136, 5, 0, 11661, NULL, '78.61.68.114', 2, '2010-09-22 15:32:39', '192.168.1.101', 2, '2012-02-07 18:44:22', 1, ''),
(14284, 5, 0, 11730, NULL, '::1', 2, '2014-04-27 12:32:56', '::1', 2, '2014-10-20 16:32:21', 0, ''),
(14285, 5, 0, 11731, NULL, '::1', 2, '2014-04-27 12:33:20', '::1', 2, '2014-10-20 16:32:32', 0, ''),
(14675, 5, 0, 11885, NULL, '::1', 2, '2014-09-30 11:54:22', '::1', 2, '2014-09-30 11:54:22', 0, ''),
(14674, 5, 0, 11884, NULL, '::1', 2, '2014-09-30 11:53:54', '::1', 2, '2014-09-30 11:53:54', 0, ''),
(14673, 5, 0, 11883, NULL, '::1', 2, '2014-09-30 11:53:47', '::1', 2, '2014-09-30 11:53:47', 0, '');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_record_lang`
--

CREATE TABLE IF NOT EXISTS `cms_record_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `search_text` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`,`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Sukurta duomenų kopija lentelei `cms_record_lang`
--

INSERT INTO `cms_record_lang` (`id`, `record_id`, `module_id`, `lng`, `search_text`) VALUES
(1, 14274, 81, 'lt', 'Home\n | \nHome\n | \nHome\n | \n/');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_relations`
--

CREATE TABLE IF NOT EXISTS `cms_relations` (
  `item_id` bigint(20) NOT NULL DEFAULT '0',
  `column_name` varchar(255) NOT NULL DEFAULT '',
  `list_item_id` bigint(20) NOT NULL DEFAULT '0',
  KEY `item_id` (`item_id`),
  KEY `list_item_id` (`list_item_id`),
  KEY `column_name` (`column_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_site_blocks`
--

CREATE TABLE IF NOT EXISTS `cms_site_blocks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `block_content` longtext,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_stat_visitors`
--

CREATE TABLE IF NOT EXISTS `cms_stat_visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `browser_version` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `device` varchar(255) NOT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `referer_domain` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `visit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `session_id` varchar(255) DEFAULT NULL,
  `robot` tinyint(1) NOT NULL DEFAULT '0',
  `page_count` int(11) DEFAULT '0',
  `back_id` int(11) DEFAULT NULL,
  `conversion_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `back_id` (`back_id`),
  KEY `conversion_id` (`conversion_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_stat_visitors_path`
--

CREATE TABLE IF NOT EXISTS `cms_stat_visitors_path` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `visit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `conversion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_id` (`visitor_id`),
  KEY `conversion_id` (`conversion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_stat_visitors_temp`
--

CREATE TABLE IF NOT EXISTS `cms_stat_visitors_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
  `ipaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visit_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_subscribers`
--

CREATE TABLE IF NOT EXISTS `cms_subscribers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_subscribers_group`
--

CREATE TABLE IF NOT EXISTS `cms_subscribers_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `short_description` text,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_tags`
--

CREATE TABLE IF NOT EXISTS `cms_tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_templates`
--

CREATE TABLE IF NOT EXISTS `cms_templates` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `defaultas` tinyint(4) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `lng` varchar(3) NOT NULL,
  `lng_saved` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Sukurta duomenų kopija lentelei `cms_templates`
--

INSERT INTO `cms_templates` (`id`, `title`, `name`, `defaultas`, `active`, `lng`, `lng_saved`) VALUES
(1, 'Paprastas puslapis', 'inner', 1, 1, '', 1),
(2, 'Pradinis puslapis', 'main', 0, 1, '', 0),
(13, 'Naujienos', 'news', 0, 1, '', 0),
(17, 'Svetainės struktūra', 'sitemap', 0, 1, '', 1),
(18, 'Paieška', 'search', 0, 1, '', 1),
(26, 'Renginiai', 'events', 0, 1, '', 1),
(25, 'Produkcija', 'products', 0, 1, '', 1),
(23, 'Blogas', 'blog', 0, 1, '', 1),
(24, 'Popup', 'popup', 0, 1, '', 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_users`
--

CREATE TABLE IF NOT EXISTS `cms_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `pswd` varchar(255) DEFAULT NULL,
  `submit` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `confirm_code` varchar(255) DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_code` varchar(255) DEFAULT NULL,
  `company_vat` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `cms_user_groups`
--

CREATE TABLE IF NOT EXISTS `cms_user_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL DEFAULT '0',
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng_saved` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `short_description` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
