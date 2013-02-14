<div id="leftside">
  <div class="clear">
  </div>
  <div id="viewvideo">
    <div id="viewvideo-title">
      {$vinfo[0].title|escape:'html'}
    </div>
    <div id="viewvideo-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <div class="vdcenter">
        <div class="videoplayer">

</script>
{literal}
<script>
	function checkStar(imgId)
	{
	   if(imgId.id == 'star_1')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_full.gif';
	   }
	   if(imgId.id == 'star_2')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_full.gif';
	   }
	   if(imgId.id == 'star_3')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_3').src = '/images/tpl_icon_star_full.gif';
	   }
	   if(imgId.id == 'star_4')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_3').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_4').src = '/images/tpl_icon_star_full.gif';
	   }
	   if(imgId.id == 'star_5')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_3').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_4').src = '/images/tpl_icon_star_full.gif';
	      document.getElementById('star_5').src = '/images/tpl_icon_star_full.gif';
	   }
	}
	
	function removeStar(imgId)
	{
	   if(imgId.id == 'star_1')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_empty.gif';
	   }
	   if(imgId.id == 'star_2')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_empty.gif';
	   }
	   if(imgId.id == 'star_3')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_3').src = '/images/tpl_icon_star_empty.gif';
	   }
	   if(imgId.id == 'star_4')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_3').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_4').src = '/images/tpl_icon_star_empty.gif';
	   }
	   if(imgId.id == 'star_5')
	   {
	      document.getElementById('star_1').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_2').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_3').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_4').src = '/images/tpl_icon_star_empty.gif';
	      document.getElementById('star_5').src = '/images/tpl_icon_star_empty.gif';
	   }
	}
</script>
{/literal}
	{if $vinfo[0].embed_code eq ''}
    {include file="view_video_player_vplayer.tpl"}
	{else}
	{$vinfo[0].embed_code}
	{/if}
        </div>
        <div class="clear">
        </div>
      </div>
    </div>
    <script language="JScript" type="text/jscript" src="{$baseurl}/js/ClickFix.js"></script>
    <!-- Add To Social Bookmarks   -->
    <script language="JavaScript" type="text/javascript">
				var addtoLayout='';						// addtoLayout: 0=Horizonal 1 row, 1=Horizonal 2 rows, 2=Vertical with icons, 3=Vertical no icons
				var addtoMethod=1;						// addtoMethod: 0=direct link, 1=popup 
				var AddURL = document.location.href;	// could be set dynamically to your blog post's permalink
				var AddTitle = escape(document.title);	// same here, this could be set dymaically instead of the page's current title
				</script>
    <script language="JavaScript" src="{$baseurl}/modules/bookmarks/addto.js" type="text/javascript"></script>
    {insert name=advertise assign=adv group='view_top'}
    {$adv}
     <div id="useraction">
     	  <div class="boxPart">
          	{assign var=viddur value=$vinfo[0].duration}
            {math equation="$viddur/60" format="%0.0f" assign=minutes}
            {math equation="$viddur - ($minutes * 60)" format="%0.0f" assign=seconds}
            {if $seconds < 0}
            {math equation="$minutes - 1" assign=minutes}
            {math equation="$seconds + 60" assign=seconds}
            {/if}
            {insert name=comment_count assign=commentcount vid=$vinfo[0].VID}
          	<span class="info">{translate item='global.runtime'}:</span> {$minutes}m {$seconds}s
            </span>|<span class="info"> {translate item='global.views'}:</span> {$vinfo[0].viewnumber} |<span class="info"> {translate item='global.comments'}:</span> {$commentcount}
          </div>
		  
		  
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td rowspan="2">
		{if $smarty.session.UID ne ""}  
                <div class="floatmenu">{translate item='view_video.rate'}</div> 
                {else}
		<div class="floatmenu"><a href="{seourl rewrite='signup' url='signup.php'}" title="SignUp">{translate item='view_video.login'}</a></div>
		{/if}
		<br />
		{if $smarty.session.UID ne ""}  
