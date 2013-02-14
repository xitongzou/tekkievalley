<div id="leftside">
	<div id="signup">
		<div id="signup-title">{translate item='global.signup'}</div>
		<div id="signup-content">
		<div class="arrow-general">&nbsp;</div>
		{translate item='signup.new_member_msg'}<br /><br />
      <form id="signup-form" name="signupForm" method="post" action="{seourl rewrite='signup' url='signup.php'}" >
        <div class="fm-req">
          <label for="fm-username">{translate item='signup.username'}: </label>
          <input maxlength="20" name="username" id="username" value="{$username}" class="signuptext"  /><br>
        </div>
        <div class="fm-req">
          <label for="fm-emailaddress">{translate item='signup.email'}: </label>
          <input type="text" maxlength="60" size="20" name="email" value="{$email}" class="signuptext"  />
        </div>
        <div class="fm-req">
          <label for="fm-password">{translate item='signup.password'}: </label>
          <input type="password" maxlength="20" name="password1" class="signuptext"  />
        </div>
        <div class="fm-req">
          <label for="fm-confirmpassword">{translate item='signup.password_confirm'}: </label>
          <input type="password" maxlength="20" name="password2" class="signuptext"  />
        </div>
        {if $enable_package eq "yes"}
        <div> <strong>{translate item='signup.available_packages'}</strong><br>
          {section name=i loop=$package}
          <input type='radio' name='pack_id' value='{$package[i].pack_id}' />
          <strong>
          {$package[i].pack_name}
          </strong>
          <p>
            {$package[i].pack_desc}
          <ul>
            <li>
              {insert name=format_size size=$package[i].space}
              video upload space</li>
            <li>
              {insert name=format_size size=$package[i].bandwidth}
              bandwidth per month</li>
            {if $package[i].video_limit gt "0"}
            <li> Maximum
              {$package[i].video_limit}
              videos upload</li>
            {/if}
            {if $package[i].price gt "0"}
            <li> Registration cost only $
              {$package[i].price}
              per
              {$package[i].period|lower}
            </li>
            {elseif $package[i].is_trial eq "yes"}
            <li> Register for
              {$package[i].trial_period}
              daysfree upload</li>
            {/if}
          </ul>
          </p>
          {/section}
        </div>
        {/if}
		{if $captcha eq 1}        
	 	<div class="captcha">
			<img src="{$baseurl}/captcha.php" width="158" height="60" alt="Visual CAPTCHA"><br/><br/>
	 	</div>
		<div class="fm-req">
          <label for="fm-confirmpassword">{translate item='signup.verification'}: </label>
          <input type="text" name="capcha" class="signuptext"> 
        </div>
		{/if}
        <div class="signupstatement">
          <ul>
            <li>{translate item='signup.certify'}</li>
            <li>{translate item='signup.agree'}</li>
          </ul>
        </div>
        <div class="signupbutton">
		  <input type="hidden" value="Sign Up" name="action_signup">
          <input type="image" src="{$imgurl}/btn_signup.gif" name="submit"/>
        </div>
      </form>
    	</div> 
     <div class="clear"></div>
	</div>
  </div>
<div id="rightside">
	<div id="login">
		<div id="login-title">Login</div>
			<div id="login-content">
  			<div class="arrow-general">&nbsp;</div>
    <form id="loginForm" name="loginForm" method="post" action="login.php">
      <p>
        <label for="name">{translate item='signup.username'}:</label>
        <br />
        <input type="text" name="username" size="22" tabindex="12" id="name" class="logintext" />
        <br />
        <label for="password">{translate item='signup.password'}:</label>
        <br />
        <input name="password" type="password" class="logintext" id="password" tabindex="13" size="22" />
        <br />
        <input name="login_remember" type="checkbox" class="checkbox" />&nbsp;Remember me?
        <br />
        <br />        
        <a href="{seourl rewrite='recoverpassword' url='recoverpass.php'}" title="Forgot!" tabindex="14">{translate item='global.recover'}</a><br />
        <input type="hidden" name="action_login"  value="Log In" />
        <input type="image" src="{$imgurl}/login.gif" tabindex="15" class="loginbutton" />
      </p>
    </form>
		</div>
	</div>
  </div>
<div class="clear"></div>
