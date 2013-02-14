     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_advertise" method="POST" action="ads.php?m=banner">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="a.adv_id"{if $option.sort == 'a.adv_id'} selected="selected"{/if}>ID</option>
                    <option value="a.adv_name"{if $option.sort == 'a.adv_name'} selected="selected"{/if}>Name</option>
                    <option value="a.adv_status"{if $option.sort == 'a.adv_status'} selected="selected"{/if}>Status</option>
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
                <td align="center"><b>Group</b></td>
                <td align="center"><b>Stats</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $advs}
            {section name=i loop=$advs}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$advs[i].adv_id}</td>
                <td align="center"><a href="ads.php?m=editbanner&AID={$advs[i].adv_id}">{$advs[i].adv_name}</a></td>
                <td align="center"><a href="ads.php?m=editgroup&AGID={$advs[i].adv_group}">{$advs[i].advgrp_name}</a></td>                
                <td align="center">
                    Views: <b>{$advs[i].adv_views}</b>
                </td>
                <td align="center"><b>{if $advs[i].adv_status == '1'}Active{else}Inactive{/if}</b></td>
                <td align="center">
                    <a href="ads.php?m=editbanner&AID={$advs[i].adv_id}">Edit</a><br>
                    {if $advs[i].adv_status == '1'}
                    <a href="ads.php?m=banner&a=suspend&AID={$advs[i].adv_id}">Suspend</a>
                    {else}
                    <a href="ads.php?m=banner&a=activate&AID={$advs[i].adv_id}">Activate</a>
                    {/if}
                    <br>
                    <a href="ads.php?m=banner&a=delete&AID={$advs[i].adv_id}">Delete</a>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO ADVERTISE BANNERS FOUND FOUND</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>