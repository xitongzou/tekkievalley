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

$UID = NULL;
$username = NULL;
if ( isset($_REQUEST['username']) && $_REQUEST['username'] != '' ) {
	$username       = @mysql_real_escape_string(trim($_REQUEST['username']));
	$sql            = sprintf("SELECT UID FROM signup WHERE username = '%s' LIMIT 1;", $username);
	$us             = $conn->execute($sql);
	if ( mysql_affected_rows() == 1 )
		$UID = $us->fields['UID'];
}

if ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) && $_REQUEST['UID'] != '' ) {
	$UID    = @mysql_real_escape_string(trim($_REQUEST['UID']));
	$sql    = sprintf("SELECT UID FROM signup WHERE UID = '%d' LIMIT 1;", $UID);
	$us     = $conn->execute($sql);
	if ( mysql_affected_rows() != 1 )
		$UID = NULL;
}

//PAGING STARTS
$page = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;
$sql = "SELECT count(*) as total from friends WHERE UID='" .$UID. "' and friends_status='Confirmed' limit " .$config['total_per_ini'];
$ars = $conn->Execute($sql);
$total = ( $ars->fields['total']<=$config['total_per_ini'] ) ? $ars->fields['total'] : $config['total_per_ini'];
$tpage = ceil($total/$config['items_per_page']);
$spage = ( $tpage == 0 ) ? $tpage+1 : $tpage;
$startfrom = ($page-1)*$config['items_per_page'];

$sql="select * from friends WHERE UID='" .$UID. "' and friends_status='Confirmed' limit $startfrom, " .$config['items_per_page'];
$rs=$conn->execute($sql);
if($rs->recordcount()>0)
	$vdo = $rs->getrows();
$start_num=$startfrom+1;
$end_num=$startfrom+$rs->recordcount();

$page_link="";
for($k=1;$k<=$tpage;$k++)
	$page_link.="<a href='" .seo_url('users/' .$username. '/friends/'. $page, 'ufriends.php?UID=' .$UID. '&page=' .$page). "'>$k</a>&nbsp;&nbsp;";
//END PAGING

STemplate::assign('UID', $UID);
STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('page',$page);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total',$total);
STemplate::assign('friends',$vdo);
STemplate::assign('head_bottom',"blank.tpl");
STemplate::assign('head_bottom_add',"viewuserlinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('ufriends.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
