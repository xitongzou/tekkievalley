<?php
require('include/config.php');
require('include/function.php');
require('language/' .$_SESSION['language']. '/error.lang.php');

$type   = ( isset($_REQUEST['type']) ) ? $_REQUEST['type'] : 'default';
switch ( $type ) {
    case 'video_missing':
        $error = $lang['error.video_missing'];
        break;
    case 'msg_missing':
        $error = $lang['error.msg_missing'];
        break;
    case 'group_missing':
        $error = $lang['error.group_missing'];
        break;
    case 'upload_disabled':
        $error = $lang['error.upload_disabled'];
        break;
    case 'user_missing':
        $error = $lang['error.user_missing'];
        break;
    case 'video_private':
        $error = $lang['error.video_private'];
        break;
    case 'playlist_private':
        $error = $lang['error.playlist_private'];
        break;
    default:
        $error = $lang['error.default'];
        break;
}

STemplate::assign('error', $error);
STemplate::display('head1.tpl');
STemplate::display('error.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
