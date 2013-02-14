     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_bans" method="POST" action="index.php?m=bans">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">IP:</td><td><input type="text" name="ip" value="{$option.ip}"></td>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="ban_id"{if $option.sort == 'ban_id'} selected="selected"{/if}>ID</option>
                    <option value="ban_ip"{if $option.sort == 'ban_ip'} selected="selected"{/if}>IP</option>
                    <option value="ban_date"{if $option.sort == 'ban_date'} selected="selected"{/if}>Date</option>
                    </select>
                </td>
                <td align="right">Order</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td align="right">Display</td>
                <td>
                    <select name="display">
                    <option value="10"{if $option.display == '10'} selected="selected"{/if}>10</option>
                    <option value="20"{if $option.display == '20'} selected="selected"{/if}>20</option>
                    <option value="30"{if $option.display == '30'} selected="selected"{/if}>30</option>
                    <option value="40"{if $option.display == '40'} selected="selected"{/if}>40</option>
                    <option value="50"{if $option.display == '50'} selected="selected"{/if}>50</option>
                    <option value="100"{if $option.display == '100'} selected="selected"{/if}>100</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="8" align="center" valign="bottom">
                    <input type="submit" name="search_bans" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        <div id="searchForm"><!-- this is not standards compliant, but it works!!! --!>
            <form name="add_ban" method="POST" action="index.php?m=bans&a=add">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">IP:</td><td><input type="text" name="add_ip" value=""></td>
                <td colspan="2" align="center" valign="bottom">
                    <input type="submit" name="add_ban" value=" -- Add Ban -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>IP</b></td>
                <td align="center"><b>Username</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $bans}
            {section name=i loop=$bans}
            {insert name=user_byip assign=uname ip=$bans[i].ban_ip}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$bans[i].ban_id}</td>
                <td align="center">{$bans[i].ban_ip}</td>
                <td align="center">{$uname}</td>
                <td align="center">{$bans[i].ban_date}</td>
                <td align="center">
                    <a href="index.php?m=bans&a=delete&BID={$bans[i].ban_id}" onClick="javascript:return confirm('Are you sure you want to remove this ban?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>