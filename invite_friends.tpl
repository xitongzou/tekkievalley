<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">{translate item='invite.invite'}</div>
    <div id="fullbox-content">
      <div class="arrow-general">&nbsp;</div>
      <div class="contentbox">
        <p> {translate item='invite.info_one'} {$site_name} {translate item='invite.info_two'} </p>
        <form action="{seourl rewrite='invite' url='invite_friends.php'}" method="post">
          <div class="fm-req">
            <label for="fm-group_name">{translate item='invite.fname'}:</label>
            {if $first_name eq ""}
            <input maxlength="60" size="30" name="first_name" value="{$first_name}" class="fullboxtext" />
            {else}
		    <input type="hidden" name="first_name" value="{$first_name}">
		    {$first_name}
	    {/if} 
	  </div>
          <div class="fm-req">
            <label for="fm-group_name"> {if $smarty.request.UID eq ""}{translate item='invite.emails'}:{else}{translate item='invite.send_to'}:{/if} </label>
            {if $smarty.request.UID eq ""}
            <textarea id="recipients" name="recipients"  class="fullboxtext" >{$smarty.request.recipients}</textarea>
            <p>{translate item='invite.emails_info'}</p>
            {else}
            <input type="hidden" name="UID" value="{$smarty.request.UID}" />
            {insert name=id_to_name assign=uname un=$smarty.request.UID}
            {$uname}
            {/if} </div>
          {translate item='invite.message'}:<br>
          
          {if $smarty.request.UID eq ""}
          {translate item='invite.hello'},
          {else}
          {insert name=id_to_name assign=uname un=$smarty.request.UID}
          {translate item='invite.hello'} {$uname},
          {/if}
          <p> {$site_name} {translate item='invite.message_one'} {$site_name} {translate item='invite.message_two'} </p>
          <div class="fm-opt">
            <label for="fm-message">{translate item='invite.message_from'} </label>
            <textarea name="message" class="fullboxtext" >{translate item='invite.message_three'} {$site_name}{translate item='invite.message_four'}</textarea>
          </div>
		  <p>
          {translate item='invite.message_five'} <br />
          {if $first_name eq ""}{translate item='invite.message_six'}{else}{$first_name}{/if}
		  </p>
		  	<div class="submitbutton">
				<input type="hidden" value="Send Invite" name="action_invite" />
				<input type="image" src="images/btn_invite.gif" name="Send Invite"/>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<div class="clear"> </div>
