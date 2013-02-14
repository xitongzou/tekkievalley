<?php
require '../include/config.php';

$lang	= $_SESSION['language'];
$sql    = "SELECT * FROM player_settings WHERE status = '1' LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $player = $rs->getrows();
    $player = $player['0'];
} else {
    die('Failed to load player profile!');
}

function clean_title( $string )
{
    $string = ereg_replace('[^ 0-9a-zA-Z]', ' ', $string);
    $string = preg_replace('/\s\s+/', ' ', $string);
    $string = trim($string);
    $string = str_replace(' ', '-', $string);
    
    return $string;
}

$video_id   = NULL;
if ( isset($_GET['vkey']) && strlen($_GET['vkey']) == 20 ) {
    $vkey   = trim($_GET['vkey']);
    $sql    = "SELECT VID, title, channel FROM video WHERE vkey = '" .mysql_real_escape_string($vkey). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $video_id   = $rs->fields['VID'];
        $channel    = $rs->fields['channel'];
        $title      = clean_title($rs->fields['title']);
    }
}

if ( !$video_id ) {
    die('Invalid video key!');
}

$madv   = array('src' => '', 'mode' => 'none', 'duration' => '', 'link' => '');
$sql    = "SELECT adv_id, adv_url, media, duration FROM adv_media WHERE status = '1' ORDER BY rand() LIMIT 1";
$rs     = $conn->execute($sql);

if ( $conn->Affected_Rows() === 1 ) {
    $mid                = intval($rs->fields['adv_id']);
    $madv['src']        = $config['BASE_URL']. '/player/adv/' .$mid. '.' .$rs->fields['media'];
    $madv['mode']       = $player['video_adv_position'];
    $madv['duration']   = $rs->fields['duration'];
    $madv['link']       = $config['BASE_URL']. '/click.php?MID=' .$mid;
    $sql                = "UPDATE adv_media SET views = views+1 WHERE adv_id = " .$mid. " LIMIT 1";
    $conn->execute($sql);
}

header('Content-Type: text/xml; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<xml>
  <logo>
    <image><?php echo $config['BASE_URL']. '/player/logo/' .$player['logo_url']; ?></image>
    <position><?php echo $player['logo_position']; ?></position>
    <link><?php echo $player['logo_link']; ?></link>
    <alpha><?php echo $player['logo_alpha']; ?></alpha>
  </logo>
  <video>
    <autorun>false</autorun>
    <image><?php echo $config['TMB_URL']. '/' .$video_id. '.jpg'; ?></image>
    <bufferTime><?php echo $player['buffertime']; ?></bufferTime>
    <src><?php echo $config['FLVDO_URL']. '/' .$video_id. '.flv'; ?></src>
    <related><?php echo $config['BASE_URL']. '/player/vRelated.php?mode=' .$player['related_content']. '&amp;vkey=' .$vkey; ?></related>
  </video>
  <mediaAdv>
    <src><?php echo $madv['src']; ?></src>
    <mode><?php echo $madv['mode']; ?></mode>
    <duration><?php echo $madv['duration']; ?></duration>
    <link><?php echo $madv['link']; ?></link>
  </mediaAdv>
  <textAdv<?php if ( $player['text_adv'] == '1' ) {; ?> enable="true"<?php } ?>>
    <src><?php echo $config['BASE_URL']. '/player/vTextAds.php'; ?></src>
    <delay><?php echo $player['text_adv_delay']; ?></delay>
  </textAdv>
  <share><?php echo $config['BASE_URL']. '/video/' .$video_id. '/' .$title; ?></share>
  <embed><?php echo '<![CDATA[<embed width="452" height="361" quality="high" bgcolor="#000000" name="main" id="main" allowfullscreen="true" allowscriptaccess="always" src="' .$config['BASE_URL']. '/player/vPlayer.swf?f=' .$config['BASE_URL']. '/player/vConfig_embed.php?vkey=' .$vkey. '" type="application/x-shockwave-flash" />]]>'; ?></embed>
  <skin><?php echo $config['BASE_URL']. '/player/vSkin.php?t=' .$player['skin']. '&amp;b=' .$player['buttons']. '&amp;r=' .$player['replay']. '&amp;e=' .$player['embed']. '&amp;s=' .$player['share']. '&amp;m=' .$player['mail']. '&amp;p=' .$player['related']. '&amp;mc=' .$player['mail_color']. '&amp;rc=' .$player['related_color']. '&amp;ec=' .$player['embed_color']. '&amp;rec=' .$player['replay_color']. '&amp;cc=' .$player['copy_color']. '&amp;tc=' .$player['time_color']. '&amp;sc=' .$player['share_color']. '&amp;anc=' .$player['adv_nav_color']. '&amp;atc=' .$player['adv_title_color']. '&amp;abc=' .$player['adv_body_color']. '&amp;alc=' .$player['adv_link_color']. '&amp;lang=' .$lang. '&amp;video=' .$video_id; ?></skin>
</xml>
