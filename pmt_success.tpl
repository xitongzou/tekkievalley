<tr><td height=250 align=center>
{if $success eq "true"}
        <h2>Your payment is received successfully</h2>
        You are subscribed for <b>{$smarty.request.period}(s)</b><br>
        Your account is valid until <b>{$exp_date|date_format}</b><br><br>
        <a href={$baseurl}/login.php>Click here</a> to login the site.
{else}
        <h2>Sorry! Your payment is not received.</h2>
        You will be notified by mail if the payment is received successfully.
        <br>
{/if}

</td></tr>
