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

include('include/config.php');
include('include/function.php');

chk_member_login();

$uid 	= mysql_real_escape_string($_SESSION['UID']);
$UID	= ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) ) ? $_REQUEST['UID'] : NULL;
$type	= ( isset($_REQUEST['type']) ) ? $_REQUEST['type'] : NULL;

//PAGING STARTS
$page	= ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
$sql 	= "select GID from group_mem where MID = '" .$uid. "'";
$rs 	= $conn->execute($sql);
$mid 	= "0";
while( !$rs->EOF ) {
        $mid .= ", ".$rs->fields['GID'];
        $rs->movenext();
}

if( $mid != '0')
        $query = ' or GID in (' .$mid. ')';

$sql 	= "SELECT count(*) as total from group_own WHERE OID = '" .$uid. "' $query";
$ars 	= $conn->Execute($sql);
$total 	= ( $ars->fields['total'] <= $config['total_per_ini'] ) ? $ars->fields['total'] : $config['total_per_ini'];
$tpage 	= ceil($total/$config['items_per_page']);
$spage	= ( $tpage == 0 ) ? $tpage+1 : $tpage;
$startfrom = ($page-1)*$config['items_per_page'];

$sql="SELECT distinct * from group_own WHERE OID=$uid $query limit $startfrom, " .$config['items_per_page'];
$rs=$conn->execute($sql);
if($rs->recordcount()>0)
	$vdo = $rs->getrows();
$start_num=$startfrom+1;
$end_num=$startfrom+$rs->recordcount();

$page_link='';
if ( $UID ) {
	for( $k=1;$k<=$tpage;$k++ )
		$page_link.="<a href='mygroup.php?UID=" .$UID. "&page=$k&type=$type'>$k</a>&nbsp;&nbsp;";
} else {
	for($k=1;$k<=$tpage;$k++)
		$page_link.="<a href='mygroup.php?UID=" .$uid. "&page=$k&type=$type'>$k</a>&nbsp;&nbsp;";
}
//END PAGING

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('page',$page);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total',$total);
STemplate::assign('answers',$vdo);
$kwords=group_tags($sql);
STemplate::assign('mytags',$kwords);
STemplate::assign('head_bottom',"grouplinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('mygroup.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>

