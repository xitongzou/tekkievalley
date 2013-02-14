<div id="leftside"> 
  <div class="clear"></div>
  <div id="submenu">
    <div id="tabmenucontainer">
      <ul>
        <li><a href="javascript:void(0)" id="active" onclick="fxShowAccInfo('divAccInfo','divRandominfo')">{translate item='uprofile.member_info'}</a></li>
        <li><a href="javascript:void(0)" onclick="fxShowAccInfo('divRandominfo','divAccInfo')">{translate item='uprofile.profile'}</a></li>
      </ul>
    </div>
    <div class="clear"></div>
    <div id="subcontent">
      <div class="contentbox">
        <div class="hellomessage">Hello. I'm
          {$answers[0].username}
          .</div>
        <div id='divAccInfo'>
          <!-- ADD Userpic -->
          <div class="imgprofile"><img src="{$photourl}/{if $answers[0].photo eq ""}nopic.gif{else}{$answers[0].photo}{/if}" boder="0" /></div>
          <!-- END ADD Userpic -->
          <div class="profileinfo"><strong>{translate item='uprofile.last_login'}:</strong> {insert name=time_range assign=rtime field=logintime IDFR=UID id=$answers[0].UID tbl=signup}
            {$rtime} </div>
          <div class="profileinfo"><strong>{translate item='uprofile.signed_up'}:</strong> {insert name=time_range assign=stime field=addtime IDFR=UID id=$answers[0].UID tbl=signup}
            {$stime} </div>
          {if $answers[0].fname ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.name'}:</strong> {$answers[0].fname}
            &nbsp;
            {$answers[0].lname} </div>
          {/if}
          {if $answers[0].bdate ne "0000-00-00"}
          <div class="profileinfo"><strong>{translate item='uprofile.age'}:</strong> {$profileage} </div>
          {/if}
          {if $answers[0].gender ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.gender'}:</strong> {$answers[0].gender} </div>
          {/if}
          {if $answers[0].relation ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.relation'}:</strong> {$answers[0].relation} </div>
          {/if}
          {if $answers[0].aboutme ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.about'}:</strong> {$answers[0].aboutme|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].website ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.website'}:</strong> {$answers[0].website|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].town ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.hometown'}:</strong> {$answers[0].town|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].city ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.current_city'}:</strong> {$answers[0].city|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].zip ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.current_zip'}:</strong> {$answers[0].zip} </div>
          {/if}
          {if $answers[0].country ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.country'}:</strong> {$answers[0].country} </div>
          {/if} </div>
        <!--   # End of Account information -->
        <!-- # Random information  -->
        <div id="divRandominfo" style='display:none' > {if $answers[0].occupation ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.occupation'}:</strong> {$answers[0].occupation|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].company ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.companies'}:</strong> {$answers[0].company|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].school ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.schools'}:</strong> {$answers[0].school|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].interest_hobby ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.interests'}:</strong> {$answers[0].interest_hobby|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].fav_movie_show ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.movies'}:</strong> {$answers[0].fav_movie_show|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].fav_music ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.music'}:</strong> {$answers[0].fav_music|wordwrap:95:"<br />":true} </div>
          {/if}
          {if $answers[0].fav_book ne ""}
          <div class="profileinfo"><strong>{translate item='uprofile.books'}:</strong> {$answers[0].fav_book|wordwrap:95:"<br />":true} </div>
          {/if} </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
</div>
<!-- right -->
<div id="rightside">
  <div id="latestvideo">
    <div id="latestvideo-title">{translate item='uprofile.latest_video'}</div>
    <div id="latestvideo-content">
      <div class="arrow-general">&nbsp;</div>
      <a href="{seourl rewrite="video/`$videos[0].VID`" url="view_video.php?viewkey=`$videos[0].vkey`" clean=$videos[0].title}"> <strong>{$videos[0].title}</strong> </a><br/>
      {if $videos[0].vkey eq ""} <img class="moduleEntryThumb" height="90" src="{$imgurl}/no_videos_groups.gif" width="120" /> {else} <a href="{seourl rewrite="video/`$videos[0].VID`" url="view_video.php?viewkey=`$videos[0].vkey`" clean=$videos[0].title}"> <img class="moduleFeaturedThumb" height="90" src="{$tmburl}/{$videos[0].thumb}_{$videos[0].VID}.jpg" width="120" /> </a> {/if} <br/>
      {if $videos[0].VID ne ""}
      {insert name=time_range assign=rtime field=addtime IDFR=VID id=$videos[0].VID tbl=video}
      {translate item='global.added'}: {$rtime}<br/>
      {/if}
      {if $smarty.session.UID ne $videos[0].VID}
      {if $chkuserflag eq ""} <a href="{seourl rewrite='signup' url='signup.php'}">{translate item='global.signup'}</a> or <a href="{seourl rewrite='login' url='login.php'}">{translate item='global.login'}</a> {translate item='uprofile.to_add'}
      {$answers[0].username}
      {translate item='uprofile.as_friend'}.<br/>
      {/if}
      {/if}
      {if $chkuserflag ne "self"}
      {if $chkuserflag eq "guest"}
      {insert name=uid_to_rate assign=trate uid=$UID}
      {insert name=show_rate assign=rate rte=$trate}
      <div id='himr' style='display:none'> Here is my rating
        { $rate }
        I'm
        {$answers[0].username}
        Rate me 
		<img class="rating" src="{$imgurl}/blank_star.gif" onclick="rateuser({$smarty.session.UID},{$UID},2)" /> 
		<img class="rating" src="{$imgurl}/blank_star.gif" onclick="rateuser({$smarty.session.UID},{$UID},4)" /> 
		<img class="rating" src="{$imgurl}/blank_star.gif" onclick="rateuser({$smarty.session.UID},{$UID},6)" /> 
		<img class="rating" src="{$imgurl}/blank_star.gif" onclick="rateuser({$smarty.session.UID},{$UID},8)" /> 
		<img class="rating" src="{$imgurl}/blank_star.gif" onclick="rateuser({$smarty.session.UID},{$UID},10)" /> 
		{/if}
	</div>
        <form action="{seourl rewrite="invite/`$answers[0].UID`" url="invite_friends.php?UID=`$answers[0].UID`"}" method="post">
          <input type="hidden" value="Add to Friends" name="addfriend" />
          <input type="image" src="{$imgurl}/btn_addfriends.gif" alt="Add Friend"  />
        </form>
        <form action="{seourl rewrite="compose/`$answers[0].username`" url="compose.php?receiver=`$answers[0].username`"}" method="post">
          <input type="hidden" value="Send Message" />
          <input type="image" src="{$imgurl}/btn_sendmsg.gif" alt="Send Message"  />
        </form>
        {insert name=is_subscribe assign=status id_to_subscribe=$UID}
        { if $status eq 'off'  }
        <form action="{seourl rewrite="users/`$answers[0].username`/subscribe/on/u" url="uprofile.php?subscribe=on&UID=`$UID`&info=u"}" method="POST">
          <input type="hidden" value="Subscribe to {$answers[0].username}'s Videos" />
          <input type="image" src="{$imgurl}/btn_subscribe.gif" alt="Subscribe to {$answers[0].username}'s Videos"  />
        </form>
        { elseif  $status eq 'on'}
        <form action="{seourl rewrite="users/`$answers[0].username`/subscribe/off/u" url="uprofile.php?subscribe=off&UID=`$UID`&info=u"}" method="POST">
          <input type="hidden" value="Unubscribe to {$answers[0].username}'s Videos" />
          <input type="image" src="{$imgurl}/btn_unsubscribe.gif" alt="Unubscribe to {$answers[0].username}'s Videos"  />
        </form>
        { else }
        <form action="{seourl rewrite="users/`$answers[0].username`/subscribe/on/i" url="uprofile.php?subscribe=on&UID=`$UID`&info=i"}" method="POST">
          <input type="hidden" value="Subscribe to {$answers[0].username}'s Videos" />
          <input type="image" src="{$imgurl}/btn_subscribe.gif" alt="Subscribe to {$answers[0].username}'s Videos"  />
        </form>
        { /if }
        {/if} 
	
    </div>
  </div>
</div>
<div class="clear"></div>
