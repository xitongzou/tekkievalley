<?php
ini_set('display_errors', 0);
define( '_VALID_CS', 1 );
require('include/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql    = "DELETE FROM adv";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (1, 'home_top_single', 'Home Top Single Ads', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (2, 'home_right_box', '<DIV style=\"display: block; width: 176px; height:100px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>HOME RIGHT BOX</font><BR>Advertisement Here<BR><BR><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></DIV>', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (3, 'home_top_banner', '<center><div style=\"display: block; width: 468px; height:60px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>HOME TOP BANNER</font><br />Advertisement Here<br /><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></div></center><br />', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (4, 'video_top_banner', '<center><div style=\"display: block; width: 440px; height:60px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>VIDEO TOP BANNER</font><br />Advertisement Here<br /><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></div></center><br />', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (5, 'video_right_single', '<DIV style=\"display: block; width: 176px; height:100px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>VIDEO RIGHT BOTTOM BOX</font><BR>Advertisement Here<BR><BR><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></DIV>', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (6, 'video_right_single_middle', '<DIV style=\"display: block; width: 176px; height:100px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>VIDEO RIGHT MIDDLE BOX</font><BR>Advertisement Here<BR><BR><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></DIV>', 'Inactive')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (7, 'groups_right_single', '<DIV style=\"display: block; width: 176px; height:100px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>GROUPS RIGHT BOX</font><BR>Advertisement Here<BR><BR><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></DIV>', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `adv` VALUES (8, 'friends_right_single', '<DIV style=\"display: block; width: 176px; height:100px; padding:5px; border: 1px solid #DDDDDD; text-align:left;\"><font size=1 color=#999999>FRIENDS RIGHT BOX</font><BR>Advertisement Here<BR><BR><font size=1 color=#BBBBBB>Edit / Enable / Disable from Admin Panel</font></DIV>', 'Active')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

// add new bans table
$sql    = "CREATE TABLE `bans` (
          `ban_id` bigint(20) NOT NULL auto_increment,
          `ban_ip` varchar(16) NOT NULL default '',
          `ban_date` datetime NOT NULL default '0000-00-00 00:00:00',
          PRIMARY KEY (`ban_id`),
          KEY `ban_ip` (`ban_ip`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

// email info (add subscribe email...)
$sql    = "INSERT INTO `emailinfo` VALUES ('subscribe_email', '\$sender_name has uploaded a new video', 'emails/subscribe_email.tpl', 'Video Subscription Email');";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

// groups
$sql    = "ALTER TABLE group_own DROP COLUMN html, DROP COLUMN css, DROP COLUMN visits";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "ALTER TABLE group_vdo DROP COLUMN addtime";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

// sconfig
$sql    = "DELETE FROM sconfig WHERE soption IN ('smarty_lifetime', 'secret_pass', 'max_video_size', 'under_maintainance', 'featured_max',
                                                'exec_time', 'show_top_cat', 'show_top_chan', 'show_tags', 'show_vdo_oday', 'show_top_videos', 'show_news',
                                                'show_now_play', 'which_top_vdos', 'require_valid', 'which_vdo_oday', 'which_now_play', 'top_chan_max',
                                                'top_cat_max', 'allow_videos', 'allow_cat', 'allow_chan', 'allow_pm', 'allow_upload', 'allow_viewvid',
                                                'allow_community', 'allow_registr', 'allow_chan_create', 'avatar_control', 'smarty_static', 'template',
                                                'admin_template', 'tmpimgpath', 'tmpimgpath2', 'news', 'comments_on', 'maintain_msg', 'gunzip', 'mencoder_latest',
                                                'rtl, encodepass', 'meta_descr', 'meta_key', 'show_latest_foot', 'show_stats_foot', 'show_featured',
                                                'show_last_tabs', 'stream', 'x3_username', 'x3_password', 'x3_status')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);


$sql    = "INSERT INTO sconfig VALUES ('admin_pass', 'admin')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('thumbs_tool', 'ffmpeg')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('seo_urls', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('captcha', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('approve', '0')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('downloads', '0')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('language', 'en_US')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('del_original_video', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('photowidth', '150')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('pm_notify', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('user_registrations', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('email_verification', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('video_view', 'all')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('meta_description', 'Meta Description Here')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('meta_keywords', 'meta, keywords, go, here')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('session_lifetime', '1440')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('session_driver', 'files')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('gzip_encoding', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('video_comments', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('video_comments_limit', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('private_msgs', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('streaming_method', 'progressive_download')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('video_module', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('friends_module', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('groups_module', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('upload_module', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('channels_module', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('community_module', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('mailer', 'mail')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('sendmail', '/usr/sbin/sendmail')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('smtp', '')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('smtp_auth', '0')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('smtp_username', '')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('smtp_password', '')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('smtp_port', '')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('smtp_prefix', '')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('upload_by_file', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('upload_by_embed', '1')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('video_max_size', '700')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('video_allowed_extensions', 'avi,mpg,mov,asf,mpeg,xvid,divx,3gp,mkv,3gpp,mp4,rmvb,rm,dat,wmv,flv,ogg')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('force_password', '0')";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "INSERT INTO `sconfig` VALUES ('items_per_front_page', 20);";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

// signup
$sql    = "ALTER TABLE signup DROP COLUMN html, DROP COLUMN css, DROP COLUMN sess_cookie, DROP COLUMN sess_time, DROP COLUMN user_online,
                              DROP COLUMN pm_allow, DROP COLUMN pm_notify";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "ALTER TABLE signup ADD `playlist` enum('Public', 'Private') NOT NULL default 'Public'";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "ALTER TABLE signup ADD `user_ip` varchar(16) NOT NULL default ''";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

//drop unused tables here
$sql    = "DROP table useronline, video_session";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

// video
$sql    = "ALTER TABLE video DROP COLUMN brightcove_id, DROP COLUMN subtit, DROP COLUMN embd, DROP COLUMN rated";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
$sql    = "ALTER TABLE video ADD `thumb` tinyint(1) unsigned NOT NULL default '1'";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);
?>
