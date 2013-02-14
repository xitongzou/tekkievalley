<?php
defined('_VALID') or die('Restricted Access!');

require 'version.php';

// send hears - we dont cache anything in siteadmin
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

function channelExists( $chid ) {
    global $conn;
    
    $sql = "SELECT CHID FROM channel WHERE CHID = '" .mysql_real_escape_string($chid). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function getVideoDuration( $vid )
{
    global $config;
  
    $flv = $config['FLVDO_DIR']. '/' .$vid. '.flv';
    if ( file_exists($flv) ) {
        exec($config['mplayer']. ' -vo null -ao null -frames 0 -identify "' .$flv. '"', $p);
        while ( list($k,$v) = each($p) ) {
            if ( $length = strstr($v, 'ID_LENGTH=') ) {
                break;
            }
        }
        
        $lx = explode('=', $length);
        
        return $lx['1'];
    }
    
    return false;
}

function regenVideoThumbs( $vid )
{
    global $config;
  
    $err        = NULL;
    $duration   = getVideoDuration($vid);
    if ( !$duration ) {
        $err = 'Failed to get video duration! Converted video not found!?';
    }
    
    $fc     = 0;
    $flv    = $config['FLVDO_DIR']. '/' .$vid. '.flv';
    if ( $err == '' ) {
        settype($duration, 'float');
        $timers = array(ceil($duration/2), ceil($duration/2), ceil($duration/3), ceil($duration/4));
        @mkdir($config['TMP_DIR']. '/thumbs/' .$vid);
        foreach ( $timers as $timer ) {
            if ( $config['thumbs_tool'] == 'ffmpeg' ) {
                $cmd = $config['ffmpeg']. ' -i ' .$flv. ' -f image2 -ss ' .$timer. ' -s ' .$config['img_max_width']. 'x' .$config['img_max_height']. ' -vframes 2 -y ' .$config['TMP_DIR']. '/thumbs/' .$vid. '/%08d.jpg';
            } else {
                $cmd = $config['mplayer']. ' ' .$flv. ' -ss ' .$timer. ' -nosound -vo jpeg:outdir=' .$config['TMP_DIR']. '/thumbs/' .$vid. ' -frames 2';
            }
            exec($cmd);
            $tmb    = ( $fc == 0 ) ? $vid : $fc. '_' .$vid;
            $fd     = $config['TMB_DIR']. '/' .$tmb. '.jpg';
            $ff     = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000002.jpg';
            if ( !file_exists($ff) )
                $ff = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000001.jpg';
            if ( !file_exists($ff) )
                $ff = $config['BASE_DIR']. '/images/default.gif';
            
            createThumb($ff, $fd, $config['img_max_width'], $config['img_max_height']);
            ++$fc;
        }
    }
    
    return $err;
}

function deleteVideo( $vid )
{
    global $config, $conn;
      
    $sql        = "SELECT vdoname FROM video WHERE VID = '" .mysql_real_escape_string($vid). "' LIMIT 1";
    $rs         = $conn->execute($sql);
    $vdoname    = $rs->fields['vdoname'];
    
    
    $flv = $config['FLVDO_DIR']. '/' .$vid. '.flv';
    if ( file_exists($flv) ) {
        @chmod($flv, 0777);
        @unlink($flv);
    }
    
    if ( $vdoname ) {
        $video = $config['VDO_DIR']. '/' .$vdoname;
        if ( file_exists($video) ) {
            @chmod($video, 0777);
            @unlink($video);
        }
    }
    
    $thumb1 = $config['TMB_DIR']. '/' .$vid. '.jpg';
    $thumb2 = $config['TMB_DIR']. '/1_' .$vid. '.jpg';
    $thumb3 = $config['TMB_DIR']. '/2_' .$vid. '.jpg';
    $thumb4 = $config['TMB_DIR']. '/3_' .$vid. '.jpg';
    if ( file_exists($thumb1) ) @unlink($thumb1);
    if ( file_exists($thumb2) ) @unlink($thumb2);
    if ( file_exists($thumb3) ) @unlink($thumb3);
    if ( file_exists($thumb4) ) @unlink($thumb4);
    
    $tables = array('comments', 'favourite', 'feature_req', 'group_vdo', 'inappro_req', 'playlist', 'video');
    foreach ( $tables as $table ) {
        $sql = "DELETE FROM " .$table. " WHERE VID = '" .mysql_real_escape_string($vid). "'";
        $conn->execute($sql);
    }
}

function videoExists( $vid )
{
    global $conn;
    
    $sql = "SELECT VID FROM video WHERE VID = '" .mysql_real_escape_string($vid). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function insert_user_byip($options)
{
    global $conn;
    
    $sql = "SELECT username FROM signup WHERE user_ip = '" .mysql_real_escape_string($options['ip']). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['username'];
                                
    return 'NO USER WITH THIS IP';
}

function insert_group_channel($options)
{
}

function insert_group_select($options)
{
    global $conn;
    
    $output = array();
    $sql    = "SELECT GID, gname FROM group_own ORDER BY gname";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() ) {
        while ( !$rs->EOF ) {
            $GID        = $rs->fields['GID'];
            $gname      = $rs->fields['gname'];
            $selected   = ( $options['gid'] == $GID ) ? ' selected="selected"' : NULL;
            $output[]   = '<option value="' .$GID. '"' .$selected. '>' .htmlspecialchars($gname). '</option>';
            
            $rs->movenext();
        }
    }
    
    return implode("\n", $output);
}

function insert_video_title($option)
{
    global $conn;
    
    $sql = "SELECT title, thumb FROM video WHERE VID = '" .mysql_real_escape_string($option['vid']). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->getrows();
    }
    
    return 'NO VIDEO ATTACHED!';
}

function userExistsByUsername( $username )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function userExistsByID( $id )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE UID = '" .mysql_real_escape_string($id). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function makeTimeStamp($year='', $month='', $day='')
{
    if(empty($year)) {
        $year = strftime('%Y');
    }
    
    if(empty($month)) {
        $month = strftime('%m');
    }
    
    if(empty($day)) {
        $day = strftime('%d');
    }
                                       
    return mktime(0, 0, 0, $month, $day, $year);
}

function groupExists($gid)
{
    global $conn;
    
    $sql = "SELECT GID FROM group_own WHERE GID = '" .mysql_real_escape_string($gid). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function topicExists($tid)
{
    global $conn;
    
    $sql = "SELECT TID FROM group_tps WHERE TID = '" .mysql_real_escape_string($tid). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function postExists($pid)
{
    global $conn;
    
    $sql = "SELECT PID FROM group_tps_post WHERE PID = '" .mysql_real_escape_string($pid). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function insert_get_video_title( $options )
{
    global $conn;
    
    $sql    = "SELECT title FROM video WHERE VID = '" .mysql_real_escape_string($options['VID']). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['title'];
    }
    
    return false;
}

function get_player_skins()
{
    global $config;

    $skins      = array();
    $skins_dir  = $config['BASE_DIR']. '/player/skins';
    if ( file_exists($skins_dir) && is_dir($skins_dir) ) {
        $files  = scandir($skins_dir);
        foreach ( $files as $file ) {
            if ( $file != 'index.php' && $file != '.' && $file != '..' ) {
                if ( is_dir($skins_dir. '/' .$file) ) {
                    $skins[] = $file;
                }
            }
        }
    }
    
    return $skins;
}
?>
