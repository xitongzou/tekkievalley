<tr><td height='250' valign=top>
{if $smarty.request.vcode eq ""}
<FORM name=Confirm_email action="{$baseurl}/confirm_email.php" method="post">
<TABLE cellSpacing=0 cellPadding=5 height='250' border=0 align='center'>
<tr><td valign='top'><br><br>
<table align="center">
<TBODY>
        <tr><td><DIV class=tableSubTitle>Please Confirm Your Email</DIV></td></tr>
        <TR>
        <TD width=200><SPAN class=label>Send a confirmation email to:</SPAN></TD></tr>
        <tr><TD><INPUT maxLength=60 size=40 value="{$smarty.session.EMAIL}" name=email readonly></TD>
        </TR>
        <TR>
        <TD align=center><INPUT type=submit value="Send Email" name=action_send></TD>
        </TR>
</TBODY>
</table>
</td></tr>
</TABLE>
</FORM>
{/if}
</td></tr>
