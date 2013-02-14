     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Session Settings</h2>
        <div id="simpleForm">
        <form name="session_settings" method="POST" action="index.php?m=sessions">
        <fieldset>
        <legend>Session Settings</legend>
            <label for="session_driver">Session Driver: </label>
            <select name="session_driver">
            <option value="files"{if $session_driver == 'files'} selected="selected"{/if}>Files</option>
            <option value="database"{if $session_driver == 'database'} selected="selected"{/if}>Database</option>
            </select><br>
            <label for="session_lifetime">Session Lifetime: </label>
            <input type="text" name="session_lifetime" value="{$session_lifetime}" class="smallplus"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_sessions" value="Update Session Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>