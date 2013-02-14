     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="groups.php?m=topics&GID={$gid}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
                <td></td><td></td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="TID"{if $option.sort == 'TID'} selected="selected"{/if}>TID</option>
                    <option value="title"{if $option.sort == 'title'} selected="selected"{/if}>Title</option>
                    <option value="addtime"{if $option.sort == 'addtime'} selected="selected"{/if}>Add Date</option>
                    <option value="approved"{if $option.sort == 'approved'} selected="selected"{/if}>Approved</option>
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
        <div style="width: 100%; text-align: center;">Topics in <b>{$group_name}</b></div>
        {if $total_topics >= 1}
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
                <td align="center"><b>Author</b></td>
                <td align="center"><b>Video</b></td>
                <td align="center"><b>Posts</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Approved</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $topics}
            {section name=i loop=$topics}
            {insert name=id_to_name assign=uname un=$topics[i].UID}
            {insert name=post_count assign=total_posts TID=$topics[i].TID}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$topics[i].TID}</td>
                <td align="center" width="30%"><a href="groups.php?m=posts&TID={$topics[i].TID}&GID={$gid}">{$topics[i].title|escape:'html'}</a></td>
                <td align="center"><a href="users.php?m=view&UID={$topics[i].UID}"><b>{$uname}</b></td>
                <td align="center">
                    {if $topics[i].VID != '0'}
                    {insert name=video_title assign=video vid=$topics[i].VID}
                    <a href="videos.php?m=view&VID={$topics[i].VID}">{$title[0].title|escape:'html'}<br>
                    <img src="{$baseurl}/thumb/{$video[0].thumb}_{$topics[i].VID}.jpg"></a>
                    {else}
                    <b>No Video Attached!</b>
                    {/if}
                </td>
                <td align="center">{$total_posts}</td>
                <td align="center">{$topics[i].addtime|date_format}</td>
                <td align="center"><b>{$topics[i].approved}</b></td>
                <td align="center">
                    <a href="groups.php?m=topicedit&TID={$topics[i].TID}">Edit</a><br>
                    <a href="groups.php?m=topics&a=delete&TID={$topics[i].TID}&GID={$gid}" onClick="javascript:return confirm('Are you sure you want to delete this topic?');">Delete</a><br>
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
        {if $total_topics >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>