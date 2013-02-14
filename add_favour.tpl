<div id="leftside">
  <div id="groups">
    <div id="groups-title">
     <div class="titlepage">
      <a href="{$baseurl}/groups_home.php?urlkey={$smarty.request.urlkey}">{$gname}</a> Add Videos
      </div>
	  <div class="videopaging">Videos {$start_num}-{$end_num} of {$total}</div>
    </div>
    <div id="groups-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {if $total gt "0"}
      	    
          {section name=i loop=$answers}
          
          {assign var=looprecord value=$smarty.section.i.index}
            {if $looprecord%2 eq 0}
                {assign var=colorLoop value=""}	
            {else}
                {assign var=colorLoop value=" blue "}	
            {/if}
          <div class="group {$colorLoop}">
            <div class="groupthumb">
            <a href="{$baseurl}/view_video.php?viewkey={$answers[i].vkey}">
                    <IMG height=90 src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width=120>
            </a>
            <br />
              <div class="button">
                <br/>
              </div>
            </div>
            <div class="groupdesc">
              <p>
                <strong>
                  <a href="{$baseurl}/view_video.php?viewkey={$answers[i].vkey}">{$answers[i].title}</a>
                </strong>
                <br/>
                Tags //
                    {insert name=video_keyword assign=tags vid=$answers[i].VID}
                    {section name=j loop=$tags}
                    <a href="{$baseurl}/search_result.php?search_id={$tags[j]}">{$tags[j]}</a>
                    {/section}	
                <br/>
                {insert name=time_to_date assign=todate tm=$answers[i].addtime}
                Added: {$todate}<br />
                Runtime: {$answers[i].duration|string_format:"%.2f"} | Views: {$answers[i].viewnumber} |
                {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                Comments: {$commentcount}  | Fans: 0
              <p>
                 <form name="addVideoForm" action="{$baseurl}/add_favour.php?urlkey={$smarty.request.urlkey}&gid={$smarty.request.gid}" method="POST">
                  	<input type="hidden" value="{$answers[i].VID}" name="VID">
                    <div class="button">
                        <input type="hidden" value="Add to Group" name="add_video" />
                        <input type="image" src="images/btn_addvideo.gif" alt="Add Video"  />
                    </div>
                </form>
              </p>
            </div>
          </div>
          {/section}
		{else}
			<p>There is no video found</p>
		{/if}
    </div>
    <div class="clear">
    </div>
  </div>
  <div id="paging">
    		<div class="pagingnav">
            {$page_link}
    		</div>
  		</div>
</div>
<div id="rightside">
  <div id="login">
    <div id="login-title">
    	Share videos
    </div>
    <div id="login-content">
      <div class="arrow-general">
        &nbsp;
      </div> 
      <a href="{seourl rewrite='invite' url='invite_friends.php'}">Share your videos with friends!</a>
    </div>
  </div>
  <br/>
  <div id="login">
    <div id="login-title">
    	My Tags
    </div>
    <div id="login-content">
      <div class="arrow-general">
        &nbsp;
      </div> 
      {section name=i loop=$tags}
        <a href="{$baseurl}/search_result.php?search_id={$tags[i]}">{$tags[i]}
</a>
        {/section}
    </div>
  </div>
</div>
<div class="clear">
</div>
