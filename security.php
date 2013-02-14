<?php
if (get_magic_quotes_runtime()||get_magic_quotes_gpc()) {
    if (get_magic_quotes_runtime()) {
        set_magic_quotes_runtime(0);
    }

    $input = array(&$_GET, &$_POST, &$_REQUEST, &$_COOKIE);
    while (list($k,$v) = each($input)) {
        foreach ($v as $key => $val) {
            if (!is_array($val)) {
                $input[$k][$key] = stripslashes($val);
                continue;
            }
            $input[] =& $input[$k][$key];
        }
    }

    unset($input);
}

function disableRegisterGlobals()
{
    if( (bool)@ini_get('register_globals') ) {      
        $noUnset    = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        $input      = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());

        foreach ($input as $k => $v) {
            if (!in_array($k, $noUnset) && isset($GLOBALS[$k])) {
                unset($GLOBALS[$k]);
            }
        }
        
        @ini_set('register_globals', 'off');
    }
}
?>
