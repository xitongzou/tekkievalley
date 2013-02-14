<div id="fullside">
 <form action="invite_members.php?urlkey={$smarty.request.urlkey}" id="fform" name="fform" method="post" onsubmit="return false;">
    <div id="invitnewfriend">
      <div id="invitefriend-title">Invite Friends to {$gname}</div>
      <div id="invitefriend-content">
        <div class="arrow-general">&nbsp;</div>
        <div class="contentbox">
			 	<input type="hidden" name="send" value="send" class="fullboxtext" />
                <div id='friends_div'></div>
                <table width="100%">
                  <tr>
                    <td align="center"><select name='myfriends' id='myfriends' size="10" style="width:200px;">
                        {$fname}
                      </select>
                    </td>
                    <td align="center"><input type='button' name='add_all' value='Add All &gt;&gt;' style="width:120px;" onclick='invite_mem_addall();' />
                      <br />
                      <br />
                      <input type='button' name='add' value='Add &gt;' style="width:120px;" onclick='invite_mem_add();' />
                      <br />
                      <br />
                      <input type='button' name='remove' value='&lt; Remove' style="width:120px;" onclick='invite_mem_remove();' />
                      <br />
                      <br />
                      <input type='button' name='remove_all' value='&lt;&lt; Remove All' style="width:120px;" onclick='invite_mem_removeall();' />
                      <br />
                      <br />
                    </td>
                    <td align="center"><select name='invitefriends' id='invitefriends' size="10" style="width:200px;" class="inputtext" >
                      </select>
                    </td>
                  </tr>
                </table>
			  
		</div>
      </div>
    </div>
    <br/>
    <div id="invitenewfriend">
      <div id="invitenewfriend-title">Invite New Friends To {$gname}</div>
      <div id="invitenewfriend-content">
        <div class="arrow-general">&nbsp;</div>
        <div class="contentbox">
        	<div class="fm-req">
			 	 <label for="fm-recipients"> Enter Email Addresses separated by Commas:</label><br/>
        		 <textarea name="recipients" id="fm-recipients" class="fullboxtext" >{$smarty.request.recipients}</textarea>		
            </div>     
            
            <p>Subject: {$smarty.session.USERNAME} has invited you to join {$site_name} group {$gname}</p>
            <div class="fm-req">
				 <label for="fm-message">Enter your message below,</label><br/>
            	 <textarea name="message" id="fm-message" class="fullboxtext" >{$smarty.request.message}</textarea>
            </div>
 			<p>Thanks,  {if $first_name eq ""}[your first name]{else}{$first_name}{/if}</p>	
            <div class="submitbutton">
            <input type="hidden" value="Send" name="action_invite" onclick="invite_mem_send();" />
            <img src="images/btn_invitemembers.gif" onclick="invite_mem_send();" alt="Send Invitation"  />
            </div>  
		</div>
      </div>
    </div>
    </form>
  </div>
  <div class="clear"></div>
<div class="clear">
</div>