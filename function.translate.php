<?php
// $param1 - language array index
function smarty_function_translate($params, &$smarty)
{
	global $lang;
	$index		= $params['item'];
	if ( $index == '' )
		$smarty->trigger_error("[translate] undefined item to translate $index", E_USER_WARNING);
	
	if ( isset($lang[$index]) ) {
		return $lang[$index];
	}
	
	return $index;
}
?>
