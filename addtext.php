<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

$adv = array('title' => '', 'desc' => '', 'url' => '', 'status' => 0);
if ( isset($_POST['adv_add']) ) {
    $title          = trim($_POST['adv_title']);
    $desc           = trim($_POST['adv_desc']);
    $url            = trim($_POST['adv_url']);
    $status         = intval(trim($_POST['adv_status']));
    
    if ( $title == '' ) {
        $err = 'Advertising title field cannot be blank!';
    } elseif ( strlen($title) > 99 ) {
        $err = 'Advertising title field can contain maximum 99 characters!';
    } else {
        $adv['title'] = $title;
    }
        
    if ( $desc != '' && strlen($desc) > 299 ) {
        $err = 'Advertising description field cannot contain more then 299 characters!';
    } else {
        $adv['desc'] = $desc;
    }
    
    if ( $url == '' ) {
        $err = 'Advertising url field cannot be blank!';
    } elseif ( !preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url) ) {
        $err = 'Advertising url field is not a valid url!';
    } else {
        $adv['url'] = $url;
    }
    
    $adv['status']   = ( $status === 0 ) ? 0 : 1;
    
    if ( $err == '' ) {
        $sql    = "INSERT INTO adv_text (title, descr, adv_url, addtime, status)
                   VALUES ('" .mysql_real_escape_string($adv['title']). "',
                           '" .mysql_real_escape_string($adv['desc']). "',
                           '" .mysql_real_escape_string($adv['url']). "',
                           " .time(). ",
                           " .$adv['status']. ")";
        $conn->execute($sql);
        $msg = 'Text Advertise was successfuly added!';
    }
}

STemplate::assign('adv', $adv);
?>
