  <div id="leftside">
    <div id="myvideo">
      <div id="myvideo-title">
	  	<div class="titlepage">{translate item='my_favour.my_favorites'}</div>
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
                     <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}"><img class="moduleEntryThumb" height="90" src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width="120" /></a><br>                    
                  <div class="button">
                    {if $smarty.session.UID ne ""}
                        <form name="USERFAVOUR" method="post" action="{seourl rewrite='my_favorites' url='my_favour.php'}">
                        <input type="hidden" name="rvid" value="{$answers[i].VID}">
                        <input type="hidden" name="removfavour" value="Remove Favorite">
                        <input type="image" src="{$imgurl}/btn_remove.gif" onclick="return confirm('Are you sure you want to remove this favorite video?');" alt="Remove Video" />
                        </form>
                    {/if} 
                  </div>
        
                  </div>
                  <div class="maindesc">
                      <p> <strong><a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">{$answers[i].title|escape:'html'}</a></strong><br />
                    {$answers[i].description}<br />
                    {translate item='global.tags'} //
                    {insert name=video_keyword assign=tags vid=$answers[i].VID}
                    {section name=j loop=$tags} <a href="{seourl rewrite="tags/`$tags[j]`" url="search_result.php?search_id=`$tags[j]`"1}"> {$tags[j]} </a> {/section} <br/>
                    {insert name=time_to_date assign=todate tm=$answers[i].addtime}
                    {translate item='global.added'}: {$todate}<br/>
                    {translate item='global.runtime'}: {$answers[i].duration|string_format:"%.2f"} | Views: {$answers[i].viewnumber} |
                    {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                    {translate item='global.comments'}:{$commentcount} </p>
                  </div>
                  <div class="otherdesc">
                      <p> {$answers[i].filehome}
                    {translate item='global.broadcast'}: {$answers[i].type} Video <br/>
                    {translate item='global.status'}: <a href="{seourl rewrite='help' url='help.php'}">Live!</a><br/>
                    <input value="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title|escape:'html'}" name="video_link" /><br/>
                    {translate item='global.share_text'} </p>
                  </div>
                </div>
                 {/section}
                 
			{else}
            	<p>{translate item='my_favour.no_favorites'}</p>
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
