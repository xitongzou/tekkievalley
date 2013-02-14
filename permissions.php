<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_POST['submit_permissions']) ) {
	$user_registrations 	= trim($_POST['user_registrations']);
	$email_verification	    = trim($_POST['email_verification']);
	$video_view		        = trim($_POST['video_view']);
	$video_comments		    = trim($_POST['video_comments']);
	$video_comments_limit	= trim($_POST['video_comments_limit']);
	$private_msgs		    = trim($_POST['private_msgs']);
	$force_password		    = trim($_POST['force_password']);
    $user_poll              = trim($_POST['user_poll']);
    $video_rating           = trim($_POST['video_rating']);
	
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($user_registrations). "' WHERE soption = 'user_registrations' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($email_verification). "' WHERE soption = 'email_verification' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($video_view). "' WHERE soption = 'video_view' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($video_comments). "' WHERE soption = 'video_comments' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($video_comments_limit). "' WHERE soption = 'video_comments_limit' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($private_msgs). "' WHERE soption = 'private_msgs' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($force_password). "' WHERE soption = 'force_password' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($user_poll). "' WHERE soption = 'user_poll' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($video_rating). "' WHERE soption = 'video_rating' LIMIT 1";
	$conn->execute($sql);
	update_config_and_smarty();
	$msg = 'Permissions Updated Successfuly!';
}
?>
