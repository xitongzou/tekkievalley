{insert name=id_to_name assign=uname un=$smarty.request.UID}
  <div id="leftside">
    <div id="myvideo">
      <div id="myvideo-title">
	  	<div class="titlepage">{$gname} {translate item='global.videos'}</div>
		<div class="videopaging">{translate item='global.videos'} {$start_num}-{$end_num} {translate item='global.of'} {$total}</div>
	  </div>
      <div id="myvideo-content">
        <div class="arrow-general">&nbsp;</div>
        {if $is_mem eq "" and $type eq "private"}
            <div align="center">
                    Sorry! You are not allowed to view this private group.
            </div>
        {else}
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
                         <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">
	                		<img height=90 src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width=120>
                		</a>
                      <div class="button">
                        {insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$smarty.request.gid}
                        {if $smarty.session.UID eq $owner_id and $answers[i].approved eq "no"}
                        <form action="{seourl rewrite="group/`$smarty.request.urlkey`/videos/`$smarty.request.gid`" url="gvideos.php?urlkey=`$smarty.request.urlkey`&gid=`$smarty.request.gid`"}" method="POST">
                            <input type="hidden" name="VID" value="{$answers[i].VID}">
                            <input type="hidden" name="approve_it" value="Approve It" >
                        	<input type="image" src="{$imgurl}/btn_approve.gif" alt="Approve It">
                        </form>
                        {/if} 
                        {if $smarty.session.UID eq $owner_id}
                        <form action="{seourl rewrite="group/`$smarty.request.urlkey`/videos/`$smarty.request.gid`" url="gvideos.php?urlkey=`$smarty.request.urlkey`&gid=`$smarty.request.gid`"}" method="POST" onsubmit="javascript: return confirm('Are you sure to delete this video from the group?');">
                            <input type="hidden" name="VID" value="{$answers[i].VID}">
                            <input type="hidden" name="remove_image" value="Remove From Group">
                            <input type="image" src="{$imgurl}/btn_remove.gif" alt="Remove From Group">
                        </form>
                        <form action="{seourl rewrite="group/`$smarty.request.urlkey`/videos/`$smarty.request.gid`" url="gvideos.php?urlkey=`$smarty.request.urlkey`&gid=`$smarty.request.gid`"}" method="POST">
                        	<input type=hidden name=VID value={$answers[i].VID}>
                        	{if $gimage eq "owner_only"}
                        	<input type="hidden" name="group_image" value="Make Default Image" >
                            <input type="image" src="{$imgurl}/btn_deafult_image.gif" alt="Make Default Image">
                        	{/if}
                        </form>
                       	{/if}
                      </div>
            
                      </div>
                      <div class="maindesc">
                          <p> <strong><a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}">{$answers[i].title|escape:'html'}</a></strong><br />
                        {$answers[i].description|escape:'html'}<br />
                        {translate item='global.tags'} //
                        {insert name=video_keyword assign=tags vid=$answers[i].VID}
                        {section name=j loop=$tags} <a href="{seourl rewrite="tags/`$tags[j]`" url="search_result.php?search_id=`$tags[j]`"}">{$tags[j]|escape:'html'}</a> {/section} <br/>
                        {insert name=time_to_date assign=todate tm=$answers[i].addtime}
                        {translate item='global.added'}: {$todate}<br/>
                        {translate item='global.runtime'}: {$answers[i].duration|string_format:"%.2f"} | Views: {$answers[i].viewnumber} |
                        {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                        {translate item='global.comments'}:{$commentcount} </p>
                      </div>
                      <div class="otherdesc">
                          <p> {$answers[i].filehome}
                        {translate item='global.type'}: {$answers[i].type} Video <br/>
                        {translate item='global.status'}: <a href="{$baseurl}/help.php">Live!</a><br/>
                        <input value="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`" clean=$answers[i].title}" name="video_link" 	/><br/>
                        {translate item='global.share_text'}</p>
                      </div>
                    </div>
                     {/section}
                {else}
                    <p>There is no video found</p>
                {/if}
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
