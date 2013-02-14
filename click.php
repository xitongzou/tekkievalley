<?php
require 'include/config.php';

$url = false;
$MID = ( isset($_GET['MID']) && is_numeric($_GET['MID']) ) ? intval($_GET['MID']) : NULL;
$TID = ( isset($_GET['TID']) && is_numeric($_GET['TID']) ) ? intval($_GET['TID']) : NULL;

if ( $MID !== 0 ) {
    $sql    = "SELECT adv_url FROM adv_media WHERE adv_id = " .$MID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() === 1 ) {
        $url = $rs->fields['adv_url'];
        $sql = "UPDATE adv_media SET clicks = clicks+1 WHERE adv_id = " .$MID. " LIMIT 1";
        $conn->execute($sql);
    }
}

if ( $TID !== 0 ) {
    $sql    = "SELECT adv_url FROM adv_text WHERE adv_id = " .$TID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() === 1 ) {
        $url = $rs->fields['adv_url'];
        $sql = "UPDATE adv_text SET clicks = clicks+1 WHERE adv_id = " .$TID. " LIMIT 1";
        $conn->execute($sql);
    }
}

if ( $url ) {
    header('Location: ' .$url);
}
die();
?>
