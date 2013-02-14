{include file=err_msg.tpl}
<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">{translate item='mail.messages'} // {translate item='mail.details'}</div>
    <div id="fullbox-content">
      <div class="arrow-general">&nbsp;</div>
      <div class="contentbox">
       <form action="{seourl rewrite='compose' url='compose.php'}" method="POST">
          <div class="fm-req">
            <label for="fm-receiver">{translate item='mail.to'}:</label>
            <input type="text" name="receiver" maxlength="40" value="{$smarty.request.receiver}" id="fm-receiver" class="inputtext" />
           </div>
           {if $buddy_name}
		   <div class="fm-opt">
          	<label for="fm-buddyname">{translate item='global.of'}</label>
           	 <select name="buddy_name" id="fm-buddyname" class="inputtext">{html_options values=$buddy_name output=$buddy_name selected=$receiver_name}</select>
        	</div>
            {/if}
			<div class="fm-req">
          	<label for="fm-subject">{translate item='mail.subject'}</label>
           	 <input type="text" name="subject" value="{$smarty.request.subject}" maxlength="200" size="50" id="fm-subject"  class="inputtext"/>
        	</div>
			<div class="fm-req">
          	<label for="fm-detail">{translate item='mail.detail'}</label>
           	 <textarea name="details" class="inputtext" id="fm-detail">{$smarty.request.details}</textarea>
        	</div>
			 <div class="signupbutton">
			 	<input type="hidden" name="send" value="Send">
				<input type="image" src="{$imgurl}/btn_sendmsg.gif" alt="Send Email" />
			  </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<div class="clear"> </div>
