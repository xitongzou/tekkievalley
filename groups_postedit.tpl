     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $post}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_post" method="POST" enctype="multipart/form-data" action="groups.php?m=postedit&PID={$post[0].PID}">
        <fieldset>
        <legend>Editing Message</legend>
            <label for="message">Title: </label>
            <textarea name="message" rows="10">{$post[0].post|wordwrap:75:"\n":true}</textarea><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_post" value="Update Post" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
        {/if}
     </div>