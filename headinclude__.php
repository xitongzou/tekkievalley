<?php
/* global value */
//stats start 
				if ($config['approve'] == 1) {$active = "and active = '1'";}
                $sql = "SELECT count(*) as total from video where type='public' $active"; 
                $ars = $conn->Execute($sql); 
                $grandtotalpublic = $ars->fields['total'];
                STemplate::assign('grandtotalpublic',$grandtotalpublic+0); 

                $sql = "SELECT count(*) as total from video where type='private' $active"; 
                $ars = $conn->Execute($sql); 
                $grandtotalprivate  = $ars->fields['total']; 
                STemplate::assign('grandtotalprivate',$grandtotalprivate+0); 

                $sql = "SELECT count(*) as total from signup $query"; 
                $ars = $conn->Execute($sql); 
                $grandtotaluser  = $ars->fields['total']; 
                STemplate::assign('grandtotaluser',$grandtotaluser+0); 			
//stats end
				$sql="SELECT * from channel ORDER BY rand() LIMIT 5 ";
				$rs = $conn->Execute($sql);
				$channellist = $rs->getrows();
				STemplate::assign('channellist',$channellist);
				
				#get latest video on db 
				#end get latest video on db 				
				$sql = "SELECT * from video where type='public' $active ORDER BY VID DESC LIMIT 5 "; 
                $rs = $conn->Execute($sql); 
                $footerLatestVideo = $rs->getrows();
				STemplate::assign('footerLatestVideo',$footerLatestVideo); 
				//Recent TAGS

				$featuredtagsquery="SELECT keyword from video where type='public' $active order by addtime desc limit 20";
				$recenttags=cloudTags($featuredtagsquery);
				STemplate::assign('recenttagsfooter',$recenttags);
		
				//Recent TAGS
				
$scriptName = @$_SERVER['SCRIPT_NAME'];
$arrayScriptName = explode("/",$scriptName);
if (sizeof($arrayScriptName) > 0){
	$scriptName = $arrayScriptName[(sizeof($arrayScriptName)-1)];
	$homecurrent = "";
	$uploadcurrent = "";
	$watchcurrent = "";
	$groupcurrent = "";
	$friendcurrent = "";
	$channelscurrent = "";
	$communitycurrent = "";
	/*
	$listCurrent = array("index.php"=>"homecurrent","upload.php"=>"uploadcurrent"
						,"video.php"=>"watchcurrent","channels.php"=>"channelscurrent"
						,"groups.php"=>"groupcurrent");
	*/
	$listCurrent = array(
	"about.php"=>"homecurrent", "add_favour.php"=>"watchcurrent", "add_video.php"=>"watchcurrent", 
	"audio.php"=>"watchcurrent", "audio_channels.php"=>"channelscurrent", 
	"audio_channel_detail.php"=>"channelscurrent", "channels.php"=>"channelscurrent", 
	"channels1.php"=>"channelscurrent", "channel_detail.php"=>"channelscurrent", 
	"compose.php"=>"homecurrent", "confirm_email.php"=>"homecurrent", "create_group.php"=>"groupcurrent", 
	"emails"=>"homecurrent","ffavour.php"=>"friendcurrent", 
	"friends.php"=>"friendcurrent", "friend_accept.php"=>"friendcurrent", 
	"fvideos.php"=>"friendcurrent", "gmembers.php"=>"homecurrent", "groups.php"=>"groupcurrent", 
	"groups_home.php"=>"groupcurrent", "group_posts.php"=>"groupcurrent","gvideos.php"=>"groupcurrent",
	"help.php"=>"homecurrent", "inbox.php"=>"homecurrent", "index.php"=>"homecurrent", "invite_friends.php"=>"friendcurrent", 
	"invite_members.php"=>"friendcurrent", "invite_signup.php"=>"friendcurrent", 
	"login.php"=>"homecurrent", "makeavideo.php"=>"watchcurrent", 
	"members.php"=>"communitycurrent", "more_tags.php"=>"homecurrent", "mygroup.php"=>"groupcurrent", "my_audio.php"=>"watchcurrent", 
	"my_favour.php"=>"homecurrent", "my_group_edit.php"=>"groupcurrent", "my_playlist.php"=>"homecurrent", "my_profile.php"=>"homecurrent", 
	"my_vdo_edit.php"=>"watchcurrent", "my_video.php"=>"watchcurrent", "outbox.php"=>"homecurrent", "pack_ops.php"=>"homecurrent", "payment.php"=>"", 
	"pmt_success.php"=>"", "privacy.php"=>"homecurrent", "recoverpass.php"=>"homecurrent", "renew_account.php"=>"homecurrent",  
	"rss_feeds.php"=>"homecurrent", "search.php"=>"homecurrent", "search_group.php"=>"groupcurrent", "search_result.php"=>"homecurrent", "signup.php"=>"homecurrent", 
    "terms.php"=>"homecurrent", "uaudios.php"=>"watchcurrent", "ufavour.php"=>"homecurrent", "ufavour_audio.php"=>"homecurrent", 
	"ufriends.php"=>"friendcurrent", "ugroups.php"=>"groupcurrent", "ugroup_members.php"=>"groupcurrent", "ugroup_videos.php"=>"groupcurrent", 
	"uplaylist.php"=>"homecurrent", "upload.php"=>"uploadcurrent", "upload_music.php"=>"uploadcurrent", "upload_success.php"=>"uploadcurrent", 
	"upload_success_music.php"=>"uploadcurrent", "uprofile.php"=>"communitycurrent", "uvideos.php"=>"watchcurrent", "video.php"=>"watchcurrent",
	 "video1.php"=>"watchcurrent", "view_audio.php"=>"watchcurrent", "view_video.php"=>"watchcurrent");
	$resultCurrent = @$listCurrent[$scriptName] ; 
    if ($resultCurrent != ""){
		${$resultCurrent} = " id='currentTab' ";
	}
	else{
		$homecurrent = " id='currentTab' ";
	} 
	STemplate::assign('homecurrent',$homecurrent);
	STemplate::assign('uploadcurrent',$uploadcurrent);
	STemplate::assign('watchcurrent',$watchcurrent);
	STemplate::assign('groupcurrent',$groupcurrent);
	STemplate::assign('friendcurrent',$friendcurrent);
	STemplate::assign('channelscurrent',$channelscurrent);
	STemplate::assign('communitycurrent',$communitycurrent);
}

if ( isset($_SESSION['UID']) ) {
	$sql    = "SELECT * from signup WHERE UID='" .mysql_real_escape_string($_SESSION['UID']). "'";
	$rs     = $conn->Execute($sql);
	$users  = $rs->getrows();
}
?>