<div class="floatmenu-without-arrow">
                    <div id="idVoteView"></div>
                    <div id="voteProcess">
                        <img id="star_1" src="{$imgurl}/tpl_icon_star_empty.gif" onClick="fxRate('{$viewkey}',2,'voteProcess','voteProcessthank','{$VID}')" onmouseover="checkStar(this)" onmouseout="removeStar(this)">
                        <img id="star_2" src="{$imgurl}/tpl_icon_star_empty.gif" onClick="fxRate('{$viewkey}',4,'voteProcess','voteProcessthank','{$VID}')" onmouseover="checkStar(this)" onmouseout="removeStar(this)">
                        <img id="star_3" src="{$imgurl}/tpl_icon_star_empty.gif" onClick="fxRate('{$viewkey}',6,'voteProcess','voteProcessthank','{$VID}')" onmouseover="checkStar(this)" onmouseout="removeStar(this)">
                        <img id="star_4" src="{$imgurl}/tpl_icon_star_empty.gif" onClick="fxRate('{$viewkey}',8,'voteProcess','voteProcessthank','{$VID}')" onmouseover="checkStar(this)" onmouseout="removeStar(this)">
                        <img id="star_5" src="{$imgurl}/tpl_icon_star_empty.gif" onClick="fxRate('{$viewkey}',10,'voteProcess','voteProcessthank','{$VID}')" onmouseover="checkStar(this)" onmouseout="removeStar(this)">
                    </div>
                    <div id="voteProcessthank" style='display:none'>Thanks for rating</div>
                </div>
                {/if}
	</td>
	<td>
		<div class="floatmenu">
		<div id="addToFavLink"><a href="#addfavour" onClick="fxAddFavorite('addToFavLink', {if $smarty.session.UID ne ''}{$smarty.session.UID}{else}0{/if}, {$vinfo[0].VID}, {$vinfo[0].UID});">{translate item='view_video.action_favour'"}</a></div>
		<div id="addToFavSuccess" style="display:none;">{translate item='view_video.addfav_success'}</div>
		<div id="addToFavFailed" style="display:none;">{translate item='view_video.addfav_failed'}</div>
		<div id="addToFavAlready" style="display:none;">{translate item='view_video.addfav_already'}</div>
		<div id="addToFavLogin" style="display:none;"><a href="{seourl rewrite='login' url='login.php'}">{translate item='view_video.addfav_login'}</a></div>
		<div id="addToFavOwner" style="display:none;">{translate item='view_video.addfav_owner'}</div>
		</div>
	</td>
	<td>
		<div class="floatmenu"> 
        	{if $smarty.session.UID eq ""}
        		<a href="{seourl rewrite="video/`$vinfo[0].VID`/?action=comment" url="view_video.php?viewkey=`$viewkey`&page=`$smarty.request.page`&viewtype=`$smarty.request.viewtype`&category=`$smarty.request.category`&action=comment"}">{translate item='view_video.comments_write'}</a>
        	{else}
        		<a href="#postcomment">{translate item='view_video.comments_write}</a>
        	{/if}
    		</div>
	</td>
  </tr>
  <tr>
	<td>
		<div class="floatmenu">
			<a href="#flagvideo">{translate item='view_video.flag_this'}</a>
		</div>
	</td>
	<td>
	                <div class="floatmenu">
                    {if $downloads eq 1}
                    {if $smarty.session.UID ne ""}
                        <a href="{$flvdourl}/{$vinfo[0].flvdoname}" title="Download">{translate item='view_video.download'}</a>
                    {else}
					<a href="{seourl rewrite='signup' url='signup.php'}" title="SignUp">{translate item='view_video.download_login'}</a>
					{/if}
                    {/if}
                </div>
	</td>
  </tr>
</table>
      <div class="clear"></div>
    </div> 
  </div>
  
  
  <div id="bookmark">
      <div id="bookmark-title">{translate item='view_video.add_social'}</div>
      <div id="bookmark-content">
        <div class="arrow-general">
          &nbsp;
        </div>
		<div id="bookmarklist">
          <ul>
            <li>
				<a href="javascript:return false;"  onclick="addto(8)"><img src="{$imgurl}/spurl.png" alt="Spurl" border="0" longdesc="http://www.spurl.net/" /><br/>Spurl</a>
			</li>
            <li>
				<a href="javascript:return false;"  onclick="addto(3)"><img src="{$imgurl}/digg.png" border="0" alt="Digg"/><br/>Digg</a>
            </li>
            <li>
				<a href="javascript:return false;"  onclick="addto(2)"><img src="{$imgurl}/deliciou.png" border="0" alt="Del.icio.us"/><br/>Del.icio.us</a>
            </li>
            <li>
				<a href="javascript:return false;"  onclick="addto(1)"><img src="{$imgurl}/blinklis.png" border="0" alt="Blink"/><br/>Blinklist</a>
            </li>
            <li>
				<a href="javascript:return false;"  onclick="addto(4)"><img src="{$imgurl}/furl.png" border="0" alt="Furl"/><br/>Furl</a>
            </li>
            <li>
				<a href="javascript:return false;"  onclick="addto(7)"><img src="{$imgurl}/yahoo.png" border="0" alt="Y!MyWeb"/><br/>Y!MyWeb</a>
            </li>
            <li>
				<a href="javascript:return false;"  onclick="addto(6)"><img src="{$imgurl}/simpy.png" border="0" alt="Simpy"/><br/>Simpy</a>
            </li>
            <li>
				<a href="javascript:return false;"  onclick="addto(5)"><img src="{$imgurl}/google.png" border="0" alt="Google"/><br/>Google</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div>    
    <div id="videodetails">
      <div id="videodetails-title">{translate item='view_video.comment_this'}</div>
      <div id="videodetails-content">
        <div class="arrow-general">&nbsp;</div>
        {if $smarty.session.UID ne "" and $isvideocommented ne ""}
        <a name="postcomment"></a>
        <div id="divComments">
          {translate item='view_video.comment_write'}: <br/>
          <form name="Add_comment" method="post" action="{seourlcurrent}">
            <div id="div_main_comment">
              <textarea rows="3" name="addcomment" id="txtComments" class="fullboxtext"></textarea><br/>
              <input type="button" name="commentpost" value="{translate item='view_video.comment_post'}" onClick="fxSendComments('divComments','txtComments',{$smarty.session.UID},{$VID})" />
            </div>
          </form>
        </div >
		<br />
        <div id="divComResult1" style='display:none'>
          <p>{translate item='view_video.comment_success'}</p>
        </div>
        <div id="divComResult2" style='display:none'>
          <p>{translate item='view_video.comment_already'}</p>
        </div>
        <div id="divComResult3" style='display:none'>
          <p>{translate item='view_video.comment_disabled'}</p>
        </div>
        {/if}
        
        {insert name=comment_info assign=cominfo vid=$VID}
        {section name=i loop=$cominfo}


<TABLE class="comment-divider" width="100%" cellspacing="10" cellpadding="0" border="0">
<TR>
	{insert name=id_to_name assign=uname un=$cominfo[i].UID}
	<TD valign="top" width="17%"><a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$cominfo[i].UID`"}">
		{insert name=comment_info_user assign=comuser uid=$cominfo[i].UID}{section name=a loop=$comuser}
		<img class="comment-image" src="{$photourl}/{if $comuser[a].photo eq ""}nopic.gif{else}{$comuser[a].photo}{/if}" width="50" height="50" border="0">{/section}</a>
	</TD>
	<TD valign="top" width="99%" align="left">
         {insert name=id_to_name assign=uname un=$cominfo[i].UID}
         <SPAN class="comment-info">Posted by</span> <A href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$cominfo[i].UID`"}">{$uname}</A>
		 {insert name=time_range assign=stime field=addtime IDFR=COMID id=$cominfo[i].COMID tbl=comments}
         <SPAN class="comment-info">({$stime})</SPAN>
		 <BR>
		  <DIV class="comment-body">
		 	{$cominfo[i].commen|nl2br|wordwrap:55:"<br>":true}
		 </DIV>
         <a href="{seourl rewrite="compose/`$uname`" url="compose.php?receiver=`$uname`&subject=Re:`$cominfo[i].commen|truncate:180`"}">Reply to this</a>
			{if $delete eq "1"}
			<BR><BR>
			<form name="removeCommentForm" action="{seourl rewrite="video/`$vinfo[0].VID`" url="/view_video.php?viewkey=`$vinfo[0].vkey`"}" method="post">
			<input type="hidden" value="1" name="action_removecomment">
			<input type="hidden" value="{$VID}" name="VID"> 
			<input type="hidden" value="{$cominfo[i].COMID}" name="COMID">
			<input onclick="return confirm('Are you sure to delete this comment?');"
			type="submit" value="Remove Comment" name="remove_comment">
			</form>
			{/if}
	</TD>
</TR>
</TABLE>


{/section}
      </div>
      <div class="clear">
      </div>
      <a name="flagvideo"></a>
      <p class="specialmessage">
    	    {translate item='view_video.fun_clean_real'}.<br/>
    	    {translate item='view_video.flag_video'} :
	    <a href="#featureVideo" onClick="fxFeatureVideo({if $smarty.session.UID ne ''}{$smarty.session.UID}{else}0{/if}, {$vinfo[0].VID});">{translate item='view_video.feature_this}!</a> - 
	    <a href="#reportVideo" onClick="fxReportVideo({if $smarty.session.UID ne ''}{$smarty.session.UID}{else}0{/if}, {$vinfo[0].VID});">{translate item='view_video.innappropiate'}</a>
      </p>
	    <p id="reportVideoLogin" class="specialmessage" style="display:none;">{translate item='view_video.report_login'}</p>
	    <p id="reportVideoSuccess" class="specialmessage" style="display:none;">{translate item='view_video.report_success'}</p>
	    <p id="reportVideoFailed" class="specialmessage" style="display:none;">{translate item='view_video.report_failed'}</p>
	    <p id="featureVideoLogin" class="specialmessage" style="display:none;">{translate item='view_video.feature_login'}</p>
	    <p id="featureVideoSuccess" class="specialmessage" style="display:none;">{translate item='view_video.feature_success'}</p>
	    <p id="featureVideoFailed" class="specialmessage" style="display:none;">{translate item='view_video.feature_failed'}</p>
    </div>
  
  
  
</div>
<div id="rightside_video">
    <div id="small-rightbox">
      <div id="small-rightbox-title">
        {translate item='view_video.video_information'}
      </div>
      <div id="small-rightbox-content">
        <div class="arrow-general">
          &nbsp;
        </div>
        <div class="startratebox2">
        <span class="info">{translate item='view_video.rating'} ({$vinfo[0].ratedby} {translate item='view_video.votes'}):</span>
        {insert name=show_rate assign=rate rte=$vinfo[0].rate}
        <span class="title">{$rate}</span>
        </div>
        <span class="info">{translate item='global.added'}: </span><span class="title">{insert name=id_to_uploaddate assign=DID un=$VID}</span><br /> 
        <span class="info">{translate item='global.from'}: </span>
        {insert name=id_to_name assign=uname un=$UID}
	<a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$UID`"}"><span class="title">{$uname}</span></a>
	(<a href="{$baseurl}/compose.php?receiver={$uname}"> {translate item='view_video.send_pm'} </a>)<br/>
	{insert name=video_count assign=vdocount uid=$UID}
        {insert name=favour_count assign=favcount uid=$UID}
        {insert name=friends_count assign=friendcount uid=$UID}  
         <span class="title"><img src="{$imgurl}/tpl_icon_video.gif" /> ({$vdocount}) | 
        <img src="{$imgurl}/tpl_icon_flag.gif" /> ({$favcount}) |
        <img src="{$imgurl}/tpl_icon_people.gif" /> ({$friendcount})</span><br /><br />	
	<span class="info"><a href="#" rel="toggle[desc]" data-openimage="{$imgurl}/navCloseX.gif" data-closedimage="{$imgurl}/navExpandArrow.gif"><img border="0" /></a>&nbsp; <a href="javascript:animatedcollapse.show('desc')">{translate item='view_video.desc'}: </a></span><br/>
	<div id="desc">
        {$vinfo[0].description|escape:'html'}<br/>
	</div>
        <span class="info">{translate item='view_video.channels}: </span>
          {insert name=video_channel assign=channel vid=$VID}
          {section name=k loop=$channel}
          	<a href="{seourl rewrite="categories/`$channel[k].CHID`" url="channel_detail.php?chid=`$channel[k].CHID`" clean=$channel[k].name}"><span class="tags">{$channel[k].name}</span></a>&nbsp;
          {/section}
		 		  
        <br/>
		
		<span class="info">{translate item='global.tags'}: </span>
          {insert name=video_keyword assign=keyword vid=$VID}
          {section name=j loop=$keyword}
	  <a href="{seourl rewrite="tags" url="search_result.php?search_id=`$keyword[j]`" clean=$keyword[j]}"><span class="tags">{$keyword[j]}</span></a>&nbsp;
          {/section}<br/><br/>
		  
               
       <form id="linkForm" name="linkForm">
            <span class="title">{translate item='view_video.url'} :</span>
            <textarea rows="2" name="video_link" id="fm-video_link" class="fullboxtext" onclick="javascript:document.linkForm.video_link.focus();document.linkForm.video_link.select();" readonly="readOnly">{seourl rewrite="video/`$vinfo[0].VID`" url="view_video.php?viewkey=`$viewkey`" clean=$vinfo[0].title}</textarea>
            <br/>
            {if $isvideoembabed eq "enabled"}
                <span class="title">{translate item='view_video.embed'}: </span>
		  <textarea class="fullboxtext" rows="2" name="video_play" onclick="javascript:document.linkForm.video_play.focus();document.linkForm.video_play.select();" readonly="readOnly">{if $vinfo[0].embed_code eq ''}<embed width="452" height="361" quality="high" bgcolor="#000000" name="main" id="main" allowfullscreen="true" allowscriptaccess="always" src="{$baseurl}/player/vPlayer.swf?f={$baseurl}/player/vConfig_embed.php?vkey={$viewkey}" type="application/x-shockwave-flash" />{else}
		  {$vinfo[0].embed_code}
		{/if}
                </textarea>
          	{/if}
       </form>
      </div> 
      <div class="clear">
      </div>
    </div>
  {insert name=advertise assign=adv group='view_right_single'}
  {if $adv != ''}
  <div id="adv">
    <div id="adv-title">
      Advertisement
    </div>
    <div id="adv-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <p>{$adv}</p>
    </div>
  </div><br>
  {/if}	
    <div id="videotabcontainer">
    <ul>
        <li><a href="javascript:void(0);" id="tabRelatedVideos" class="tabactive" onClick="showRelatedVideos();">{translate item='view_video.related'}</a></li>
        <li><a href="javascript:void(0);" id="tabUserVideos" onClick="showUserVideos();">{translate item='view_video.user'}</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div id="small-rightbox">
    <div id="small-rightbox-content">
        <div id="relatedVideos">
        <br>
        <div class="side_results"  onscroll="render_full_side();" name="side_results" align="center">
        {section name=i loop=$answers}
        {assign var=looprecord value=$smarty.section.i.index}
        {if $looprecord%2 eq 0}{assign var=colorLoop value=""}{else}{assign var=colorLoop value="blue"}{/if}
        {if $viewkey eq $answers[i].vkey}{assign var=selectedVideo value="selectedvideo"}{else}{assign var=selectedVideo value=""}{/if}
        {insert name=id_to_name assign=uname un=$answers[i].UID}
        {insert name=comment_count assign=commentcount vid=$answers[i].VID}
        <div class="relatedvideolist {$colorLoop} {$selectedVideo}">
              <div class="relatedvideothumbnail"><a class="bold" href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$smarty.request.page`&amp;viewtype=`$smarty.request.viewtype`&amp;category=`$smarty.request.category`" clean=$answers[i].title}" target="_parent"><img height="45" src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width="60" /></a>{if $viewkey eq $answers[i].vkey}<br />{translate item='view_video.playing'}{/if}</div>
              <div class="relatedvideodesc">
                  <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$smarty.request.page`&amp;viewtype=`$smarty.request.viewtype`&amp;category=`$smarty.request.category`" clean=$answers[i].title}" target="_parent">{$answers[i].title|escape:'html'}</a><br>
                  {assign var=viddur value=$answers[i].duration}
                  {math equation="$viddur/60" format="%0.0f" assign=minutes}
                  {math equation="$viddur - ($minutes * 60)" format="%0.0f" assign=seconds}
                  {if $seconds < 0}
                  {math equation="$minutes - 1" assign=minutes}
                  {math equation="$seconds + 60" assign=seconds}
                  {/if}
                  <span class="duration">{$minutes}:{$seconds}</span><br>
                  {translate item='global.from'} <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$answers[i].UID`"}" target="_parent">{$uname}</a>
              </div>
              <div class="clear"></div>
        </div>
        {/section}
        </div>
        <a href="{seourl rewrite="related/`$viewkey`" url="search_result.php?search_type=related&search_key=`$viewkey`"}" target="_parent">{translate item='view_video.see_all'}</a>
        </div><div id="userVideos" style="display:none;"><br>
        <div class="side_results"  onscroll="render_full_side();" name="side_results" align="center">
        {section name=i loop=$answersuser}
        {assign var=looprecord value=$smarty.section.i.index}
        {if $looprecord%2 eq 0}{assign var=colorLoop value=""}{else}{assign var=colorLoop value="blue"}{/if}
        {if $viewkey eq $answersuser[i].vkey}{assign var=selectedVideo value="selectedvideo"}{else}{assign var=selectedVideo value=""}{/if}
        {insert name=id_to_name assign=uname un=$answersuser[i].UID}
        {insert name=comment_count assign=commentcount vid=$answersuser[i].VID}
        <div class="relatedvideolist {$colorLoop}{$selectedVideo}">
              <div class="relatedvideothumbnail"><a class="bold" href="{seourl rewrite="video/`$answersuser[i].VID`" url="view_video.php?viewkey=`$answersuser[i].vkey`&amp;page=`$smarty.request.page`&amp;viewtype=`$smarty.request.viewtype`&amp;category=`$smarty.request.category`" clean=$answersuser[i].title}" target="_parent"><img height="45" src="{$tmburl}/{$answersuser[i].thumb}_{$answersuser[i].VID}.jpg" width="60" /></a>{if $viewkey eq $answersuser[i].vkey}<br />Playing{/if}</div>
              <div class="relatedvideodesc">
                  <a href="{seourl rewrite="video/`$answersuser[i].VID`" url="view_video.php?viewkey=`$answersuser[i].vkey`&amp;page=`$smarty.request.page`&amp;viewtype=`$smarty.request.viewtype`&amp;category=`$smarty.request.category`" clean=$answersuser[i].title}" target="_parent">{$answersuser[i].title|escape:'html'}</a><br>
                  {assign var=viddur value=$answersuser[i].duration}
                  {math equation="$viddur/60" format="%0.0f" assign=minutes}
                  {math equation="$viddur - ($minutes * 60)" format="%0.0f" assign=seconds}
                  {if $seconds < 0}
                  {math equation="$minutes - 1" assign=minutes}
                  {math equation="$seconds + 60" assign=seconds}
                  {/if}
                  <span class="duration">{$minutes}:{$seconds}</span><br>
                  {translate item='global.from'} <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$answersuser[i].UID`"}" target="_parent">{$uname}</a>
              </div>
              <div class="clear"></div>
        </div>
        {/section}
        </div>
        <a href="{seourl rewrite="users/`$uname`/videos/public/1" url="uvideos.php?UID=`$UID`"}">See All</a>
        </div>
    </div>
    </div>
    <div class="clear"></div>
  {insert name=advertise assign=adv group='view_right'}
  {if $adv != ''}
  <div id="adv">
    <div id="adv-title">
      Advertisement
    </div>
    <div id="adv-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <p>{$adv}</p>
    </div>
  </div>
  {/if}
</div>
<div class="clear">
</div>