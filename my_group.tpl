{if $total ne "0"}
<div id="leftside">
  <div id="groups">
    <div id="groups-title">
     <div class="titlepage">
      {translate item='global.my_groups'}
      </div>
	  <div class="videopaging">{translate item='global.groups'} {$start_num}-{$end_num} {translate item='global.of'} {$total}</div>
    </div>
    <div id="groups-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {section name=i loop=$answers}
    {insert name=group_img assign=groupimg gid=$answers[i].GID tbl=group_vdo}
    {insert name=time_to_date assign=todate tm=$answers[i].gcrtime}
    {insert name=row_count assign=mcnt gid=$answers[i].GID tbl=group_mem}
    {insert name=row_count assign=vcnt gid=$answers[i].GID tbl=group_vdo}
    {insert name=row_count assign=tcnt gid=$answers[i].GID tbl=group_tps}
    {insert name=check_group_own assign=WONID gid=$answers[i].GID}
    {assign var=looprecord value=$smarty.section.i.index}
	{if $looprecord%2 eq 0}
    {assign var=colorLoop value=""}	
    {else}
    {assign var=colorLoop value=" blue "}	
    {/if}
      <div class="group {$colorLoop}">
        <div class="groupthumb">
        <a href="{seourl rewrite="group/`$answers[i].gurl`" url="groups_home.php?urlkey=`$answers[i].gurl`"}">
                {if $groupimg eq ""}<IMG class=moduleEntryThumb height=90 src="{$imgurl}/no_videos_groups.gif" width=120>
                {else}<IMG class=moduleEntryThumb height=90 src="thumb/1_{$groupimg}.jpg" width=120>
                {/if}</A>
          <br/>
          <br />
          <div class="button">
            <br/>
          </div>
        </div>
        <div class="groupdesc">
          <p>
            <strong>
              <a href="{seourl rewrite="group/`$answers[i].gurl`" url="groups_home.php?urlkey=`$answers[i].gurl`"}">
                {$answers[i].gname|escape:'html'}
              </a>
            </strong>
            <br/>
            {$answers[i].gdescn|escape:'html'}<br/>
            {translate item='global.tags'}: {$answers[i].keyword}<br/>
            {translate item='global.status'}: {$answers[i].type}<br/>
            {translate item='global.created'}: {$todate}<br />
          <p><span class="video"><a href="{seourl rewrite="group/`$answers[i].gurl`/videos/`$answers[i].GID`" url="gvideos.php?urlkey=`$answers[i].gurl`&gid=`$answers[i].GID`"}">{$vcnt}</a></span>
            <span class="topic"><a href="{seourl rewrite="group/`$answers[i].gurl`" url="groups_home.php?urlkey=`$answers[i].gurl`"}">{$tcnt}</a></span>
            <span class="people"><a href="{seourl rewrite="group/`$answers[i].gurl`/members/`$answers[i].GID`" url="gmembers.php?urlkey=`$answers[i].gurl`&gid=`$answers[i].GID`"}">{$mcnt}</a></span></p>
          </p>
          <p>
            {if $smarty.session.UID eq $WONID}        
            <b>{translate item='my_group.owner'}</b>
            {/if}
          </p>
        </div>
      </div>
      {/section}
    </div>
    <div class="clear">
    </div>
  </div>
    <div id="paging">
        <div class="pagingnav">
        	{$page_link}
        </div>
    </div>

</div>
<div id="rightside">
  <div id="login">
    <div id="login-title">
      {translate item='global.browse_groups'}
    </div>
    <div id="login-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <div>
      <A href="{seourl rewrite="usergroups" url="groups.php"}">
        <span class="white_bold">{translate item='my_group.browse'}</span>
      </A>
      </div><br/>
      {translate item='my_group.tags'}:
      {section name=i loop=$mytags}
      <A href="{$baseurl}/search_result.php?search_type=search_groups&search_id={$mytags[i]}">
        {$mytags[i]}
      </A>
      {/section}
    </div>
  </div>
</div>
<div class="clear">
</div>
{else}
<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">
      All Channels
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <div id="videobox">
        There is no group found
      </div>
    </div>
  </div>
  <div class="clear">
    &nbsp;
  </div>
</div>
</div>
<div class="clear">
</div>
{/if}