-- phpMyAdmin SQL Dump
-- version 2.11.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2008 at 09:22 AM
-- Server version: 4.1.22
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `adv`
--

CREATE TABLE IF NOT EXISTS `adv` (
  `adv_id` bigint(20) NOT NULL auto_increment,
  `adv_group` tinyint(3) unsigned NOT NULL default '0',
  `adv_name` varchar(99) NOT NULL default '',
  `adv_text` text NOT NULL,
  `adv_views` bigint(20) NOT NULL default '0',
  `adv_click` bigint(20) NOT NULL default '0',
  `adv_addtime` bigint(20) NOT NULL default '0',
  `adv_status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`adv_id`),
  KEY `adv_group` (`adv_group`),
  KEY `adv_addtime` (`adv_addtime`),
  KEY `adv_status` (`adv_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Table structure for table `adv_group`
--

CREATE TABLE IF NOT EXISTS `adv_group` (
  `advgrp_id` tinyint(3) unsigned NOT NULL default '0',
  `advgrp_name` varchar(99) NOT NULL default '',
  `advgrp_width` tinyint(4) unsigned NOT NULL default '0',
  `advgrp_height` tinyint(3) unsigned NOT NULL default '0',
  `total_advs` bigint(20) NOT NULL default '0',
  `advgrp_rotate` enum('1','0') NOT NULL default '1',
  `advgrp_status` enum('1','0') NOT NULL default '1',
  KEY `advgrp_name` (`advgrp_name`),
  KEY `advgrp_rotate` (`advgrp_rotate`),
  KEY `advgrp_status` (`advgrp_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adv_group`
--

INSERT INTO `adv_group` (`advgrp_id`, `advgrp_name`, `advgrp_width`, `advgrp_height`, `total_advs`, `advgrp_rotate`, `advgrp_status`) VALUES
(1, 'index_top', 0, 0, 0, '1', '1'),
(2, 'index_right', 0, 0, 0, '1', '1'),
(3, 'index_top_single', 0, 0, 0, '1', '1'),
(4, 'view_top', 0, 0, 0, '1', '1'),
(5, 'view_right', 0, 0, 0, '1', '1'),
(6, 'view_right_single', 0, 0, 0, '1', '1'),
(7, 'groups_right', 0, 0, 0, '1', '1'),
(8, 'friends_right', 0, 0, 0, '1', '1'),
(9, 'index_feature', 0, 0, 0, '1', '1'),
(10, 'video_top', 0, 0, 0, '1', '1'),
(11, 'channels_top', 0, 0, 0, '1', '1'),
(12, 'groups_top', 0, 0, 0, '1', '1'),
(13, 'community_top', 0, 0, 0, '1', '1'),
(14, 'friends_top', 0, 0, 0, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `adv_media`
--

CREATE TABLE IF NOT EXISTS `adv_media` (
  `adv_id` bigint(20) unsigned NOT NULL auto_increment,
  `adv_url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `duration` tinyint(3) unsigned NOT NULL default '0',
  `media` enum('jpg','swf','flv') NOT NULL default 'flv',
  `views` bigint(20) NOT NULL default '0',
  `clicks` bigint(20) NOT NULL default '0',
  `addtime` int(10) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`adv_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Table structure for table `adv_text`
--

CREATE TABLE IF NOT EXISTS `adv_text` (
  `adv_id` bigint(20) unsigned NOT NULL auto_increment,
  `adv_url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `views` bigint(20) NOT NULL default '0',
  `clicks` bigint(20) NOT NULL default '0',
  `addtime` int(10) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`adv_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Table structure for table `bans`
--

CREATE TABLE IF NOT EXISTS `bans` (
  `ban_id` bigint(20) NOT NULL auto_increment,
  `ban_ip` varchar(16) NOT NULL default '',
  `ban_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ban_id`),
  KEY `ban_ip` (`ban_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `buddy_list`
--

CREATE TABLE IF NOT EXISTS `buddy_list` (
  `username` varchar(80) default NULL,
  `buddy_name` varchar(80) default NULL,
  UNIQUE KEY `username` (`username`,`buddy_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
  `CHID` bigint(20) NOT NULL auto_increment,
  `name` varchar(120) NOT NULL default '',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`CHID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `COMID` bigint(20) NOT NULL auto_increment,
  `VID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `commen` text NOT NULL,
  `addtime` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`COMID`),
  KEY `VID` (`VID`,`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Table structure for table `emailinfo`
--

CREATE TABLE IF NOT EXISTS `emailinfo` (
  `email_id` varchar(50) NOT NULL default '',
  `email_subject` varchar(255) NOT NULL default '',
  `email_path` varchar(255) NOT NULL default '',
  `comment` varchar(255) default NULL,
  PRIMARY KEY  (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emailinfo`
--

INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES
('verify_email', 'About email verification', 'emails/verify_email.tpl', 'Email Verification'),
('invite_email', 'Friendship invitation from  $sender_name', 'emails/invite_email.tpl', 'To invite a friend'),
('invite_group_email', '$sender_name has invited you to join a group {$gname}', 'emails/invite_group_email.tpl', 'Send invitation to join a group'),
('recover_password', 'Your site login password', 'emails/recover_password.tpl', 'Recovering user login password'),
('subscribe_email', '$sender_name has uploaded a new video', 'emails/subscribe_email.tpl', 'Video Subscription Email'),
('player_email', 'I want to share this video with you!', 'emails/player_email.tpl', 'Player Share Email');

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE IF NOT EXISTS `favourite` (
  `UID` bigint(20) NOT NULL default '0',
  `VID` bigint(20) NOT NULL default '0',
  UNIQUE KEY `UID` (`UID`,`VID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favourite`
--


-- --------------------------------------------------------

--
-- Table structure for table `feature_req`
--

CREATE TABLE IF NOT EXISTS `feature_req` (
  `VID` bigint(20) NOT NULL default '0',
  `req` bigint(20) NOT NULL default '0',
  `date` varchar(10) default NULL,
  PRIMARY KEY  (`VID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `FID` bigint(20) default NULL,
  `friends_name` varchar(100) NOT NULL default '',
  `friends_type` varchar(255) NOT NULL default 'All',
  `invite_date` date NOT NULL default '0000-00-00',
  `friends_status` enum('Pending','Confirmed','DENIED') NOT NULL default 'Pending',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Table structure for table `group_mem`
--

CREATE TABLE IF NOT EXISTS `group_mem` (
  `AID` bigint(20) NOT NULL auto_increment,
  `GID` bigint(20) NOT NULL default '0',
  `MID` bigint(20) NOT NULL default '0',
  `member_since` date NOT NULL default '0000-00-00',
  `approved` char(3) NOT NULL default 'yes',
  PRIMARY KEY  (`AID`),
  UNIQUE KEY `GID` (`GID`,`MID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table structure for table `group_own`
--

CREATE TABLE IF NOT EXISTS `group_own` (
  `GID` bigint(20) NOT NULL auto_increment,
  `gname` varchar(120) NOT NULL default '',
  `keyword` text NOT NULL,
  `gdescn` text NOT NULL,
  `gurl` varchar(80) NOT NULL default '',
  `channel` varchar(120) NOT NULL default '',
  `type` varchar(40) NOT NULL default '',
  `gupload` varchar(40) NOT NULL default '',
  `gposting` varchar(40) NOT NULL default '',
  `gimage` varchar(30) NOT NULL default '',
  `gimage_vdo` bigint(20) default NULL,
  `gcrtime` varchar(30) NOT NULL default '',
  `featured` varchar(3) NOT NULL default 'no',
  `OID` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`GID`),
  UNIQUE KEY `GID` (`GID`,`OID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table structure for table `group_tps`
--

CREATE TABLE IF NOT EXISTS `group_tps` (
  `TID` bigint(20) NOT NULL auto_increment,
  `GID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` text NOT NULL,
  `VID` bigint(20) NOT NULL default '0',
  `approved` varchar(3) NOT NULL default 'yes',
  PRIMARY KEY  (`TID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Table structure for table `group_tps_post`
--

CREATE TABLE IF NOT EXISTS `group_tps_post` (
  `PID` bigint(20) NOT NULL auto_increment,
  `TID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `VID` bigint(20) default NULL,
  `post` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`PID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table structure for table `group_vdo`
--

CREATE TABLE IF NOT EXISTS `group_vdo` (
  `AID` bigint(20) NOT NULL auto_increment,
  `GID` bigint(20) NOT NULL default '0',
  `VID` bigint(20) NOT NULL default '0',
  `MID` bigint(20) NOT NULL default '0',
  `approved` char(3) NOT NULL default 'yes',
  PRIMARY KEY  (`AID`),
  UNIQUE KEY `GID` (`GID`,`VID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table structure for table `guest_info`
--

CREATE TABLE IF NOT EXISTS `guest_info` (
  `sl` int(4) NOT NULL auto_increment,
  `guest_ip` varchar(16) NOT NULL default '',
  `log_date` date NOT NULL default '0000-00-00',
  `use_bw` bigint(20) NOT NULL default '0',
  UNIQUE KEY `sl` (`sl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `inappro_req`
--

CREATE TABLE IF NOT EXISTS `inappro_req` (
  `VID` bigint(20) NOT NULL default '0',
  `req` bigint(20) NOT NULL default '0',
  `date` varchar(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `last_5users`
--

CREATE TABLE IF NOT EXISTS `last_5users` (
  `LOGID` bigint(30) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`LOGID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `pack_id` int(11) NOT NULL auto_increment,
  `pack_name` varchar(255) NOT NULL default '',
  `pack_desc` text NOT NULL,
  `space` bigint(20) NOT NULL default '0',
  `bandwidth` bigint(20) NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `video_limit` int(11) default NULL,
  `period` enum('Day','Month','Year') NOT NULL default 'Month',
  `status` enum('Active','Inactive') NOT NULL default 'Active',
  `is_trial` varchar(3) NOT NULL default 'no',
  `trial_period` int(11) default NULL,
  PRIMARY KEY  (`pack_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pack_id`, `pack_name`, `pack_desc`, `space`, `bandwidth`, `price`, `video_limit`, `period`, `status`, `is_trial`, `trial_period`) VALUES
(1, 'Gold', 'For ultimate service', 20100, 6000, 100, 501, 'Year', 'Active', 'no', NULL),
(3, 'Silver', 'This is for medium user', 512, 4000, 50, 0, 'Month', 'Active', 'no', NULL),
(4, 'Free Trial', 'Join now to test the system.', 200, 400, 0, 100, '', 'Active', 'yes', 60);

-- --------------------------------------------------------

--
-- Table structure for table `player_settings`
--

CREATE TABLE IF NOT EXISTS `player_settings` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `profile` varchar(255) NOT NULL default '',
  `autorun` enum('true','false') NOT NULL default 'false',
  `buffertime` tinyint(2) unsigned NOT NULL default '5',
  `buttons` enum('0','1') NOT NULL default '1',
  `logo_url` varchar(255) NOT NULL default '',
  `logo_position` varchar(2) NOT NULL default 'BR',
  `logo_link` varchar(255) NOT NULL default '',
  `logo_alpha` tinyint(2) unsigned NOT NULL default '10',
  `text_adv` enum('0','1') NOT NULL default '1',
  `text_adv_type` enum('global','video','channel') NOT NULL default 'global',
  `text_adv_delay` tinyint(3) unsigned NOT NULL default '5',
  `video_adv` enum('0','1') NOT NULL default '1',
  `video_adv_type` enum('global','video','channel') NOT NULL default 'global',
  `video_adv_position` enum('b','e','be') NOT NULL default 'be',
  `skin` varchar(255) NOT NULL default 'default',
  `embed` enum('0','1') NOT NULL default '1',
  `related` enum('0','1') NOT NULL default '1',
  `related_content` enum('related','featured','commented','rated','viewed') NOT NULL default 'related',
  `share` enum('0','1') NOT NULL default '1',
  `mail` enum('0','1') NOT NULL default '1',
  `replay` enum('0','1') NOT NULL default '1',
  `mail_color` varchar(8) NOT NULL default '0x999999',
  `related_color` varchar(8) NOT NULL default '0x999999',
  `replay_color` varchar(8) NOT NULL default '0x999999',
  `embed_color` varchar(8) NOT NULL default '0x999999',
  `copy_color` varchar(8) NOT NULL default '0x999999',
  `time_color` varchar(8) NOT NULL default '0x999999',
  `share_color` varchar(8) NOT NULL default '0x999999',
  `adv_nav_color` varchar(8) NOT NULL default '0x999999',
  `adv_title_color` varchar(8) NOT NULL default '0x999999',
  `adv_body_color` varchar(8) NOT NULL default '0x999999',
  `adv_link_color` varchar(8) NOT NULL default '0x999900',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `profile` (`profile`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `player_settings`
--

INSERT INTO `player_settings` (`id`, `profile`, `autorun`, `buffertime`, `buttons`, `logo_url`, `logo_position`, `logo_link`, `logo_alpha`, `text_adv`, `text_adv_type`, `text_adv_delay`, `video_adv`, `video_adv_type`, `video_adv_position`, `skin`, `embed`, `related`, `related_content`, `share`, `mail`, `replay`, `mail_color`, `related_color`, `replay_color`, `embed_color`, `copy_color`, `time_color`, `share_color`, `adv_nav_color`, `adv_title_color`, `adv_body_color`, `adv_link_color`, `status`) VALUES
(1, 'default', 'true', 3, '1', '', 'BR', '', 10, '1', 'global', 5, '1', 'global', 'b', 'default', '1', '1', 'related', '1', '1', '1', '0x999999', '0x999999', '0x999999', '0x999999', '0xf1f1f1', '0x999999', '0x999999', '0x999999', '0xffa200', '0xf1f1f1', '0x999999', '1');

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `UID` bigint(20) default NULL,
  `VID` bigint(20) default NULL,
  UNIQUE KEY `UID` (`UID`,`VID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `pm`
--

CREATE TABLE IF NOT EXISTS `pm` (
  `pm_id` bigint(20) NOT NULL auto_increment,
  `subject` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `sender` varchar(40) NOT NULL default '',
  `receiver` varchar(40) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `seen` tinyint(1) NOT NULL default '0',
  `inbox_track` int(11) NOT NULL default '2',
  `outbox_track` int(11) NOT NULL default '2',
  PRIMARY KEY  (`pm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Table structure for table `poll_question`
--

CREATE TABLE IF NOT EXISTS `poll_question` (
  `poll_id` int(4) NOT NULL auto_increment,
  `poll_qty` varchar(250) NOT NULL default '',
  `poll_answer` text NOT NULL,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `AID` bigint(20) NOT NULL auto_increment,
  `FAID` bigint(20) NOT NULL default '0',
  `FBID` bigint(20) NOT NULL default '0',
  `status` varchar(8) NOT NULL default 'pending',
  `type` varchar(8) NOT NULL default '',
  `e_mail` varchar(80) NOT NULL default '',
  PRIMARY KEY  (`AID`),
  UNIQUE KEY `FAID` (`FAID`,`e_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `sconfig`
--

CREATE TABLE IF NOT EXISTS `sconfig` (
  `soption` varchar(60) NOT NULL default '',
  `svalue` varchar(200) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sconfig`
--

INSERT INTO `sconfig` (`soption`, `svalue`) VALUES
('admin_email', 'admin@yoursite.com'),
('admin_name', 'admin'),
('site_name', 'ClipShare'),
('admin_pass', 'admin'),
('total_per_ini', '9999'),
('emailsender', 'Admin'),
('max_img_size', '200'),
('img_max_width', '120'),
('img_max_height', '90'),
('max_display_size', '400'),
('items_per_page', '20'),
('max_video_size', '300000000'),
('rel_video_per_page', '10'),
('recently_viewed_video', '12'),
('flashplayer', 'yes'),
('activexinstall', 'no'),
('enable_package', 'no'),
('paypal_receiver_email', 'payment@yoursite.com'),
('payment_method', 'Paypal'),
('enable_test_payment', 'no'),
('authorizelogin', ''),
('authorizekey', ''),
('lfubannar', 'Enable'),
('pollinganel', 'Enable'),
('user_poll', 'Once'),
('video_rating', 'Once'),
('phppath', '/usr/local/bin/php'),
('mplayer', '/usr/local/bin/mplayer'),
('mencoder', '/usr/local/bin/mencoder'),
('ffmpeg', '/usr/local/bin/ffmpeg'),
('metainject', '/usr/bin/flvtool2'),
('thumbs_tool', 'mplayer'),
('vbitrate', '800'),
('sbitrate', '22050'),
('vresize', '0'),
('vresize_x', '320'),
('vresize_y', '240'),
('seo_urls', '1'),
('captcha', '1'),
('approve', '0'),
('downloads', '0'),
('language', 'en_US'),
('guest_limite', '65535'),
('del_original_video', '1'),
('photowidth', '150'),
('pm_notify', '1'),
('user_registrations', '1'),
('email_verification', '1'),
('video_view', 'all'),
('meta_description', 'Meta Description Here'),
('meta_keywords', 'meta, keywords, go, here'),
('session_lifetime', '1440'),
('session_driver', 'files'),
('gzip_encoding', '1'),
('video_comments', '1'),
('video_comments_limit', '1'),
('private_msgs', '1'),
('streaming_method', 'progressive_download'),
('video_module', '1'),
('friends_module', '1'),
('groups_module', '1'),
('upload_module', '1'),
('channels_module', '1'),
('community_module', '1'),
('mailer', 'mail'),
('sendmail', '/usr/sbin/sendmail'),
('smtp', ''),
('smtp_auth', '0'),
('smtp_username', ''),
('smtp_password', ''),
('smtp_port', ''),
('smtp_prefix', ''),
('upload_by_file', '1'),
('upload_by_embed', '1'),
('video_max_size', '1000'),
('video_allowed_extensions', 'avi,flv,mpeg,wmv,mov,3gp,mp4,mpg'),
('rotating_thumbs', '1'),
('force_password', '1'),
('items_per_front_page', '10'),
('multilanguage', '1');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE IF NOT EXISTS `signup` (
  `UID` bigint(20) NOT NULL auto_increment,
  `email` varchar(80) NOT NULL default '',
  `username` varchar(80) NOT NULL default '',
  `pwd` varchar(50) NOT NULL default '',
  `fname` varchar(40) NOT NULL default '',
  `lname` varchar(40) NOT NULL default '',
  `bdate` date NOT NULL default '0000-00-00',
  `gender` varchar(6) NOT NULL default '',
  `relation` varchar(8) NOT NULL default '',
  `aboutme` text NOT NULL,
  `website` varchar(120) NOT NULL default '',
  `town` varchar(80) NOT NULL default '',
  `city` varchar(80) NOT NULL default '',
  `zip` varchar(30) NOT NULL default '',
  `country` varchar(80) NOT NULL default '',
  `occupation` text NOT NULL,
  `company` text NOT NULL,
  `school` text NOT NULL,
  `interest_hobby` text NOT NULL,
  `fav_movie_show` text NOT NULL,
  `fav_music` text NOT NULL,
  `fav_book` text NOT NULL,
  `friends_type` varchar(255) NOT NULL default 'All|Family|Friends',
  `video_viewed` int(10) NOT NULL default '0',
  `profile_viewed` int(10) NOT NULL default '0',
  `watched_video` int(10) NOT NULL default '0',
  `addtime` varchar(20) NOT NULL default '',
  `logintime` varchar(20) NOT NULL default '',
  `emailverified` varchar(3) NOT NULL default 'no',
  `account_status` enum('Active','Inactive') NOT NULL default 'Active',
  `vote` varchar(5) NOT NULL default '',
  `ratedby` varchar(5) NOT NULL default '0',
  `rate` varchar(5) NOT NULL default '0',
  `parents_name` varchar(50) NOT NULL default '',
  `parents_email` varchar(50) NOT NULL default '',
  `friends_name` varchar(50) NOT NULL default '',
  `friends_email` varchar(50) NOT NULL default '',
  `photo` varchar(100) NOT NULL default '',
  `playlist` enum('Public','Private') NOT NULL default 'Public',
  `user_ip` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`UID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Table structure for table `subscribe_video`
--

CREATE TABLE IF NOT EXISTS `subscribe_video` (
  `sl` int(4) NOT NULL auto_increment,
  `subscribe_to` varchar(20) NOT NULL default '',
  `subscribe_from` varchar(20) NOT NULL default '',
  `status` varchar(5) NOT NULL default '',
  UNIQUE KEY `sl` (`sl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `subscriber`
--

CREATE TABLE IF NOT EXISTS `subscriber` (
  `UID` bigint(20) NOT NULL default '0',
  `pack_id` int(11) NOT NULL default '0',
  `used_space` bigint(20) NOT NULL default '0',
  `used_bw` bigint(20) NOT NULL default '0',
  `total_video` bigint(20) NOT NULL default '0',
  `subscribe_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `expired_time` datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `users_online`
--

CREATE TABLE IF NOT EXISTS `users_online` (
  `UID` bigint(20) NOT NULL default '0',
  `online` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`UID`),
  KEY `online` (`online`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `uservote`
--

CREATE TABLE IF NOT EXISTS `uservote` (
  `candate_id` varchar(15) NOT NULL default '',
  `voter_id` varchar(15) NOT NULL default '',
  `vote` varchar(2) NOT NULL default '0',
  `voted_date` varchar(12) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `verify`
--

CREATE TABLE IF NOT EXISTS `verify` (
  `UID` bigint(20) NOT NULL default '0',
  `vcode` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `VID` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `title` varchar(120) NOT NULL default '',
  `description` text NOT NULL,
  `featuredesc` text NOT NULL,
  `keyword` text NOT NULL,
  `channel` varchar(255) NOT NULL default '0|',
  `vdoname` varchar(40) NOT NULL default '',
  `flvdoname` varchar(40) default NULL,
  `duration` float NOT NULL default '0',
  `space` bigint(20) NOT NULL default '0',
  `type` varchar(7) NOT NULL default '',
  `addtime` varchar(20) default NULL,
  `adddate` date NOT NULL default '0000-00-00',
  `record_date` date NOT NULL default '0000-00-00',
  `location` text NOT NULL,
  `country` varchar(120) NOT NULL default '',
  `vkey` varchar(20) NOT NULL default '',
  `viewnumber` bigint(10) NOT NULL default '0',
  `viewtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `com_num` int(8) NOT NULL default '0',
  `fav_num` int(8) NOT NULL default '0',
  `featured` varchar(3) NOT NULL default 'no',
  `ratedby` bigint(10) NOT NULL default '0',
  `rate` float NOT NULL default '0',
  `filehome` varchar(120) NOT NULL default '',
  `be_comment` varchar(3) NOT NULL default 'yes',
  `be_rated` varchar(3) NOT NULL default 'yes',
  `embed` varchar(8) NOT NULL default 'enabled',
  `embed_code` text NOT NULL,
  `thumb` tinyint(1) unsigned NOT NULL default '1',
  `voter_id` varchar(200) NOT NULL default '',
  `active` char(1) NOT NULL default '',
  PRIMARY KEY  (`VID`),
  UNIQUE KEY `vkey` (`vkey`),
  KEY `viewnumber` (`viewnumber`),
  KEY `rate` (`rate`),
  KEY `fav_num` (`fav_num`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Table structure for table `vote_result`
--

CREATE TABLE IF NOT EXISTS `vote_result` (
  `vote_id` varchar(10) NOT NULL default '',
  `voter_id` varchar(20) NOT NULL default '',
  `answer` varchar(250) NOT NULL default '',
  `client_ip` varchar(25) NOT NULL default '',
  `voted_date` date NOT NULL default '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
