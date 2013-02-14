<tr><td valign="top" height="250">
        <form action='payment.php?pack={$smarty.request.pack}&uid={$smarty.request.uid}' method='post'>
        <center><h2>Confirm Payment</h2>
        Provide necessary information to complete your payment:
        
        {if $enable_package eq "yes"}
        <table width=350>
        <tr>
        <td colspan=2 bgcolor="#000000" align="center">
                <input type='hidden' name='period' value='{$smarty.request.period}'>
                <input type='hidden' name='method' value='{$smarty.request.method}'>
                <table width="100%" cellpadding=3 cellspacing=3 bgcolor="#F8F8FF" align="center">
                <tr><td width="17"></td><td width="35%"><b>Your Package:</b></td><td><b>{$package.pack_name}</b></input></td></tr>
                <tr><td></td><td><b>Total Price:</b></td><td><font color="#0055CC"><b>${$totalprice}</b></font> for <b>{$smarty.request.period}</b> {$package.period}(s)</td></tr>
                <tr><td></td><td><b>Payment Method:</b></td><td>{$smarty.request.method}</td></tr>

                </table>
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <td align='center'>
               <input type=button name='back' value='<<Back' onclick="document.location='pack_ops.php?pack={$smarty.request.pack}&uid={$smarty.request.uid}'">&nbsp;&nbsp;&nbsp;
               <input type=submit name='submit' value='Next >>'>
        </td></tr>
        </table>
        {/if}
        </center>
        </form>
<br><br>
</td></tr>
