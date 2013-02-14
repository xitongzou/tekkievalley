     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_package" method="POST" action="index.php?m=packageadd">
        <fieldset>
        <legend>Add Package</legend>
            <label for="name">Package Name: </label>
            <input type="text" name="name" value="{$package.name}" class="large"><br>
            <label for="desc">Description: </label>
            <textarea name="desc" rows="5">{$package.desc}</textarea><br>
            <label for="space">Space: </label>
            <input type="text" name="space" value="{$package.space}" class="smallplus">&nbsp;<b>MB</b><br>
            <label for="bandwidth">Bandwidth: </label>
            <input type="text" name="bandwidth" value="{$package.bandwidth}" class="smallplus">&nbsp;<b>MB</b><br>
            <label for="price">Price: </label>
            <input type="text" name="price" value="{$package.price}" class="small">&nbsp;<b>$</b><br>
            <label for="video_limit">Video Limit: </label>
            <input type="text" name="video_limit" value="{$package.limit}" class="smallplus">&nbsp;Leave blank or 0 for unlimited upload!<br>
            <label for="period">Subscription Period: </label>
            <select name="period">
            <option value="Month"{if $package.period == 'Month'} selected="selected"{/if}>Month</option>
            <option value="Year"{if $package.period == 'Year'} selected="selected"{/if}>Year</option>
            </select><br>
            <label for="status">Status: </label>
            <select name="status">
            <option value="Active"{if $package.status == 'Active'} selected="selected"{/if}>Active</option>
            <option value="Inactive"{if $package.status == 'Inactive'} selected="selected"{/if}>Inactive</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_package" value="Add Package" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>