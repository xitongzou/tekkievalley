     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Send Email To All Users</h2>
        <div id="simpleForm">
        <form name="email_users" method="POST" action="users.php?m=mailall">
        <fieldset>
        <legend>Email Information</legend>
            <label for="subject" style="width: 20%;">Subject: </label>
            <input type="text" name="subject" value="{$subject}" class="large"><br>
        </fieldset>
        <br>
        {$editor}
        <div style="text-align: center;">
            <input type="submit" name="email_users" value="Send Email" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>