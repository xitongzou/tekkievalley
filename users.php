<?php
define('_VALID', true);
require('../include/config.php');
require('../include/function.php');
require('../include/function_admin.php');

chk_admin_login();

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'all';
$module_template    = 'users.tpl';
$modules_allowed    = array('all', 'active', 'inactive', 'edit', 'view', 'view', 'mail', 'mailall');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Users Module!';
}

$module_keep = NULL;
switch ( $module ) {
    case 'edit':
    case 'view':
    case 'add':
    case 'mail':
    case 'mailall':
        $module_template = 'users_' .$module. '.tpl';
        break;
    case 'all':
    case 'active':
    case 'inactive':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'users.tpl';
        break;
}
require 'modules/users/' .$module. '.php';

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('module', $module_keep);
STemplate::assign('active_menu', 'users');
STemplate::display('siteadmin/header.tpl');
STemplate::display('siteadmin/leftmenu/users.tpl');
STemplate::display('siteadmin/' .$module_template);
STemplate::display('siteadmin/footer.tpl');
?>
