     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_channel" method="POST" enctype="multipart/form-data" action="channels.php?m=edit&CID={$channel[0].CHID}">
        <fieldset>
        <legend>Editing: {$channels[0].name}</legend>
            <label for="name">Channel Name: </label>
            <input type="text" name="name" value="{$channel[0].name}" class="large"><br>
            <label for="desc">Channel Description: </label>
            <textarea name="desc">{$channel[0].descrip}</textarea><br>
        </fieldset>
        <fieldset>
        <legend>Channel Image</legend>
            <label for="current">Current Image: </label>
            <img src="{$baseurl}/chimg/{$channel[0].CHID}.jpg" style="margin-left: 1%;"><br>
            <label for="picture">Channel Image: </label>
            <input name="picture" type="file"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_channel" value="Update Channel" class="button">
            <input type="button" name="cancel" value="Cancel" class="button" onClick="window.location='channels.php'">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>