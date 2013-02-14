<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_POST['submit_modules']) ) {
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string(trim($_POST['video_module'])). "' WHERE soption = 'video_module' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string(trim($_POST['groups_module'])). "' WHERE soption = 'groups_module' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string(trim($_POST['channels_module'])). "' WHERE soption = 'channels_module' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string(trim($_POST['community_module'])). "' WHERE soption = 'community_module' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string(trim($_POST['upload_module'])). "' WHERE soption = 'upload_module' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string(trim($_POST['friends_module'])). "' WHERE soption = 'friends_module' LIMIT 1";
	$conn->execute($sql);
	update_config_and_smarty();
	$msg = 'Modules configuration updated successfuly!';
}
?>
