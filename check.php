<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$mencoder	= $config['mencoder'];
$mplayer	= $config['mplayer'];
$metainject	= $config['metainject'];
$php		= $config['phppath'];
$ffmpeg     = $config['ffmpeg'];
$flvideo_dir	= $config['FLVDO_DIR'];
$video_dir	= $config['VDO_DIR'];
$tmp_dir	= $config['BASE_DIR']. '/tmp';
$thumbs_dir	= $config['TMB_DIR'];
$photo_dir	= $config['PHO_DIR'];
$chimg_dir	= $config['BASE_DIR']. '/chimg';
$restrictions	= array('safe_mode' => '', 'open_basedir' => '');
$upload		= array('max_upload_size' => '', 'max_post_size' => '');
$binaries  	= array('php' => '<b>missing</b>', 'mencoder' => '<b>missing</b>', 'mplayer' => '<b>missing</b>', 'ffmpeg' => '<b>missing</b>', 'metainject' => '<b>missing</b>');
$paths		= array('thumbs' => 'not writable', 'tmp' => 'not writable', 'flvideo' => 'not writable', 'video' => 'not writable', 'photo' => 'not writable', 'chimg' => 'not writable', 'sessions' => 'not writable', 'thumb' => 'not_writable', 'logs' => 'not_writable', 'uploader' => 'not writable');
$paths_perms	= array('thumbs' => '', 'tmp' => '', 'flvideo' => '', 'video' => '', 'photo' => '', 'chimg' => '', 'sessions' => '', 'thumb' => '', 'logs' => '', 'uploader' => '');
$formats 	= array('h264' => 'missing', 'faac' => 'missing', 'lame' => 'missing', 'xvid' => 'missing', 'theora' => 'missing', 'jpeg' => 'missing');
$formats_paths 	= array('h264' => '', 'faac' => '', 'lame' => '', 'xvid' => '', 'theora' => '', 'jpeg' => '');

if ( file_exists($flvideo_dir) && is_dir($flvideo_dir) && is_writable($flvideo_dir) ) {
	$paths['flvideo'] 	= 'writable';
	$paths_perms['flvideo'] = substr(sprintf('%o', fileperms($flvideo_dir)), -4);
}

if ( file_exists($video_dir) && is_dir($video_dir) && is_writable($video_dir) ) {
	$paths['video'] 	= 'writable';
	$paths_perms['video'] = substr(sprintf('%o', fileperms($video_dir)), -4);
}

if ( file_exists($thumbs_dir) && is_dir($thumbs_dir) && is_writable($thumbs_dir) ) {
	$paths['thumbs'] 	= 'writable';
	$paths_perms['thumbs'] = substr(sprintf('%o', fileperms($thumbs_dir)), -4);
}

if ( file_exists($tmp_dir) && is_dir($tmp_dir) && is_writable($tmp_dir) ) {
	$paths['tmp'] 		= 'writable';
	$paths_perms['tmp'] 	= substr(sprintf('%o', fileperms($tmp_dir)), -4);
}

if ( file_exists($photo_dir) && is_dir($photo_dir) && is_writable($photo_dir) ) {
	$paths['photo'] 	= 'writable';
	$paths_perms['photo'] = substr(sprintf('%o', fileperms($photo_dir)), -4);
}

if ( file_exists($chimg_dir) && is_dir($chimg_dir) && is_writable($chimg_dir) ) {
	$paths['chimg'] 	= 'writable';
	$paths_perms['chimg'] = substr(sprintf('%o', fileperms($chimg_dir)), -4);
}

if ( file_exists($tmp_dir. '/sessions') && is_dir($tmp_dir. '/sessions') && is_writable($tmp_dir. '/sessions') ) {
	$paths['sessions'] 	= 'writable';
	$paths_perms['sessions'] = substr(sprintf('%o', fileperms($tmp_dir. '/sessions')), -4);
}

if ( file_exists($tmp_dir. '/thumbs') && is_dir($tmp_dir. '/thumbs') && is_writable($tmp_dir. '/thumbs') ) {
	$paths['thumb'] 	= 'writable';
	$paths_perms['thumb'] = substr(sprintf('%o', fileperms($tmp_dir. '/thumbs')), -4);
}

