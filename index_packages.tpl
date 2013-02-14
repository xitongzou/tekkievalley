     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_packages" method="POST" action="index.php?m=packages">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="pack_id"{if $option.sort == 'pack_id'} selected="selected"{/if}>ID</option>
                    <option value="space"{if $option.sort == 'space'} selected="selected"{/if}>Space</option>
                    <option value="bandwidth"{if $option.sort == 'bandwidth'} selected="selected"{/if}>Bandwidth</option>
                    <option value="price"{if $option.sort == 'price'} selected="selected"{/if}>Price</option>
                    <option value="video_limit"{if $option.sort == 'video_limit'} selected="selected"{/if}>Video Limit</option>
                    <option value="period"{if $option.sort == 'period'} selected="selected"{/if}>Period</option>
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
                    <input type="submit" name="search_packages" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Space</b></td>
                <td align="center"><b>Bandwidth</b></td>
                <td align="center"><b>Price</b></td>
                <td align="center"><b>Video Limit</b></td>
                <td align="center"><b>Period</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $packages}
            {section name=i loop=$packages}
            <tr {if $packages[i].is_trial == 'yes'}bgcolor="#F8F8F8"{else}bgcolor="{cycle values="#F8F8F8,#F2F2F2"}{/if}">
                <td align="center">{$packages[i].pack_id}</td>
                <td align="center"><a href="index.php?m=packageview&PID={$packages[i].pack_id}">{$packages[i].pack_name}</a></td>
                <td align="center">{insert name=format_size size=$packages[i].space}</td>
                <td align="center">{insert name=format_size size=$packages[i].bandwidth}</td>
                <td align="center">{if $packages[i].is_trial == 'yes'}No{else}{$packages[i].price}{/if}</td>
                <td align="center">{if $packages[i].video_limit == '0'}No{else}{$packages[i].video_limit}{/if}</td>
                <td align="center">{if $packages[i].is_trial == 'yes'}{$packages[i].trial_period} days{else}{$packages[i].period}{/if}</td>
                <td align="center"><b>{$packages[i].status}</b></td>
                <td align="center">
                    <a href="index.php?m=packageview&PID={$packages[i].pack_id}">View</a><br>
                    <a href="index.php?m=packageedit&PID={$packages[i].pack_id}">Edit</a><br>
                    {if $packages[i].is_trial != 'yes'}
                    <a href="index.php?m=packages&a=delete&PID={$packages[i].pack_id}" onClick="javascript:return confirm('Are you sure you want to delete this package?');">Delete</a><br>
                    {/if}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO PACKAGES AVAILABLE</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>