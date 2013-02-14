     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>{if $specific}Emailing: {$username}{else}Send Email{/if}</h2>
        <div id="simpleForm">
        <form name="email_user" method="POST" action="users.php?m=mail">
        <input name="username" type="hidden" value="{$username}">
        <fieldset>
        <legend>Email Information</legend>
            {if $specific}
            <label for="email" style="width: 20%;">To: </label>
            <input type="text" name="email" value="{$email}" class="large"><br>
            {else}
            <label for="username" style="width: 20%;">Username: </label>
            <input type="text" name="username" value="{$username}" class="large">&nbsp Enter <b>all</b> for all users!<br>
            {/if}
            <label for="subject" style="width: 20%;">Subject: </label>
            <input type="text" name="subject" value="{$subject}" class="large"><br>
        </fieldset>
        <br>
        {$editor}
        <div style="text-align: center;">
            <input type="submit" name="send_email" value="Send Email" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>