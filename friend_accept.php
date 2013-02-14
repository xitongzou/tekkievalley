<?php
/**************************************************************************************************
| Software Name        : ClipShare - Video Sharing Community Script
| Software Author      : Clip-Share.Com / ScriptXperts.Com
| Website              : http://www.clip-share.com
| E-mail               : office@clip-share.com
|**************************************************************************************************
| This source file is subject to the ClipShare End-User License Agreement, available online at:
| http://www.clip-share.com/video-sharing-script-eula.html
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2006-2007 Clip-Share.com. All rights reserved.
|**************************************************************************************************/

require('include/config.php');
require('include/function.php');
require('language/' .$_SESSION['language']. '/friends_accept.lang.php');

chk_member_login();

$id = ( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) ? $_REQUEST['id'] : NULL;
if ( $id ) {
	$sql = "SELECT * FROM friends WHERE id = '" .$id. "'";
	$rs  = $conn->execute($sql);
	if ( $rs->recordcount() > 0 ) {
		STemplate::assign('AID', $id);
		STemplate::assign('UID', $rs->fields['UID']);
	}
}

//ACCEPT
if ( isset($_REQUEST['friend_accept']) && $_REQUEST['friend_accept'] != '' ) {
	$aid = ( isset($_REQUEST['AID']) && is_numeric($_REQUEST['AID']) ) ? mysql_real_escape_string($_REQUEST['AID']) : NULL;
	$sql = "SELECT * FROM friends WHERE id = '" .$aid. "' AND friends_status = 'Pending'";
	$rs  = $conn->execute($sql);
	if ( $rs->recordcount() > 0 ) {
		$uid 	  = mysql_real_escape_string($_SESSION['UID']);
		$username = mysql_real_escape_string($_SESSION['USERNAME']);
		$sql      = "UPDATE friends SET FID = '" .$uid. "', friends_name = '" .$username. "', friends_status = 'Confirmed'
		             WHERE id = '" .$aid. "' AND friends_status = 'Pending'";
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 ) {
			$fid['un'] = $rs->fields['UID'];
			$fname = insert_id_to_name($fid);
			$sql = "INSERT friends SET UID = '" .$uid. "', FID = '" .$rs->fields['UID']. "', friends_name = '" .$fname. "',
			        friends_type = 'All|Friends', invite_date = '" .date('Y-m-d'). "', friends_status = 'Confirmed'";
			$conn->execute($sql);
            		$msg = $lang['friends_accept.accepted'];
    		}
	}
}

//DENY
if ( isset($_REQUEST['friend_deny']) && $_REQUEST['friend_deny'] != '' ) {
	$delaid = ( isset($_REQUEST['AID']) && is_numeric($_REQUEST['AID']) ) ? $_REQUEST['AID'] : NULL;
	$sql    = "DELETE FROM friends WHERE id = '" .$delaid. "'";
	$rs     = $conn->execute($sql);
	if ( $conn->Affected_Rows() >= 1 )
		$msg = $lang['friends_accept.denied'];
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('friend_accept.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
