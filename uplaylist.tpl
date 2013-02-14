{php}    
	function insert_removeTag($array){
    	$tag = $array["tag"];
        $text = $array["text"];
        return str_replace($tag," ",$text);
    }
{/php}
{insert name=id_to_name assign=uname un=$smarty.request.UID}
  <div id="leftside">
    <div id="myvideo">
      <div id="myvideo-title">
	  	<div class="titlepage">{translate item='global.playlists'} {$uname}</div>
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
                         <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}"><img height=90 src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width=120>
                		</a>
                          <div class="button">
                          </div>            
                      </div>
                      <div >
                          <p> <strong><a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">{$answers[i].title}</a></strong><br />
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
          	{insert name=removeTag assign=pageLink tag="<BR>" text=$page_link}
      		{insert name=removeTag assign=pageLink tag="&nbsp;" text=$pageLink	}
      		{$pageLink}
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
    <br/>
    <div id="login">
      <div id="login-title">{translate item='global.my_tags'}</div>
      <div id="login-content">
        <div class="arrow-general">&nbsp;</div>
      	<div class="listtgs">  
        {section name=k loop=$mytags}
         <a href="{seourl rewrite="tags/`$tags[k]`" url="search_result.php?search_id=`$vtags[k]`"}">{$mytags[k]}</a>
        {/section}
        </div>
      </div>
    </div>
  </div>
<div class="clear"></div>
