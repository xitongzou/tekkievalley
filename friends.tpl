  <div id="leftside">
    {insert name=advertise assign=adv group='friends_top'}
    {$adv}
    <div id="myfriends">
      <div id="myfriends-title">
        <div class="titlepage">{translate item='friends.contacts'} {if $smarty.request.view eq ""}{translate item='friends.overview}{else}{$smarty.request.view}{/if}</div>
    	<div class="videopaging"> 
				{if $smarty.request.sort ne "name"}
                    {translate item='friends.sort'} : <a href="{seourl rewrite="userfriends/name/`$page`" url="friends.php?sort=name"}">{translate item='friends.sort_name'}</a> |
                    <b>{translate item='friends.sort_date'}</b> {else} <b>{translate item='friends.sort_name'}</b> | <a href="{seourl rewrite="userfriends/date/`$page`" url="friends.php"}">{translate item='friends.sort_date'}</a> 
				{/if} 
		</div>
      </div>
      <div id="myfriends-content">
      <div class="arrow-general">&nbsp;</div>
      
        <form id="friendsForm" name="friendsForm" method="post">
          <input type="hidden" name="action_name" id="action_name" />
          <input type="hidden" name="view" />
          <input type="hidden" value="t" name="sort" />
          <input type="hidden" value="1" name="page" />
			{if $total_friends eq "0"}
			<p>{translate item='friends.invite_one'} <a href="{seourl rewrite='invite' url='invite_friends.php'}">{translate item='global.invite'}</a> {translate item='friends.invite_two'}</p>
			{else} 
			{if $smarty.request.view ne "" and $smarty.request.view ne "All"} 
			<a href="friends.php?del_list={$smarty.request.view}" onclick="javascript: confirm('{translate item='friends.delete_contact'}')">{translate item='friends.delete_list'}</a> 
			{/if} 
			<div class="dropdownviewnav">
				{translate item='friends.view'}:
				<select onchange="javascript: document.location.href='{$baseurl}/friends.php?view='+this.value;" name="view">
				{$ftype_ops}
				</select>    
				<b>{if $total ne "0"}{$link}{/if}</b>
			</div>
				{section name=i loop=$friends}
                {insert name=id_to_name assign=uname un=$friends[i].FID}
                {insert name=id_to_photo assign=photo un=$friends[i].FID}
                {assign var=looprecord value=$smarty.section.i.index}
                {if $looprecord%2 eq 0}
                    {assign var=colorLoop value=""}	
                {else}
                	{assign var=colorLoop value=" blue"}	
                {/if} 
				<div class="friendlist {$colorLoop}">
            	<div class="friendspict">
					<img width=60 height=45 src="{$baseurl}/photo/{if $photo eq ""}nopic.gif{else}{$photo}{/if}" boder="0" />
                </div>
                <div class="friendstat">
					<p>
                    <input id="AID[]" type="checkbox" value="{$friends[i].id}" name="AID[]" />
					<strong>
                    {if $friends[i].friends_status eq "Confirmed"} 
						<a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$friends[i].FID`"}">{$uname}</a> 
					{else}
						{$uname}
					{/if}
                    </strong>
                    {if $friends[i].friends_status eq "Pending"}
						 - {$friends[i].invite_date|date_format:"%B %e, %Y"}
					{/if}
					</p>
                    
					{if $friends[i].friends_status eq "Confirmed"}
						{insert name=video_count assign=video uid=$friends[i].FID}
						{insert name=favour_count assign=favour uid=$friends[i].FID}
						{insert name=friends_count assign=frnd uid=$friends[i].FID}
						
						<p><span class="video">{if $video ne "0" and $video ne ""}<a href="{seourl rewrite="users/`$uname`/videos/public"  url="uvideos.php?UID=`$friends[i].FID`"}">{$video}</a>{else}0{/if}</span>
						<span class="flag">{if $favour ne "0"}<a href="{seourl rewrite="users/`$uname`/favorites" url="ufavour.php?UID=`$friends[i].FID`"}">{$favour}</a>{else}0{/if}</span>
						<span class="people">{if $frnd ne "0"}<a href="{seourl rewrite="users/`$uname`/friends" url="ufriends.php?UID=`$friends[i].FID`"}">{$frnd}</a>{else}0{/if}</span>
						</p>
					{/if}
					{insert name=showlist assign=showlist id=$friends[i].id}
					<p>
					{translate item='friends.list'}: {$showlist} <br/>
					{translate item='friends.status'}: {$friends[i].friends_status} <br/>
                    </p>
                </div>
                </div>          
          		{/section}
                <div class="friendsaction">
            		<div class="selectaction">
                    <select id="action" onchange="doAction(this.value)" name="action">{$action_ops}</select>
                    <a href="javascript:createNewList();">{translate item='friends.list_new'}</a>
                    </div> 
                </div>
        	 {/if}
			</form>
    </div>
    <div class="clear"></div>
  </div>
  {if $total ne '0'}
  <div id="paging">
        <div class="pagingnav">
    		{$browse}
        </div>
      </div>
  {/if}
</div>
<div id="rightside">
  <div id="login">
    <div id="login-title">{translate item='global.share_video'}</div>
    <div id="login-content">
      <div class="arrow-general">&nbsp;</div>
      <a href="{seourl rewrite='invite' url='invite_friends.php'}">{translate item='global.share'}</a> </div>
  </div>
  {insert name=advertise assign=adv group='friends_right'}
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
</div>
</div>
<div class="clear"></div>
