<div id="leftside">
  <div id="groups">
    <div id="groups-title">
     <div class="titlepage">
      <a href="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}">{$gname|escape:'html'}</a> Members
      </div>
	  <div class="videopaging">Members {$start_num}-{$end_num} of {$total}</div>
    </div>
    <div id="groups-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {if $total gt "0"}      	    
        {insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$smarty.request.gid}
        {assign var=countrecord value=0}            	
        {section name=i loop=$friends}
        {if $smarty.session.UID eq $owner_id or $friends[i].approved eq 'yes'}
            {assign var=looprecord value=$countrecord}
            {if $looprecord%2 eq 0}
                {assign var=colorLoop value=""}	
            {else}
                {assign var=colorLoop value=" blue "}	
            {/if}        	
        	{assign var=countrecord value=($countrecord+1)}          
              <div class="group {$colorLoop}">
                <div class="groupthumb">
                {insert name=member_img UID=$friends[i].MID}
                <br />
                  <div class="button">
                  {if $owner_id == $smarty.session.UID}
                  {if $owner_id != $friends[i].MID}
                  {if $friends[i].approved == 'yes'}
                  <form name="remove_member" method="POST" action="{seourl rewrite="group/`$smarty.request.urlkey`/members/`$smarty.request.gid`" url="gmembers.php?urlkey=`$smarty.request.urlkey`&gid=`$smarty.request.gid`"}">
                  <input type="hidden" name="MID" value="{$friends[i].MID}">
                  <input type="hidden" name="remove_mem" value="Remove Member">
                  <input type="image" src="{$imgurl}/btn_remove.gif" alt="Delete"  />
                  </form>
                  {else}
                  <form name="approve_member" method="POST" action="{seourl rewrite="group/`$smarty.request.urlkey`/members/`$smarty.request.gid`" url="gmembers.php?urlkey=`$smarty.request.urlkey`&gid=`$smarty.request.gid`"}">
                  <input type="hidden" name="MID" value="{$friends[i].MID}">
                  <input type="hidden" name="approve_mem" value="Approve Member">
                  <input type="image" src="{$imgurl}/btn_approve.gif" alt="Approve"  />
                  </form>                  
                  {/if}
                  {/if}
                  {/if}
                  </div>
                </div>
                <div class="groupdesc">
                  <p>
                    <strong>
                      {insert name=id_to_name assign=uname un=$friends[i].MID}
                      <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$friends[i].MID`"}">{$uname}</a>
                    </strong>
                    {insert name=video_count assign=video uid=$friends[i].MID}
                    {insert name=favour_count assign=favour uid=$friends[i].MID}
                    {insert name=friends_count assign=frnd uid=$friends[i].MID}
                    <br/>
                     <p><span class="video">{if $video ne "0" and $video ne ""}<a href="{seourl rewrite="users/`$uname`/videos/public" url="uvideos.php?UID=`$friends[i].MID`"}">{$video}</a>{else}0{/if}</span>
                        <span class="flag">{if $favour ne "0"}<a href="{seourl rewrite="users/`$uname`/favorites" url="ufavour.php?UID=`$friends[i].MID`"}">{$favour}</a>{else}0{/if}</span>
                        <span class="people">{if $frnd ne "0"}<a href="{seourl rewrite="users/`$uname`/friends" url="ufriends.php?UID=`$friends[i].MID`"}">{$vfrnd}</a>{else}0{/if}</span>
                      </p>  
                  </p>
                </div>
              </div>
          {/if}
          <div class="clear"></div>
          {/section}
		{else}
			<p>There is no members found</p>
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
      <a href="{seourl rewrite='invite' url='invite_friends.php'}">Share your
        videos with friends!</a>
    </div>
  </div>
   
</div>
<div class="clear">
</div>
