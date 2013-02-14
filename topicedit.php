<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$topic  = array();
$TID    = ( isset($_GET['TID']) && is_numeric($_GET['TID']) && topicExists($_GET['TID']) ) ? $_GET['TID'] : NULL;
if ( $TID ) {
    if ( isset($_POST['edit_topic']) ) {
        $title = $filterObj->process(trim($_POST['title']));
        
        if ( $title == '' )
            $err = 'Topic title field cannot be blank!';
        
        if ( $err == '' ) {
            $sql = "UPDATE group_tps SET title = '" .mysql_real_escape_string($title). "'
                    WHERE TID = '" .mysql_real_escape_string($TID). "' LIMIT 1";
            $conn->execute($sql);
            $msg = 'Topic updated successfuly!';
        }
    }

    $sql    = "SELECT * FROM group_tps WHERE TID = '" .mysql_real_escape_string($TID). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    $topic  = $rs->getrows();
} else
    $err = 'Topic does not exist!';

STemplate::assign('topic', $topic);
?>
