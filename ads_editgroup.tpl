     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_adv_group" method="POST" action="ads.php?m=editgroup&AGID={$adv_group[0].advgrp_id}">
        <fieldset>
        <legend>Editing Group: {$adv_group[0].advgrp_name}</legend>
            <label for="adv_width">Width: </label>
            <input name="adv_width" type="text" value="{$adv_group[0].advgrp_width}"><br>
            <label for="adv_height">Height: </label>
            <input name="adv_height" type="text" value="{$adv_group[0].advgrp_height}"><br>
            <label for="adv_rotate">Rotating: </label>
            <select name="adv_rotate">
            <option value="1"{if $adv_group[0].advgrp_rotate == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $adv_group[0].advgrp_rotate == '0'} selected="selected"{/if}>No</option>
            </select><br />
            <label for="adv_status">Status: </label>
            <select name="adv_status">
            <option value="1"{if $adv_group[0].advgrp_status == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $adv_group[0].advgrp_status == '0'} selected="selected"{/if}>No</option>
            </select>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_adv_group" value="Update Advertise Group" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>