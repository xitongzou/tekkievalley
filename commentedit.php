<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$comment    = NULL;
$COMID      = ( isset($_GET['COMID']) && is_numeric($_GET['COMID']) ) ? $_GET['COMID'] : NULL;

if ( isset($_POST['edit_comment']) ) {
    $comment = trim($_POST['comment']);
    
    if ( $comment == '' ) {
        $err = 'Please enter your comment!';
    }
    
    if ( !$err ) {
        $sql    = "UPDATE comments SET commen = '" .mysql_real_escape_string($comment). "'
                   WHERE COMID = '" .mysql_real_escape_string($COMID). "' LIMIT 1";
        $conn->execute($sql);
        $msg    = 'Comment successfully updated!';
    }
}

if ( $COMID ) {
    $sql    = "SELECT commen FROM comments WHERE COMID = '" .mysql_real_escape_string($COMID). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $comment = $rs->fields['commen'];
    } else {
        $err = 'Invalid comment id or not set!?';
    }
}

STemplate::assign('COMID', $COMID);
STemplate::assign('comment', $comment);
?>
