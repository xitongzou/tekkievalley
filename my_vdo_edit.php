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
require('include/strip_symbols.php');
require('include/strip_punctuation.php');
require('language/' .$_SESSION['language']. '/my_video_edit.lang.php');

chk_member_login();

$active = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$vid	= ( isset($_REQUEST['VID']) && is_numeric($_REQUEST['VID']) ) ? mysql_real_escape_string($_REQUEST['VID']) : NULL;
$uid 	= mysql_real_escape_string($_SESSION['UID']);

$sql    = "SELECT UID FROM video WHERE VID = '" .$vid. "' LIMIT 1";
$rs     = $conn->execute($sql);
if ( $uid != $rs->fields['UID'] )
	$err = $lang['my_video_edit.invalid_username'];

if ( isset($_REQUEST['update_video']) && $_REQUEST['update_video'] != '' && $err == '' ) {
	$year		    = trim($_POST['year']);
	$month		    = trim($_POST['month']);
	$day		    = trim($_POST['day']);
    $recorddate	    = $year. '-' .$month. '-' .$day;
	$vtitle		    = $filterObj->process(trim($_POST['vtitle']));
	$vdesc		    = $filterObj->process(trim($_POST['vdescription']));
	$vdesc		    = str_replace('\r', '', $vdesc);
	$vdesc		    = preg_replace('/\n\n+/', '/n', $vdesc);
	$vdesc		    = str_replace('\n', '<br>', $vdesc);
	$vtags		    = $filterObj->process(trim($_POST['vkeyword']));
	if (@preg_match('/^.$/u', 'ñ')) {
  	  $vtags          = strip_symbols($vtags);
  	  $vtags          = strip_punctuation($vtags);
	}
    $vtags          = str_replace('$', '', $vtags);
    $vtags          = str_replace('+', '', $vtags);
    $vtags          = str_replace('/', '', $vtags);
    $vtags          = str_replace('=', '', $vtags);
    $vtags          = str_replace('[', '', $vtags);
    $vtags          = str_replace(']', '', $vtags);
    $vtags          = str_replace('&', '', $vtags);
    $vtags          = str_replace('~', '', $vtags);
    $vtags          = str_replace('/', '', $vtags);
	$vfeaturedesc	= ( isset($_POST['featuredesc']) ) ? $filterObj->process(trim($_POST['featuredesc'])) : NULL;
	$vlocation	    = $filterObj->process(trim($_POST['field_address']));
	$vchannels	    = $_POST['chlist'];
	
	if ( strlen($vtitle) < 3 )
		$err = $lang['my_video_edit.title_length'];
  	elseif ( strlen($vdesc) < 3 ) 
		$err = $lang['my_video_edit.desc_length'];
	elseif ( strlen($vtags) < 3 )
		$err = $lang['my_video_edit.tags_empty'];
  	elseif ( count($vchannels)<1 || count($vchannels)>3) 
		$err = $lang['my_video_edit.select_channel'];
	
    $listch = implode('|', $vchannels);
    
	if ( $err == '' ) {
		$add = '';
		if ( $recorddate != 'yyyy-mm-dd' )
			$add .= "record_date = '" .mysql_real_escape_string($recorddate). "',";
		if ( $_REQUEST['country'] != 'Select Country' )
			$add .= "country = '" .mysql_real_escape_string($_REQUEST['country']). "',";
    		
		$vtitle 	    = mysql_real_escape_string($vtitle);
		$vdesc  	    = mysql_real_escape_string($vdesc);
		$tags   	    = mysql_real_escape_string($vtags);
		$vfeaturedesc	= mysql_real_escape_string($vfeaturedesc);
		$vlocation	    = mysql_real_escape_string($vlocation);
		
		$sql = "UPDATE video SET title='" .$vtitle. "', description='" .$vdesc. "', featuredesc='" .$vfeaturedesc. "',
                keyword='" .$tags. "', channel='0|" .mysql_real_escape_string($listch). "|0', type='" .mysql_real_escape_string($_REQUEST['video_privacy']). "',
                location='" .$vlocation. "', $add be_comment='" .mysql_real_escape_string($_REQUEST['allow_comments']). "',
                be_rated='" .mysql_real_escape_string($_REQUEST['allow_ratings']). "', embed='" .mysql_real_escape_string($_REQUEST['allow_embed']). "',
		        thumb='" .mysql_real_escape_string($_REQUEST['thumb']). "'
                WHERE VID='" .$vid. "' AND UID='" .$uid. "' LIMIT 1";
    	$conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
			$msg = $lang['my_video_edit.success'];
        }
    }
}

$sql		= "SELECT * FROM video WHERE VID = '" .$vid. "' AND UID = '" .$uid. "'" .$active. " LIMIT 1";
$rs		    = $conn->execute($sql);
$date		= explode('-',$rs->fields['record_date']);
$chid		= explode('|',$rs->fields['channel']);
$answers 	= $rs->getarray();

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('chid',$chid);
STemplate::assign('days',days($date['2']));
STemplate::assign('months',months($date['1']));
STemplate::assign('years',years($date['0']));
STemplate::assign('country',country_box($answers['0']['country']));
STemplate::assign('answers',$answers);
STemplate::assign('head_bottom',"homelinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('my_vdo_edit.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
