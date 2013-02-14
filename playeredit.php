<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

$profile_id = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? intval($_GET['PID']) : NULL;
if ( !$profile_id ) {
    $err = 'Player profile id not valid or not set!';
}

if ( isset($_POST['submit_settings']) && $err == '' ) {
    $autorun            = $filterObj->process($_POST['autorun']);
    $buffertime         = intval($_POST['buffertime']);
    $buttons            = intval($_POST['buttons']);
    $replay             = intval($_POST['replay']);
    $related            = intval($_POST['related']);
    $related_content    = $filterObj->process($_POST['related_content']);
    $share              = intval($_POST['share']);
    $mail               = intval($_POST['mail']);
    $embed              = intval($_POST['embed']);
    $text_adv           = intval($_POST['text_adv']);
    $text_adv_type      = $filterObj->process($_POST['text_adv_type']);
    $text_adv_delay     = intval($_POST['text_adv_delay']);
    $video_adv          = intval($_POST['video_adv']);
    $video_adv_type     = $filterObj->process($_POST['video_adv_type']);
    $video_adv_position = $filterObj->process($_POST['video_adv_position']);
    $skin               = $filterObj->process($_POST['skin']);
    $mail_color         = $filterObj->process($_POST['mail_color']);
    $related_color      = $filterObj->process($_POST['related_color']);
    $replay_color       = $filterObj->process($_POST['replay_color']);
    $copy_color         = $filterObj->process($_POST['copy_color']);
    $embed_color        = $filterObj->process($_POST['embed_color']);
    $time_color         = $filterObj->process($_POST['time_color']);
    $share_color	= $filterObj->process($_POST['share_color']);
    $adv_nav_color      = $filterObj->process($_POST['adv_nav_color']);
    $adv_body_color     = $filterObj->process($_POST['adv_body_color']);
    $adv_title_color    = $filterObj->process($_POST['adv_title_color']);
    $adv_link_color     = $filterObj->process($_POST['adv_link_color']);

    if ( $buffertime == '0' ) {
        $err = 'Please enter a value greater then 0 for the player buffertime!';
    }
    
    if ( $text_adv_delay == '0' ) {
        $err = 'Please enter a value greater then 0 for the player text advertising delay!';
    }
    
    if ( $err == '' ) {
        $autorun    = ( $autorun == 'true' ) ? 'true' : 'false';
        $buttons    = ( $buttons == '0' ) ? 0 : 1;
        $replay     = ( $replay == '0' ) ? 0 : 1;
        $related    = ( $related == '0' ) ? 0 : 1;
        $share      = ( $share == '0' ) ? 0 : 1;
        $mail       = ( $mail == '0' ) ? 0 : 1;
        $embed      = ( $embed == '0' ) ? 0 : 1;
        $text_adv   = ( $text_adv == '0' ) ? 0 : 1;
        $video_adv  = ( $video_adv == '0' ) ? 0 : 1;
        
        $sql    = "UPDATE player_settings SET autorun = '" .$autorun. "', buttons = '" .$buttons. "', buffertime = '" .$buffertime. "',
                                              replay = '" .$replay. "', share = '" .$share. "', mail = '" .$mail. "', embed = '" .$embed. "',
                                              related = '" .$related. "', related_content = '" .mysql_real_escape_string($related_content). "', skin = '" .mysql_real_escape_string($skin). "',
                                              text_adv = '" .$text_adv. "', text_adv_type = '" .mysql_real_escape_string($text_adv_type). "', text_adv_delay = '" .$text_adv_delay. "',
                                              video_adv = '" .$video_adv. "', video_adv_type = '" .mysql_real_escape_string($video_adv_type). "', video_adv_position = '" .mysql_real_escape_string($video_adv_position). "',
                                              mail_color = '" .mysql_real_escape_string($mail_color). "', related_color = '" .mysql_real_escape_string($related_color). "', 
                                              replay_color = '" .mysql_real_escape_string($replay_color). "', embed_color = '" .mysql_real_escape_string($embed_color). "', 
                                              copy_color = '" .mysql_real_escape_string($copy_color). "', time_color = '" .mysql_real_escape_string($time_color). "',
					      share_color = '" .mysql_real_escape_string($share_color). "', adv_nav_color = '" .mysql_real_escape_string($adv_nav_color). "',
					      adv_title_color = '" .mysql_real_escape_string($adv_title_color). "', adv_body_color = '" .mysql_real_escape_string($adv_body_color). "',
					      adv_link_color = '" .mysql_real_escape_string($adv_link_color). "'
                   WHERE status = '1' LIMIT 1";
        $conn->execute($sql);
        $msg = 'Default video player profile updated!';
    }
}

$player = array();
$sql    = "SELECT * FROM player_settings WHERE id = " .$profile_id. " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == '1' ) {
    $player = $rs->getrows();
    $player = $player['0'];
} else {
    $err    = 'Failed to load default player profile!';
}

$skins  = get_player_skins();

STemplate::assign('skins', $skins);
STemplate::assign('player', $player);
?>
