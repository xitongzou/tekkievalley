<div id="leftside">
  {if $total > 0}
  <div id="groups">
    <div id="groups-title">
     <div class="titlepage">
      {translate item='search_group.search'}
      </div>
	  <div class="videopaging"> {translate item='search_group.result'} {$start_num} - {$end_num} {translate item='global.of'} {$total}</div>
    </div>
    <div id="groups-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {section name=i loop=$answers}
      {insert name=group_img assign=groupimg gid=$answers[i].GID tbl=group_vdo}
      {insert name=group_info_count assign=gmemcount tbl=group_mem gid=$answers[i].GID}
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
        	<img class="moduleEntryThumb" height="90" src="{$baseurl}/thumb/1_{$groupimg}.jpg" width="120" />
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
                {$answers[i].gname|escape:'html'}
              </a>
            </strong>
            <br/>
            {$answers[i].gdescn}<br/>
            {translate item='global.tags'}: {$answers[i].keyword}
            {translate item='global.status'}: {$answers[i].type}
      		{insert name=time_to_date assign=todate tm=$answers[i].gcrtime}<br />
            {translate item='global.created'}: {$todate}<br />
          <p><span class="video"><a href="{seourl rewrite="group/`$gurl`/videos/`$answers[i].GID`" url="gvideos.php?urlkey=`$gurl`&gid=`$answers[i].GID`"}">{$gvdocount}</a></span>
            <span class="topic"><a href="{seourl rewrite="group/`$gurl`" url="groups_home.php?urlkey=`$gurl`"}">{$gtpscount}</a></span>
            <span class="people"><a href="{seourl rewrite="group/`$gurl`/members/`$answers[i].GID`" url="gmembers.php?urlkey=`$gurl`&gid=`$answers[i].GID`"}">{$gmemcount}</a></span></p>
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
      <ul>
      <li><a href="{seourl rewrite='usergroups/fr' url='groups.php?b=fr'}">{translate item='search_group.featured'}</a></li>
      <li><a href="{seourl rewrite='usergroups/ra' url='groups.php?b=ra'}">{translate item='search_group.recently_added'}</a></li>
      <li><a href="{seourl rewrite='usergroups/mm' url='groups.php?b=mm'}">{translate item='search_group.most_members'}</a></li>
      <li><a href="{seourl rewrite='usergroups/mv' url='groups.php?b=mv'}">{translate item='search_group.most_videos'}</a></li>
      <li><a href="{seourl rewrite='usergroups/mt' url='groups.php?b=mt'}">{translate item='search_group.most_topics'}</a></li>
      </ul>
    </div>
  </div>
  <br/>
    <div id="login">
    <div id="login-title">
      {translate item='search_group.tags'}
    </div>
    <div id="login-content">
      <div class="arrow-general">
      </div>
        {section name=i loop=$tags}
        <a href="{seourl rewrite="tags/`$tags[i]`" url="search_result.php?search_id=`$tags[i]`"}">{$tags[i]}</a>
        {/section}
        
    </div>
  </div>
</div>
<div class="clear">
{/if}
</div>
