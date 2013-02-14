<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

$adv = array();
$AID = ( isset($_GET['AID']) ) ? intval($_GET['AID']) : NULL;
$sql = "SELECT * FROM adv_text WHERE adv_id = " .$AID. " LIMIT 1";
$rs  = $conn->execute($sql);
if ( !$conn->Affected_Rows() === 1 ) {
    $err = 'Invalid text advertise id! Are you sure this advertise exists?!';
} else {
    $adv = $rs->getrows();
    $adv = $adv['0'];
}

if ( isset($_POST['adv_edit']) && !$err ) {
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
        $adv['descr'] = $desc;
    }
    
    if ( $url == '' ) {
        $err = 'Advertising url field cannot be blank!';
    } elseif ( !preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url) ) {
        $err = 'Advertising url field is not a valid url!';
    } else {
        $adv['adv_url'] = $url;
    }
    
    $adv['status']   = ( $status === 0 ) ? 0 : 1;
    
    if ( $err == '' ) {
        $sql = "UPDATE adv_text
                SET title = '" .mysql_real_escape_string($adv['title']). "',
                    descr = '" .mysql_real_escape_string($adv['descr']). "',
                    adv_url = '" .mysql_real_escape_string($adv['adv_url']). "',
                    status = '" .$adv['status']. "'
                WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $msg = 'Text Advertise was successfuly updated!';
    }
}

STemplate::assign('adv', $adv);
?>
