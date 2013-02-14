<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_POST['submit_media']) ) {
	$phppath			        = trim($_POST['phppath']);
	$mencoder			        = trim($_POST['mencoder']);
	$mplayer			        = trim($_POST['mplayer']);
	$ffmpeg				        = trim($_POST['ffmpeg']);
	$metainject			        = trim($_POST['metainject']);
	$thumbs_tool			    = trim($_POST['thumbs_tool']);
	$vbitrate			        = trim($_POST['vbitrate']);
	$sbitrate			        = trim($_POST['sbitrate']);
	$vresize			        = trim($_POST['vresize']);
	$vresize_x			        = trim($_POST['vresize_x']);
	$vresize_y			        = trim($_POST['vresize_y']);
	$img_max_width			    = trim($_POST['img_max_width']);
	$img_max_height			    = trim($_POST['img_max_height']);
	$video_max_size			    = trim($_POST['video_max_size']);
	$video_allowed_extensions	= trim($_POST['video_allowed_extensions']);
    $video_allowed_extensions   = str_replace(' ', '', $video_allowed_extensions);
    $video_allowed_extensions   = str_replace("\r", '', $video_allowed_extensions);
    $video_allowed_extensions   = str_replace("\n", '', $video_allowed_extensions);
	$post_max_size			    = str_replace('M', '', ini_get('post_max_size'));
	$upload_max_filesize		= str_replace('M', '', ini_get('upload_max_filesize'));
    
	if ( $phppath == '' )
		$err = 'Path to PHP CLI binary cannot be left blank!';
	if ( $mencoder == '' )
		$err = 'Path to Mencoder binary cannot be left blank!';
	if ( $ffmpeg == '' )
		$err = 'Path to ffmpeg binary cannot be left blank!';
	if ( $mplayer == '' )
		$err = 'Path to MPlayer binary cannot be left blank!';
	if ( $metainject == '' )
		$err = 'Path to FLVTool2 binary cannot be left blank!';
	if ( $vbitrate == '' )
		$err = 'Bit-rate for converted videos cannot be left blank!';
	elseif( !is_numeric($vbitrate) )
		$err = 'Bit-rate for converted videos must have a numeric value!';
	if ( $sbitrate == '' )
		$err = 'Sound sampling rate for converted videos cannot be left blank!';
	elseif( !is_numeric($sbitrate) )
		$err = 'Sound sampling rate for converted videos must have a numeric value!';
	if ( $vresize == 1 ) {
		if ( $vresize_x ==  '' )
			$err = 'Width (in pixels) for converted videos cannot be left blank!';
		elseif ( !is_numeric($vresize_x) )
			$err = 'Width (in pixels) for converted videos must have a numeric value!';
		if ( $vresize_y ==  '' )
			$err = 'Height (in pixels) for converted videos cannot be left blank!';
		elseif ( !is_numeric($vresize_y) )
			$err = 'Height (in pixels) for converted videos must have a numeric value!';		
	}
	if ( $img_max_width == '' )
		$err = 'Max thumbnail width (in pixels) cannot be left blank!';
	elseif ( !is_numeric($img_max_width) )
		$err = 'Max thumbnail width (in pixels) must have a numeric value!';
	if ( $img_max_height == '' )
		$err = 'Max thumbnail height (in pixels) cannot be left blank!';
	elseif ( !is_numeric($img_max_height) )
		$err = 'Max thumbnail height (in pixels) must have a numeric value!';
	if ( $video_max_size == '' )
		$err = 'Video max size field cannot be blank!';
	else {
		settype($video_max_size, 'integer');
		settype($post_max_size, 'integer');
		settype($upload_max_filesize, 'integer');
		if ( $video_max_size > $post_max_size || $video_max_size > $upload_max_filesize )
			$err = 'Video maximum size cannot be bigger then the php values for \'post_max_size\' or \'upload_max_filesize\'.<br> Please edit php settings (php.ini) and increase the post_max_size and upload_max_filesize values!';
	}
	if ( $video_allowed_extensions == '' )
		$err = 'Video allowed extensions field cannot be empty!';
	elseif ( !preg_match('/^[a-zA-Z0-9, ]*$/', $video_allowed_extensions) )
		$err = 'Video allowed extensions field can only contain alpha-numeric characters, comas and spaces!';
	else {
		$video_allowed_extensions = str_replace(' ', '', $video_allowed_extensions);
	}
    	
	if ( $err == '' ) {
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($phppath). "' WHERE soption = 'phppath' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($mplayer). "' WHERE soption = 'mplayer' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($mencoder). "' WHERE soption = 'mencoder' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($ffmpeg). "' WHERE soption = 'ffmpeg' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($metainject). "' WHERE soption = 'metainject' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($thumbs_tool). "' WHERE soption = 'thumbs_tool' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($vbitrate). "' WHERE soption = 'vbitrate' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($sbitrate). "' WHERE soption = 'sbitrate' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($vresize). "' WHERE soption = 'vresize' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($vresize_x). "' WHERE soption = 'vresize_x' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($vresize_y). "' WHERE soption = 'vresize_y' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($img_max_width). "' WHERE soption = 'img_max_width' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($img_max_height). "' WHERE soption = 'img_max_height' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($video_max_size). "' WHERE soption = 'video_max_size' LIMIT 1;");
		$conn->execute("UPDATE sconfig SET svalue = '" .mysql_real_escape_string($video_allowed_extensions). "' WHERE soption = 'video_allowed_extensions' LIMIT 1;");
		update_config_and_smarty();
		$msg = 'Conversion settings updated successfully!';
	}
}
?>
