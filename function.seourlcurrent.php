<?php
function smarty_function_seourlcurrent($params, &$smarty)
{
	global $config;
	
	return ( isset($_SERVER['REQUEST_URI']) ) ? $config['URL'].$_SERVER['REQUEST_URI'] : $config['BASE_URL'];
}
?>
