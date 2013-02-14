{include file="search-community.tpl"}
<div id="fullside">
  {insert name=advertise assign=adv group='community_top'}
  {$adv}
  <div id="fullbox">
    <div id="fullbox-title">
      <div class="titlepage">{translate item='menu.community'}</div>
      <div class="navvideo">
        <p class="basicdetailed"><img src="{$imgurl}/arrowright.gif" />
          <a href="{seourl rewrite='community' url='members.php'}">{translate item='members.all'}</a> 
        </p>
        <p class="basicdetailed"><img src="{$imgurl}/arrowright.gif" />
           <a href="{seourl rewrite='community/avatar' url='members.php?type=avatar'}">{translate item='members.avatar'}</a> 
        </p>
      </div>
	<div class="videopaging">{translate item='members.show'} {$start_num}-{$end_num} {translate item='global.of'} {$total}</div>   
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
     {assign var=total value=$answers|@count}
     {if $total le 5}
      	{math equation="x * y" x=$total y=150 assign=tablewidth } 
      {else}
  		{assign var=tablewidth value="99%"}    
      {/if}
      <div id="videobox">
        <table align="center" width="{$tablewidth}">
          <tr>
            <td> 
              {if $smarty.request.viewtype eq "" or $smarty.request.viewtype eq "basic"}
                {section name=i loop=$answers}
                      {insert name=video_count assign=vdocount uid=$answers[i].UID} 
                      <div class="listchannel">
                        <div class="imagechannel">
							<a href="{seourl rewrite="users/`$answers[i].username`" url="uprofile.php?UID=`$answers[i].UID`"}">
                   			 <img  id="video" src="{$baseurl}/photo/{if $answers[i].photo eq ""}nopic.gif{else}{$answers[i].photo}{/if}"/>
                            </a>
                        </div>
                        <span class="title"><a href="{seourl rewrite="users/`$answers[i].username`" url="uprofile.php?UID=`$answers[i].UID`"}">
                    	{$answers[i].username} </a></span><br/>
                        {$answers[i].profile_viewed} <span class="info">{translate item='members.profile_views'}</span><br/>
                        {$vdocount} <span class="info">{translate item='global.videos'}</span><br/>
                      </div> 
                    
              {/section}
             {/if}
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="clear">
    &nbsp;
  </div>
  <div id="paging">
    <div class="pagingnav">
      {$page_link}
    </div>
  </div>
</div>