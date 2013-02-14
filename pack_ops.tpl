<tr><td valign="top" height="250">
        <form action='payment.php?pack={$smarty.request.pack}&uid={$smarty.request.uid}' method='post'>
        <center><h2>Package Options</h2>
        Provide necessary information to complete your payment:
        {if $enable_package eq "yes"}
        <table width=350>
        <tr>
        <td colspan=2 bgcolor="#000000" align="center">
                <table width="100%" cellpadding=3 cellspacing=3 bgcolor="#F8F8FF" align="center">
                <tr><td width="40%" align=right><b>Your Package:</b></td><td><b>{$package.pack_name}</b></input></td></tr>
                <tr><td align=right><b>Package Price:</b></td><td><font color="#0055CC">${$package.price} per {$package.period}</font></td></tr>
                <tr><td align=right><b>Subscription Period:</b></td><td><select name='period'>{$period_ops}</select> {$package.period}</td></tr>
                <tr><td align=right><b>Payment Method:</b></td><td><select name='method'>{$payment_method_ops}</select></td></tr>
                </table>
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <td align='center'><input type=submit name='next' value='Next >>'></td></tr>
        </table>
        {/if}
        </center>
        <form>
<br><br>
</td></tr>
