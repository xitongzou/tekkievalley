<div id="fullside">
    <div id="fullbox">
      <div id="fullbox-title">Friend Accepted </div>
      <div id="fullbox-content">
        <div class="arrow-general">&nbsp;</div>
        <div class="contentbox">
{if $AID ne ""}
{insert name=id_to_name assign=uname un=$UID}
<p>Friend Invitation from <strong>{$uname}</strong> </p>
<p>Accept thisinvitation if you know this user and wish to share videos with each other.</p>

User: <a href="{$baseurl}/uprofile.php?UID={$smarty.session.UID}">{$smarty.session.USERNAME}
</a>

<form action="{$baseurl}/friend_accept.php" method="post">
<input type="hidden" value="150E0406E61EE03D" name="friend_link_id" />

<input type="hidden" value="{$AID}" name="AID" />
<input type="hidden" value="Yes, I want to share videos." name="friend_accept" />
<input type="image" src="images/btn_yesiwantshare.gif" alt="Yes, I want to share videos." />
</form>

<form onsubmit="return confirm('Are you sure you want to deny this friend request?');"
action="{$baseurl}/friend_accept.php" method="post">
<input type="hidden" value="{$AID}" name="AID" />
<input type="hidden" value="No thanks." name="friend_deny" />
<input type="image" src="images/btn_nothanks.gif" alt="No Thanks" />
</form>
{/if}
		</div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
<div class="clear">
</div>
