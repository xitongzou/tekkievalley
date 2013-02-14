<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

$AID = ( isset($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
$sql = "SELECT * FROM adv_media WHERE adv_id = " .$AID. " LIMIT 1";
$rs  = $conn->execute($sql);
if ( !$conn->Affected_Rows() === 1 ) {
    $err = 'Invalid media advertise id! Are you sure this advertise exists?!';
} else {
    $adv = $rs->getrows();
    $adv = $adv['0'];
}

if ( isset($_POST['adv_edit']) && !$err ) {
    $title          = trim($_POST['adv_title']);
    $desc           = trim($_POST['adv_desc']);
    $url            = trim($_POST['adv_url']);
    $duration       = intval(trim($_POST['adv_duration']));
    $status         = intval(trim($_POST['adv_status']));
    
    if ( $title == '' ) {
        $err = 'Advertising title field cannot be blank!';
    } elseif ( strlen($title) > 99 ) {
        $err = 'Advertising title field can contain maximum 99 characters!';
    } else {
        $adv['title'] = $title;
    }
        
    if ( $desc != '' && strlen($desc) > 199 ) {
        $err = 'Advertising description field cannot contain more then 199 characters!';
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
    
    $adv['duration'] = $duration;
    $adv['status']   = ( $status === 0 ) ? 0 : 1;
    
    if ( $_FILES['adv_media']['tmp_name'] != '' ) {
        if ( !is_uploaded_file($_FILES['adv_media']['tmp_name']) ) {
            $err = 'Advertising media file is not a valid uploaded file!';
        } else {
            $filename = substr($_FILES['adv_media']['name'], strrpos($_FILES['adv_media']['name'], DIRECTORY_SEPARATOR)+1);
            $ext     = strtolower(substr($filename, strrpos($filename, '.')+1));
            if ( !in_array($ext, array('jpg', 'jpeg', 'swf', 'flv')) ) {
                $err = 'Advertising media file is not a valid supported file format (allowed formats: jpg, swf and flv)!';
            } else {
                if ( $ext == 'jpeg' ) {
                    $ext = 'jpg';
                }
            }
        }
    }
    
    if ( $err == '' ) {
        $sql = "UPDATE adv_media
                SET title = '" .mysql_real_escape_string($adv['title']). "',
                    descr = '" .mysql_real_escape_string($adv['descr']). "',
                    adv_url = '" .mysql_real_escape_string($adv['adv_url']). "',
                    duration = " .$adv['duration']. ",
                    media = '" .mysql_real_escape_string($ext). "',
                    status = '" .$adv['status']. "'
                WHERE adv_id = " .$AID. " LIMIT 1";    
        $conn->execute($sql);
        @unlink($config['BASE_DIR']. '/player/adv/' .$AID. '.' .$adv['media']);
        if ( !move_uploaded_file($_FILES['adv_media']['tmp_name'], $config['BASE_DIR']. '/player/adv/' .$AID. '.' .$ext) ) {
            $err = 'Failed to move uploaded file!';            
        } else {
            $msg = 'Advertising media was successully updated!';
        }
        
    }
}

STemplate::assign('adv', $adv);
?>
