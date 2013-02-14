<?php
require('include/config.php');
require('include/function.php');

// Get arguments from the argv array 
$vdoname = $_SERVER['argv']['1']; 
$vid = $_SERVER['argv']['2']; 
$ff = $_SERVER['argv']['3']; 

if( ( $vdoname != '' ) && ( $vid != '' ) && ( $ff != '') ) {
    $ext                = strtolower(substr($vdoname, strrpos($vdoname, '.') + 1));
    $ofps               = ( $ext == 'wmv' ) ? '-ofps 25000/1001' : NULL;
    $mencoder_version   = '1.0rc1';
    exec($config['mencoder'], $mencoder_check);
    if ( isset($mencoder_check['0']) ) {
        if ( !strstr($mencoder_check['0'], 'MEncoder 1.0rc1') ) {
            $mencoder_version = '1.0rc2';
        }
    }
    $options            = ( $mencoder_version == '1.0rc1' ) ? '-lavfopts i_certify_that_my_video_stream_does_not_use_b_frames' : NULL;
        
	if( $config['vresize'] == 1) {
		$encodecommand="$config[mencoder] $config[VDO_DIR]/$vdoname -o $config[FLVDO_DIR]/".$vid."x.flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=$config[vbitrate]:mbd=2:mv0:trell:v4mv:keyint=10:cbp:last_pred=3 -vop scale=$config[vresize_x]:$config[vresize_y] -srate $config[sbitrate] $options $ofps";
	} else {
		$encodecommand="$config[mencoder] $config[VDO_DIR]/$vdoname -o $config[FLVDO_DIR]/".$vid."x.flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=$config[vbitrate]:mbd=2:mv0:trell:v4mv:keyint=10:cbp:last_pred=3 -srate $config[sbitrate] $options $ofps";
	}
	
	log_conversion($config['LOG_DIR']. '/' .$vid. '.log', $encodecommand);
	
	$ext = strtolower(substr($vdoname, strrpos($vdoname, '.') + 1));
	if ( $config['vresize'] != 1 && $ext == 'flv' )
		copy($ff, $config['FLVDO_DIR']. '/' .$vid. 'x.flv');
	else
		exec($encodecommand. ' 2>&1', $output);
	
	log_conversion($config['LOG_DIR']. '/' .$vid. '.log', implode("\n", $output));
	
	//update flv metatags
	exec($config['metainject']. ' -Uv ' .$config['FLVDO_DIR']. '/' .$vid. 'x.flv ' .$config['FLVDO_DIR']. '/' .$vid. '.flv');

	//remove temporary
	@unlink($config['FLVDO_DIR']. '/' .$vid. 'x.flv');

	//create thumbnails
	video_to_frame($ff, $vid);
	
	//delete log if conversion was successfuly
	if ( file_exists($config['FLVDO_DIR']. '/' .$vid. '.flv') && filesize($config['FLVDO_DIR']. '/' .$vid. '.flv') > 10 )
		@unlink($config['TMP_DIR']. '/logs/' .$vid. '.log');
	
	//delete original video
	if($config['del_original_video'] == 1)  {
    		if(filesize($config['FLVDO_DIR']. '/' .$vid. '.flv') > 100 && file_exists($config['FLVDO_DIR']. '/' .$vid. '.flv')) {
    			$del_upvid = $config['VDO_DIR']. '/' .$vdoname; 
    			@chmod($del_upvid, 0777); 
    			@unlink($del_upvid);
    		} 
	}

	// Delete Tmp Files
	$picA = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000001.jpg';
	$picB = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000002.jpg';
	$picC = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000003.jpg';
	$picD = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000004.jpg';
	if(file_exists($picA)) @unlink($picA);
	if(file_exists($picB)) @unlink($picB);
	if(file_exists($picC)) @unlink($picC);
	if(file_exists($picD)) @unlink($picD);

	@rmdir($config['TMP_DIR']. '/thumbs/' .$vid);
}
?>  
