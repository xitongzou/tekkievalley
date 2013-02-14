<?php
// $param1 - seo url
// $param2 - normal url
// $param3 - string to clean
function smarty_function_seourl($params, &$smarty)
{
	global $config;
	$seo_url	= $params['rewrite'];
	$normal_url	= $params['url'];
	$seo_clean	= ( isset($params['clean']) ) ? $params['clean'] : NULL;
	$base_url	= $config['BASE_URL'];

	if ( $config['seo_urls'] == '1' ) {
		if ( $seo_clean ) {
			$entities_match 	= array(' ','--','&quot;','!','@','#','%','^','&','*','_','(',')','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
			$entities_replace 	= array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
			$seo_clean		= str_replace($entities_match, $entities_replace, $seo_clean);
//            $seo_clean      = preg_replace('/[^a-zA-Z0-9\-]/', '', $seo_clean);
            if ( $seo_clean != '' )
			    $seo_clean		= '/' .$seo_clean;
		}
		
		return $base_url. '/' .$seo_url.$seo_clean;
	}
	
	return $base_url. '/' .$normal_url;
}
?>
