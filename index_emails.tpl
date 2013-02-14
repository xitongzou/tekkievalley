     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Subject</b></td>
                <td align="center"><b>Comments</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $emails}
            {section name=i loop=$emails}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$emails[i].email_id}</td>
                <td align="center">{$emails[0].email_subject}</td>
                <td align="center">{$emails[i].comment}</td>
                <td align="center">
                    <a href="index.php?m=emailedit&EID={$emails[i].email_id}">Edit</a><br>
                    <a href="index.php?m=emails&a=delete&EID={$emails[i].email_id}" onClick="javascript:return confirm('Are you sure you want to delete this email?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO EMAILS AVAILABLE</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>