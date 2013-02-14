<div id="fullside">
	<div id="fullbox">
		<div id="fullbox-title">
		{translate item='mail.messages'} {translate item='mail.details'}
		</div>
			<div id="fullbox-content">
  				<div class="arrow-general">&nbsp;</div>
			  <div class="inbox">
			  	<div>{translate item='mail.sender'}: <a href="{seourl rewrite="users/`$sender`" url="uprofile.php?UID=`$userid`"}">{$sender}</a></div>
                <div>{insert name=member_img UID=$userid} </div>
				<div>{translate item='mail.subject'}: {$subject}</div>
				<div>{translate item='mail.details'}: {$body}</div>
				<div><a href="compose.php?receiver={$sender}&subject=Re: {$subject}">Reply</a></div>
                <div>{translate item='mail.sent_info'}:{$date|date_format:"%A, %B %e, %Y"} at {$date|date_format:"%I:%M:%S %p"}</div>
			  </div>
			</div>
  	</div>
</div>	
<div class="clear"></div>