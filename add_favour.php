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

chk_member_login();

$active = ( $config['approve'] == 1 ) ? " AND v.active = '1'" : NULL;
$gid    = ( isset($_REQUEST['gid']) && is_numeric($_REQUEST['gid']) ) ? mysql_real_escape_string($_REQUEST['gid']) : NULL;
$vid    = ( isset($_REQUEST['VID']) && is_numeric($_REQUEST['vid']) ) ? mysql_real_escape_string($_REQUEST['VID']) : NULL;
$uid    = mysql_real_escape_string($_SESSION['UID']);
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

$sql    = "SELECT * FROM group_own WHERE GID = '" .$gid. "' LIMIT 1";
$rs     = $conn->execute($sql);
if ( !$conn->Affected_Rows() ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=group_missing');
    die();
}

$gname      = $rs->fields['gname'];
$gupload    = $rs->fields['gupload'];
STemplate::assign('gname', $gname);
STemplate::assign('gupload', $gupload);

$sql        = "SELECT username FROM signup WHERE UID = '" .$uid. "' LIMIT 1";
$rs         = $conn->execute($sql);
$username   = $rs->fields['username'];

if( isset($_REQUEST['add_video']) && $_REQUEST['add_video'] ) {
        $sql = "select * from group_mem where GID = '" .$gid. "'";
        $rs = $conn->execute($sql);
        if($rs->recordcount()>0) {
		    $approved = ( $gupload == 'owner_approve' ) ? 'no' : 'yes';
            $sql = "insert group_vdo set GID = '" .$gid. "', VID = '" .$vid. "', MID = '" .$uid. "', approved='" .$approved. "'";
            $conn->execute($sql);
		    $msg = ( $gupload == 'owner_approve' ) ? 'The video will be appear after owner approval' : 'The video is added to the group';
        }
}

$sql_count          = "SELECT count(*) AS total_videos FROM video AS v, favourite AS f WHERE f.UID = '" .$uid. "' AND f.VID = v.VID" .$active;
$ars                = $conn->execute($sql_count);
$total              = $ars->fields['total_videos'];
$pagination         = new Pagination(ceil($config['items_per_page']/2));
$limit              = $pagination->getLimit($total);
$sql                = "SELECT * FROM video AS v, favourite AS f WHERE f.UID = '" .$uid. "' AND f.VID = v.VID" .$active. " LIMIT " .$limit;
$rs                 = $conn->execute($sql);
$videos             = $rs->getrows();
$pagination_url     = $config['BASE_URL']. '/group/add/favorite/';

$sql   = "SELECT count(*) as total from video as v, favourite as f WHERE f.UID=$uid and f.VID=v.VID $active limit " .$config['total_per_ini'];
$ars   = $conn->Execute($sql);
$total = ( $ars->fields['total'] <= $config['total_per_ini'] ) ? $ars->fields['total'] : $config['total_per_ini'];
$tpage = ceil($total/$config['items_per_page']);
$spage = ( $tpage == 0 ) ? $tpage+1 : $tpage;
$startfrom = ($page-1)*$config['items_per_page'];

$sql="select * from video as v, favourite as f WHERE f.UID=$uid and f.VID=v.VID $active limit $startfrom, " .$config['items_per_page'];
$rs=$conn->execute($sql);
if($rs->recordcount()>0)
	$vdo = $rs->getrows();
$start_num=$startfrom+1;
$end_num=$startfrom+$rs->recordcount();
$page_link="";
for($k=1;$k<=$tpage;$k++)
	$page_link.="<a href='ufavour.php?UID=$_SESSION[UID]&page=$k&type=$_REQUEST[type]'>$k</a>&nbsp;&nbsp;";
//END PAGING

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $videos);
STemplate::assign('head_bottom', 'homelinks.tpl');
if ( isset($_SESSION['UID']) ) {
	STemplate::assign('head_bottom_add', 'addvideolink.tpl');
}
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('add_favour.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
