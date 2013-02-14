<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $PID = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? trim($_GET['PID']) : NULL;
    if ( $PID ) {
        $sql = "DELETE FROM poll_question WHERE poll_id = '" .mysql_real_escape_string($PID). "'";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() )
            $msg = 'Poll deleted successfuly!';
        else
            $err = 'Failed to delete poll! Poll does not exist!?';
    } else
        $err = 'Poll id not set or not numeric!';
}

$sql    = "SELECT * FROM poll_question";
$rs     = $conn->execute($sql);
$polls  = $rs->getarray();

STemplate::assign('polls', $polls);
?>
