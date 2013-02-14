     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Mail Settings</h2>
        <div id="simpleForm">
        <form name="mail_settings" method="POST" action="index.php?m=mail">
        <fieldset>
        <legend>Mail Settings</legend>
            <label for="mailer">Mailer: </label>
            <select name="mailer">
            <option value="mail"{if $mailer == 'mail'} selected="selected"{/if}>PHP Mail Function</option>
            <option value="sendmail"{if $mailer == 'sendmail'} selected="selected"{/if}>Sendmail</option>
            <option value="smtp"{if $mailer == 'smtp'} selected="selected"{/if}>SMTP Server</option>
            </select><br>
            <label for="sendmail">Sendmail Path: </label>
            <input type="text" name="sendmail" value="{$sendmail}" class="large"><br>
            <label for="smtp">SMTP Server: </label>
            <input type="text" name="smtp" value="{$smtp}" class="large"><br>
            <label for="smtp_port">SMTP Port: </label>
            <input type="text" name="smtp_port" value="{$smtp_port}"><br>
            <label for="smtp_prefix">SMTP Prefix: </label>
            <select name="smtp_prefix">
            <option value=""{if $smtp_prefix == ''} selected="selected"{/if}>Default</option>
            <option value="ssl"{if $smtp_prefix == 'ssl'} selected="selected"{/if}>SSL</option>
            <option value="tls"{if $smtp_prefix == 'tls'} selected="selected"{/if}>TLS</option>
            </select><br>
            <label for="smtp_auth">SMTP Authentification: </label>
            <select name="smtp_auth">
            <option value="1"{if $smtp_auth == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $smtp_auth == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="smtp_username">SMTP Username: </label>
            <input type="text" name="smtp_username" value="{$smtp_username}" class="large"><br>
            <label for="smtp_password">SMTP Password: </label>
            <input type="password" name="smtp_password" value="{$smtp_password}" class="large"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_mail" value="Update Mail Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>