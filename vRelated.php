<?php
require '../include/config.php';

function clean_title( $string )
{
    $string = ereg_replace('[^ 0-9a-zA-Z]', ' ', $string);
    $string = preg_replace('/\s\s+/', ' ', $string);
    $string = trim($string);
    $string = str_replace(' ', '-', $string);

    return $string;
}

function url( $sef_url, $url, $title )
{
    global $config;
    if ( $config['seo_urls'] == '1' ) {
        return $config['BASE_URL']. '/' .$sef_url. '/' .clean_title($title);
    }
    
    return $config['BASE_URL']. '/' .$url;
}

function format_duration ( $duration )
{
    $duration_formated  = NULL;
    $duration           = round($duration);
    if ( $duration > 3600 ) {
        $hours              = floor($duration/3600);
        $duration_formated .= sprintf('%02d',$hours). ':';
        $duration           = round($duration-($hours*3600));
    }
    if ( $duration > 60 ) {
        $minutes            = floor($duration/60);
        $duration_formated .= sprintf('%02d', $minutes). ':';
        $duration           = round($duration-($minutes*60));
    } else {
        $duration_formated .= '00:';
    }

    return $duration_formated . sprintf('%02d', $duration);
}

$vkey   = ( isset($_GET['vkey']) && strlen($_GET['vkey']) == 20 )  ? $_GET['vkey'] : NULL;
if ( !$vkey ) {
    die('Invalid video key!');
}

$active = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$mode   = ( isset($_GET['mode']) && ctype_alpha($_GET['mode']) ) ? $_GET['mode'] : 'related';
switch ( $mode ) {
    case 'commented':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate FROM video
                   WHERE type = 'public'" .$active. " ORDER BY com_num DESC LIMIT 20";
        break;
    case 'featured':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate FROM video
                   WHERE type = 'public' AND featured = '1'" .$active. " ORDER BY addtime DESC LIMIT 20";
        break;
    case 'rated':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate
                   FROM video WHERE type = 'public'" .$active. " ORDER BY (ratedby*rate) DESC LIMIT 20";
        break;
    case 'viewed':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate
                   FROM video WHERE type = 'public'" .$active. " ORDER BY viewnumber DESC LIMIT 20";
        break;
    default:
        $sql    = "SELECT title, keyword, description FROM video WHERE vkey = '" .mysql_real_escape_string($vkey). "' LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() != 1 ) {
            die('Invalid video key (video does not exist)!');
        }
        $video          = $rs->getrows();
        $keywords       = explode(' ', $video['0']['keyword']);
        $keywords_add   = NULL;
        $keywords_count = count($keywords);
        if ( $keywords_count > 1 ) {
            for ( $i=1; $i<$keywords_count; $i++ ) {
                $keywords_add .= " OR keyword LIKE '%" .mysql_real_escape_string($keywords[$i]). "%'";
            }
        }
        $sql_add        = " AND ( keyword LIKE '%" .mysql_real_escape_string($keywords['0']). "%' " .$keywords_add. ")";
        $sql            = "SELECT VID, title, vkey, thumb, description, duration, rate FROM video
                           WHERE type = 'public'" .$active . $sql_add. " ORDER BY VID DESC LIMIT 20";
}

$rs     = $conn->execute($sql);
$videos = $rs->getrows();

header('Content-Type: text/xml; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<xml>
    <videos>
    <?php foreach( $videos as $video ): ?>
        <video>
            <title><?php echo $video['title']; ?></title>
            <duration><?php echo format_duration($video['duration']); ?></duration>
            <url><?php echo url('video/' .$video['VID'], 'view_video.php?viewkey=' .$video['vkey'], $video['title']); ?></url>
            <image><?php echo $config['TMB_URL']. '/' .$video['VID']. '.jpg'; ?></image>
            <desc><?php echo htmlspecialchars($video['description'], ENT_QUOTES, 'UTF-8'); ?></desc>
            <stars><?php echo $video['rate']; ?></stars>
        </video>
    <?php endforeach; ?>
    </videos>
</xml>
