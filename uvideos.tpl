  <div id="leftside">
    <div id="myvideo">
      <div id="myvideo-title">
	  	<div class="titlepage">{if $smarty.request.type eq "private"}{translate item='global.private_videos'}{else}{translate item='global.public_videos'}{/if} {$uname}</div>
		<div class="videopaging">{translate item='global.videos'} {$start_num}-{$end_num} {translate item='global.of'} {$total}</div>
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
                         <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}"><img height=90 src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width=120></a>
                      <div class="button">                      
                      </div>
                      </div>
                      <div class="maindescwithoutborder">
                          <p> <strong><a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">{$answers[i].title|escape:'html'}</a></strong><br />
                        {$answers[i].description}<br />
                        {translate item='global.tags'} //
                        {insert name=video_keyword assign=tags vid=$answers[i].VID}
                        {section name=j loop=$tags} <a href="{seourl rewrite="tags/`$tags[j]`" url="search_result.php?search_id=`$tags[j]`"}"> {$tags[j]} </a> {/section} <br/>
                        {insert name=time_to_date assign=todate tm=$answers[i].addtime}
                        {translate item='global.added'}: {$todate}<br/>
                        {translate item='global.runtime'}: {$answers[i].duration|string_format:"%.2f"} | {translate item='global.views'}: {$answers[i].viewnumber} |
                        {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                        {translate item='global.comments'}:{$commentcount} 
                        <br/>
                        {insert name=show_rate assign=vrate rte=$answers[i].rate}{$vrate}
                        </p>
                      </div> 
                    </div>
                     {/section}
                {else}
                    <p>{translate item='global.video_not_found'}</p>
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
      <div id="login-title">Share Video</div>
      <div id="login-content">
        <div class="arrow-general">&nbsp;</div>
        <a href="{seourl rewrite='invite' url='invite_friends.php'}">{translate item='global.share'}</a> </div>
    </div>
    <br/>
    <div id="login">
      <div id="login-title">{translate item='global.my_tags'}</div>
      <div id="login-content">
        <div class="arrow-general">&nbsp;</div>
        {section name=k loop=$vtags}
         <a href="{seourl rewrite="tags/`$vtags[k]`" url="search_result.php?search_id=`$vtags[k]`"}">{$vtags[k]}</a>
        {/section}</div>
    </div>
  </div>
<div class="clear"></div>
