<?php
require '../include/config.local.php';

$theme              = ( isset($_GET['t']) && preg_match('/[0-9a-zA-Z_]+/', $_GET['t']) ) ? trim($_GET['t']) : NULL;
$buttons            = ( isset($_GET['b']) && $_GET['b'] == '0' ) ? 'false' : 'true';
$replay             = ( isset($_GET['r']) && $_GET['r'] == '0' ) ? 'false' : 'true';
$embed              = ( isset($_GET['e']) && $_GET['e'] == '0' ) ? 'false' : 'true';
$share              = ( isset($_GET['s']) && $_GET['s'] == '0' ) ? 'false' : 'true';
$mail               = ( isset($_GET['m']) && $_GET['m'] == '0' ) ? 'false' : 'true';
$related            = ( isset($_GET['p']) && $_GET['p'] == '0' ) ? 'false' : 'true';
$mail_color         = ( isset($_GET['mc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['mc']) : '0x999999';
$related_color      = ( isset($_GET['rc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['rc']) : '0x999999';
$replay_color       = ( isset($_GET['rec']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['rec']) : '0x999999';
$copy_color         = ( isset($_GET['cc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['cc']) : '0x999999';
$time_color         = ( isset($_GET['tc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['tc']) : '0x999999';
$embed_color        = ( isset($_GET['ec']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['ec']) : '0x999999';
$share_color        = ( isset($_GET['ec']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['ec']) : '0x999999';
$adv_nav_color      = ( isset($_GET['anc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['anc']) : '0x999999';
$adv_title_color    = ( isset($_GET['atc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['atc']) : '0x999999';
$adv_body_color     = ( isset($_GET['abc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['abc']) : '0x999999';
$adv_link_color     = ( isset($_GET['alc']) && strlen($_GET['mc']) === 8 ) ? htmlspecialchars($_GET['alc']) : '0x999999';
$language	    	= ( isset($_GET['lang']) && strlen($_GET['lang']) == 5 ) ? htmlspecialchars($_GET['lang']) : 'en_US';
$video_id			= ( isset($_GET['video']) ) ? intval($_GET['video']) : NULL;

if ( !$theme ) {
    die('Please provide a player theme!');
}

$config['BASE_DIR'] = dirname(dirname(__FILE__));

require $config['BASE_DIR']. '/language/' .$language. '/player.lang.php';

$skin_url   = $config['BASE_URL']. '/player/skins/' .$theme;

header('Content-Type: text/xml; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<xml>
    <text>
        <advertisement><?php echo $lang['player_advertisement']; ?></advertisement>
        <options>
          <related><?php echo $lang['player_related']; ?></related>
          <share><?php echo $lang['player_share']; ?></share>
          <embed><?php echo $lang['player_embed']; ?></embed>
		  <mail>
      		  <title><?php echo $lang['player_mail_title']; ?></title>
      		  <error><?php echo $lang['player_mail_error']; ?></error>
      		  <success><?php echo $lang['player_mail_success']; ?></success>
      		  <script><?php echo $config['BASE_URL']; ?>/player/vMail.php?video_id=<?php echo $video_id; ?></script>
      		  <fields>
        		  <me><?php echo $lang['player_mail_from']; ?></me>
        		  <to><?php echo $lang['player_mail_to']; ?></to>
        		  <message><?php echo $lang['player_mail_msg']; ?></message>
      		  </fields>
    	  </mail>
        </options>
    </text>
    <graphics>
        <options>
            <buttons visible="<?php echo $buttons; ?>">
                <mail enable="<?php echo $mail; ?>" text="<?php echo $lang['player_mail_text']; ?>"><?php echo $skin_url; ?>/btn_mail.png</mail>
                <related enable="<?php echo $related; ?>" text="<?php echo $lang['player_related_text']; ?>"><?php echo $skin_url; ?>/btn_related.png</related>
                <share enable="<?php echo $share; ?>" text="<?php echo $lang['player_share_text']; ?>"><?php echo $skin_url; ?>/btn_share.png</share>
                <embed enable="<?php echo $embed; ?>" text="<?php echo $lang['player_embed_text']; ?>"><?php echo $skin_url; ?>/btn_embed.png</embed>
                <replay enable="<?php echo $replay; ?>" text="<?php echo $lang['player_replay_text']; ?>"><?php echo $skin_url; ?>/btn_replay.png</replay>
                <copy text="<?php echo $lang['player_copy_text']; ?>"><?php echo $skin_url; ?>/btn_copy.png</copy>
				<send text="<?php echo $lang['player_send_text']; ?>"><?php echo $skin_url; ?>/btn_copy.png</send>
                <close><?php echo $skin_url; ?>/btn_close.png</close>
            </buttons>
        </options>
        <navigation>
            <play normal="<?php echo $skin_url; ?>/play.png" over="<?php echo $skin_url; ?>/play_over.png"/>
            <pause normal="<?php echo $skin_url; ?>/pause.png" over="<?php echo $skin_url; ?>/pause_over.png"/>
            <stop normal="<?php echo $skin_url; ?>/stop.png" over="<?php echo $skin_url; ?>/stop_over.png"/>
            <volume normal="<?php echo $skin_url; ?>/sound.png" over="<?php echo $skin_url; ?>/sound_over.png"/>
            <mute><?php echo $skin_url; ?>/mute.png</mute>
            <options normal="<?php echo $skin_url; ?>/options.png" over="<?php echo $skin_url; ?>/options_over.png"/>
            <fullscreen normal="<?php echo $skin_url; ?>/fs.png" over="<?php echo $skin_url; ?>/fs_over.png"/>
            <normalsreen normal="<?php echo $skin_url; ?>/normal.png" over="<?php echo $skin_url; ?>/normal_over.png"/>
        </navigation>
        <other>
            <msgcopied>Copied to ClipBoard</msgcopied>
            <centerButton><?php echo $skin_url; ?>/center_btn.png</centerButton>
            <navigationBg>
                <left><?php echo $skin_url; ?>/bg_nav_left.png</left>
                <middle><?php echo $skin_url; ?>/bg_nav_middle.png</middle>
                <right><?php echo $skin_url; ?>/bg_nav_right.png</right>
            </navigationBg>
        </other>
        <videoprogress>
            <tracker normal="<?php echo $skin_url; ?>/time_track.png" over="<?php echo $skin_url; ?>/time_track_over.png"></tracker>
            <bg><?php echo $skin_url; ?>/time_bg.png</bg>
            <play><?php echo $skin_url; ?>/time_play.png</play>
            <load><?php echo $skin_url; ?>/time_load.png</load>
        </videoprogress>
        <volumeprogress>
            <traker><?php echo $skin_url; ?>/volume_track.png</traker>
            <bg><?php echo $skin_url; ?>/volume_bg.png</bg>
            <active><?php echo $skin_url; ?>/volume_value.png</active>
        </volumeprogress>        
    </graphics>
    <colors>
        <mail><?php echo $mail_color; ?></mail>
        <related><?php echo $related_color; ?></related>
        <embed><?php echo $embed_color; ?></embed>
        <share><?php echo $share_color; ?></share>
        <replay><?php echo $replay_color; ?></replay>
        <copy><?php echo $copy_color; ?></copy>
        <time><?php echo $time_color; ?></time>
        <adnavigation><?php echo $adv_nav_color; ?></adnavigation>
        <adv_text_title><?php echo $adv_title_color; ?></adv_text_title>
        <adv_text_body><?php echo $adv_body_color; ?></adv_text_body>
        <adv_text_link><?php echo $adv_link_color; ?></adv_text_link>
    </colors>
</xml>