if ( file_exists($tmp_dir. '/logs') && is_dir($tmp_dir. '/logs') && is_writable($tmp_dir. '/logs') ) {
	$paths['logs'] 	= 'writable';
	$paths_perms['logs'] = substr(sprintf('%o', fileperms($tmp_dir. '/logs')), -4);
}

if ( file_exists($tmp_dir. '/uploader') && is_dir($tmp_dir. '/uploader') && is_writable($tmp_dir. '/uploader') ) {
	$paths['uploader'] 	= 'writable';
	$paths_perms['uploader'] = substr(sprintf('%o', fileperms($tmp_dir. '/uploader')), -4);
}

$upload['max_upload_size'] 	= ini_get('upload_max_filesize');
$upload['max_post_size']	= ini_get('post_max_size');

$restrictions['safe_mode']	= ini_get('safe_mode');
$restrictions['open_basedir']	= ini_get('open_basedir');

if ( file_exists($php) && is_file($php) && is_executable($php) )
	$binaries['php'] = 'found';
if ( file_exists($mencoder) && is_file($mencoder) && is_executable($mencoder) )
	$binaries['mencoder'] = 'found';
if ( file_exists($mplayer) && is_file($mplayer) && is_executable($mplayer) )
	$binaries['mplayer'] = 'found';
if ( file_exists($ffmpeg) && is_file($ffmpeg) && is_executable($ffmpeg) )
	$binaries['ffmpeg'] = 'found';
if ( file_exists($metainject) && is_file($metainject) && is_executable($metainject) )
	$binaries['metainject'] = 'found';

$formats_error = '';
if ( $binaries['mencoder'] == 'found' && $binaries['mplayer'] == 'found' ) {
	exec('/usr/bin/ldd ' .$mencoder, $output);
	if ( !$output ) {
		exec('/bin/ldd' .$mencoder, $output);
		if ( !$output ) {
			exec('/usr/local/bin/ldd' .$mencoder, $output);
			if ( !$output ) {
				exec('/sbin/ldd' .$mencoder, $output);
			}
		}
	}
	
	if ( $output ) {
		foreach ( $output as $key => $value ) {
			if ( strstr($value, 'libjpeg') ) {
				$array = explode(' => ', $value);
				$formats['jpeg'] 	= 'found';
				$formats_paths['jpeg']	= $array['1'];
			}
			if ( strstr($value, 'libmp3lame') ) {
				$array = explode(' => ', $value);
				$formats['lame'] 	= 'found';
				$formats_paths['lame']	= $array['1'];
			}
			if ( strstr($value, 'libxvidcore') ) {
				$array = explode(' => ', $value);
				$formats['xvid'] 	= 'found';
				$formats_paths['xvid']	= $array['1'];
			}
			if ( strstr($value, 'libfaac') ) {
				$array = explode(' => ', $value);
				$formats['faac'] 	= 'found';
				$formats_paths['faac']	= $array['1'];
			}
			if ( strstr($value, 'libx264') ) {
				$array = explode(' => ', $value);
				$formats['x264'] 	= 'found';
				$formats_paths['x264']	= $array['1'];
			}
			if ( strstr($value, 'libtheora') ) {
				$array = explode(' => ', $value);
				$formats['theora'] 	= 'found';
				$formats_paths['theora']= $array['1'];
			}
		}
	} else {
		$formats_error = 'Formats Error (could not find ldd binary)!';
	}
} else {
	$formats_error = 'Formats Error (mplayer or mencoder not installed)!';
}

STemplate::assign('flvideo_dir', $flvideo_dir);
STemplate::assign('video_dir', $video_dir);
STemplate::assign('thumbs_dir', $thumbs_dir);
STemplate::assign('photo_dir', $photo_dir);
STemplate::assign('chimg_dir', $chimg_dir);
STemplate::assign('tmp_dir', $tmp_dir);
STemplate::assign('upload', $upload);
STemplate::assign('binaries', $binaries);
STemplate::assign('paths', $paths);
STemplate::assign('paths_perms', $paths_perms);
STemplate::assign('formats', $formats);
STemplate::assign('formats_paths', $formats_paths);
STemplate::assign('formats_error', $formats_error);
STemplate::assign('restrictions', $restrictions);
?>
