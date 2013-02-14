     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="ads.php?m=media">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="adv_id"{if $option.sort == 'adv_id'} selected="selected"{/if}>ID</option>
                    <option value="title"{if $option.sort == 'title'} selected="selected"{/if}>Title</option>
                    <option value="descr"{if $option.sort == 'descr'} selected="selected"{/if}>Description</option>
                    <option value="duration"{if $option.sort == 'duration'} selected="selected"{/if}>Duration</option>
                    <option value="addtime"{if $option.sort == 'addtime'} selected="selected"{/if}>Date</option>
                    <option value="views"{if $option.sort == 'views'} selected="selected"{/if}>Views</option>
                    <option value="clicks"{if $option.sort == 'clicks'} selected="selected"{/if}>Clicks</option>
                    <option value="status"{if $option.sort == 'status'} selected="selected"{/if}>Status</option>
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
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_media" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $advs_total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Title</b></td>
                <td align="center"><b>Description</b></td>
                <td align="center"><b>Url</b></td>
                <td align="center"><b>Duration</b></td>
                <td align="center"><b>Views</b></td>
                <td align="center"><b>Clicks</b></td>
                <td align="center"><b>ClickRate</b></td>
                <td align="center"><b>Add Date</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $advs}
            {section name=i loop=$advs}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$advs[i].adv_id}</td>
                <td align="center">{$advs[i].title|escape:'html'}</td>
                <td align="center">{$advs[i].descr|escape:'html'}</td>
                <td align="center"><a href="{$advs[i].adv_url}">{$advs[i].adv_url|escape:'html'}</a></td>
                <td align="center">{$advs[i].duration}</td>
                <td align="center">{$advs[i].views}</td>
                <td align="center">{$advs[i].clicks}</td>
                <td align="center">{math equation="(( x * y ) / z )" x=$advs[i].views y=$advs[i].clicks z=100 format="%.2f"}</td>
                <td align="center">{$advs[i].addtime|date_format}</td>
                <td align="center"><b>{if $advs[i].status == '1'}Active{else}Suspended{/if}</b></td>
                <td align="center">
                    <a href="ads.php?m=editmedia&AID={$advs[i].adv_id}">Edit</a><br>
                    <a href="ads.php?m=media&a=delete&AID={$advs[i].adv_id}" onClick="javascript:return confirm('Are you sure you want to delete this advertising media?');">Delete</a><br>
                    {if $advs[i].status == '1'}
                    <a href="ads.php?m=media&a=suspend&AID={$advs[i].adv_id}" onClick="javascript:return confirm('Are you sure you want to suspend this advertising media?');">Suspend</a>
                    {else}
                    <a href="ads.php?m=media&a=activate&AID={$advs[i].adv_id}" onClick="javascript:return confirm('Are you sure you want to activate this advertising media?');">Activate</a>
                    {/if}
                    <br>
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
        {if $advs_total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>