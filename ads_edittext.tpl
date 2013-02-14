     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_adv" method="POST" action="ads.php?m=edittext&AID={$adv.adv_id}">
        <fieldset>
        <legend>Add Text Advertise</legend>
            <label for="name">Name: </label>
            <input name="adv_title" type="text" value="{$adv.title}" class="large"><br />
            <label for="desc">Description: </label>
            <input name="adv_desc" type="text" value="{$adv.descr}" class="large"><br />
            <label for="url">Url: </label>
            <input name="adv_url" type="text" value="{$adv.adv_url}" class="large"><br />
            <label for="status">Status: </label>
            <select name="adv_status">
            <option value="1"{if $adv.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $adv.status == '0'} selected="selected"{/if}>Inactive</optio>
            </select>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="adv_edit" value="Update Text Advertise" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>