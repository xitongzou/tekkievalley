     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Permissions Settings</h2>
        <div id="simpleForm">
        <form name="permissions_settings" method="POST" action="index.php?m=permissions">
        <fieldset>
        <legend>Permissions Settings</legend>
            <label for="user_registrations" style="width: 40%;">User Registrations: </label>
            <select name="user_registrations">
            <option value="1"{if $user_registrations == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $user_registrations == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="email_verification" style="width: 40%;">Email Activation (verification): </label>
            <select name="email_verification">
            <option value="1"{if $email_verification == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $email_verification == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="video_view" style="width: 40%;">Video Watching: </label>
            <select name="video_view">
            <option value="all"{if $video_view == '1'} selected="selected"{/if}>All</option>
            <option value="registered"{if $video_view == '0'} selected="selected"{/if}>Registered</option>
            </select><br>
            <label for="video_comments" style="width: 40%;">Video Comments: </label>
            <select name="video_comments">
            <option value="1"{if $video_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="video_comments_limit" style="width: 40%;">Video Comments (per user): </label>
            <select name="video_comments_limit">
            <option value="1"{if $video_comments_limit == '1'} selected="selected"{/if}>One</option>
            <option value="0"{if $video_comments_limit == '0'} selected="selected"{/if}>Unlimited</option>
            </select><br>
            <label for="private_msgs" style="width: 40%;">Private Messaging: </label>
            <select name="private_msgs">
            <option value="1"{if $private_msgs == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $private_msgs == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="force_password" style="width: 40%;">Force logged in users to re-enter password for any account changes: </label>
            <select name="force_password">
            <option value="1"{if $force_password == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $force_password == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="video_rating" style="width: 40%;">Video Rating: </label>
            <select name="video_rating">
            <option value="Once"{if $video_rating == 'Once'} selected="selected"{/if}>Once</option>
            <option value="Unlimited"{if $video_rating == 'Unlimited'} selected="selected"{/if}>Unlimited</option>
            </select><br>
            <label for="user_poll" style="width: 40%;">User Poll: </label>
            <select name="user_poll">
            <option value="Once"{if $user_poll == 'Once'} selected="selected"{/if}>Once</option>
            <option value="Unlimited"{if $user_poll == 'Unlimited'} selected="selected"{/if}>Unlimited</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_permissions" value="Update Permissions Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>