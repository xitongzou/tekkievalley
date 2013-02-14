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
require('language/' .$_SESSION['language']. '/upload_success.lang.php');

chk_member_login();

$viewkey = ( isset($_REQUEST['viewkey']) && strlen($_REQUEST['viewkey']) == 20 ) ? mysql_real_escape_string($_REQUEST['viewkey']) : NULL;
if ( !$viewkey )
	$err = $lang['upload_success.invalid_key'];
else {
	$sql = "SELECT UID FROM video WHERE vkey = '" .$viewkey. "' LIMIT 1";
	$rs  = $conn->execute($sql);
	if ( $_SESSION['UID'] != $rs->fields['UID'] ) {
		$err = $lang['upload_success.invalid_username'];
    }
}

$day        = NULL;
$month      = NULL;
$year       = NULL;
$country    = NULL;
if ( isset($_REQUEST['action_update']) && $_REQUEST['action_update'] != '' && $err == '' ) {
	$sql = "SELECT VID FROM video WHERE vkey = '" .$viewkey. "' LIMIT 1";
	$rs  = $conn->Execute($sql);
	if( $rs->recordcount() <=0 )
		$err = $lang['upload_success.invalid_key'];
	
	if( $err == '' ) {
		$month		= ( isset($_REQUEST['month']) && is_numeric($_REQUEST['month']) ) ? $_REQUEST['month'] : NULL;
		$year		= ( isset($_REQUEST['year']) && is_numeric($_REQUEST['year']) ) ? $_REQUEST['year'] : NULL;
		$day		= ( isset($_REQUEST['day']) && is_numeric($_REQUEST['day']) ) ? $_REQUEST['day'] : NULL;
		$location	= $filterObj->process(trim($_REQUEST['field_address']));
		$country	= $filterObj->process(trim($_REQUEST['country']));
		
    		if( !checkdate($month, $day, $year) )
    			$err = $lang['upload_success.invalid_date'];
    		elseif( $location == '' )
			$err = $lang['upload_success.location_empty'];
    		elseif( $country == 'Select Country' )
			$err = $lang['upload_success.country_empty'];
    		
		if ( $err == '' ) {
    			$sql = "UPDATE video SET record_date = '" .mysql_real_escape_string($year). "-" .mysql_real_escape_string($month). "-" .mysql_real_escape_string($day). "',
                                         location = '" .mysql_real_escape_string($location). "',
					                     country = '" .mysql_real_escape_string($country). "'
					    WHERE VID = '" .$rs->fields['VID']. "' AND UID = '" .mysql_real_escape_string($_SESSION['UID']). "' LIMIT 1";
    			$conn->execute($sql);
    			if ( $conn->Affected_Rows() == 1 ) {
				    $msg = $lang['upload_success.update_success'];
				    session_write_close();
				    header('Location: ' .$config['BASE_URL']. '/my_video.php?msg=' .$msg);
				    die();
			    } else
                    $err = 'Failed to update video!';
    		}
	}
}

$sql 	    = "SELECT VID, title, thumb, vkey, flvdoname, embed_code FROM video WHERE vkey = '" .$viewkey. "' LIMIT 1";
$rs  	    = $conn->execute($sql);
$vinfo      = $rs->getrows();
$vinfo      = $vinfo['0'];

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('head_bottom',"blank.tpl");
STemplate::assign('days', days($day));
STemplate::assign('months', months($month));
STemplate::assign('years', years($year));
STemplate::assign('country', country_box($country));
STemplate::assign('vinfo', $vinfo);
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('upload_success.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
