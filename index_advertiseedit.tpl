     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_adv" method="POST" action="index.php?m=advertiseedit&AID={$adv[0].adv_id}">
        <fieldset>
        <legend>Preview: {$adv[0].adv_name}</legend>
            <div align="center">{$adv[0].adv_text}</div>
        </fieldset>
        <fieldset>
        <legend>Editing: {$adv[0].adv_name}</legend>
            <textarea name="code" rows="20" class="adv">{$adv[0].adv_text}</textarea><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_advertise" value="Update Advertise" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>