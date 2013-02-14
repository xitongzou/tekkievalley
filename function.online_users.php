<?php
// $param1 - language array index
function smarty_function_online_users($params, &$smarty)
{
	global $config, $conn;
	    
    $sql    = "SELECT COUNT(UID) AS online_users FROM users_online WHERE online > " .(time()-300);
    $rs     = $conn->execute($sql);

    return $rs->fields['online_users'];
}
?>
