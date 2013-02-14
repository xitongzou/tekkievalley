<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$video  = array();
$VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
settype($VID, 'integer');
if ( !$VID ) 
    $err = 'Invalid video ID. This video does not exist!';

if ( $err == '' ) {
    if ( isset($_POST['edit_video']) ) {
        $title          = trim($_POST['title']);
        $description    = trim($_POST['description']);
        $featuredesc    = trim($_POST['feature_desc']);
        $keyword        = trim($_POST['keyword']);
        $channel        = $_POST['channel'];
        $type           = trim($_POST['type']);
        $featured       = trim($_POST['featured']);
        $be_comment     = trim($_POST['be_comment']);
        $be_rated       = trim($_POST['be_rated']);
        $embed          = trim($_POST['embed']);
        $thumb          = trim($_POST['thumb']);
        $rate           = trim($_POST['rate']);
        $ratedby        = trim($_POST['ratedby']);
        $viewnumber     = trim($_POST['viewnumber']);
        $com_num        = trim($_POST['com_num']);
        $fav_num        = trim($_POST['fav_num']);
        $active         = trim($_POST['active']);
        
        if ( strlen($title) < 3 )
            $err = 'Video title field cannot be blank!';
        elseif ( strlen($description) < 3 )
            $err = 'Video description field cannot be blank!';
        elseif ( strlen($keyword) < 3 )
            $err = 'Video keyword(tags) field cannot be blank!';
        elseif ( count($channel)<1 || count($channel)>3 )
            $err = 'Select at least one channel and no more then 3!';
        
        if ( $err == '' ) {
            settype($thumb, 'integer');
            settype($rate, 'float');
            settype($ratedby, 'integer');
            settype($viewnumber, 'integer');
            settype($com_num, 'integer');
            settype($fav_num, 'integer');
        
            $sql = "UPDATE video SET title = '" .mysql_real_escape_string($title). "', description = '" .mysql_real_escape_string($description). "',
                                     featuredesc = '" .mysql_real_escape_string($featuredesc). "', keyword = '" .mysql_real_escape_string($keyword). "',
                                     channel = '0|" .implode('|', $channel). "|0', type = '" .mysql_real_escape_string($type). "',
                                     featured = '" .mysql_real_escape_string($featured). "', be_comment = '" .mysql_real_escape_string($be_comment). "',
                                     be_rated = '" .mysql_real_escape_string($be_rated). "', embed = '" .mysql_real_escape_string($embed). "',
                                     thumb = '" .mysql_real_escape_string($thumb). "', rate = '" .mysql_real_escape_string($rate). "',
                                     ratedby = '" .mysql_real_escape_string($ratedby). "', viewnumber = '" .mysql_real_escape_string($viewnumber). "',
                                     com_num = '" .mysql_real_escape_string($com_num). "', fav_num = '" .mysql_real_escape_string($fav_num). "',
                                     active  = '" .mysql_real_escape_string($active). "' WHERE VID = '" .mysql_real_escape_string($VID). "' LIMIT 1";
            $conn->execute($sql);
            $msg = 'Video information updated successfuly!';
        }
    }

    $sql    = "SELECT * FROM video WHERE VID = '" .$VID. "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( mysql_affected_rows() == 1 ) {
        $video                  = $rs->getrows();
        $video['0']['channel']  = explode('|', $video['0']['channel']);
    }
    else
        $err    = 'Invalid Video ID. This video does not exist!';
}

STemplate::assign('video', $video);

?>
