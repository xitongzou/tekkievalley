     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_advertise" method="POST" action="ads.php?m=groups">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="advgrp_id"{if $option.sort == 'advgrp_id'} selected="selected"{/if}>ID</option>
                    <option value="advgrp_name"{if $option.sort == 'advgrp_name'} selected="selected"{/if}>Name</option>
                    <option value="advgrp_status"{if $option.sort == 'advgrp_status'} selected="selected"{/if}>Status</option>
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
                <td align="center"><b>Size</b></td>
                <td align="center"><b>Rotate</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $advgroups}
            {section name=i loop=$advgroups}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$advgroups[i].advgrp_id}</td>
                <td align="center"><a href="ads.php?m=editgroup&AGID={$advgroups[i].advgrp_id}">{$advgroups[i].advgrp_name}</a></td>
                <td align="center"><b>{$advgroups[i].adv_width}</b>x<b>{$advgroups[i].adv_height}</b></td>
                <td align="center"><b>{if $advgroups[i].advgrp_rotate == '1'}yes{else}no{/if}</b></td>
                <td align="center"><b>{if $advgroups[i].advgrp_status == '1'}Active{else}Inactive{/if}</b></td>
                <td align="center">
                    <a href="ads.php?m=editgroup&AGID={$advgroups[i].advgrp_id}">Edit</a><br>
                    {if $advgroups[i].advgrp_status == '1'}
                    <a href="ads.php?m=groups&a=suspend&AGID={$advgroups[i].advgrp_id}">Suspend</a>
                    {else}
                    <a href="ads.php?m=groups&a=activate&AGID={$advgroups[i].advgrp_id}">Activate</a>
                    {/if}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO ADVERTISE GROUPS FOUND</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>