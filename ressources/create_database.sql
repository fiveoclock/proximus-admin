-- phpMyAdmin SQL Dump
-- version 3.3.7deb5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2011 at 06:15 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `proximus`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 178),
(2, 1, NULL, NULL, 'Pages', 2, 7),
(3, 2, NULL, NULL, 'display', 3, 4),
(4, 1, NULL, NULL, 'Blockednetworks', 8, 23),
(5, 4, NULL, NULL, 'index', 9, 10),
(6, 4, NULL, NULL, 'savePos', 11, 12),
(7, 4, NULL, NULL, 'redirectBack', 13, 14),
(8, 4, NULL, NULL, 'add', 15, 16),
(9, 4, NULL, NULL, 'edit', 17, 18),
(10, 4, NULL, NULL, 'delete', 19, 20),
(11, 1, NULL, NULL, 'NoauthRules', 24, 39),
(12, 11, NULL, NULL, 'index', 25, 26),
(13, 11, NULL, NULL, 'savePos', 27, 28),
(14, 11, NULL, NULL, 'redirectBack', 29, 30),
(15, 11, NULL, NULL, 'add', 31, 32),
(16, 11, NULL, NULL, 'edit', 33, 34),
(17, 11, NULL, NULL, 'delete', 35, 36),
(18, 1, NULL, NULL, 'Groups', 40, 57),
(19, 18, NULL, NULL, 'savePos', 41, 42),
(20, 18, NULL, NULL, 'redirectBack', 43, 44),
(21, 18, NULL, NULL, 'index', 45, 46),
(22, 18, NULL, NULL, 'view', 47, 48),
(23, 18, NULL, NULL, 'add', 49, 50),
(24, 18, NULL, NULL, 'edit', 51, 52),
(25, 18, NULL, NULL, 'delete', 53, 54),
(26, 1, NULL, NULL, 'Users', 58, 71),
(27, 26, NULL, NULL, 'index', 59, 60),
(28, 26, NULL, NULL, 'view', 61, 62),
(29, 26, NULL, NULL, 'add', 63, 64),
(30, 26, NULL, NULL, 'edit', 65, 66),
(31, 26, NULL, NULL, 'delete', 67, 68),
(32, 1, NULL, NULL, 'Locations', 72, 89),
(33, 32, NULL, NULL, 'savePos', 73, 74),
(34, 32, NULL, NULL, 'index', 75, 76),
(35, 32, NULL, NULL, 'start', 77, 78),
(36, 32, NULL, NULL, 'view', 79, 80),
(71, 41, NULL, NULL, 'checkAllowedLocations', 107, 108),
(38, 32, NULL, NULL, 'add', 81, 82),
(39, 32, NULL, NULL, 'edit', 83, 84),
(40, 32, NULL, NULL, 'delete', 85, 86),
(41, 1, NULL, NULL, 'Rules', 90, 111),
(42, 41, NULL, NULL, 'getAll', 91, 92),
(43, 41, NULL, NULL, 'redirectBack', 93, 94),
(44, 41, NULL, NULL, 'search', 95, 96),
(45, 41, NULL, NULL, 'index', 97, 98),
(46, 41, NULL, NULL, 'view', 99, 100),
(47, 41, NULL, NULL, 'add', 101, 102),
(48, 41, NULL, NULL, 'edit', 103, 104),
(49, 41, NULL, NULL, 'delete', 105, 106),
(50, 1, NULL, NULL, 'Admins', 112, 133),
(51, 50, NULL, NULL, 'initDB', 113, 114),
(52, 50, NULL, NULL, 'login', 115, 116),
(53, 50, NULL, NULL, 'logout', 117, 118),
(54, 50, NULL, NULL, 'index', 119, 120),
(55, 50, NULL, NULL, 'view', 121, 122),
(56, 50, NULL, NULL, 'add', 123, 124),
(57, 50, NULL, NULL, 'edit', 125, 126),
(58, 50, NULL, NULL, 'delete', 127, 128),
(59, 1, NULL, NULL, 'Roles', 134, 147),
(60, 59, NULL, NULL, 'index', 135, 136),
(61, 59, NULL, NULL, 'view', 137, 138),
(62, 59, NULL, NULL, 'add', 139, 140),
(63, 59, NULL, NULL, 'edit', 141, 142),
(64, 59, NULL, NULL, 'delete', 143, 144),
(65, 2, NULL, NULL, 'checkAllowedLocations', 5, 6),
(66, 4, NULL, NULL, 'checkAllowedLocations', 21, 22),
(67, 11, NULL, NULL, 'checkAllowedLocations', 37, 38),
(68, 18, NULL, NULL, 'checkAllowedLocations', 55, 56),
(69, 26, NULL, NULL, 'checkAllowedLocations', 69, 70),
(70, 32, NULL, NULL, 'checkAllowedLocations', 87, 88),
(72, 50, NULL, NULL, 'changePassword', 129, 130),
(73, 50, NULL, NULL, 'checkAllowedLocations', 131, 132),
(74, 59, NULL, NULL, 'checkAllowedLocations', 145, 146),
(75, 1, NULL, NULL, 'Logs', 148, 167),
(76, 75, NULL, NULL, 'index', 149, 150),
(77, 75, NULL, NULL, 'view', 151, 152),
(78, 75, NULL, NULL, 'add', 153, 154),
(79, 75, NULL, NULL, 'edit', 155, 156),
(80, 75, NULL, NULL, 'delete', 157, 158),
(81, 75, NULL, NULL, 'checkAllowedLocations', 159, 160),
(84, 75, NULL, NULL, 'deleteWithChildren', 161, 162),
(87, 41, NULL, NULL, 'createFromLog', 109, 110),
(85, 75, NULL, NULL, 'searchlist', 163, 164),
(86, 75, NULL, NULL, 'searchstring', 165, 166),
(94, 1, NULL, NULL, 'ProxySettings', 168, 177),
(95, 94, NULL, NULL, 'index', 169, 170),
(96, 94, NULL, NULL, 'edit', 171, 172),
(97, 94, NULL, NULL, 'add', 173, 174),
(98, 94, NULL, NULL, 'delete', 175, 176);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  `role_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `active`, `role_id`, `created`, `modified`) VALUES
(1, 'admin', '2a489457d306f3bd0d0c4d833aa8b2336cdb8303', 'Y', 1, '2011-05-25 10:31:44', '2011-05-25 10:31:44'),
(2, 'locadmin', '2a489457d306f3bd0d0c4d833aa8b2336cdb8303', 'Y', 2, '2009-06-18 14:37:46', '2011-05-25 12:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `admins_locations`
--

CREATE TABLE IF NOT EXISTS `admins_locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ADMINS_LOCATIONS_KEY` (`admin_id`,`location_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admins_locations`
--

INSERT INTO `admins_locations` (`id`, `admin_id`, `location_id`, `created`, `modified`) VALUES
(2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Role', 1, NULL, 1, 16),
(2, NULL, 'Role', 2, NULL, 17, 88),
(3, NULL, 'Role', 3, NULL, 89, 90),
(4, 1, 'Admin', 1, NULL, 2, 3),
(5, 2, 'Admin', 2, NULL, 86, 87),
(7, 2, 'Admin', 4, NULL, 18, 19),
(8, 2, 'Admin', 5, NULL, 20, 21),
(9, 2, 'Admin', 6, NULL, 22, 23),
(10, 2, 'Admin', 7, NULL, 24, 25),
(11, 2, 'Admin', 8, NULL, 26, 27),
(12, 2, 'Admin', 9, NULL, 28, 29),
(13, 1, 'Admin', 10, NULL, 4, 5),
(14, 2, 'Admin', 11, NULL, 30, 31),
(15, 2, 'Admin', 12, NULL, 32, 33),
(16, 2, 'Admin', 13, NULL, 34, 35),
(17, 1, 'Admin', 14, NULL, 6, 7),
(18, 2, 'Admin', 15, NULL, 36, 37),
(19, 2, 'Admin', 16, NULL, 38, 39),
(20, 2, 'Admin', 17, NULL, 40, 41),
(21, 2, 'Admin', 18, NULL, 42, 43),
(22, 2, 'Admin', 19, NULL, 44, 45),
(23, 2, 'Admin', 20, NULL, 46, 47),
(24, 2, 'Admin', 21, NULL, 48, 49),
(25, 2, 'Admin', 22, NULL, 50, 51),
(26, 2, 'Admin', 23, NULL, 52, 53),
(27, 2, 'Admin', 24, NULL, 54, 55),
(28, 2, 'Admin', 25, NULL, 56, 57),
(30, 2, 'Admin', 27, NULL, 58, 59),
(31, 1, 'Admin', 28, NULL, 8, 9),
(32, 2, 'Admin', 29, NULL, 60, 61),
(33, 2, 'Admin', 30, NULL, 62, 63),
(34, 1, 'Admin', 31, NULL, 10, 11),
(35, 1, 'Admin', 32, NULL, 12, 13),
(36, 2, 'Admin', 33, NULL, 64, 65),
(37, 2, 'Admin', 34, NULL, 66, 67),
(38, 2, 'Admin', 35, NULL, 68, 69),
(39, 2, 'Admin', 36, NULL, 70, 71),
(40, 2, 'Admin', 37, NULL, 72, 73),
(41, 2, 'Admin', 38, NULL, 74, 75),
(42, 2, 'Admin', 39, NULL, 76, 77),
(43, 2, 'Admin', 40, NULL, 78, 79),
(44, 2, 'Admin', 41, NULL, 80, 81),
(45, 2, 'Admin', 42, NULL, 82, 83),
(46, 2, 'Admin', 43, NULL, 84, 85),
(48, 1, 'Admin', 45, NULL, 14, 15);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(27, 2, 48, '1', '1', '1', '1'),
(26, 2, 47, '1', '1', '1', '1'),
(25, 2, 46, '1', '1', '1', '1'),
(24, 2, 44, '1', '1', '1', '1'),
(23, 2, 39, '1', '1', '1', '1'),
(22, 2, 36, '1', '1', '1', '1'),
(21, 2, 35, '1', '1', '1', '1'),
(20, 2, 25, '1', '1', '1', '1'),
(19, 2, 24, '1', '1', '1', '1'),
(18, 2, 23, '1', '1', '1', '1'),
(17, 2, 22, '1', '1', '1', '1'),
(16, 2, 1, '-1', '-1', '-1', '-1'),
(15, 3, 1, '-1', '-1', '-1', '-1'),
(28, 2, 49, '1', '1', '1', '1'),
(29, 2, 72, '1', '1', '1', '1'),
(30, 2, 55, '1', '1', '1', '1'),
(31, 2, 84, '1', '1', '1', '1'),
(32, 2, 80, '1', '1', '1', '1'),
(33, 2, 85, '1', '1', '1', '1'),
(34, 2, 86, '1', '1', '1', '1'),
(35, 2, 87, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `blockednetworks`
--

CREATE TABLE IF NOT EXISTS `blockednetworks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `network` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blockednetworks`
--

INSERT INTO `blockednetworks` (`id`, `network`, `description`, `location_id`, `created`, `modified`) VALUES
(1, '10.1.2.0/24', 'example block /24 network', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '10.92.1.2', 'example block single host', 1, '0000-00-00 00:00:00', '2011-05-25 12:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE IF NOT EXISTS `global_settings` (
  `subsite_sharing` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'valid: "own_parents" or "all_parents" or ""',
  `mail_interval` tinyint(4) NOT NULL COMMENT 'mail interval in hours',
  `retrain_key` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT 'if set allows to retrain dynamic rules by inserting it before the hostname',
  `regex_cut` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'this regex will be cut off from the username'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`subsite_sharing`, `mail_interval`, `retrain_key`, `regex_cut`) VALUES
('own_parents', 1, '-', '.*\\+');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `location_id` int(11) unsigned NOT NULL,
  `user_count` int(11) unsigned DEFAULT NULL,
  `rule_count` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INC2, NULL, NULL, '2011-05-25 12:25:36', '2011-05-25 12:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `code`, `name`) VALUES
(1, 'ALL', '*All Locations*'),
(2, 'VIE', 'Vienna'),
(3, 'NY', 'New York Office');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ipaddress` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `protocol` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*',
  `created` datetime DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `location_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `source` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hitcount` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_duplicates` (`sitename`,`protocol`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `maillog`
--

CREATE TABLE IF NOT EXISTS `maillog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `protocol` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `sent` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maillog`
--


-- --------------------------------------------------------

--
-- Table structure for table `noauth_rules`
--

CREATE TABLE IF NOT EXISTS `noauth_rules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `sitename` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `noauth_rules`
--

