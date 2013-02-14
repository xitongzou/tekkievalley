     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_advertise" method="POST" action="index.php?m=advertise">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="adv_id"{if $option.sort == 'adv_id'} selected="selected"{/if}>ID</option>
                    <option value="adv_name"{if $option.sort == 'adv_name'} selected="selected"{/if}>Name</option>
                    <option value="adv_status"{if $option.sort == 'adv_status'} selected="selected"{/if}>Status</option>
                    </select>
                </td>
                <td align="right">Order</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td colspan="2" align="center">
                    <input type="submit" name="search_advertise" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        <div id="right">
            <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $ads}
            {section name=i loop=$ads}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$ads[i].adv_id}</td>
                <td align="center"><a href="index.php?m=advertiseedit&AID={$ads[i].adv_id}">{$ads[i].adv_name}</a></td>
                <td align="center"><b>{$ads[i].adv_status}</b></td>
                <td align="center">
                    <a href="index.php?m=advertiseedit&AID={$ads[i].adv_id}">Edit</a><br>
                    {if $ads[i].adv_status == 'Active'}
                    <a href="index.php?m=advertise&a=suspend&AID={$ads[i].adv_id}">Suspend</a>
                    {else}
                    <a href="index.php?m=advertise&a=activate&AID={$ads[i].adv_id}">Activate</a>
                    {/if}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO ADS FOUND</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>