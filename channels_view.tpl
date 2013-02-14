     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $channel}
        {insert name=channel_count assign=count cid=$channel.CHID}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="80%">
                <h2>Channel Information</h2>
                <table width="100%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Channel ID</b></td>
                    <td>{$channel[0].CHID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Channel Name</b></td>
                    <td><b>{$channel[0].name}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Description</b></td>
                    <td>{$channel[0].descrip}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Videos</b></td>
                    <td>{$count[1]}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Groups</b></td>
                    <td>{$count[2]}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="20%" valign="top" align="center">
                <h2>Channel Image</h2>
                <img src="{$baseurl}/chimg/{$channel[0].CHID}.jpg"><br>
                <a href="channels.php?m=edit&CID={$channel[0].CHID}" class="view">Edit</a><br>
                <a href="channels.php?m=list&a=delete&CID={$channel[0].CHID}" onClick="javascript:return confirm('Are you sure you want to delete this channel?');" class="view">Delete</a><br>
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>