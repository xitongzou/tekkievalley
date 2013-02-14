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
require('language/' .$_SESSION['language']. '/upload.lang.php');

if ( $config['upload_by_file'] == '0' && $config['upload_by_embed'] == '0' ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=upload_disabled');
    die();
}

chk_member_login();
isMailVerified();

if( $config['enable_package'] == 'yes') {
	check_subscriber(100);
}

$upload_method 	= ( $config['upload_by_file'] == '1' ) ? 'File' : 'Embed';
$upload_page	= 'upload';

$uid 		= mysql_real_escape_string($_SESSION['UID']);

// Uber Uploader ...
require $config['BASE_DIR']. '/ubr_ini.php';
require $config['BASE_DIR']. '/ubr_lib.php';
require $config['BASE_DIR']. '/ubr_finished_lib.php';

header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

require $config['BASE_DIR']. '/' .$DEFAULT_CONFIG;

STemplate::assign('UBR_path_to_link_script', $PATH_TO_LINK_SCRIPT);
STemplate::assign('UBR_path_to_js_script', $PATH_TO_JS_SCRIPT);
STemplate::assign('UBR_path_to_set_progress_script', $PATH_TO_SET_PROGRESS_SCRIPT);
STemplate::assign('UBR_path_to_get_progress_script', $PATH_TO_GET_PROGRESS_SCRIPT);
STemplate::assign('UBR_path_to_upload_script', $PATH_TO_UPLOAD_SCRIPT);
STemplate::assign('UBR_multi_configs_enabled', $MULTI_CONFIGS_ENABLED);
STemplate::assign('UBR_config_file', $DEFAULT_CONFIG);
STemplate::assign('UBR_check_allow_extensions_on_client', $_CONFIG['check_allow_extensions_on_client']);
STemplate::assign('UBR_check_disallow_extensions_on_client', $_CONFIG['check_disallow_extensions_on_client']);
STemplate::assign('UBR_allow_extensions', $_CONFIG['allow_extensions']);
STemplate::assign('UBR_disallow_extensions', $_CONFIG['disallow_extensions']);
STemplate::assign('UBR_check_file_name_format', $_CONFIG['check_file_name_format']);
STemplate::assign('UBR_check_null_file_count', $_CONFIG['check_null_file_count']);
STemplate::assign('UBR_check_duplicate_file_count', $_CONFIG['check_duplicate_file_count']);
STemplate::assign('UBR_max_upload_slots', $_CONFIG['max_upload_slots']);
STemplate::assign('UBR_cedric_progress_bar', $_CONFIG['cedric_progress_bar']);
STemplate::assign('UBR_cedric_hold_to_sync', $_CONFIG['cedric_hold_to_sync']);
STemplate::assign('UBR_progress_bar_width', $_CONFIG['progress_bar_width']);
STemplate::assign('UBR_show_percent_complete', $_CONFIG['show_percent_complete']);
STemplate::assign('UBR_show_files_uploaded', $_CONFIG['show_files_uploaded']);
STemplate::assign('UBR_show_current_position', $_CONFIG['show_current_position']);
STemplate::assign('UBR_show_elapsed_time', $_CONFIG['show_elapsed_time']);
STemplate::assign('UBR_show_est_time_left', $_CONFIG['show_est_time_left']);
STemplate::assign('UBR_show_est_speed', $_CONFIG['show_est_speed']);
STemplate::assign('UBR_embedded_upload_results', $_CONFIG['embedded_upload_results']);
STemplate::assign('UBR_opera_browser', $_CONFIG['opera_browser']);
STemplate::assign('UBR_safari_browser', $_CONFIG['safari_browser']);

