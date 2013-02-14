<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
{insert name=video_info assign=vinfo vid=$VID}
<title>{$site_name} - {$vinfo[0].title}</title> 
<link rel="shortcut icon" href="/favicon.ico" >
<meta name="title" content="{$vinfo[0].description|escape:'html'}" /> 
<meta name="abstract" content="{$vinfo[0].description|escape:'html'}" /> 
<meta name="keywords" content="{section name=i loop=$tags}{$tags[i]|escape:'html'}, {/section}" /> 
<meta name="description" content="{$vinfo[0].description|escape:'html'}" /> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="alternate" type="application/rss+xml" title="RSS - 20 newest videos" href="{$baseurl}/rss/new/" /> 
<link rel="alternate" type="application/rss+xml" title="RSS - 20 most viewed videos" href="{$baseurl}/rss/views/" /> 
<link rel="alternate" type="application/rss+xml" title="RSS - 20 most commented videos" href="{$baseurl}/rss/comments/" /> 

	<!-- INITIALIZE myjavascriptfx.js -->
	<script type="text/javascript">
	var baseurl = '{$baseurl}/';
	var imgurl = '{$baseurl}/images';
	</script>
	<script src="{$baseurl}/js/jquery-1.2.6.pack.js" type="text/javascript"></script>
	<script src="{$baseurl}/js/jquery-clipshare-0.1.js" type="text/javascript"></script>
	{if $rotating_thumbs == '1'}
	<script src="{$baseurl}/js/jquery.rotator-0.1.js" type="text/javascript"></script>
	{/if}

	 <!--!!!!!!!!!!!!!!!!!!!!!!!! LIBRARY !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
	<script src="{$baseurl}/ajax/cpaint2.inc.js" type="text/javascript"></script>
	<script src="{$baseurl}/js/myjavascriptfx.js" type="text/javascript"></script>
	<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

	<!--!!!!!!!!!!!!!!!!!!!!!!!!! Processing SCRIPT !!!!!!!!!!!!!!!!!!!-->
	<script language=JavaScript src={$baseurl}/js/indexonly.js></script>
	<script language=JavaScript src={$baseurl}/js/myjavascriptajax.js></script>
	<script language=JavaScript src={$baseurl}/js/myjavascript.js></script>
	<script language=JavaScript src={$baseurl}/js/player_fs.js></script>
	
<link href="{$baseurl}/css/tpl_style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="{$baseurl}/js/google.js"></script>
<script language="javascript" type="text/javascript" src="{$baseurl}/js/animatedcollapse.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="http://platform.twitter.com/anywhere.js?id=0cgShlFrgy2njceXTU4Z2w&v=1" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="{$baseurl}/js/expand.js"></script>
<!--[if IE 6]><link href="{$baseurl}/css/tpl_ie_6.css"  rel="stylesheet" type="text/css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="{$baseurl}/css/tpl_ie_7.css" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="{$baseurl}/css/tpl_ie_7.css" /><![endif]-->
	<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
</head>
<body>
{php}
 function insert_additional_data(){
	global $config,$conn,$users;	
    if (!$conn) {
    $conn = &ADONewConnection($DBTYPE);
if ( !$conn->Connect($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME) ) {
    echo 'Could not connect to mysql! Please check your database settings!';
    die();
}
$conn->execute("SET NAMES 'utf8'");
    }
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
            if (@$_SESSION["UID"] != ""){
                $sql="SELECT * from signup WHERE UID='".$_SESSION["UID"]."'";
                $rs = $conn->Execute($sql);
                $users = $rs->getrows();
            }
 }
 
{/php}

