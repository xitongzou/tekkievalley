     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="groups.php?m=members&GID={$gid}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Email:</td><td><input type="text" name="email" value="{$option.email}"></td>
                <td align="right">Country:</td><td><input type="text" name="country" value="{$option.country}"></td>
            </tr>
            <tr>
                <td align="right">Full Name:</td><td><input type="text" name="name" value="{$option.name}"></td>
                <td align="right">Gender:</td>
                <td>
                    <select name="gender">
                    <option value=""{if $option.gender == ''} selected="selected"{/if}>------</option>
                    <option value="male"{if $option.gender == 'male'} selected="selected"{/if}>Male</option>
                    <option value="female"{if $option.gender == 'female'} selected="selected"{/if}>Female</option>
                    </select>
                </td>
                <td align="right">Relation:</td>
                <td>
                    <select name="relation">
                    <option value=""{if $option.relation == ''} selected="selected"{/if}>--------</option>
                    <option value="Single"{if $option.relation == 'Single'} selected="selected"{/if}>Single</option>
                    <option value="Taken"{if $option.relation == 'Taken'} selected="selected"{/if}>Taken</option>
                    <option value="Open"{if $option.relation == 'Open'} selected="selected"{/if}>Open</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="UID"{if $option.sort == 'UID'} selected="selected"{/if}>UID</option>
                    <option value="username"{if $option.sort == 'username'} selected="selected"{/if}>Username</option>
                    <option value="email"{if $option.sort == 'email'} selected="selected"{/if}>Email</option>
                    <option value="addtime"{if $option.sort == 'addtime'} selected="selected"{/if}>Joined</option>
                    <option value="logintime"{if $option.sort == 'logintime'} selected="selected"{/if}>Last Login</option>
                    <option value="country"{if $option.sort == 'country'} selected="selected"{/if}>Country</option>
                    <option value="gender"{if $option.sort == 'gender'} selected="selected"{/if}>Gender</option>
                    <option value="video_viewed"{if $option.sort == 'video_viewed'} selected="selected"{/if}>Videos Viewed</option>
                    <option value="profile_viewed"{if $option.sort == 'profile_viewed'} selected="selected"{/if}>Profile Viewed</option>
                    <option value="watched_video"{if $option.sort == 'watched_video'} selected="selected"{/if}>Watched Videos</option>
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
        <div style="width: 100%; text-align: center;">Members in <b>{$group_name}</b></div>
        {if $total_users >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Username</b></td>
                <td align="center"><b>Country</b></td>
                <td align="center"><b>Join/Last Login Date</b></td>
                <td align="center"><b>Videos</b></td>
                {if $enable_package == 'yes' }
                <td align="center"><b>Package</b></td>
                {/if}
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $users}
            {section name=i loop=$users}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$users[i].UID}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$users[i].UID}">{$users[i].username}<br><br>
                    <img src="../photo/{if $users[i].photo == ''}nopic.gif{else}{$users[i].photo}{/if}" width="70"></a>
                </td>
                <td align="center">{$users[i].country}</td>
                <td align="center">
                    {$users[i].addtime|date_format}<br>
                    {$users[i].logintime|date_format}
                </td>
                <td align="center">
                {insert name=video_count assign=vdo uid=$users[i].UID}
                Owns: <a href="videos.php?m=all&UID={$users[i].UID}">{$vdo}</a><br>
                Viewed: {$users[i].watched_video}<br>
                Views: {$users[i].video_viewed}<br>
                </td>
                {if $enable_package == 'yes'}
                <td align="center">
                {insert name=subscriber_info assign=pack uid=$users[i].UID}
                {$pack.pack_name}
                </td>
                {/if}
                <td align="center">{$users[i].account_status}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$users[i].UID}">View</a><br>
                    <a href="users.php?m=edit&UID={$users[i].UID}">Edit</a><br>
                    <a href="users.php?m={$module}&a=delete&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to delete this user?');">Delete</a><br>
                    <a href="groups.php?m=members&a=remove&GID={$gid}&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to remove user from group?');">Remove</a><br>
                    <a href="users.php?m=mail&email={$users[i].email}&username={$users[i].username}">Email</a>
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
        {if $total_users >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>