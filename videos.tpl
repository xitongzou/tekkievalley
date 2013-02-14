     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="videos.php?m={$module}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
                <td align="right">Description:</td><td><input type="text" name="description" value="{$option.description}"></td>
            </tr>
            <tr>
                <td align="right">Keyword:</td><td><input type="text" name="keyword" value="{$option.keyword}"></td>
                <td align="right">Channel:</td>
                <td>
                    <select name="channel">
                    {insert assign=channels name=list_channel}
                    <option value="">Select Channel</option>
                    {section name=i loop=$channels}
                    <option value="{$channels[i].id}"{if $channels[i].id == $option.channel } selected="selected"{/if}>{$channels[i].ch}</option>
                    {/section}
                    </select>                                                                                            
                </td>
                <td align="right">Featured:</td>
                <td>
                    <select name="featured">
                    <option value="">---</option>
                    <option value="yes"{if $option.featured == 'yes'} selected="selected"{/if}>Yes</option>
                    <option value="no"{if $option.featured == 'no'} selected="selected"{/if}>No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="VID"{if $option.sort == 'VID'} selected="selected"{/if}>VID</option>
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
                    <input type="submit" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_videos >= 1}
        <form name="video_select" method="post" id="video_select" action="videos.php?m=videos&m={$module}&page={$page}">
        <div id="actions">
            <input type="submit" name="delete_selected_videos" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected videos?');">
            {if $approve == '1'}
            <input type="submit" name="suspend_selected_videos" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected videos?');">
            <input type="submit" name="approve_selected_videos" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected videos?');">
            {/if}
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_videos" type="checkbox" id="video_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Title</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Active</b></td>
                <td align="center"><b>Type</b></td>
                <td align="center"><b>Duration</b></td>
                <td align="center"><b>Featured</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $videos}
            {section name=i loop=$videos}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="video_id_checkbox_{$videos[i].VID}" id="video_checkbox_{$videos[i].VID}" type="checkbox"></td>
                <td align="center">{$videos[i].VID}</td>
                <td align="center">
                    <a href="videos.php?m=view&VID={$videos[i].VID}">{$videos[i].title|escape:'html'}<br><br>
                    <img src="{$tmburl}/{$videos[i].thumb}_{$videos[i].VID}.jpg"></a>
                </td>
                <td align="center">
                    {insert name=id_to_name assign=uname un=$videos[i].UID}
                    <a href="users.php?m=view&UID={$videos[i].UID}">{$uname}</a>
                </td>
                <td align="center">
                    <b>{if $videos[i].active == 1}yes{else}no{/if}</b><br>
                    Views: {$videos[i].viewnumber}<br>
                    Favorites: {$videos[i].fav_num}<br>
                    Comments: <a href="videos.php?m=comments&VID={$videos[i].VID}">{$videos[i].com_num}</a><br>
                </td>
                <td align="center">{$videos[i].type}</td>
                <td align="center">{$videos[i].duration|string_format:"%.2f"}</td>
                <td align="center"><b>{$videos[i].featured}</b></td>
                <td align="center">{$videos[i].adddate|date_format}</td>
                <td align="center">
                    <a href="videos.php?m=view&VID={$videos[i].VID}">View</a><br>
                    <a href="videos.php?m=edit&VID={$videos[i].VID}">Edit</a><br>
                    {if $videos[i].featured == 'yes'}
                    <a href="videos.php?m={$module}&a=unfeature&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to unfeature this video?');">Unfeature</a><br>
                    {else}
                    <a href="videos.php?m={$module}&a=feature&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to unfeature this video?');">Feature</a><br>
                    {/if}
                    <a href="videos.php?m={$module}&a=delete&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to delete this video?');">Delete</a><br>
                    {if $approve == '1'}
                    {if $videos[i].active == '1'}
                    <a href="videos.php?m={$module}&a=suspend&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to suspend this video?');">Suspend</a>
                    {else}
                    <a href="videos.php?m={$module}&a=activate&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to approve this video?');">Activate</a>
                    {/if}
                    <br>
                    {/if}
                    {if $videos[i].embed_code == ''}
                    <a href="videos.php?m={$module}&a=regenthumbs&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to regenerate thumbs for this video?');">Thumbs</a>
                    {/if}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
            </form>
        </div>
        {if $total_videos >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>