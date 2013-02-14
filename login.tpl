    <div id="login_errors" align="center">{include file="siteadmin/errmsg.tpl"}</div>
    <div id="login" align="center">
        <div id="simpleForm">
        <form name="logig" method="POST" action="login.php">
        <label for="username">Username: </label>
        <input name="username" type="text" class="large" style="width: 65%;"><br>
        <label for="password">Password: </label>
        <input name="password" type="password" class="large" style="width: 65%;">
        <div style="text-align: center;">
        <input type="submit" name="submit_login" value="Login" class="button">
        <input type="submit" name="submit_forgot" value="Forgot Password" class="button">
        </div>
        </form>
        </div>
    </div>
    </div>
</div>