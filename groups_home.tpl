<div id="fullside">
    <div id="fullbox">
      <div id="fullbox-title">
        Group <a href="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}">{$smarty.request.urlkey|escape:'html'}</a> 
      </div>
      <div id="fullbox-content">
        <div class="arrow-general">
          &nbsp;
        </div>
        <div class="group-home">
          <div class="groupthumb">
            {insert name=group_info_count assign=gmemcount tbl=group_mem gid=$answers[0].GID query="and approved='yes'"}
            {insert name=group_info_count assign=gvdocount tbl=group_vdo gid=$answers[0].GID query="and approved='yes'"}
            {insert name=group_info_count assign=gtpscount tbl=group_tps gid=$answers[0].GID query="and approved='yes'"}
            {insert name=check_group_mem assign=checkmem gid=$answers[0].GID}
            {insert name=group_img assign=groupimg gid=$answers[0].GID tbl=group_vdo}
            {if $groupimg eq ""}
            	{assign var=imgThumb value="no_videos_groups.gif"}
            	<img height="90" src="{$imgurl}/{$imgThumb}" width="120" /><br/>
            {else}
            	{assign var=imgThumb value="1_$groupimg.jpg"}
            	<img height="90" src="{$tmburl}/{$imgThumb}" width="120" /><br/>
            {/if}
            
			<br />
              <div class="button"> 
              {*--------- Begin Check Sessuib UID Not Equal Blank --------- *}
              {if $smarty.session.UID ne "" and $checkmem ne "0"}
                {if $smarty.session.UID eq $answers[0].OID}
                    <a href="{seourl rewrite="group/edit/`$smarty.request.urlkey`" url="my_group_edit.php?urlkey=`$smarty.request.urlkey`"}"><img src="{$imgurl}/btn_editgroup.gif" alt="Edit Group" /></a>
                    <a href="{seourl rewrite="group/add/video/`$smarty.request.urlkey`/`$answers[0].GID`" url="add_video.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$answers[0].GID`"}"><img src="{$imgurl}/btn_addvideo.gif" alt="Add Videos" /></a>
                {else} 
                    {if $is_mem eq 'yes'}
                      {insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$answers[0].GID}
                        {if $smarty.session.UID eq $owner_id and $gupload eq "owner_only"}
                            <a href="{$baseurl}/add_video.php?urlkey={$smarty.request.urlkey}&amp;gid={$answers[0].GID}"><img src="{$imgurl}/btn_addvideo.gif" alt="Add Videos" /></a>
                        {/if}
                        {if $gupload ne "owner_only"}
                            <a href="{$baseurl}/add_video.php?urlkey={$smarty.request.urlkey}&amp;gid={$answers[0].GID}"><img src="{$imgurl}/btn_addvideo.gif" alt="Add Videos" /></a>
                        {/if}
                        <a href="invite_members.php?urlkey={$smarty.request.urlkey}"><img src="{$imgurl}/btn_invitemembers.gif" alt="Invite Members" /></a>
                    {/if}
                {/if}
              {/if}
              {* --------- End Check Sessuib UID Not Equal Blank --------- *}
            </div>
          </div>
          <div class="group-home-desc">
            <p>
              <strong>
                {$answers[0].gname|escape:'html'}
              </strong><br/>
              {$answers[0].gdescn|escape:'html'}
              <br/>
              {translate item='global.tags'}: {$answers[0].keyword}<br />
              {translate item='global.channels'}:&nbsp;
                {insert name=video_channel assign=grpchannel tbl=group_own gid=$answers[0].GID}
                {section name=k loop=$grpchannel}
                	<a href="{seourl rewrite="categories/`$grpchannel[k].CHID`" url="channel_detail.php?chid=`$grpchannel[k].CHID`" clean=$grpchannel[k].name}">{$grpchannel[k].name}</a>
                {/section}
                &nbsp;
              <br />
              {translate item='global.type'}: {$answers[0].type}<br />
              {translate item='groups_home.created_by'}:&nbsp;
                {insert name=id_to_name assign=uname un=$answers[0].OID}
                <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$answers[0].OID`"}">
                {$uname}
		        </a>
              <br />
              {if $smarty.session.UID eq $answers[0].OID}
                {assign var=memberShipStatus value="You are the owner of this group."} 
              {elseif $is_mem eq "no"}
                {assign var=memberShipStatus value="Your request is sent to the owner."}
              {elseif $is_mem eq "yes"}
                {assign var=memberShipStatus value="You are the member of this group."}
              {else}
                {assign var=memberShipStatus value="You are not the member of this group."}
              {/if}
              
              {translate item='groups_home.membership_status'}: <strong>{$memberShipStatus}</strong>
              <br />
              {translate item='groups_home.url'}: <a href="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}">{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}</a>
              <p id="grouphome_icon">
              <span class="video" alt="video"><a href="{seourl rewrite="group/`$smarty.request.urlkey`/videos/`$answers[0].GID`" url="gvideos.php?urlkey=`$smarty.request.urlkey`&gid=`$answers[0].GID`"}">{$gvdocount}</a></span>
              {if $smarty.session.UID eq $answers[0].OID}
                  {if $total_new_video ne "0"}
                    <span class="newvideo" alt="new video">{$total_new_video}</span>
                  {/if}
              {/if}
              <span class="people" alt="member"><a href="{seourl rewrite="group/`$smarty.request.urlkey`/members/`$answers[0].GID`" url="gmembers.php?urlkey=`$smarty.request.urlkey`&gid=`$answers[0].GID`"}">{$gmemcount}</a></span>
              {if $smarty.session.UID eq $answers[0].OID}
                  {if $total_new_member ne "0"}
                    <span class="newpeople" alt="new member">{$total_new_member}</span>
                  {/if}
              {/if}
              </a>
              <br/><br/>
              {if $smarty.session.UID ne $answers[0].OID}
                <form name="Joingroup" method="post" action="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}">
                {if $checkmem eq "0"}
                    <input type="hidden" name="joingroup" value=" Join to this Group "/>
                    <input type="image" src="{$imgurl}/btn_joingroup.gif" alt="Join Group"  />
                {elseif $is_mem eq "yes"}
                	<input type="hidden" name="leavegroup" value=" Leave this Group "/>
                    <input type="image" src="{$imgurl}/btn_leavegroup.gif" alt="Leave Group"  />
                {/if}
                	<input type="hidden" name="GRPID" value="{$answers[0].GID}"/>
                </form>
              {/if}
              </p>
            </p>
          </div>
          <div class="clear">
            &nbsp;
          </div>
          <div id="groupforum">
            <div id="groupforum-title">
              <div class="titlepage">
                {translate item='groups_home.forum_messages'}
              </div>
              <div class="videopaging">
                 {insert name=topic_count assign=total_topic GID=$answers[0].GID}
              </div>
            </div>
            <div id="groupforum-content">
              <div class="arrow-general">
                &nbsp;
              </div>
              <div class="groupforum-items">
                <div class="inbox">
                  <br/>
                  {if $grptps eq ""}
                  	<p>{translate item='groups_home.no_topics'}</p>
                  {else}
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <th scope="col">{translate item='groups_home.topics'}</th>
                      <th scope="col">{translate item='groups_home.author'}</th>
                      <th scope="col">{translate item='groups_home.posts'}</th>
                      <th scope="col">{translate item='groups_home.created'}</th>
                      <th scope="col">{translate item='groups_home.last_post'}</th>
                      <th scope="col">&nbsp;</th>
                    </tr>
                    {insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$answers[0].GID}
                    {section name=i loop=$grptps}
                    {assign var=looprecord value=$smarty.section.i.index}
                    {if $looprecord%2 eq 0}
                        {assign var=colorLoop value=""}	
                    {else}
                        {assign var=colorLoop value=" blue "}	
                    {/if}
                    {if $smarty.session.UID eq $owner_id or $grptps[i].approved eq "yes"}
                    {insert name=id_to_name assign=uname un=$grptps[i].UID}
                    {insert name=post_count assign=total_post TID=$grptps[i].TID}
                    {insert name=getfield assign=lastpost field='date' table='group_tps_post' qfield='TID' qvalue=$grptps[i].TID order='order by PID desc'}
                    <tr>
                      <td class="{$colorLoop}"><a href="{seourl rewrite="group/`$smarty.request.urlkey`/posts/`$answers[0].GID`/`$grptps[i].TID`" url="group_posts.php?urlkey=`$smarty.request.urlkey`&gid=`$answers[0].GID`&tid=`$grptps[i].TID`"}">{$grptps[i].title|truncate:110|escape:'html'}</a></td>
                      <td class="{$colorLoop} center"><a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$grptps[i].UID`"}">{$uname}</a></td>
                      <td class="{$colorLoop} center">{$total_post}</td>
                      <td class="{$colorLoop} center">{$grptps[i].addtime|date_format:"%b %e, %Y, %I:%M %p"}</td>
                      <td class="{$colorLoop} center">{if $lastpost eq ""}N/A{else}{insert name=timediff time=$lastpost}{/if}</td>
                      {if $smarty.session.UID eq $owner_id and $grptps[i].approved eq "no"}          
                        <td class="{$colorLoop} center">
                        <form name="apostform{$grptps[i].TID}" id="apostform{$grptps[i].TID}" action="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}" method="post">
                          <input type="hidden" name="apost_TID" value="Approve" />
                          <input type="image" src="{$imgurl}/btn_approve.gif" alt="Approve"  />
                          <input type="hidden" name="apost_TID" value="{$grptps[i].TID}" />
                        </form>
                        <form name="unapostform{$grptps[i].TID}" id="unapostform{$grptps[i].TID}" action="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}" method="post">
                          <input type="hidden" name="unapost_TID" value="Delete"/>
                          <input type="image" src="{$imgurl}/btn_remove.gif" alt="Delete"  />
                          <input type="hidden" name="unapost_TID" value="{$grptps[i].TID}" />
        				</form>			
                        </td>
                      {else}
                      	<td class="center">&nbsp;</td>                        
                      {/if}
					</tr>
                    {/if}
                    {/section} 
                    <tr>
                      <td colspan="6" align="center">
                      <div id="paging">
                        <div class="pagingnav">
                          {$page_link}
                        </div>
                      </div>
                      </td>
                    </tr>
                  </table>
                  {/if}
                  <br/>
                {insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$answers[0].GID}
                {if $smarty.session.UID eq $owner_id or $answers[0].gposting ne 'owner_only'}
                	{if $smarty.session.UID ne ''}
                		{if $checkmem ne "0"}
                        	{* ---- Check If User Has Join Group Or Not ----*}
                			{if $is_mem eq "yes"}
							 <div id="formNewTopic"> 
                              <form action="{seourl rewrite="group/`$smarty.request.urlkey`" url="groups_home.php?urlkey=`$smarty.request.urlkey`"}" method="post" name="add_group_topic" id="add_group_topic">
                                <div class="fm-opt">
                                	<label for="fm-topictitle">{translate item='groups_home.add_topic'}</label>
                                    <textarea id="fm-topictitle" tabindex="2" name="topic_title" rows="3" cols="55" class="fullboxtext"></textarea>
                                </div>
                                <div class="fm-opt">
                                	<label for="fm-attachvideo">{translate item='groups_home.attach_video'}</label>
                                	<select name="topic_video" id="fm-attachvideo">{$video_ops}</select>
                                </div>
                                <div class="submitbutton">
                                <input type="hidden" name="GID" value="{$answers[0].GID}" />
                                <input type="hidden" value="Add Topic" name="add_topic" />
                                <input type="image" src="{$imgurl}/btn_addtopic.gif" alt="Add Topic" />
                                </div>
                              </form>
                        	 </div>
                            {/if}
                            {else}
                              <form name="Joingroup" id="Joingroup" method="post" action="{$baseurl}/groups_home.php?urlkey={$smarty.request.urlkey}">
                                <input type="hidden" name="joingroup" value=" Join to this Group " class="fullboxtext"/>
                                <input type="hidden" name="GRPID" value="{$smarty.request.gid}" class="fullboxtext" />
                              </form>
                              Please <a href="javascript:void(0);" onclick="javascript:document.getElementById('Joingroup').submit();"> join this group </a> to post a topic.
                           {/if} 
                           {* ---- End Check If User Has Join Group Or Not ----*}
						{else}
                          Please <a href="{$baseurl}/signup.php?next=groups_home&amp;add={$add}">Login</a> to post new topic
                        {/if}
                    {/if}
                </div>
              </div>
            </div>
            <div class="clear">
            </div>
          </div>
          <div class="clear">
            &nbsp;
          </div>
          <div id="grouprecentvideo">
            <div id="grouprecentvideo-title">
              <div class="titlepage">
                {translate item='groups_home.recent_videos'}
              </div>
              <div class="navvideo">
              </div>
              <div class="videopaging">
                <a href="{seourl rewrite="group/`$answers[0].gurl`/videos/`$answers[0].GID`" url="gvideos.php?gid=`$answers[0].GID`"}">View All Videos</a>
              </div>
            </div>
            <div id="grouprecentvideo-content">
              <div class="arrow-general">
                &nbsp;
              </div>
        {assign var=gtotal value=$gvideo|@count}
        {if $total le 5}
        {math equation="x * y" x=$gtotal y=140 assign=tablewidth } 
        {else}
        {assign var=tablewidth value="99%"}    
        {/if}
      <div id="videobox">
        <table align="center" width="{$tablewidth}">
                  <tr>
                    <td><!--recently-->
                    {section name=i loop=$gvideo}
                      <div class="listchannel">
                        <div class="imagechannel"><a href="{seourl rewrite="video/`$gvideo[i].VID`" url="view_video.php?viewkey=`$gvideo[i].vkey`" clean=$gvideo[i].title}"><img height="90" src="{$tmburl}/{$gvideo[i].thumb}_{$gvideo[i].VID}.jpg" width="120" /></a></div>
                        <a href="{seourl rewrite="video/`$gvideo[i].VID`" url="view_video.php?viewkey=`$gvideo[i].vkey`" clean=$gvideo[i].title}">{$gvideo[i].title|escape:'html'}</a>
                      </div> 
                      {/section}
                      <!-- -->
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="clear">
            &nbsp;
          </div>
          <div id="grouprecentvideo">
            <div id="grouprecentvideo-title">
              <div class="titlepage">
                {translate item='groups_home.recent_members'}
              </div>
              <div class="navvideo">
              </div>
              <div class="videopaging"><a href="{seourl rewrite="group/`$smarty.request.urlkey`/members/`$answers[0].GID`" url="gmembers.php?gid=`$answers[0].GID`"}">View All Members</a></div>
            </div>
            <div id="grouprecentvideo-content">
              <div class="arrow-general">
                &nbsp;
              </div>
  	    {assign var=gmtotal value=$gmember|@count}
        {if $total le 5}
        {math equation="x * y" x=$gmtotal y=140 assign=tablewidth }
        {else}
        {assign var=tablewidth value="99%"}    
        {/if}
      <div id="videobox">
        <table align="center" width="{$tablewidth}">
                  <tr>
                    <td><!--Most Viewed-->
                      {section name=i loop=$gmember}
                      {insert name=id_to_name assign=uname un=$gmember[i].UID}
                      <div class="listchannel">
                        <div class="imagechannel">
                          <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$gmember[i].UID`"}">{insert name=member_img UID=$gmember[i].UID}</a>
                        </div>
                        <br/>
                          <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$gmember[i].UID`"}"><strong>{$uname}</strong></a>
                        <br/>
                      </div>
                      {/section}
                      <!-- -->
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clear">
      </div>
    </div>
  </div>
</div>
<div class="clear">
</div>
