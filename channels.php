<?php
define('_VALID', true);
require('../include/config.php');
require('../include/function.php');
require('../include/function_admin.php');

chk_admin_login();

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'list';
$modules_allowed    = array('list', 'view', 'add', 'edit', 'videos', 'groups');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'list';
    $err    = 'Invalid Channels Module!';
}

switch ( $module ) {
    case 'view':
    case 'add':
    case 'edit':
        $module_template = 'channels_' .$module. '.tpl';
        break;
    case 'list':
    default:
        $module_template = 'channels.tpl';
}

require 'modules/channels/' .$module. '.php';

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('active_menu', 'channels');
STemplate::display('siteadmin/header.tpl');
STemplate::display('siteadmin/leftmenu/channels.tpl');
STemplate::display('siteadmin/' .$module_template);
STemplate::display('siteadmin/footer.tpl');
?>
