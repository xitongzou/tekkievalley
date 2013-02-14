     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_package" method="POST" action="index.php?m=packageedit&PID={$package[0].pack_id}">
        <fieldset>
        <legend>Editing: {$package[0].pack_name}</legend>
            <input type="hidden" name="is_trial" value="{if $package[0].is_trial == 'yes'}yes{else}no{/if}">
            <label for="pack_id">Package ID: </label>
            <input type="text" name="pack_id" value="{$package[0].pack_id}" readonly="readonly" class="small"><br>
            <label for="name">Package Name: </label>
            <input type="text" name="name" value="{$package[0].pack_name}" class="large"><br>
            <label for="desc">Description: </label>
            <textarea name="desc" rows="5">{$package[0].pack_desc}</textarea><br>
            <label for="space">Space: </label>
            <input type="text" name="space" value="{$package[0].space}" class="smallplus">&nbsp;<b>MB</b><br>
            <label for="bandwidth">Bandwidth: </label>
            <input type="text" name="bandwidth" value="{$package[0].bandwidth}" class="smallplus">&nbsp;<b>MB</b><br>
            {if $package[0].is_trial != 'yes'}
            <label for="price">Price: </label>
            <input type="text" name="price" value="{$package[0].price}" class="small">&nbsp;<b>$</b><br>
            {/if}
            <label for="video_limit">Video Limit: </label>
            <input type="text" name="video_limit" value="{$package[0].video_limit}" class="smallplus">&nbsp;Leave blank or 0 for unlimited upload!<br>
            {if $package[0].is_trial != 'yes'}
            <label for="period">Subscription Period: </label>
            <select name="period">
            <option value="Month"{if $package[0].period == 'Month'} selected="selected"{/if}>Month</option>
            <option value="Year"{if $package[0].period == 'Year'} selected="selected"{/if}>Year</option>
            </select><br>
            {else}
            <label for="trial_period">Trial Period: </label>
            <input name="trial_period" type="text" value="{$package[0].trial_period}" class="small">&nbsp;<b>days</b><br>
            {/if}
            <label for="status">Status: </label>
            <select name="status">
            <option value="Active"{if $package[0].status == 'Active'} selected="selected"{/if}>Active</option>
            <option value="Inactive"{if $package[0].status == 'Inactive'} selected="selected"{/if}>Inactive</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_package" value="Update Package" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>