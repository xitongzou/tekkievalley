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
require('classes/pagination.class.php');
require('language/' .$_SESSION['language']. '/friends.lang.php');

chk_member_login();

$uid    = mysql_real_escape_string($_SESSION['UID']);
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;
$view   = ( isset($_REQUEST['view']) && preg_match('^[a-zA-Z]*$/', $_REQUEST['view']) ) ? $_REQUEST['view'] : 'All';
$sort   = ( isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'name' ) ? 'name' : 'date';

if ( isset($_REQUEST['add_list']) && $_REQUEST['add_list'] ) {
	add_item('signup', 'friends_type', 'UID=' .$uid, $_REQUEST['add_list']);
	session_write_close();
	header('Location: friends.php?msg=' .$lang['friends.add_list']);
	die();
}

if ( isset($_REQUEST['del_list']) && $_REQUEST['del_list'] ) {
	remove_item('signup', 'friends_type', 'UID=' .$uid, $_REQUEST['del_list']);
	$sql = "SELECT id FROM friends WHERE UID = '" .$uid. "'";
	$rs  = $conn->execute($sql);
	while ( !$rs->EOF ) {
		remove_item('friends', 'friends_type', 'id=' .$rs->fields['id'], $_REQUEST['del_list']);
		$rs->movenext();
	}
	
	session_write_close();
	header('Location: ' .$config['BASE_URL']. 'friends.php?msg=' .$lang['friends.del_list']);
	die();
}

if ( isset($_REQUEST['action_name']) ) {
	$action = $_REQUEST['action_name'];
	if ( $action == 'delete' ) {
		while ( list($k, $v) = @each($_REQUEST['AID']) ) {
			settype($v, 'integer');
			$conn->execute("DELETE FROM friends WHERE id = '" .mysql_real_escape_string($v). "'");
		}
		
		session_write_close();
		header('Location: friends.php?msg=' .$lang['friends.del']);
		die();
	} else {
		$sql  = "SELECT friends_type FROM signup WHERE UID = '" .$uid. "' LIMIT 1";
		$rs   = $conn->execute($sql);
		$type = explode('|', $rs->fields['friends_type']);
		$cmd  = explode('_', $action);
		if ( $cmd['0'] == 'add' && $cmd['1'] != '' ) {
			while ( list($k,$v) = @each($_REQUEST['AID']) ) {
				settype( $v, 'integer' );
				add_item('friends', 'friends_type', 'id = ' .$v, $type[$cmd['1']]);
				$msg = $lang['friends.action_add'];
			}
		} elseif ( $cmd['0'] == 'delete' && $cmd['1'] != '' ) {
			while ( list($k, $v) = @each($_REQUEST['AID']) ) {
				settype( $v, 'integer' );
				remove_item('friends', 'friends_type', 'id=' .$v, $type[$cmd['1']]);
				$msg = $lang['friends.action_del'];
			}
		}
		
		session_write_close();
		header('Location: friends.php?msg=' .$msg);
		die();
	}
}

if ( isset($_REQUEST['invite_signup']) && $_REQUEST['invite_signup'] != '' ) {
	for ( $i=0; $i<count($friends_email); $i++ ) {
		if ( $friends_email[$i] != '' ) {
			$emails[] = $friends_email[$i];
			$tag      = 'yes';
			if ( $friends_name[$i] == '') {
				$err = $lang['friends.email_fname'];
				break;
			}
			$fnames[] = $friends_fname[$i];
			$rtype[]  = $type[$i];	
		}
	}
	
	if ( $tag != 'yes' )
		$err = $lang['friends.provide_email'];
	
	if ( $err == '' ) {
		$to 	= $_SESSION['EMAIL'];
		$name 	= $_SESSION['USERNAME'];
		$from	= $config['admin_email'];
		$subj   = 'Invitation';
		
		STemplate::assign('message', $message);
		STemplate::assign('freqkey', $_SESSION['UID']);
		
		for ( $i=0; $i<count($emails); $i++ ) {
			$sql  = "INSERT INTO relation SET FAID = '" .$uid. "', type = '" .$rtype[$i]. "', e_mail = '" .$emails[$i]. "'";
			$conn->execute($sql);
			$id = mysql_insert_id();
			
			STemplate::assign('id', $id);
			STemplate::assign('firstname', $fnames[$i]);
			
			$mailbody = STemplate::fetch('emails/invite_email.tpl');
			$mailbody = nl2br($mailbody);
			mailing($to, $name, $from, $subj, $mailbody);
		}
	}
}

$sql_count      = "SELECT count(*) AS total_friends FROM friends WHERE UID = '" .$uid. "'";
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_friends'];
$pagination     = new Pagination(ceil($config['items_per_page']/2));
$limit          = $pagination->getLimit($total);
$view_add       = " AND friends_type LIKE '%" .mysql_real_escape_string($view). "%'";
$sort_add       = ( $sort == 'name' ) ? " ORDER BY friends_name" : " ORDER BY id";
$sql            = "SELECT DISTINCT * FROM friends WHERE UID = '" .$uid. "'" .$view_add . $sort_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$friends        = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/userfriends/' .$sort. '/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();
$link           = '<br>' .$start_num. ' - ' .$end_num. ' of ' .$total. '</b>&nbsp;&nbsp;';

STemplate::assign('friends', $friends);
STemplate::assign('total', count($friends));

$sql = "SELECT DISTINCT * FROM friends WHERE UID = '" .$uid. "'";
$rs = $conn->execute($sql);

STemplate::assign('total_friends', count($rs->getrows()));

$sql = "SELECT friends_type FROM signup WHERE UID = '" .$uid. "'";
$rs = $conn->execute($sql);

$ftype = explode('|', $rs->fields['friends_type']);
sort($ftype);

$ftype_ops = "";
for($i=0; $i<count($ftype); $i++) {
        if ( $ftype[$i] != '' ) {
		$sel = ( $view == $ftype[$i] ) ? "selected" : "";
    		$ftype_ops .= "<option value='".$ftype[$i]."' $sel>".$ftype[$i]."</option>";
        }
}
STemplate::assign('ftype_ops',$ftype_ops);


$sql = "select friends_type from signup where UID=$uid";
$rs = $conn->execute($sql);
$type = explode("|", $rs->fields['friends_type']);
$type = array_splice($type, 1-count($type));

$action_ops = " <OPTION value='' selected>--- " .$lang['friends.select']. " ---</OPTION>
                <OPTION disabled>" .$lang['friends.action_add']. ":</OPTION>";

for($i=0; $i<count($type); $i++) {
        $action_ops .= "<option value='add_".($i+1)."'>&nbsp;&nbsp;&nbsp;&nbsp;$type[$i]</option>";
}
$action_ops .= "<OPTION disabled>" .$lang['friends.action_delete']. ":</OPTION>";

for($i=0; $i<count($type); $i++) {
        $action_ops .= "<option value='delete_".($i+1)."'>&nbsp;&nbsp;&nbsp;&nbsp;$type[$i]</option>";
}
$action_ops .= "<OPTION value='delete'>" .$lang['friends.delete_selected']. "</OPTION>";
                                    
STemplate::assign('action_ops', $action_ops);
STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('link', $link);
STemplate::assign('browse', $page_link);
STemplate::assign('page', $page);
STemplate::assign('head_bottom', 'friendlinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('search.tpl');
STemplate::display('friends.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
