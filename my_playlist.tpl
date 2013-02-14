{if $total gt "0"}
  <div id="leftside">
    <div id="myvideo">
      <div id="myvideo-title">
	  	<div class="titlepage">{translate item='menu.my_playlist'}</div>
		<div class="videopaging">{translate item='global.videos'} {$start_num} -{$end_num} {translate item='global.of'} {$total}</div>
	  </div>
      <div id="myvideo-content">
        <div class="arrow-general">&nbsp;</div>
        <div style="text-align: right;">
        <form name="deletePlaylist" method="POST" action="{seourl rewrite='my_playlists' url='my_playlist.php'}">
        <input name="delete" type="hidden" value="deletePlaylist">
        <input type="image" src="{$imgurl}/btn_remove.gif" onClick="return confirm('{translate item='my_playlist.delete_question'}');" alt="Delete Playlist">
        </form>
        </div>
		{section name=i loop=$answers}
        {assign var=looprecord value=$smarty.section.i.index}
		{if $looprecord%2 eq 0}
			{assign var=colorLoop value=""}	
		{else}
			{assign var=colorLoop value="blue"}	
		{/if}
        <div class="myvideo {$colorLoop}">
          <div class="videothumb"> 
             <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}"> <img class="moduleEntryThumb" height="90" src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width="120" /> </a>
         	<div class="button">
            {if $smarty.session.UID ne ""}
                <form method="post" action="{seourl rewrite='my_playlists' url='my_playlist.php'}">
                <input type="hidden" name="rvid" value="{$answers[i].VID}">
                <input type="hidden" name="removevideo" value="Remove Video">
                <input type="image" src="{$imgurl}/btn_remove.gif" onclick="return confirm('{translate item='my_playlist.remove_question'}');" alt="Remove Video" />
                </form>
            {/if}
            </div>
          </div>
          <div class="maindesc">
              <p> <strong><a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">{$answers[i].title|escape:'html'}</a></strong><br />
            {$answers[i].description}<br />
            {translate item='global.tags'} //
            {insert name=video_keyword assign=tags vid=$answers[i].VID}
            {section name=j loop=$tags} <a href="{$baseurl}/search_result.php?search_id={$tags[j]}"> {$tags[j]} </a> {/section} <br/>
            {insert name=time_to_date assign=todate tm=$answers[i].addtime}
            {translate item='global.added'}: {$todate}<br/>
            {translate item='global.runtime'}: {$answers[i].duration|string_format:"%.2f"} | {translate item='global.views'}: {$answers[i].viewnumber} |
            {insert name=comment_count assign=commentcount vid=$answers[i].VID}
            {translate item='global.comments'}:{$commentcount} </p>
          </div>
          <div class="otherdesc">
              <p> {$answers[i].filehome}
            {translate item='global.broadcast'}: {$answers[i].type} Video <br/>
            {translate item='global.status'}: <a href="{seourl rewrite='help' url='help.php'}">Live!</a><br/>
            <input value="{$baseurl}/view_video.php?viewkey={$answers[i].vkey}" name="video_link" /><br/>
            {translate item='global.share_text'}</p>
          </div>
        </div>
         {/section}
		 <div id="paging">
			<div class="pagingnav">
			  {$page_link}
			</div>
		  </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <div id="rightside">
    <div id="login">
      <div id="login-title">{translate item='global.share_video'}</div>
      <div id="login-content">
        <div class="arrow-general">&nbsp;</div>
        <a href="{seourl rewrite='invite' url='invite_friends.php'}">{translate item='global.share'}</a> </div>
    </div>
  </div>
<div class="clear"></div>
{else}
<p>There is no video found</p>
{/if}