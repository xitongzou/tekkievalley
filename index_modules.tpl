     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Modules Configuration</h2>
        <div id="simpleForm">
        <form name="mail_settings" method="POST" action="index.php?m=modules">
        <fieldset>
        <legend>Mail Settings</legend>
            <label for="video_module" style="width: 40%;">Video Module (Watch Menu): </label>
            <select name="video_module">
            <option value="1"{if $video_module == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video_module == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="upload_module" style="width: 40%;">Upload Module (Upload Menu): </label>
            <select name="upload_module">
            <option value="1"{if $upload_module == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $upload_module == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="groups_module" style="width: 40%;">Groups Module (Groups Menu): </label>
            <select name="groups_module">
            <option value="1"{if $groups_module == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $groups_module == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="friends_module" style="width: 40%;">Friends Module (Friends Menu): </label>
            <select name="friends_module">
            <option value="1"{if $friends_module == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $friends_module == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="community_module" style="width: 40%;">Community Module (Community Menu): </label>
            <select name="community_module">
            <option value="1"{if $community_module == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $community_module == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="channels_module" style="width: 40%;">Channels Module (Channels Menu): </label>
            <select name="channels_module">
            <option value="1"{if $channels_module == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $channels_module == '0'} selected="selected"{/if}>No</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_modules" value="Update Modules Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>