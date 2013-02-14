     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $profiles}
            {section name=i loop=$profiles}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$profiles[i].id}</td>
                <td align="center">{$profiles[i].profile}</td>
                <td align="center"><b>{if $profiles[i].status == '1'}Active{else}Disabled{/if}</b></td>
                <td align="center">
                    <a href="index.php?m=playeredit&PID={$profiles[i].id}">Edit</a><br>
                    {if $profiles[i].status == '0'}
                    <a href="index.php?m=player&a=activate&PID={$profiles[i].id}">Activate</a><br>
                    <a href="index.php?m=player&a=delete&PID={$profiles[i].id}">Delete</a>
                    {/if}
                </td>
            <tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO PACKAGES AVAILABLE</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>