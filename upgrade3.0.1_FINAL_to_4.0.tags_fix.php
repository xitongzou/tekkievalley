<?php
require('include/config.php');
$sql = "SELECT VID, keyword FROM video";
$rs  = $conn->execute($sql);
$videos = $rs->getrows();
foreach ( $videos as $video ) {
    $tags = str_replace('+', ' ', $video['keyword']);
    $tags = str_replace(',', ' ', $tags);
    $sql = "UPDATE video SET keyword = '" .mysql_real_escape_string($tags). "' WHERE VID = '" .mysql_real_escape_string($video['VID']). "' LIMIT 1";
    $conn->execute($sql);
    echo $sql, '<br>';
}
?>
