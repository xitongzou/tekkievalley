  <div id="leftside">
    <div id="myfriends">
      <div id="myfriends-title">
        <div class="titlepage"> {translate item='menu.friends'} </div>
    	<div class="videopaging"> {$start_num}-{$end_num} {translate item='global.of'} {$total}</div>
      </div>
      <div id="myfriends-content">
          <div class="arrow-general">&nbsp;</div> 
		  {if $total_friends eq "0"}
		    <p>You have not invited any friends or family at this time! <a href="{seourl rewrite='invite' url='invite_friends.php'}">Invite</a> your friends and family to start sharing videos today!</p>
		  {else} 
		  {if $smarty.request.view ne "" and $smarty.request.view ne "All"} 
		    <a href="friends.php?del_list={$smarty.request.view}" onclick="javascript: confirm('Are you sure you want to delete this contact group?')">delete list</a> 
		  {/if}  
		  {section name=i loop=$friends} 
          {insert name=id_to_photo assign=photo un=$friends[i].FID}
          {assign var=looprecord value=$smarty.section.i.index}
          {if $looprecord%2 eq 0}{assign var=colorLoop value=""}{else}{assign var=colorLoop value=" blue"}{/if} 
		  <div class="friendlist {$colorLoop}">
              <div class="friendspict"><img src="{$photourl}/{if $photo eq ""}nopic.gif{else}{$photo}{/if}" border="0" width=60 height=45 /></div>
              <div class="friendstat" style="margin-left: 85px;">
		          <p><strong>{if $friends[i].friends_status eq "Confirmed"}<a href="{seourl rewrite="users/`$friends[i].friends_name`" url="uprofile.php?UID=`$friends[i].FID`"}">{$friends[i].friends_name}</a>{else}{$friends[i].friends_name}{/if}</strong></p>                    
				  {if $friends[i].friends_status eq "Confirmed"}
				      {insert name=video_count assign=video uid=$friends[i].FID}
					  {insert name=favour_count assign=favour uid=$friends[i].FID}
					  {insert name=friends_count assign=frnd uid=$friends[i].FID}
					  {insert name=id_to_name assign=uname un=$friends[i].FID}
					  <p>
                          <span class="video">{if $video ne "0" and $video ne ""}<a href="{seourl rewrite="users/`$uname`/videos/public" url="uvideos.php?UID=`$friends[i].FID`"}">{$video}</a>{else}0{/if}</span>
					      <span class="flag">{if $favour ne "0"}<a href="{seourl rewrite="users/`$uname`/favorites" url="ufavour.php?UID=`$friends[i].FID`"}">{$favour}</a>{else}0{/if}</span>
					      <span class="people">{if $frnd ne "0"}<a href="{seourl rewrite="users/`$uname`/friends" url="ufriends.php?UID=`$friends[i].FID`"}">{$frnd}</a>{else}0{/if}</span>
					  </p>
				  {/if}
				  {insert name=showlist assign=showlist id=$friends[i].id}
				  <p>
				      Lists: {$showlist} <br/>
					  Status: {$friends[i].friends_status} <br/>
					  {if $friends[i].friends_status eq "Pending"}({$friends[i].invite_date|date_format:"%B %e, %Y"}){/if}
                  </p>
              </div>
          </div>          
          {/section}
          {/if} 
    </div>
    <div class="clear"></div>
  </div>
</div>
<div id="rightside">
  <div id="login">
    <div id="login-title">Share Video</div>
    <div id="login-content">
      <div class="arrow-general">&nbsp;</div>
      <a href="{seourl rewrite='invite' url='invite_friends.php'}">Share your videos with friends!</a> </div>
  </div>
</div>
</div>
<div class="clear"></div>
