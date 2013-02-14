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
require('language/' .$_SESSION['language']. '/groups_create.lang.php');

chk_member_login();

if ( isset($_REQUEST['creategroup']) && $_REQUEST['creategroup'] != '' ) {
	$uid 			    = mysql_real_escape_string($_SESSION['UID']);
	$listch 		    = mysql_real_escape_string(implode('|', $_REQUEST['chlist']));
	$group_name 		= mysql_real_escape_string($filterObj->process(trim($_REQUEST['group_name'])));
	$tags 			    = mysql_real_escape_string($filterObj->process(trim($_REQUEST['tags'])));
	$description 		= mysql_real_escape_string($filterObj->process(trim($_REQUEST['description'])));
	$short_name 		= mysql_real_escape_string($filterObj->process(trim($_REQUEST['short_name'])));
	$group_type		    = mysql_real_escape_string(trim($_REQUEST['group_type']));
	$video_upload_type	= mysql_real_escape_string(trim($_REQUEST['video_upload_type']));
	$forum_upload_type	= mysql_real_escape_string(trim($_REQUEST['forum_upload_type']));
	$group_icon		    = mysql_real_escape_string(trim($_REQUEST['group_icon']));
	
	if ( $group_name == '' )
		$err = $lang['group_create.name_empty'];
	elseif ( $tags == '' )
		$err = $lang['group_create.tags_empty'];
	elseif ( $description == '' )
		$err = $lang['group_create.desc_empty'];
	elseif ( $short_name == '' || check_field_exists($short_name, 'gurl', 'group_own' ) == 1 )
		$err = $lang['group_create.url_empty'];
	elseif ( !preg_match('/^[a-zA-Z0-9_]*$/', $short_name) )
		$err = $lang['group_create.url_invalid'];	
	elseif ( strlen($short_name) < 3 or strlen($short_name) > 18 )
		$err = $lang['group_create.url_length'];
	elseif ( count($_REQUEST['chlist']) < 1 || count($_REQUEST['chlist']) > 3 )
		$err = $lang['group_create.channels_empty'];

        if ( $err == '' ) {
		$sql="insert into group_own set OID='" .$uid. "', gname='" .$group_name. "', keyword='" .$tags. "',
            		gdescn='" .$description. "', gurl='" .$short_name. "', channel='0|" .$listch. "|0',
            		type='" .$group_type. "', gupload='" .$video_upload_type. "', gposting='" .$forum_upload_type. "',
			gimage='" .$group_icon. "', gcrtime='".time()."'";
    		$conn->execute($sql);
    		$id=mysql_insert_id();
    		$sql="insert into group_mem set GID='" .$id. "', MID='" .$uid. "', member_since = '".date('Y-m-d')."'";
    		$conn->execute($sql);
    		if ( $conn->Affected_Rows() >= 1 )  {
			    session_write_close();
			    $URL = seo_url('group/' .$short_name. '?msg=' .$lang['group_create.created'], 'groups_home.php?urlkey=' .$short_name. '&msg=' .$lang['group_create.created']);
			    header('Location: ' .$URL);
			    die();
    		}
	}
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('answers',$users);
STemplate::assign('head_bottom',"grouplinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('create_group.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
