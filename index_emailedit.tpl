     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div class="legend">
            <table width="100%" cellspacing="5" cellpadding="0" border="0" class="view">
            <tr>
                <td colspan="2" align="center"><b>Variables: (For Email Subject)</b></td>
                <td colspan="2" align="center"><b>Variables: (For Email Details)</b></td>
            </tr>
            <tr class="view">
                <td align="right">Sender Name: </td>
                <td>$sender_name</td>
                <td align="right">Sender User Name: </td>
                <td>{literal}{$sender_name}{/literal}</td>
            </tr>
            <tr class="view">
                <td align="right">Group Name:</td>
                <td>{literal}$gname{/literal}</td>
                <td align="right">Sender First Name:</td>
                <td>{literal}{$sender_fname}{/literal}</td>
            </tr>
            <tr class="view">
                <td align="right">Site Name:</td>
                <td>{literal}$config[site_name]{/literal}</td>
                <td align="right">Sender Last Name:</td>
                <td>{literal}{$sender_lname}{/literal}</td>
            </tr>
            <tr class="view">
                <td colspan="2">&nbsp;</td>
                <td align="right">Receiver User Name:</td>
                <td>{literal}{$receiver_name}{/literal}</td>
            </tr>
            <tr class="view">
                <td colspan="2">&nbsp;</td>
                <td align="right">Receiver First Name: </td>
                <td>{literal}{$receiver_fname}{/literal}</td>
            </tr>
            <tr class="view">
                <td colspan="2">&nbsp;</td>
                <td align="right">Receiver Last Name:</td>
                <td>{literal}{$receiver_lname}{/literal}</td>
            </tr>
            <tr class="view">
                <td colspan="2">&nbsp;</td>
                <td align="right">Sender Message:</td>
                <td>{literal}{$message}{/literal}</td>
            </tr>
            <tr class="view">
                <td colspan="2">&nbsp;</td>
                <td align="right">Site Name:</td>
                <td>{literal}{$site_name}{/literal}</td>
            </tr>
            </table>
        </div>
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_email" method="POST" action="index.php?m=emailedit&EID={$email[0].email_id}" style="width: 96%;">
        <fieldset>
        <legend>Editing: {$email[0].email_id}</legend>
            <input type="hidden" name="email_path" value="{$email[0].email_path}">
            <label for="subject" style="width: 15%;">Subject: </label>
            <input type="text" name="subject" value="{$email[0].email_subject}" class="large"><br>
            <label for="content" style="width: 15%;">Content: </label>
            <textarea name="content" rows="20" class="large">{$email[0].details}</textarea><br>
            <label for="comment" style="width: 15%;">Comments (admin): </label>
            <input type="text" name="comment" value="{$email[0].comment}" class="large"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_email" value="Update Email" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>