{insert name=additional_data }
<div id="wrapper">
<div id="head">
  <h3>
    <div id="top_links">
    {insert name="msg_count" assign=total_msg}
    {insert name=select_language assign=select_language current=$smarty.session.language}
    {if $smarty.session.USERNAME ne ""}
	{translate item='global.welcome'}, 
    <a href="{seourl rewrite='my_profile' url='my_profile.php'}">{$smarty.session.USERNAME}</a> | 
    <a href="{seourl rewrite='mail/inbox' url='inbox.php'}"> 
    	{if $total_msg eq ""}
        	{assign var=mailIcon value="tpl_icon_message.gif"}
        {else}
        	{assign var=mailIcon value="tpl_icon_new_message.gif"}
    	{/if}
        <img src="{$imgurl}/{$mailIcon}" border="0" /> 
    	
    </a> (<a href="{seourl rewrite='mail/inbox' url='inbox.php'}">
    {$total_msg}
    </a>) | <a href="{seourl rewrite='logout' url='logout.php'}">{translate item='global.logout'}</a> 
    {else}
    <a href="{seourl rewrite='signup' url='signup.php'}">{translate item='global.signup'}</a> |
    <a href="{seourl rewrite='login' url='login.php'}">{translate item='global.login'}</a>
    {/if}
	</div>
    {if $multilanguage == '1'}
    {$select_language}
    | <form name="language_form" method="POST" action="" id="language_form">
    <input name="session_language" type="hidden" value="{$smarty.session.language}">
    </form>
    <div style="clear: left;"></div>
    {/if}
	<div id="search">
  <form action="{seourl rewrite='search/' url='search_result.php'}" method="get" name="searchForm" id="searchForm">
    <p>
      <input size="40" tabindex="1" maxlength="22" name="search_id" value="{$smarty.request.search_id|escape:'html'}" class="text"  />
      <select name="search_type" class="select_back_white"  tabindex="2">
        {if $smarty.request.search_type eq "search_videos"}
        <option value="search_videos" selected="selected">{translate item='global.search_videos'}</option>
        {else}
        <option value="search_videos">{translate item='global.search_videos'}</option>
        {/if}
        {if $smarty.request.search_type eq "search_users"}
        <option value="search_users" selected="selected">{translate item='global.search_users'}</option>
        {else}
        <option value="search_users">{translate item='global.search_users'}</option>
        {/if}
        {if $smarty.request.search_type eq "search_groups"}
        <option value="search_groups" selected="selected">{translate item='global.search_groups'}</option>
        {else}
        <option value="search_groups">{translate item='global.search_groups'}</option>
        {/if}
      </select>
      <input type="image" src="{$imgurl}/searchico.png" tabindex="3"  class="button" />
    </p>
  </form>
</div>
  </h3>
    <h1><a href="{$baseurl}/" title="TekkieValley" class="logo">TekkieValley</a></h1>
</div>
<!-- end div head -->
<div class="clear"></div>
<div id="headnav">
  <div id="navbar">
    <div id="navcontainer">
      <ul>
        <li><a href="{$baseurl}" {$homecurrent}>{translate item='menu.home'}</a></li>
        {if $upload_module == 1}<li><a href="{seourl rewrite='upload' url='upload.php'}" {$uploadcurrent}>{translate item='menu.upload'}</a></li>{/if}
        {if $video_module == 1}<li><a href="{seourl rewrite='videos' url='video.php'}" {$watchcurrent}>{translate item='menu.videos'}</a></li>{/if}
        {if $channels_module == 1}<li><a href="{seourl rewrite='categories' url='channels.php'}" {$channelscurrent}>{translate item='menu.channels'}</a></li>{/if}
        {if $groups_module == 1}<li><a href="{seourl rewrite='usergroups' url='groups.php'}" {$groupcurrent}>{translate item='menu.groups'}</a></li>{/if}
        {if $community_module == 1}<li><a href="{seourl rewrite='community' url='members'}" {$communitycurrent}>{translate item='menu.community'}</a></li>{/if}
        {if $friends_module == 1}<li><a href="{seourl rewrite='userfriends' url='friends.php'}" {$friendcurrent}>{translate item='menu.friends'}</a></li>{/if}
      </ul>
    </div>
  </div>
  <div id="navsubbar">
    <p>
      {if $head_bottom ne ""}
      {include file = head_bottom/$head_bottom}
      {else}
      {include file = head_bottom/blank.tpl}
      {/if}
      {if $head_bottom_add ne ""}
      {include file = head_bottom/$head_bottom_add}
      {/if}
    </p>
  </div>
</div>
<!-- end div headnav -->
<div id="wrapper-content">
<div id="container">
