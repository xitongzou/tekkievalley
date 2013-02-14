     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_comment" method="POST" action="videos.php?m=commentedit&COMID={$COMID}">
        <fieldset>
        <legend>Comment Text</legend>
            <textarea name="comment" rows="10" class="adv">{$comment}</textarea><br>    
        </fieldset>
        <div align="center">
            <input type="submit" name="edit_comment" value="Update Comment" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>