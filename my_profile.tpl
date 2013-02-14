<div id="fullside">
    <div id="myprofile">
      <div id="myprofile-title">{translate item='my_profile.profile'}</div>
      <div id="myprofile-content">
        <div class="arrow-general">&nbsp;</div>
   <div class="contentbox">
    <form method="post" enctype="multipart/form-data">
      <fieldset>
          <legend>{translate item='my_profile.account_information'}</legend>
          <input type="hidden" value="profile_submit" name="command" />
          <input type="hidden" name="prevemail" value="{$answers[0].email}" />
          <div class="fm-req">
            <label for="fm-emailaddress">{translate item='my_profile.email'}:</label>
            <input maxlength="60" size="30" value="{$answers[0].email}" name="email" class="myprofiletext" />
          </div>
          <div class="fm-req">
            <label for="fm-username">{translate item='my_profile.username'}:</label>
            <span class="myprofiletext" >
            {$answers[0].username}
            </span> </div>
          <div class="fm-req">
            <label for="fm-password">{translate item='my_profile.password'}:</label>
            <input type="password" maxlength="20" value="" name="password1" class="myprofiletext"/>
          </div>
          <div class="fm-req">
            <label for="fm-confirmpassword">{translate item='my_profile.password_confirm'}:</label>
            <input type="password" maxlength="20" value="" name="password2" class="myprofiletext"/>
          </div>
      </fieldset>
      <fieldset>
          <legend>{translate item='my_profile.settings'}:</legend>
          <div class="fm-req">
              <label for="fm-playlist">{translate item='global.playlists'}</label>
              <select name="playlist" class="myprofiletext">
              <option value="Public"{if $answers[0].playlist == 'Public'} selected="selected"{/if}>{translate item='global.public'}</option>
              <option value="Private"{if $answers[0].playlist == 'Private'} selected="selected"{/if}>{translate item='global.private'}</option>
              </select>
          </div>
      </fieldset>
      <fieldset>
          <legend>{translate item='my_profile.personal_information'}:</legend>
          <!-- ADD Userpic -->
          <div class="fm-opt">
            <label for="fm-userpic">{translate item='my_profile.upload_avatar'}:</label>
            <input type="file" name="userpic" class="myprofilebrowsefile"/>
          </div>
          <div class="fm-opt">
            <label for="fm-delete">{translate item='my_profile.delete_avatar'}?</label>
            <input type="checkbox" name="delete" value="1" class="myprofilecheckbox"/>
		  </div>
		  <div class="fm-opt">
		  <label>&nbsp;</label>
		   <img src="{if $answers[0].photo eq ""}photo/nopic.gif{else}{$photourl}/{$answers[0].photo}{/if}" />
		  </div>
		  <br/>
          <!-- END ADD Userpic -->
          <div class="fm-opt">
            <label for="fm-firstname">{translate item='my_profile.fname'}:</label>
            <input maxlength="30" size="30" name="fname" value="{$answers[0].fname}" class="myprofiletext" />
          </div>
          <div class="fm-opt">
            <label for="fm-lastname">{translate item='my_profile.lname'}:</label>
            <input maxlength="30" size="30" name="lname" value="{$answers[0].lname}" class="myprofiletext" />
          </div>
          <div class="fm-opt">
            <label for="fm-birthday">{translate item='my_profile.bday'}:</label>
            <select name="month" class="myprofiletext">
              <option>mm</option>
              {$months}
            </select>
            <select name="day" class="myprofiletext">
              <option>dd</option>
              {$days}
            </select>
            <select name="year" class="myprofiletext">
              <option>yyyy</option>
              {$years}
            </select>
          </div>
          <div class="fm-opt">
            <label for="fm-gender">{translate item='my_profile.gender'}:</label>
            <select name="gender" class="myprofiletext">
              <option value="">---</option>
              <option value="Female" {if $answers[0].gender eq "Female"}selected{/if}>Female</option>
              <option value="Male" {if $answers[0].gender eq "Male"}selected{/if}>Male</option>
            </select>
          </div>
          <div class="fm-opt">
            <label for="fm-relstatus">{translate item='my_profile.relation'}:</label>
            <select name="relation" class="myprofiletext">
              <option value="">---</option>
              <option value="Single" {if $answers[0].relation eq "Single"}selected{/if}>Single</option>
              <option value="Taken" {if $answers[0].relation eq "Taken"}selected{/if}>Taken</option>
              <option value="Open" {if $answers[0].relation eq "Open"}selected{/if}>Open</option>
            </select>
          </div>
          <div class="fm-opt">
            <label for="fm-aboutme">{translate item='my_profile.about'}:</label>
            <textarea name="aboutme" rows="5" cols="45" class="myprofiletext">{$answers[0].aboutme}
    </textarea>
          </div>
          <div class="fm-opt">
            <label for="fm-personalweb">{translate item='my_profile.website'}:</label>
            <input maxlength="255" size="40" name="url" value="{$answers[0].website}" class="myprofiletext"/>
          </div>
      </fieldset>
      <fieldset>
          <legend>{translate item='my_profile.location_information'}:</legend>
          <div class="fm-opt">
            <label for="fm-hometown">{translate item='my_profile.hometown'}:</label>
            <input maxlength="120" size="30" name="hometown" value="{$answers[0].town}" class="myprofiletext"/>
          </div>
          <div class="fm-opt">
            <label for="fm-city">{translate item='my_profile.city'}:</label>
            <input maxlength="120" size="30" name="city" value="{$answers[0].city}" class="myprofiletext" />
          </div>
          <div class="fm-opt"><br />
            <label for="fm-zip">{translate item='my_profile.zip'}:</label>
            <input maxlength="5" size="5" name="zip" value="{$answers[0].zip}" class="myprofiletext" /> &nbsp;(US &amp; Canada Only)&nbsp;&nbsp;
          </div>
          <div class="fm-opt">
            <label for="fm-country">{translate item='my_profile.country'}:</label>
            <select name="country" class="myprofiletext">
              <option value="">Select Country</option>
              {$country}
            </select>
          </div>
      </fieldset>
      <fieldset>
          <legend>{translate item='my_profile.random_information'} <i>({translate item='my_profile.random_information_expl'})</i></legend> 
          <div class="fm-opt">
          <label for="fm-occupations">{translate item='my_profile.occupation'}:</label>
          <input maxlength="500" size="40" name="occupation" value="{$answers[0].occupation}" class="myprofiletext"/>
          </div>
          <div class="fm-opt">
          <label for="fm-companies">{translate item='my_profile.company'}:</label>
          <input maxlength="500" size="40" name="companies" value="{$answers[0].company}" class="myprofiletext"/>
           </div>
          <div class="fm-opt">
          <label for="fm-schools">{translate item='my_profile.school'}:</label>
          <input maxlength="500" size="40" name="schools" value="{$answers[0].school}" class="myprofiletext"/>
           </div>
          <div class="fm-opt">
          <label for="fm-interest">{translate item='my_profile.hobbies'}:</label>
          <textarea name="hobbies" rows="5" cols="45" class="myprofiletext">{$answers[0].interest_hobby}</textarea>
           </div>
          <div class="fm-opt">
          <label for="fm-favmovies">{translate item='my_profile.fav_movies'}:</label>
          <textarea name="movies" rows="5" cols="45" class="myprofiletext">{$answers[0].fav_movie_show}</textarea>
           </div>
          <div class="fm-opt">
          <label for="fm-favmusic">{translate item='my_profile.fav_music'}:</label>
          <textarea name="music" rows="5" cols="45" class="myprofiletext">{$answers[0].fav_music}</textarea>
           </div>
          <div class="fm-opt">
          <label for="fm-favbook">{translate item='my_profile.fav_books'}:</label>
          <textarea name="books" rows="5" cols="45" class="myprofiletext">{$answers[0].fav_book}</textarea>
          </div>
      </fieldset>
      <input type="hidden" value="Update Profile" name="update_profile" />
      <div class="signupbutton">
	  	<input type="image" src="{$imgurl}/btn_update.gif"/>
	  </div>
    </form>
	</div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
<div class="clear">
</div>
