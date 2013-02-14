<?php
/**************************************************************************************************
| Software Name        : ClipShare - Video Sharing Community Script
| Software Author      : Clip-Share.Com / ScriptXperts.Com
| Website              : http://www.clip-share.com
| E-mail               : office@clip-share.com
|**************************************************************************************************
| This source file is subject to the ClipShare End-User License Agreement, available online at:
| http://www.clip-share.com/video-sharing-script-eula.html
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2006-2007 Clip-Share.com. All rights reserved.
|**************************************************************************************************/

require('include/config.php');
require('include/function.php');

$active = ( $config['approve'] == 1 ) ? "and active = '1'" : NULL;

//RECENT CLOUD TAGS
$recenttagsquery="SELECT keyword from video where type='public' $active order by addtime desc limit 100";
$recenttags=cloudTags($recenttagsquery);
STemplate::assign('recenttags',$recenttags);
//END CLOUD TAGS

//POPULAR CLOUD TAGS
$populartagsquery="SELECT keyword from video where type='public' $active order by viewnumber desc limit 100";
$populartags=cloudTags($populartagsquery);
STemplate::assign('populartags',$populartags);
//END CLOUD TAGS

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('answers',$users);
STemplate::assign('head_bottom',"homelinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('more_tags.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
