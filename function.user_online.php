<?php
function smarty_function_user_online($params, &$smarty)
{
	global $config, $conn;
    
    $UID    = $params['UID'];
    $time   = time()-3600;
    $msg    = 'Offline';
    $sql    = "SELECT logintime FROM signup WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
    $rs     = $conn->execute($sql);    
    if ( $conn->Affected_Rows() == 1 ) {
        if ( $rs->fields['logintime'] > $time ) {
            $msg = 'Online';
        } 
    }
    
    return $msg;
}
?>
