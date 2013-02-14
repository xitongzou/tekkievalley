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

$urlkey	= ( isset($_REQUEST['urlkey']) ) ? $_REQUEST['urlkey'] : NULL;
$uid	= ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) ) ? $_REQUEST['UID'] : NULL;

$sql="SELECT * from group_own WHERE gurl='" .$urlkey. "' limit 1";
$rs = $conn->Execute($sql);
if($rs->recordcount()>0) {
	STemplate::assign('groupname',$rs->fields[gname]);
	//PAGING STARTS
	$page 		= ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : NULL;
	$sql 		= "SELECT count(*) as total from group_mem WHERE GID='" .$rs->fields['GID']. "' limit 1";
	$ars 		= $conn->Execute($sql);
	$total		= ( $ars->fields['total']<=$config['total_per_ini'] ) ? $ars->fields['total'] : $config['total_per_ini'];
	$tpage 		= ceil($total/$config['items_per_page']);
	$spage		= ( $tpage == 0 ) ? $tpage+1 : $tpage;
	$startfrom 	= ($page-1)*$config['items_per_page'];
	$sql		= "SELECT m.*,s.addtime from group_mem as m,signup as s WHERE m.MID=s.UID and m.GID='".$rs->fields['GID']."' limit $startfrom, " .$config['items_per_page'];
	$rs		= $conn->execute($sql);
	if($rs->recordcount()>0)
		$vdo = $rs->getrows();
	$start_num	= $startfrom+1;
	$end_num	= $startfrom+$rs->recordcount();
	$page_link	= '';
	$type		= ( isset($_REQUEST['type']) && $_REQUEST['type'] != '' ) ? "&type=" .$_REQUEST['type'] : NULL;
	for ( $k=1;$k<=$tpage;$k++ )
		$page_link.="<a href='group_members.php?UID=" .$uid. "&page=" .$k. $type. "'>$k</a>&nbsp;&nbsp;";
	//END PAGING
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('page',$page);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total',$total);
STemplate::assign('answers',$vdo);
STemplate::assign('head_bottom',"grouplinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('ugroup_members.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
