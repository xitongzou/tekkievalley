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
require('language/' .$_SESSION['language']. '/my_group_edit.lang.php');

chk_member_login();

$urlkey = NULL;
if ( isset($_REQUEST['urlkey']) && $_REQUEST['urlkey'] != '' && preg_match('/^[A-Za-z0-9_\-]+$/', $_REQUEST['urlkey']) )
    $urlkey = @mysql_real_escape_string($_REQUEST['urlkey']);

$uid    = mysql_real_escape_string($_SESSION['UID']);

if ( isset($_POST['edit_group']) ) {
	$group_name 	= $filterObj->process(trim($_POST['group_name']));
	$description	= $filterObj->process(trim($_POST['description']));
	$short_name	    = $filterObj->process(trim($_POST['short_name']));
	$tags		    = $filterObj->process(trim($_POST['tags']));
	$channel	    = $_POST['channel'];
	
	if ( $group_name == '' )
		$err = $lang['my_group.name_empty'];
	elseif ( $tags == '' )
		$err = $lang['my_group.tags_empty'];
	elseif ( $description == '' )
		$err = $lang['my_group.desc_empty'];
	elseif ( $short_name == '' )
		$err = $lang['my_group.url_empty'];
	elseif ( count($channel)<1 or count($channel)>3 )
		$err = $lang['my_group_create.channels_empty'];
	else {
		$sql = "SELECT GID FROM group_own WHERE gurl = '" .mysql_real_escape_string($short_name). "' AND gurl != '" .$urlkey. "' limit 1";
		$rs  = $conn->execute($sql);
		if ( $rs->recordcount() > 0 )
			$err = $lang['my_group.url_exists'];
	}
        
	if ( $err == '' ) {
		$group_name  		= mysql_real_escape_string($group_name);
		$tags	     		= mysql_real_escape_string($tags);
		$description 		= mysql_real_escape_string($description);
		$short_name  		= mysql_real_escape_string($short_name);
        $group_type         = mysql_real_escape_string($_POST['group_type']);
		$video_upload_type 	= mysql_real_escape_string($_POST['video_upload_type']);
		$forum_upload_type 	= mysql_real_escape_string($_POST['forum_upload_type']);
		$group_icon 		= mysql_real_escape_string($_POST['group_icon']);
        

        $sql = "update group_own set gname = '" .$group_name. "', keyword = '" .$tags. "', gdescn = '" .$description. "',
                gurl = '" .$short_name. "', type = '" .$group_type. "', gupload = '" .$video_upload_type. "', channel = '0|" .implode('|', mysql_real_escape_string($channel)). "|0',
                gposting = '" .$forum_upload_type. "', gimage = '" .$group_icon. "' where OID='" .$uid. "' and gurl='" .$urlkey. "'";
        $conn->execute($sql);
		$msg = $lang['my_group.success'];
		$URL = seo_url('group/' .$short_name. '/?msg=' .$msg, 'groups_home.php?urlkey=' .$short_name. '&msg=' .$msg);
		session_write_close();
        header('Location: ' .$URL);
		die();
	}
}

$sql="SELECT * from group_own WHERE gurl='" .$urlkey. "' limit 1";
$rs = $conn->Execute($sql);
if($rs->recordcount()>0) {
        $ownid=insert_check_group_own($rs->fields['GID']);
        $group = $rs->getrows();
}

$mych = explode('|', $group['0']['channel']);
$ch = insert_list_channel();
for($i=0; $ch[$i]['ch']!=''; $i++) {
        if(in_array($ch[$i]['id'], $mych))
                $checked = 'checked';
        else
                $checked = '';

        $ch_checkbox .= "<input type=checkbox name=channel[] value=".$ch[$i]['id']." $checked>".$ch[$i]['ch']."</input><br>";
}

STemplate::assign('ch_checkbox',$ch_checkbox);
STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('group',$group['0']);
STemplate::assign('head_bottom',"grouplinks.tpl");
STemplate::assign('head_bottom_add',"crglinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('my_group_edit.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
