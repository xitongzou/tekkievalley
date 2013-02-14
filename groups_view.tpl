     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $group}
        {insert name=group_info_count assign=gmemcount tbl=group_mem gid=$group[0].GID query="and approved='yes'"}
        {insert name=group_info_count assign=gvdocount tbl=group_vdo gid=$group[0].GID query="and approved='yes'"}
        {insert name=group_info_count assign=gtpscount tbl=group_tps gid=$group[0].GID query="and approved='yes'"}
        {insert name=id_to_name assign=uname un=$group[0].OID}
        {insert name=group_img assign=groupimg gid=$group[0].GID tbl=group_vdo}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="80%">
                <h2>Group Information</h2>
                <table width="100%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Group ID</b></td>
                    <td>{$group[0].GID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Group Name</b></td>
                    <td><b>{$group[0].gname}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Owner</b></td>
                    <td><a href="users.php?m=view&UID={$group[0].OID}"<b>{$uname}</b></a></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Tags</b></td>
                    <td>{$group[0].keyword}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Description</b></td>
                    <td>{$group[0].gdescn}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>URL</b></td>
                    <td>{seourl rewrite="groups/`$group[0].gurl`" url="/groups_home.php?urlkey=`$group[0].gurl`"}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Channel(s)</b></td>
                    <td>
                        {insert name=video_channel assign=channels tbl=group_own gid=$group[0].GID}
                        {section name=j loop=$channels}
                            <a href="channels.php?m=view&CID={$channels[j].CHID}">{$channels[j].name}</a><br>
                        {/section}
                    </td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Videos</b></td>
                    <td>{$gvdocount}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Members</b></td>
                    <td>{$gmemcount}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Topics</b></td>
                    <td>{$gtpscount}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Group Type</b></td>
                    <td>{$group[0].type}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Video Upload Type</b></td>
                    <td>{$group[0].gupload}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Topic Posting Type</b></td>
                    <td>{$group[0].gposting}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Group Image Type</b></td>
                    <td>{$group[0].gimage}</td>
                </tr>
                <tr class="view">
                    <td valip="top"><b>Featured</b></td>
                    <td><b>{$group[0].featured}</b></td>
                </tr>
                </table>
                <br>
            </td>
            <td width="20%" valign="top" align="center">
                <h2>Group Image</h2>
                {if $groupimg eq ''}
                <img src="{$imgurl}/no_videos_groups.gif" width="120">
                {else}
                <img src="{$baseurl}/thumb/1_{$groupimg}.jpg" width="120">
                {/if}
                <br><br>
                <a href="groups.php?m=edit&GID={$group[0].GID}" class="view">Edit</a><br>
                <a href="groups.php?m=all&a=delete&GID={$group[0].GID}" onClick="javascript:return confirm('Are you sure you want to delete this group?');" class="view">Delete</a><br>
                {if $group[0].featured == 'yes'}
                <a href="groups.php?m=view&a=unfeature&GID={$group[0].GID}" onClick="javascript:return confirm('Are you sure you want to unfeature this group?');" class="view">Unfeature</a><br>
                {else}
                <a href="groups.php?m=view&a=feature&GID={$group[0].GID}" onClick="javascript:return confirm('Are you sure you want to feature this group?');" class="view">Feature</a><br>
                {/if}                
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>