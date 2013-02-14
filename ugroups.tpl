<div id="leftside">
  <div id="groups">
    <div id="groups-title">
      <div class="titlepage">
        {translate item='menu.groups'}
      </div>
      <div class="videopaging">{translate item='menu.groups'} {$start_num} - {$end_num} {translate item='global.of'} {$total}</div>
    </div>
    <div id="groups-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {section name=i loop=$answers}
      {insert name=group_img assign=groupimg gid=$answers[i].GID tbl=group_vdo}
      {insert name=group_info_count assign=gmemcount tbl=group_mem gid=$answers[i].GID  query="and approved='yes'"}
      {insert name=group_info_count assign=gvdocount tbl=group_vdo gid=$answers[i].GID  query="and approved='yes'"}
      {insert name=group_info_count assign=gtpscount tbl=group_tps gid=$answers[i].GID  query="and approved='yes'"}
      { insert name=gid_to_gurl assign=gurl gid=$answers[i].GID}
      {assign var=looprecord value=$smarty.section.i.index}
      {if $looprecord%2 eq 0}
      {assign var=colorLoop value=""}
      {else}
      {assign var=colorLoop value=" blue "}
      {/if}
      <div class="group {$colorLoop}">
        <div class="groupthumb">
          <a href="{seourl rewrite="group/`$gurl`" url="groups_home.php?urlkey=`$gurl`"}">
            {if $groupimg eq ""}
            <img class="moduleEntryThumb" height="90" src="{$imgurl}/no_videos_groups.gif" width="120" />
            {else}
            <img class="moduleEntryThumb" height="90" src="{$tmburl}/1_{$groupimg}.jpg" width="120" />
            {/if}
          </a>
          <br/>
          <br />
          <div class="button">
            <br/>
          </div>
        </div>
        <div class="groupdesc">
          <p>
            <strong>
              <a href="{seourl rewrite="group/`$gurl`" url="groups_home.php?urlkey=`$gurl`"}">
                {$answers[i].gname}
              </a>
            </strong>
            <br/>
            {$answers[i].gdescn}
            <br/>
            {translate item='global.tags'}:
            {$answers[i].keyword}<br>
            {translate item='global.status'}:
            {$answers[i].type}
            {insert name=time_to_date assign=todate tm=$answers[i].gcrtime}
            <br />
            {translate item='global.created'}:
            {$todate}
            <br />
          <p><span class="video">
            <a href="{seourl rewrite="group/`$gurl`/videos/`$answers[i].GID`" url="gvideos.php?urlkey=`$gurl`&gid=`$answers[i].GID`"}">
              {$gvdocount}
            </a>
            </span>
            <span class="topic">
            <a href="{seourl rewrite="group/`$gurl`" url="groups_home.php?urlkey=`$gurl`"}">
              {$gtpscount}
            </a>
            </span>
            <span class="people">
            <a href="{seourl rewrite="group/`$gurl`/members/`$answers[i].GID`" url="gmembers.php?urlkey=`$gurl`&gid=`$answers[i].GID`"}">
              {$gmemcount}
            </a>
            </span></p>
          </p>
        </div>
      </div>
      {/section}
    </div>
    <div class="clear"></div>
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
      <!--Begin Left Side Group Navigation Links-->
      <a href="{seourl rewrite='groups/fr' url='groups.php?b=fr'}">{translate item='groups.featured'}</a><br/>
      <a href="{seourl rewrite='groups/ra' url='groups.php?b=ra'}">{translate item='groups.recently_added'}</a><br/>
      <a href="{seourl rewrite='groups/mm' url='groups.php?b=mm'}">{translate item='groups.most_members'}</a><br/>
      <a href="{seourl rewrite='groups/mv' url='groups.php?b=mv'}">{translate item='groups.most_videos'}</a><br/>
      <a href="{seourl rewrite='groups/mt' url='groups.php?b=mt'}">{translate item='groups.most_topics'}</a><br/><br/>
      <a href="{seourl rewrite='groups' url='groups.php'}">{translate item='groups.browse_more'}</a>
    </div>
  </div>
  <br/>
  <div id="login">
    <div id="login-title">
      {translate item='groups.tags'}
    </div>
    <div id="login-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {section name=i loop=$tags}
      <a href="{seourl rewrites="tags/groups/`$tags[i]`" url="search_result.php?search_type=search_groups&search_id=`$tags[i]`"}">
        {$tags[i]}
      </a>
      {/section}
    </div>
  </div>
</div>
<div class="clear">
</div>
