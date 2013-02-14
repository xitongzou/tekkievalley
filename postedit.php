<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$post  = array();
$PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) && postExists($_GET['PID']) ) ? $_GET['PID'] : NULL;
if ( $PID ) {
    if ( isset($_POST['edit_post']) ) {
        $message = $filterObj->process(trim($_POST['message']));
        
        if ( $message == '' )
            $err = 'Topic message field cannot be blank!';
        
        if ( $err == '' ) {
            $sql = "UPDATE group_tps_post SET post = '" .mysql_real_escape_string($message). "'
                    WHERE PID = '" .mysql_real_escape_string($PID). "' LIMIT 1";
            $conn->execute($sql);
            $msg = 'Topic message updated successfuly!';
        }
    }

    $sql    = "SELECT * FROM group_tps_post WHERE PID = '" .mysql_real_escape_string($PID). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    $post  = $rs->getrows();
} else
    $err = 'Topic message does not exist!';

STemplate::assign('post', $post);
?>
