<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$video  = array();
$VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
settype($VID, 'integer');
if ( !$VID ) 
    $err = 'Invalid video ID. This video does not exist!';

if ( $err == '' ) {
    if ( isset($_GET['a']) && $_GET['a'] == 'approve' ) {
        $sql = "UPDATE video SET active = '1' WHERE VID = '" .$VID. "' LIMIT 1";
        $conn->execute($sql);
        $msg = 'Video approved successfuly!';
    }

    $sql    = "SELECT * FROM video WHERE VID = '" .$VID. "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( mysql_affected_rows() == 1 )
        $video = $rs->getrows();
    else
        $err = 'Invalid video ID. This video does not exist!';
}

STemplate::assign('video', $video);

?>
