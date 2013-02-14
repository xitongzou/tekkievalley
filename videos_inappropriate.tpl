     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="videos.php?m=inappropriate">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
                <td align="right">Description:</td><td><input type="text" name="description" value="{$option.description}"></td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="VID"{if $option.sort == 'VID'} selected="selected"{/if}>VID</option>
                    <option value="req"{if $option.sort == 'req'} selected="selected"{/if}>Requests</option>
                    <option value="date"{if $option.sort == 'date'} selected="selected"{/if}>Request Date</option>
                    <option value="title"{if $option.sort == 'title'} selected="selected"{/if}>Title</option>
                    <option value="type"{if $option.sort == 'type'} selected="selected"{/if}>Type</option>
                    <option value="duration"{if $option.sort == 'duration'} selected="selected"{/if}>Duration</option>
                    <option value="addate"{if $option.sort == 'addate'} selected="selected"{/if}>Date</option>
                    <option value="viewnumber"{if $option.sort == 'viewnumber'} selected="selected"{/if}>Views</option>
                    <option value="fav_num"{if $option.sort == 'fav_num'} selected="selected"{/if}>Favorites</option>
                    <option value="com_num"{if $option.sort == 'com_num'} selected="selected"{/if}>Comments</option>
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
                    <input type="submit" name="search_videos" value=" -- Search -- " class="button">
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
                <td align="center"><b>Title</b></td>
                <td align="center"><b>Active</b></td>
                <td align="center"><b>Total Requests</b></td>
                <td align="center"><b>Last Request Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $videos}
            {section name=i loop=$videos}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$videos[i].VID}</td>
                <td align="center">
                    <a href="videos.php?m={$module}&a=view&VID={$videos[i].VID}">{$videos[i].title}<br><br>
                    <img src="{$tmburl}/{$videos[i].thumb}_{$videos[i].VID}.jpg"></a>
                </td>
                <td align="center">
                    <b>{if $videos[i].active == 1}yes{else}no{/if}</b><br>
                    Views: {$videos[i].viewnumber}<br>
                    Favorites: {$videos[i].fav_num}<br>
                    Comments: {$videos[i].com_num}<br>
                </td>
                <td align="center">{$videos[i].req}</td>
                <td align="center">{$videos[i].date|date_format}</td>
                <td align="center">
                    <a href="videos.php?m=view&VID={$videos[i].VID}">View</a><br>
                    <a href="videos.php?m=edit&VID={$videos[i].VID}">Edit</a><br>
                    <a href="videos.php?m=inappropriate&a=delete&VID={$videos[i].VID}">Delete Request</a><br>
                    <a href="videos.php?m=inappropriate&a=delete_video&VID={$videos[i].VID}">Delete Video</a><br>
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