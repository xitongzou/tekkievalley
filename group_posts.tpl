<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">
      Post Group
      <a href="groups_home.php?urlkey={$smarty.request.urlkey}">
        {$gname}
      </a>
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <div class="contentbox">
        <div class="group-home">
          <div class="groupthumb">
            {if $topic.VID eq '0'}
            <img src="{$imgurl}/no_videos_groups.gif" />
            {else}
            {insert name=getfield assign=view_key field='vkey' table='video' qfield='VID' qvalue=$topic.VID}
            {insert name=getfield assign=view_title field='title' table='video' qfield='VID' qvalue=$topic.VID}
            {insert name=getfield assign=view_VID field='VID' table='video' qfield='VID' qvalue=$topic.VID}
            {insert name=getfield assign=view_thumb field='thumb' table='video' qfield='VID' qvalue=$topic.VID}
            <a href="{seourl rewrite="video/`$view_VID`" url="view_video.php?viewkey=`$view_key`" clean=$view_title}"><img src="{$baseurl}/thumb/{$view_thumb}_{$topic.VID}.jpg"></a>
            {/if}
            <div class="button">
            </div>
          </div>
        </div>
        <div class="group-home-desc">
          Topic:
          {$topic.title}
          <br/>
          Date Add: {$topic.addtime|date_format:"%A, %B %e, %Y, %H:%M %p"}<br />
          {insert name=id_to_name assign=uname un=$topic.UID}
          Author: <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$topic.UID`"}">{$uname}</a><br />
          Comment:  {$total_post} <br/>
        </div>
        <div class="clear">
        </div>
		<br/>
   		{if $total_post > 0}
        <div id="groupforum">
          <div id="groupforum-title">
            <div class="titlepage">Comment On This Group</div>
          </div>
          <div id="groupforum-content">
          {section name=i loop=$post}          
              <div class="grouppost-comment">
                  <div class="groupthumb">
                    {if $post[i].VID ne "0"}
                      {insert name=getfield assign=view_key field='vkey' table='video' qfield='VID' qvalue=$post[i].VID}
                      {insert name=getfield assign=view_VID field='VID' table='video' qfield='VID' qvalue=$post[i].VID}
                      {insert name=getfield assign=view_title field='title' table='video' qfield='VID' qvalue=$post[i].VID}
                      {insert name=getfield assign=view_thumb field='thumb' table='video' qfield='VID' qvalue=$post[i].VID}
                      <a href="{seourl rewrite="video/`$view_VID`" url="view_video.php?viewkey=`$view_key`" clean=$view_title}">
                        <img src="{$baseurl}/{$view_thumb}_{$post[i].VID}.jpg" />
                      </a>
                      {else}
                      <img src="{$baseurl}/images/no_videos_groups.gif" alt="No Video" />
                     {/if}<br/><br />
                  </div>
                  <div class="group-post-desc">
                    <p>
                        {insert name=id_to_name assign=uname un=$post[i].UID}
                        {insert name=video_count assign=video uid=$post[i].UID}
                        {insert name=favour_count assign=favour uid=$post[i].UID}
                        {insert name=friends_count assign=frnd uid=$post[i].UID}
                        <strong><a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$post[i].UID`"}">{$uname}</a></strong><br/>
                        {$post[i].post|escape:'html'}<br/>
                        <p id="grouppost_icon">
                            <span class="video" alt="video"><a href="{seourl rewrite="users/`$uname`/videos/public" url="uvideos.php?UID=`$post[i].UID`"}">{$video}</a></span>
                            <span class="flag" alt="Favorite"><a href="{seourl rewrite="users/`$uname`/favorites" url="ufavour.php?UID=`$post[i].UID`"}">{$favour}</a></span>
                            <span class="people" alt="people"><a href="{seourl rewrite="users/`$uname`/friends" url="ufriends.php?UID=`$post[i].UID`"}">{$frnd}</a></span>
                            - {insert name=timediff value=var time=$post[i].date}
                        </p>	  
                    </p>
                  </div> <div class="clear"></div>
              </div>
          {/section}
          </div><!-- end div groupforum-content-->
        </div>
        <br/>
        {/if}

        {if $smarty.session.UID ne ''}
        {insert name=check_group_mem assign=checkmem gid=$smarty.request.gid}
        <div id="groupforum">
          <div id="groupforum-title">
            <div class="titlepage">
              Post Message
            </div>
          </div>
          <div id="groupforum-content">
            <div class="arrow-general">
              &nbsp;
            </div>
            <div class="groupforum-items">
              {if $checkmem ne "0"}
              <form action="{seourl rewrite="group/`$smarty.request.urlkey`/posts/`$smarty.request.gid`/`$topic.TID`" url="group_posts.php?urlkey=`$smarty.request.urlkey`&gid=`$smarty.request.gid`&tid=`$topic.TID`"}" method="post" name="add_group_topic" id="add_group_topic">
                <div class="fm-opt">
                  <label for="fm-topictitle">Message</label>
                  <textarea id="fm-topictitle" tabindex="2" name="topic_message" rows="3" cols="55" class="fullboxtext"></textarea>
                </div>
                <div class="fm-opt">
                  <label for="fm-attachvideo">Attach a video</label>
                  <select name="message_video" id="fm-attachvideo">
                    {$video_ops}
                  </select>
                </div>
                <div class="submitbutton">
                  <input type="hidden" name="GID" value="{$answers[0].GID}" />
                  <input type="hidden" value="Add Message" name="add_message" />
                  <input type="image" src="{$baseurl}/images/btn_addtopic.gif" alt="Add Message" />
                </div>
              </form>
              {else}
              <form name="Joingroup" id="Joingroup" method="post" action="{$baseurl}/groups_home.php?urlkey={$smarty.request.urlkey}">
                <input type="hidden" name="joingroup" value=" Join to this Group " />
                <input type="hidden" name="GRPID" value="{$smarty.request.gid}" />
              </form>
              <p>Please
                <a href="javascript:void(0);" onclick="javascript:document.getElementById('Joingroup').submit();">
                  join this group
                </a>
                to post a topic.</p>
              {/if}
            </div>
          </div>
          {/if}
        </div>
      </div>
    </div>
  </div>
</div>