$upl = array('title' => '', 'desc' => '', 'tags' => '');
if ( isset($_REQUEST['action_upload']) && $_REQUEST['action_upload'] != '' ) {
	$title 	= $filterObj->process(trim($_REQUEST['field_myvideo_title']));
	$desc	= $filterObj->process(trim($_REQUEST['field_myvideo_descr']));
	$tags	= $filterObj->process(trim($_REQUEST['field_myvideo_keywords']));
	if (@preg_match('/^.$/u', 'ñ')) {
  		$tags   = strip_symbols($tags);
  		$tags   = strip_punctuation($tags);
	}
    $tags   = str_replace('$', '', $tags);
    $tags   = str_replace('+', '', $tags);
    $tags   = str_replace('/', '', $tags);
    $tags   = str_replace('=', '', $tags);
    $tags   = str_replace('[', '', $tags);
    $tags   = str_replace(']', '', $tags);
    $tags   = str_replace('&', '', $tags);
    $tags   = str_replace('~', '', $tags);
    $tags   = str_replace('/', '', $tags);
    $tags   = str_replace(',', ' ', $tags);
    
	$chlist	= ( isset($_REQUEST['chlist']) ) ? $_REQUEST['chlist'] : array();
	
	if ( strlen($title) < 3 ) {
		$err = $lang['upload.title_length'];
    } else {
        $upl['title'] = $title;
    }
        
	if ( strlen($desc) < 3 )  {
		$err = $lang['upload.desc_length'];
    } else {
        $upl['desc'] = $desc;
    }
    
	if ( strlen($tags) < 3 ) {
		$err = $lang['upload.tags_empty'];
    } else {
        $upl['tags'] = $tags;
    }
    
	if ( count($chlist)<1 || count($chlist)>3 )	{
    	$err = $lang['upload.chlist_empty'];
    }
        
    if ( $err == '' ) {
		$page = 'second';
		STemplate::assign('secondpage', $page);
		$listch=implode('|', $chlist);
		STemplate::assign('listch', $listch);
		$var = "<script language=javascript>
		var field_myvideo_title = " .$title. ";
		var field_myvideo_descr = " .$desc. ";
		var field_myvideo_keywords = " .$tags. ";
		var listch = " .$listch. ";
		</script>";
		STemplate::assign("var", $var);
    }
    
    STemplate::assign('chlist', $chlist);
}

if(isset($_GET['upload_id']) && preg_match('/^[a-zA-Z0-9]{32}$/', $_GET['upload_id']) && $config['upload_by_file'] == '1' )
{
	$upload_method = 'Upload';
	STemplate::assign('upload_page', 'upload');
        
	$UPLOAD_ID = trim($_GET['upload_id']);
	
	$_XML_DATA = array();
	$_CONFIG_DATA = array();
	$_POST_DATA = array();
	$_FILE_DATA = array();
	$_FILE_DATA_TABLE = '';
	$_FILE_DATA_EMAIL = '';
	
	$xml_parser = new XML_Parser;
	$xml_parser->setXMLFile($TEMP_DIR, $_REQUEST['upload_id']);
	$xml_parser->setXMLFileDelete($DELETE_REDIRECT_FILE);
	$xml_parser->parseFeed();
	
	// WE HAVE A ERROR! NOT GOOD 
	if ( $xml_parser->getError() )
		$err = 'Application Error While Retrieving Upload File Data! Aborting!';
		
	if ( $err == '' ) {
		$_XML_DATA 		= $xml_parser->getXMLData();
		$_CONFIG_DATA 		= getConfigData($_XML_DATA);
		$_POST_DATA  		= getPostData($_XML_DATA);
		$_FILE_DATA 		= getFileData($_XML_DATA);
	
		$upload_dir 		= $_CONFIG_DATA['upload_dir'];
		$upload_file		= $_FILE_DATA['0']->name;
		$upload_file_path	= $upload_dir . $upload_file;
		
		if ( !is_file($upload_file_path) || filesize($upload_file_path) < 10 ) {
			$err = $lang['upload_failed'];
		}
		
		$upload_file_size = filesize($upload_file_path);
		if ( $err == '' ) {
			$position  	= strrpos($upload_file, '.');
			$extension 	= strtolower(substr($upload_file, $position+1, strlen($upload_file)-$position));
			$space		= round($upload_file_size/(1024*1024));
			if ( $config['enable_package'] == 'yes' )
				check_subscriber($space);
			
			
			$allowed_extensions = explode(',', $config['video_allowed_extensions']);
			if ( !in_array($extension, $allowed_extensions) )
				$err = $lang['upload.invalid_format'];
			if ( $space > $config['video_max_size'] )
				$err = $lang['upload.invalid_size'];
			
			if ( $err == '' ) {
				$active 	= ( $config['approve'] == 1 ) ? "active='0'" : "active='1'";
				$v_title 	= $filterObj->process($_POST_DATA['field_myvideo_title']);
				$v_descr 	= $filterObj->process($_POST_DATA['field_myvideo_descr']);
				$v_descr 	= str_replace('\r', '', $v_descr);
				$v_descr 	= preg_replace('/\n\n+/', '/n', $v_descr);
				$v_descr 	= str_replace('\n', '<br>', $v_descr);
				
				$sql = "INSERT INTO video SET UID = '" .$uid. "', title = '" .mysql_real_escape_string($v_title). "', 
						description = '" .mysql_real_escape_string($v_descr). "', keyword = '" .mysql_real_escape_string($_POST_DATA['field_myvideo_keywords']). "', 
						channel = '0|" .mysql_real_escape_string($_POST_DATA['listch']). "|0', 
						space = '" .mysql_real_escape_string($space). "', addtime = '" .time(). "', 
						adddate = '" .date('Y-m-d'). "', vkey = '" .mt_rand(). "',
						type = '" .mysql_real_escape_string($_POST_DATA['field_privacy']). "', " .$active. ", 
						filehome = '" .mysql_real_escape_string($_POST_DATA['p']). "'";
				$conn->execute($sql);
    			$vid		= mysql_insert_id();
    			$vdoname	= $vid. '.' .$extension;
				$ff 		= $config['VDO_DIR']. '/' .$vdoname;
				
                if ( rename($upload_file_path, $ff) ) {
                    $cgi = ( strpos(php_sapi_name(), 'cgi') ) ? 'env -i ' : NULL;
                    $cmd = $cgi . $config['phppath']. ' ' .$config['BASE_DIR']. '/convert.php ' .$vdoname. ' ' .$vid. ' ' .$ff;
                    exec($cmd. '>/dev/null &');
                    video_to_frame2($ff, $vid);
                    exec($config['mplayer']. ' -vo null -ao null -frames 0 -identify "' .$config['VDO_DIR']. '/' .$vdoname. '"', $p);
                    while ( list($k,$v) = each($p) ) {
                        if ( $length = strstr($v, 'ID_LENGTH=') )
                            break;
                    }
    				$lx = explode('=', $length);
    				$duration = $lx['1'];                
                } else {
                    $err = $lang['upload.failed_rename'];
                }
				
				if ( $err == '' ) {
					$key = substr(md5($vid),11,20);
                    send_subscribed_mail($_SESSION['UID'], $_SESSION['USERNAME'], $_SESSION['EMAIL'], $vid, $v_title, $key);
    				
                    $sql="UPDATE video SET vdoname = '" .mysql_real_escape_string($vdoname). "',
                                           flvdoname = '" .mysql_real_escape_string($vid). ".flv',
                                           duration = '" .mysql_real_escape_string($duration). "',
                                           vkey = '" .mysql_real_escape_string($key). "'
                          WHERE VID = '" .mysql_real_escape_string($vid). "' limit 1";
    				$conn->execute($sql);
      
    				if( $config['enable_package'] == 'yes' ) {
    				    $sql = "update subscriber set used_space=used_space+$space, used_bw=used_bw+$space, total_video=total_video+1 where UID = '" .$uid. "'";
        				$conn->execute($sql);
    				}
    		
					$url = seo_url('uploadsuccess/' .$key, 'upload_success.php?viewkey=' .$key. '&upload=yes');
					session_write_close();
    				header('Location: ' .$url);
					die();
				}
			}
		}
	}
}

