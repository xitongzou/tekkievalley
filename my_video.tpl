  <div id="leftside">
    <div id="myvideo">
      <div id="myvideo-title">
	  	<div class="titlepage">{translate item='menu.my_videos'}</div>
		<div class="videopaging">{translate item='global.videos'} {$start_num} -{$end_num} {translate item='global.of'} {$total}</div>
	  </div>
      <div id="myvideo-content">
        <div class="arrow-general">&nbsp;</div>
		{if $total gt "0"}
        {section name=i loop=$answers}
		{assign var=looprecord value=$smarty.section.i.index}
		{if $looprecord%2 eq 0}
			{assign var=colorLoop value=""}	
		{else}
			{assign var=colorLoop value="blue"}	
		{/if}
        <div class="myvideo {$colorLoop}">
          <div class="videothumb"> 
             <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}"><img class="moduleEntryThumb" height="90" src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width="120" /> </a>
            <div class="button">
            <form action="{seourl rewrite="video/edit/`$answers[i].VID`" url="my_vdo_edit.php?VID=`$answers[i].VID`"}" method="post" name="editVideoForm" id="editVideoForm">
              <input type="hidden" value="{$answers[i].VID}" name="VID" />
              <input type="hidden" value="Edit Video" name="Edit Video" />
              <input type="image" src="{$imgurl}/btn_edit.gif" alt="Edit Video"/>
            </form>
          </div>
          <div class="button">
            <form action="{seourl rewrite='my_videos' url='my_video.php'}" method="post" name="removeVideoForm" id="removeVideoForm">
              <input type="hidden" value="1" name="action_removevideo" />
              <input type="hidden" value="{$answers[i].VID}" name="VID" />
              <input type="hidden" value="Remove Video" name="remove_video" />
              <input type="image" src="{$imgurl}/btn_remove.gif" onclick="return confirm('Are you sure you want to remove this video?');" alt="Remove Video" />
            </form>
          </div>
          </div>
          <div class="maindesc">
              <p> <strong><a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">{$answers[i].title|escape:'html'}</a></strong><br />
            {$answers[i].description|wordwrap:55:"<br />":true}<br />
            {translate item='global.tags'} //
            {insert name=video_keyword assign=tags vid=$answers[i].VID}
            {section name=j loop=$tags} <a href="{seourl rewrite="tags/`$tags[j]`" url="search_result.php?search_id=`$tags[j]`"}"> {$tags[j]} </a> {/section} <br/>
            {insert name=time_to_date assign=todate tm=$answers[i].addtime}
            {translate item='global.added'}: {$todate}<br/>
            {translate item='global.runtime'}: {$answers[i].duration|string_format:"%.2f"} | {translate item='global.views'}: {$answers[i].viewnumber} |
            {insert name=comment_count assign=commentcount vid=$answers[i].VID}
            {translate item='global.comments'}:{$commentcount} </p>
          </div>
          <div class="otherdesc">
              <p> {$answers[i].filehome}
            {translate item='global.broadcast'}: {$answers[i].type} Video <br/>
            Status: <a href="{seourl rewrite='help' url='help.php'}">Live!</a><br/>
            <input value="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}" name="video_link" /><br/>
            {translate item='global.share_text'} </p>
          </div>
        </div>
         {/section}
        {else}
        <p>There is no video found</p>
        {/if}
      </div>
      <div class="clear"></div>
    </div>
    <div id="paging">
			<div class="pagingnav">
			  {$page_link}
			</div>
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
