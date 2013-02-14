<tr><td valign="top" height="250">
        <form action='renew_account.php?uid={$smarty.request.uid}' method='post'>
        <center><h2>Your Account is Expired - Renew Now!</h2>
        Choose one of the following packages to renew your account:
        {if $enable_package eq "yes"}
        <table width=350>
        <tr>
        <td colspan=2 bgcolor="#000000" align="center">
                <table width="100%" cellpadding=3 cellspacing=3 bgcolor="#F8F8FF" align="center">
                <tr><td colspan=2><font size="3px"><b>Available Packages</b></font></td></tr>
                {section name=i loop=$package}
                <tr>
                <td valign="top" width=5><input type='radio' name='pack_id' value='{$package[i].pack_id}'></input></td>
                <td><b>{$package[i].pack_name}</b></input><br>
                        {$package[i].pack_desc}<br>
                        - <font color="#0055CC">{insert name=format_size size=$package[i].space}</font> video upload space<br>
                        - <font color="#0055CC">{insert name=format_size size=$package[i].bandwidth}</font> bandwidth per month<br>
                        {if $package[i].video_limit gt "0"}
                        - Maximum <font color="#0055CC">{$package[i].video_limit}</font> videos upload<br>
                        {/if}
                        {if $package[i].price gt "0"}
                        - Registration cost only <font color="#0055CC">${$package[i].price}</font> per {$package[i].period|lower}
                        {elseif $package[i].is_trial eq "yes"}
                        - Register for <font color="#0055CC">{$package[i].trial_period} days</font> free upload
                        {/if}
                </td>
                </tr>
                {/section}
                </table>
        </td>
        </tr>
        <tr><td align='center'><br><input type=submit name='submit' value='Next >>'></td></tr>
        </table>
        {/if}
        </center>
        <form>
<br><br>
</td></tr>
