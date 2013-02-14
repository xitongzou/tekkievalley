     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Send Email To All Users</h2>
        <div id="simpleForm">
        <form name="email_group" method="POST" action="groups.php?m=mail">
        <fieldset>
        <legend>Email Information</legend>
            <label for="group" style="width: 20%;">Group: </label>
            <select name="group">
            <option value="">Select Group</option>
            {insert name=group_select gid=$group}
            </select><br>
            <label for="subject" style="width: 20%;">Subject: </label>
            <input type="text" name="subject" value="{$subject}" class="large"><br>
        </fieldset>
        <br>
        {$editor}
        <div style="text-align: center;">
            <input type="submit" name="email_group" value="Send Email" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>