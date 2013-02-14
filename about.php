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

STemplate::assign('err',$err);
STemplate::assign('head_bottom',"blank.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
echo "<table width=100% height=300 cellpadding=0 cellspacing=0><tr><td valign=top>";
STemplate::display('about.tpl');
echo "</td></tr></table>";
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>

