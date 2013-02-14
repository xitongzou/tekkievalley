<?php
define('_VALID', true);
require('../include/config.php');
require('../include/function.php');
require('../include/function_admin.php');

chk_admin_login();

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'all';
$module_keep        = NULL;
$module_template    = 'videos.tpl';
$modules_allowed    = array('all', 'public', 'private', 'feature', 'inappropriate', 'view', 'edit', 'comments', 'commentedit');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Videos Module!';
}

switch ( $module ) {
    case 'feature':
    case 'inappropriate':
    case 'edit':
    case 'view':
    case 'comments':
    case 'commentedit':
        $module_template = 'videos_' .$module. '.tpl';
        break;
    case 'all':
    case 'public':
    case 'private':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'videos.tpl';
        break;
}
require 'modules/videos/' .$module. '.php';

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('module', $module_keep);
STemplate::assign('active_menu', 'videos');
STemplate::display('siteadmin/header.tpl');
STemplate::display('siteadmin/leftmenu/videos.tpl');
STemplate::display('siteadmin/' .$module_template);
STemplate::display('siteadmin/footer.tpl');
?>
