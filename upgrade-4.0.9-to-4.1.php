<?php
require 'include/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "DROP table adv";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "CREATE TABLE `adv` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23;";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "CREATE TABLE `adv_group` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "INSERT INTO `adv_group` (`advgrp_id`, `advgrp_name`, `advgrp_width`, `advgrp_height`, `total_advs`, `advgrp_rotate`, `advgrp_status`) VALUES
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
(14, 'friends_top', 0, 0, 0, '1', '1');";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "CREATE TABLE `adv_media` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "CREATE TABLE `adv_text` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "CREATE TABLE `player_settings` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "INSERT INTO `player_settings` (`id`, `profile`, `autorun`, `buffertime`, `buttons`, `logo_url`, `logo_position`, `logo_link`, `logo_alpha`, `text_adv`, `text_adv_type`, `text_adv_delay`, `video_adv`, `video_adv_type`, `video_adv_position`, `skin`, `embed`, `related`, `related_content`, `share`, `mail`, `replay`, `mail_color`, `related_color`, `replay_color`, `embed_color`, `copy_color`, `time_color`, `share_color`, `adv_nav_color`, `adv_title_color`, `adv_body_color`, `adv_link_color`, `status`) VALUES
(1, 'default', 'true', 3, '1', '', 'BR', '', 10, '1', 'global', 5, '1', 'global', 'b', 'default', '1', '1', 'related', '1', '1', '1', '0x999999', '0x999999', '0x999999', '0x999999', '0xf1f1f1', '0x999999', '0x999999', '0x999999', '0xffa200', '0xf1f1f1', '0x999999', '1');";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "CREATE TABLE `users_online` (
  `UID` bigint(20) NOT NULL default '0',
  `online` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`UID`),
  KEY `online` (`online`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "INSERT INTO sconfig SET soption='rotating_thumbs', svalue='1'";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "INSERT INTO sconfig SET soption='multilanguage', svalue='1'";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';

$sql = "insert into emailinfo (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('player_email', 'I want to share this video with you!', 'emails/player_email.tpl', 'Player Share Email')";
$conn->execute($sql);
echo htmlspecialchars($sql). '<br><br>';
?>
