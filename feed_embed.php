<?php
require('include/config.php');
require('include/function.php');

$active = ( $config['approve'] == 1 ) ? " AND active='1'" : NULL;
$vkey   = ( isset($_GET['v']) && strlen($_GET['v']) == 20 ) ? trim($_GET['v']) : NULL;
if ( !$vkey ) {
    die('No video key provided!');
}

$sql    = "SELECT title, keyword FROM video WHERE type = 'public' AND vkey = '" .mysql_real_escape_string($vkey). "'" .$active. " LIMIT 1";
$rs     = $conn->execute($sql);
if ( !$conn->Affected_Rows() == 1 ) {
    die('Video does not exist!');
}

$video          = $rs->getarray();
$keywords       = explode(' ', $video['0']['keyword']);
$keywords_count  = count($keywords);
$keywords_add   = NULL;
if ( $keywords_count ) {
    $keywords_add   = " OR ( keyword LIKE '%" .mysql_real_escape_string($keywords['0']). "%'";

    for ( $i=1; $i<=$keywords_count-1; $i++ ) {
        $keywords_add .= " OR keyword LIKE '%" .mysql_real_escape_string($keywords[$i]). "%'";
    }
    
    $keywords_add   .= ")";
}

$sql    = "SELECT VID, vkey, title, thumb FROM video WHERE type = 'public' AND vkey != '" .mysql_real_escape_string($vkey). "'
           AND title LIKE '%" .mysql_real_escape_string($video['0']['title']). "%'" .$keywords_add . $active. " LIMIT 20";
$rs     = $conn->execute($sql);
if ( !$conn->Affected_Rows() > 0 ) {
    $sql    = "SELECT VID, vkey, title, thumb FROM video WHERE type = 'public' AND vkey != '" .mysql_real_escape_string($vkey). "' ORDER BY VID DESC LIMIT 20";
    $rs     = $conn->execute($sql);
}

$videos = $rs->getrows();

header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header("Content-type: text/xml");
print "<recommendations>\n\n";
if ( $videos ) {
    foreach ( $videos as $video ) {
        $link = seo_url('video/' .$video['VID'], 'view_video.php?viewkey=' .$video['vkey'], $video['title']);
	print "\t<recommendation>\n";
	print "\t\t<title>" .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). "</title>\n";
        print "\t\t<image>" .$config['BASE_URL']. "/thumb/" .$video['thumb']. "_" .$video['VID']. ".jpg</image>\n";
        print "\t\t<link>" .$link. "</link>\n";
        print "\t</recommendation>\n";
    }
}
print "</recommendations>\n";
?>