if ( isset($_POST['submit_embed']) && $config['upload_by_embed'] == '1' ) {
	STemplate::assign('secondpage', 'second');
	$upload_method		= 'Embed';
	$upload_page		= 'upload';
	$embed_code		    = trim($_POST['embed_code']);
    $embed_code         = str_replace('<script', '', $embed_code);
	$duration_seconds	= trim($_POST['duration_seconds']);
	$duration_minutes	= trim($_POST['duration_minutes']);	
	$field_privacy		= $_POST['field_privacy'];
	$field_keywords		= $filterObj->process(trim($_POST['field_myvideo_keywords']));
    if (@preg_match('/^.$/u', 'ñ')) {
		$field_keywords     = strip_symbols($field_keywords);
  		$field_keywords     = strip_punctuation($field_keywords);
	}
    $field_keywords     = str_replace('$', '', $field_keywords);
    $field_keywords     = str_replace('+', '', $field_keywords);
    $field_keywords     = str_replace('/', '', $field_keywords);
    $field_keywords     = str_replace('=', '', $field_keywords);
    $field_keywords     = str_replace('[', '', $field_keywords);
    $field_keywords     = str_replace(']', '', $field_keywords);
    $field_keywords     = str_replace('&', '', $field_keywords);
    $field_keywords     = str_replace('~', '', $field_keywords);
    $field_keywords     = str_replace('/', '', $field_keywords);
    $field_keywords     = str_replace(',', ' ', $field_keywords);
	$field_title		= $filterObj->process(trim($_POST['field_myvideo_title']));
	$field_desc		    = $filterObj->process(trim($_POST['field_myvideo_descr']));
	$field_desc 		= str_replace('\r', '', $field_desc);
	$field_desc 		= preg_replace('/\n\n+/', '/n', $field_desc);
	$field_desc 		= str_replace('\n', '<br>', $field_desc);
	$field_channels		= trim($_POST['listch']);
	
	if ( $embed_code == '' )
		$err = $lang['upload.embed_empty'];
	elseif ( strstr($embed_code, '<script') )
		$err = $lang['upload.embed_invalid'];
	elseif ( $duration_seconds == '' )
		$err = $lang['upload.duration_seconds_empty'];
	elseif ( !is_numeric($duration_seconds) )
		$err = $lang['upload.duration_seconds_invalid'];
	elseif ( $duration_minutes == '' )
		$err = $lang['upload.duration_minutes_empty'];
	elseif ( !is_numeric($duration_minutes) )
		$err = $lang['upload.duration_minutes_invalid'];
	elseif ( $_FILES['thumb']['tmp_name'] == '' && is_uploaded_file($_FILES['thumb']['tmp_name']) )
		$err = $lang['upload.thumb_empty'];
	else {
		$space	= round($_FILES['thumb']['size']/(1024*1024));
		if ( $config['enable_package'] == 'yes' ) {
			check_subscriber($space);
		}
	}
    
    if ( $err == '' ) {
        $imagesize = getimagesize($_FILES['thumb']['tmp_name']);
        if ( $imagesize['2'] != 2 )
            $err = $lang['upload.thumb_invalid'];
    }

    if ( !stristr($embed_code, '<embed') && !stristr($embed_code, '<object') ) {
        $embed_code     = NULL;
        $err            = $lang['upload.embed_empty'];
    }
    if ( stristr($embed_code, '<a') || stristr($embed_code, '<img') || stristr($embed_code, '<iframe') ) {
        $embed_code     = NULL;
        $err            = $lang['upload.embed_empty'];
    }
	
	if ( $err == '' ) {
		$active = "active='0'";
		$sql = "INSERT INTO video SET UID = '" .$uid. "', 
			title = '" .mysql_real_escape_string($field_title). "', 
			description = '" .mysql_real_escape_string($field_desc). "', 
			keyword = '" .mysql_real_escape_string($field_keywords). "', 
			channel = '0|" .mysql_real_escape_string($field_channels). "|0', 
			space = '0',
			addtime = '" .time(). "', 
			adddate = '" .date('Y-m-d'). "', 
			vkey = '" .mt_rand(). "', 
			type = '" .mysql_real_escape_string($field_privacy). "', " .$active. ", 
			filehome = '',
			embed_code = '" .mysql_real_escape_string($embed_code). "'";

		$conn->execute($sql);
    	$vid	= mysql_insert_id();		
		$thumb	= $_FILES['thumb']['name'];
		$space	= $_FILES['thumb']['size'];
		move_uploaded_file($_FILES['thumb']['tmp_name'], $config['TMP_DIR']. '/thumbs/' .$thumb);
		@chmod($config['TMP_DIR']. '/' .$thumb, 0644);
		$ff	= $config['TMP_DIR']. '/thumbs/' .$thumb;
		$fd	= $config['TMB_DIR']. '/' .$vid. '.jpg';
		createThumb($ff, $fd, $config['img_max_width'], $config['img_max_height']);
		copy($fd, $config['TMB_DIR']. '/1_' .$vid. '.jpg');
		copy($fd, $config['TMB_DIR']. '/2_' .$vid. '.jpg');
		copy($fd, $config['TMB_DIR']. '/3_' .$vid. '.jpg');
		@unlink($config['TMP_DIR']. '/thumbs/' .$thumb);
		
		$key 		= substr(md5($vid),11,20);
		$duration	= $duration_minutes*60;
		$duration	= $duration+$duration_seconds;
		$sql 		= "UPDATE video SET duration = '" .mysql_real_escape_string($duration). "',
                                        vkey = '" .mysql_real_escape_string($key). "'
                       WHERE VID = '" .mysql_real_escape_string($vid). "' LIMIT 1";
		$conn->execute($sql);
		
        send_subscribed_mail($_SESSION['UID'], $_SESSION['USERNAME'], $_SESSION['EMAIL'], $vid, $field_title, $key);
		
		if ( $config['enable_package'] == 'yes' ) {
			$sql = "UPDATE subscriber SET used_space=used_space+$space, used_bw=used_bw+$space, total_video=total_video+1 where UID='" .$uid. "' LIMIT 1";
			$conn->execute($sql);
		}
		
		$url = seo_url('uploadsuccess/' .$key, 'upload_success.php?viewkey=' .$key. '&upload=yes');
		session_write_close();
    	header('Location: ' .$url);
		die();
	}
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('upl', $upl);
STemplate::assign('upload_method', $upload_method);
STemplate::assign('upload_page', $upload_page);
STemplate::assign('menu_active', 'upload'); 
STemplate::assign('head_bottom', 'blank.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('upload.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
