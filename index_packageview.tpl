     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $package}
        <div id="right">
        <table width="80%" cellspacing="5" cellpadding="0" border="0" align="center">
        <tr>
            <td colspan="2"><div style="font-size: 1.5em;"><b>Package</b>: {$package[0].pack_name}</div><br></td>
        </tr>
        <tr class="view">
            <td><b>Package Id:</td>
            <td>{$package[0].pack_id}</td>
        </tr>
        <tr class="view">
            <td valign="top"><b>Package Name:</b></td>
            <td>{$package[0].pack_name}</td>
        </tr>
        <tr class="view">
            <td valign="top"><b>Description:</b></td>
            <td>{$package[0].pack_desc}</td>
        </tr>
        <tr class="view">
            <td><b>Space:</b></td>
            <td>{insert name=format_size size=$package[0].space}</td>
        </tr>
        <tr class="view">
            <td><b>Bandwidth:</b></td>
            <td>{insert name=format_size size=$package[0].bandwidth}</td>
        </tr>
        <tr class="view">
            <td><b>Price</b></td>
            <td>{if $package[0].price == '0'}Free{else}{$package[0].price}${/if}</td>
        </tr>
        <tr class="view">
            <td><b>Video Limit:</b></td>
            <td>{if $package[0].video_limit == '0' or $package[0].video_limit == ''}Unlimited{else}{$package[0].video_limit}{/if}</td>
        </tr>
        <tr class="view">
            <td><b>Subscription Period</b></td>
            <td>{if $package[0].is_trial == 'yes'}{$package[0].trial_period}{else}{$package[0].period}{/if}</td>
        </tr>
        <tr class="view">
            <td><b>Status</b></td>
            <td>{$package[0].status}</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><a href="index.php?m=packageedit&PID={$package[0].pack_id}" class="view"><b>Edit Package</b></a></td>
        </tr>
        </table>
        </div>
        {/if}
     </div>