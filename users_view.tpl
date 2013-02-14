     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $user}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="80%">
                <h2>User Information</h2>
                <table width="100%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>User ID</b></td>
                    <td>{$user[0].UID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Username</b></td>
                    <td><b>{$user[0].username}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>email</b></td>
                    <td>{$user[0].email}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Full Name</b></td>
                    <td>{$user[0].fname} {$user[0].lname}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Gender</b></td>
                    <td>{$user[0].gender}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Birth Date</b></td>
                    <td>{$user[0].bdate|date_format}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>City</b></td>
                    <td>{$user[0].city}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Country</b></td>
                    <td>{$user[0].country}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Last IP</b></td>
                    <td>{$user[0].user_ip} {if $user[0].user_ip != ''}<a href="index.php?m=bans&a=add&ip={$user[0].user_ip}" onClick='Javascript:return confirm("Are you sure you want to ban this user?");'><b>Ban User</b></a>{/if}</td>
                </tr>
                {if $enable_package == 'yes'}
                <tr><td colspan="2">&nbsp;</td></tr>
                {insert name=subscriber_info assign=pack uid=$user[0].UID}
                <tr class="view">
                    <td valign="top"><b>Package</b></td>
                    <td><a href="index.php?m=packageview?pack_id={$pack.pack_id}&page=">{$pack.pack_name}</a></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Used Space</b></td>
                    <td>{insert name=format_size size=$pack.used_space}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Used Bandwidth</b></td>
                    <td>{insert name=format_size size=$pack.used_bw}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Uploaded Videos</b></td>
                    <td>{$pack.total_video}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Expired Date</b></td>
                    <td>{$pack.expired_time|date_format}</td>
                </tr>
                {/if}
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr class="view">
                    <td valign="top"><b>Website</b></td>
                    <td>{$user[0].website}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Occupation</b></td>
                    <td>{$user[0].occupation|nl2br}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Company Name</b></td>
                    <td>{$user[0].company|nl2br}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>School</b></td>
                    <td>{$user[0].school|nl2br}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Interest/Hobby</b></td>
                    <td>{$user[0].interest_hobby|nl2br}</td>
                </tr>
                <tr class="view">
                    <td valip="top"><b>Favorite Movies</b></td>
                    <td>{$user[0].fav_movie_show|nl2br}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Favorite Book</b></td>
                    <td>{$user[0].fav_book|nl2br}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Favorite Music</b></td>
                    <td>{$user[0].fav_music|nl2br}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>About Me</b></td>
                    <td>{$user[0].aboutme|nl2br}</td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr class="view">
                    <td valign="top"><b>Video Viewed</b></td>
                    <td>{$user[0].video_viewed}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Profile Views</b></td>
                    <td>{$user[0].profile_viewed}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Watched Video</b></td>
                    <td>{$user[0].watched_video}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Join Date</b></td>
                    <td>{$user[0].addtime|date_format}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Last Login</b></td>
                    <td>{$user[0].logintime|date_format}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Email Verified</b></td>
                    <td>{$user[0].emailverified}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Account Status</b></td>
                    <td>{$user[0].account_status}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="20%" valign="top" align="center">
                <h2>User Photo</h2>
                <img src="../photo/{if $user[0].photo == ''}nopic.gif{else}{$user[0].photo}{/if}"><br>
                <a href="users.php?m=edit&UID={$user[0].UID}" class="view">Edit</a><br>
                <a href="users.php?m=all&a=delete&UID={$user[0].UID}" onClick="javascript:return confirm('Are you sure you want to delete this user?');" class="view">Delete</a><br>
                {if $user[0].account_status == 'Active'}
                <a href="users.php?m=view&a=suspend&UID={$user[0].UID}" onClick="javascript:return confirm('Are you sure you want to suspend this user?');" class="view">Suspend</a><br>
                {else}
                <a href="users.php?m=view&a=activate&UID={$user[0].UID}" onClick="javascript:return confirm('Are you sure you want to activate this user?');" class="view">Activate</a><br>
                {/if}
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>