INSERT INTO `noauth_rules` (`id`, `type`, `sitename`, `location_id`, `valid_until`, `description`, `created`, `modified`) VALUES
(1, 'DN', '.example.com', 1, NULL, 'example rule', '2011-05-18 08:31:12', '2011-05-18 08:31:12'),
(2, 'DN', '.testing.at', 2, '2011-05-20 11:00:00', 'example expire rule', NULL, '2011-05-20 17:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `proxy_settings`
--

CREATE TABLE IF NOT EXISTS `proxy_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `fqdn_proxy_hostname` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `redirection_host` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `smtpserver` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admincc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `proxy_settings`
--

INSERT INTO `proxy_settings` (`id`, `location_id`, `fqdn_proxy_hostname`, `redirection_host`, `smtpserver`, `admin_email`, `admincc`) VALUES
(1, 2, 'srv-proxy01.vie.example.com', 'proxy.vie.example.com', 'localhost', 'root@example.com', 0),
(2, 3, 'srv-proxy01.ny.example.com', 'proxy.ny.example.com', 'localhost', '-------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `minprio` int(11) DEFAULT NULL,
  `maxprio` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `minprio`, `maxprio`, `created`, `modified`) VALUES
(1, 'Global Admin', 0, 59, '2009-06-18 14:35:07', '2009-06-18 14:35:07'),
(2, 'Location Admin', 20, 39, '2009-06-18 14:35:15', '2009-06-18 14:35:15'),
(3, 'Global Read-Only', 0, 0, '2009-06-18 14:35:28', '2009-06-18 14:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `protocol` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*',
  `priority` int(11) NOT NULL DEFAULT '0',
  `policy` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) unsigned NOT NULL DEFAULT '0',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `sitename`, `protocol`, `priority`, `policy`, `starttime`, `endtime`, `description`, `location_id`, `group_id`, `created`, `modified`) VALUES
(1, '*.badsite.com', '*', 60, 'DENY', NULL, NULL, 'example rule', 1, 0, '2010-02-18 12:04:49', '2010-02-18 12:04:49'),
(2, 'lego.com', 'SSL', 32, 'DENY_MAIL', NULL, NULL, 'example rule', 2, 0, '2010-01-29 09:24:48', '2010-01-29 09:24:48'),
(3, 'www.facebook.com', '*', 31, 'DENY', NULL, NULL, 'example rule', 2, 0, '2010-01-28 17:01:48', '2010-01-28 17:01:48'),
(4, '*', '*', 0, 'ALLOW', NULL, NULL, 'default policy is allow', 1, 0, '2011-05-25 12:27:17', '2011-05-25 12:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `realname` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailaddress` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned DEFAULT '0',
  `updated` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `realname`, `emailaddress`, `location_id`, `group_id`, `updated`, `active`, `create_time`, `update_time`) VALUES
(1, 'jodoe', 'John Doe', 'john.doe@example.com', 2, 0, '1', 'Y', '2009-11-17 14:04:14', '2011-05-24 20:12:45'),
(2, 'jadoe', 'Jane Doe', 'jane.doe@example.com', 2, 0, 'Y', 'Y', '2009-11-17 14:04:14', '2011-05-19 14:39:09');

