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
require('language/' .$_SESSION['language']. '/uprofile.lang.php');

$UID    = NULL;
$active = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
if ( isset($_REQUEST['username']) && $_REQUEST['username'] != '' ) {
	$username	    = trim($_REQUEST['username']);
	$sql            = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1;";
	$us             = $conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 )
		$UID = $us->fields['UID'];
}

if ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) && $_REQUEST['UID'] != '' ) {
	$UID 	= @mysql_real_escape_string(trim($_REQUEST['UID']));
	$sql	= "SELECT UID FROM signup WHERE UID = '" .$UID. "' LIMIT 1;";
	$us	= $conn->execute($sql);
	if ( $conn->Affected_Rows() != 1 )
		$UID = NULL;
}

if ( !$UID )
	$err = $lang['uprofile.exists'];

$r_uid = $UID;
$s_uid = @mysql_real_escape_string($_SESSION['UID']);

if ( isset($_REQUEST['subscribe']) ) {
    if ( !$s_uid ) {
        $err = $lang['uprofile.subscribe_login'];
    } elseif ( $s_uid == $r_uid ) {
        $err = $lang['uprofile.subscribe_self'];
    } else {
	    if ( $_REQUEST['subscribe'] == 'on' ) {
    	    if ( isset($_REQUEST['info']) && $_REQUEST['info'] == 'i' ) {
		        $sql = " INSERT into subscribe_video set subscribe_to ='" .$r_uid. "', subscribe_from ='" .$s_uid. "', status='on' ";
                $conn->execute( $sql );
    	    } else {
		        $sql = " UPDATE subscribe_video set status='on' where subscribe_to ='" .$r_uid. "' and subscribe_from ='" .$s_uid. "'";
                $conn->execute( $sql );
            }
            $msg = $lang['uprofile.subscribe_on'];
	    } else if ( $_REQUEST['subscribe'] == 'off') {
		    $sql = " UPDATE subscribe_video set status='off' where subscribe_to ='" .$r_uid. "'and subscribe_from ='" .$s_uid. "'";
    	    $conn->execute( $sql );
            $msg = $lang['uprofile.subscribe_off'];
	    }
    }
}

$sql    = "select * from signup WHERE UID='" .$r_uid. "' LIMIT 1;";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
        $user_exists    = true;  
        $sql            = "update signup set profile_viewed=profile_viewed+1 WHERE UID='" .$r_uid. "' limit 1";
        $conn->execute($sql);
        STemplate::assign('profileage', birthday($rs->fields['bdate']));
        $users          = $rs->getrows();
        $sql            = "select * from video WHERE UID='" .$r_uid. "' $active order by VID desc limit 1";
        $rs             = $conn->execute($sql);
        $vdo            = $rs->getrows();
}

function birthday ($birthday){
    list($year,$month,$day) = explode("-",$birthday);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0)
      $year_diff--;
    return $year_diff;
}

$chkuserflag    = '';
if( checklogin() ) {
        $chkuserflag = 'guest';
}

if ( $_SESSION['myUID'] == $r_uid ) {
        $chkuserflag = 'self';
	if ( !isset($user_exists) )
		$msg = $lang['uprofile.exists'];
}

STemplate::assign('UID',$UID);
STemplate::assign('chkuserflag',$chkuserflag);        
STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('answers',$users);
STemplate::assign('videos',$vdo);
STemplate::assign('head_bottom', 'blank.tpl');
STemplate::assign('head_bottom_add', 'viewuserlinks.tpl');
STemplate::display('head1.tpl');
echo "<br>";
STemplate::display('err_msg.tpl');
if ( isset($user_exists) )
	STemplate::display('uprofile.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
