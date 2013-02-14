     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_channel" method="POST" enctype="multipart/form-data" action="channels.php?m=add">
        <fieldset>
        <legend>Add Channel</legend>
            <label for="name">Channel Name: </label>
            <input type="text" name="name" value="{$channel.name}" class="large"><br>
            <label for="desc">Channel Description: </label>
            <textarea name="desc">{$channe.desc}</textarea><br>
            <label for="picture">Channel Image: </label>
            <input name="picture" type="file"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_channel" value="Add Channel" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>