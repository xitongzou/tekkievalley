     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_user" method="POST" enctype="multipart/form-data" action="users.php?m=edit&UID={$user[0].UID}">
        <fieldset>
        <legend>Account Information</legend>
            <label for="UID">User ID: </label>
            <input type="text" name="UID" value="{$user[0].UID}" readonly="readonly"><br>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$user[0].username}" readonly="readonly" class="large"><br>
            <label for="email">Email Address: </label>
            <input type="text" name="email" value="{$user[0].email}" class="large"><br>
            <label for="emailverified">Email Verified: </label>
            <select name="emailverified">
            <option value="yes"{if $user[0].emailverified == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $user[0].emailverified == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="account_status">Account Status: </label>
            <select name="account_status">
            <option value="Active"{if $user[0].account_status == 'Active'} selected="selected"{/if}>Active</option>
            <option value="Inactive"{if $user[0].account_status == 'Inactive'} selected="selected"{/if}>Inactive</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Personal Information</legend>
            <label for="full_name">Full Name: </label>
            <input type="text" name="fname" value="{$user[0].fname}" class="medium">
            <input type="text" name="lname" value="{$user[0].lname}" class="medium"><br>
            <label for="gender">Gender: </label>
            <select name="gender">
            <option value="">------</option>
            <option value="Male"{if $user[0].gender == 'Male'} selected="selected"{/if}>Male</option>
            <option value="Female"{if $user[0].gender == 'Female'} selected="selected"{/if}>Female</option>
            </select><br>
            <label for="relation">Relation: </label>
            <select name="relation">
            <option value="">--------</option>
            <option value="Single"{if $user[0].relation == 'Single'} selected="selected"{/if}>Single</option>
            <option value="Open"{if $user[0].relation == 'Open'} selected="selected"{/if}>Open</option>
            <option value="Taken"{if $user[0].relation == 'Taken'} selected="selected"{/if}>Taken</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Location Information</legend>
            <label for="town">Hometown: </label>
            <input type="text" name="town" value="{$user[0].town}" class="large"><br>            
            <label for="city">City: </label>
            <input type="text" name="city" value="{$user[0].city}" class="large"><br>
            <label for="zip">Zip Code: </label>
            <input type="text" name="zip" value="{$user[0].zip}" class="medium"><br>
            <label for="country">Country: </label>
            <select name="country">
            <option value="">Select Country</option>
            {section name=i loop=$countries}
            <option value="{$countries[i]}"{if $user[0].country == $$countries[i]} selected="selected"{/if}>{$countries[i]}</option>
            {/section}
            </select><br>        
        </fieldset>
        <fieldset>
        <legend>Profile Information</legend>          
            <label for="website">Website: </label>
            <input type="text" name="website" value="{$user[0].website}" class="large"><br>
            <label for="aboutme">About Me: </label>
            <textarea name="aboutme">{$user[0].aboutme}</textarea><br>
            <label for="occupation">Occupation: </label>
            <textarea name="occupation">{$user[0].occupation}</textarea><br>
            <label for="company">Company: </label>
            <textarea name="company">{$user[0].company}</textarea><br>
            <label for="school">School: </label>
            <textarea name="school">{$user[0].school}</textarea><br>
            <label for="interest_hobby">Interest/Hobby: </label>
            <textarea name="interest_hobby">{$user[0].interest_hobby}</textarea><br>
            <label for="fav_movie_show">Favorite Movies: </label>
            <textarea name="fav_movie_show">{$user[0].fav_movie_show}</textarea><br>
            <label for="fav_book">Favorite Books: </label>
            <textarea name="fav_book">{$user[0].fav_book}</textarea><br>
            <label for="fav_music">Favorite Music: </label>
            <textarea name="fav_music">{$user[0].fav_music}</textarea><br>
        </fieldset>
        <fieldset>
        <legend>User Avatar</legend>
            <label for="current_avatar">Current Avatar: </label>
            <img src="../photo/{if $user[0].photo == ''}nopic.gif{else}{$user[0].photo}{/if}" style="margin-left: 1%;"><br>
            <label for="avatar">Upload Avatar: </label>
            <input name="avatar" type="file"><br>
            <label for="delete_avatar">Delete Avatar: </label>
            <input name="delete_avatar" type="checkbox"><br>
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
            <label for="video_viewed">Video Viewed: </label>
            <input type="text" name="video_viewed" value="{$user[0].video_viewed}"><br>
            <label for="profile_viewed">Profile Viewed: </label>
            <input type="text" name="profile_viewed" value="{$user[0].profile_viewed}"><br>
            <label for="watched_video">Watched Videos: </label>
            <input type="text" name="watched_video" value="{$user[0].watched_video}"><br>
        </fieldset>
        </div>
        <div id="password" style="display: none;">
        <fieldset>
        <legend>Change Password</legend>
            <label for="password">Password: </label>
            <input type="password" name="password"><br>
            <label for="password_confirm">Confirm Password: </label>
            <input type="password" name="password_confirm"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="edit_user" value="Update User" class="button">
            <input type="button" name="edit_user_advanced" id="edit_user_advanced" value="-- Show Advanced --" class="button">
            <input type="button" name="edit_user_password" id="edit_user_password" value="-- Change Password --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>