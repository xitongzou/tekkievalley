     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $topic}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_topic" method="POST" enctype="multipart/form-data" action="groups.php?m=topicedit&TID={$topic[0].TID}">
        <fieldset>
        <legend>Editing Topic</legend>
            <label for="title">Title: </label>
            <textarea name="title" rows="10">{$topic[0].title|wordwrap:75:"\n":true}</textarea><br>            
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_topic" value="Update Topic" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
        {/if}
     </div>