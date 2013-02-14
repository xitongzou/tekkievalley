     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_adv" method="POST" action="ads.php?m=addbanner">
        {if $adv.text != ''}
        <fieldset>
        <legend>Preview:</legend>
        <div style="width: 100%; text-align: center;">{$adv.text}</div>
        </fieldset>
        {/if}
        <fieldset>
        <legend>Add Banner</legend>
            <label for="name">Name: </label>
            <input name="adv_name" type="text" value="{$adv.name}"><br>            
            <label for="group">Group: </label>
            <select name="adv_group">
            <option value="0"{if $adv.group == '0'} selected="selected"{/if}>Select Group</option>
            {section name=i loop=$advgroups}
            <option value="{$advgroups[i].advgrp_id}"{if $adv.group == $advgroups[i].advgrp_id} selected="selected"{/if}>{$advgroups[i].advgrp_name}</option>
            {/section}
            </select><br>
            <label for="code">Code: </label>
            <textarea name="adv_text" rows="10">{$adv.text}</textarea><br>
            <label for="status">Status: </label>
            <select name="adv_status">
            <option value="1"{if $adv.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $adv.status == '0'} selected="selected"{/if}>Inactive</optio>
            </select>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="adv_add" value="Add Advertise Banner" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>