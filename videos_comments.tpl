     <div id="rightcontent">
        {insert name=get_video_title assign=video_title VID=$VID}
        <div align="center"><b>Video</b>: <a href="videos.php?m=view&VID={$VID}">{$VID} - {$video_title|escape:'html'}</a></div><br>
        {include file="siteadmin/errmsg.tpl"}
        {if $total_comments >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Comment</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $comments}
            {section name=i loop=$comments}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$comments[i].COMID}</td>
                <td align="center" width="50%">
                    {$comments[i].commen|nl2br|escape:'html'}
                </td>
                <td align="center">
                    {insert name=id_to_name assign=uname un=$comments[i].UID}
                    <a href="users.php?m=view&UID={$comments[i].UID}">{$uname}</a>
                </td>
                <td align="center">{$comments[i].addtime|date_format}</td>
                <td align="center">
                    <a href="videos.php?m=commentedit&VID={$VID}&COMID={$comments[i].COMID}">Edit</a><br>
                    <a href="videos.php?m=comments&a=delete&VID={$VID}&COMID={$comments[i].COMID}" onClick="javascript:return confirm('Are you sure you want to delete this comment?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">THIS VIDEO HAS NO COMMENTS</div></td>
            </tr>
            {/if}
            </table>
        </div>
        {if $total_comments >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>