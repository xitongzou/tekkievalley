{php}
	function insert_cutText($array){
        $text = @$array["un"];
        $useDot == "" ? $useDot = true : $useDot = false ;
        $size == "" ? $size = 15 : $size = $size ;
        $dot = "";
        if ($useDot == "true"){$dot = "...";}
        if ((strlen($text)-1) <=  $size){
            $dot = "";
        }
        return substr($text,0,$size).$dot;
	}
{/php}

{if $total ne 0}
    <div id="fullside">
      <div id="fullbox">
        <div id="fullbox-title">
          <div class="titlepage">{translate item='global.search_videos'}</div>
          <div class="navvideo">
            <p class="basicdetailed"><img src="{$imgurl}/arrowright.gif" />
	      <a href="{seourl rewrite="search/basic/?search_id=`$smarty.request.search_id`" url="search_result.php?search_id=`$smarty.request.search.id`&search_type=search_videos&viewtype=basic"}">
                {translate item='search_result.basic'}
              </a>
            </p>
            <p class="basicdetailed"><img src="{$imgurl}/arrowright.gif" />
	      <a href="{seourl rewrite="search/detailed/?search_id=`$smarty.request.search_id`" url="search_result.php?search_id=`$smarty.request.search.id`&search_type=search_videos&viewtype=detailed"}">
                {translate item='search_result.detailed'}
              </a>
            </p>
          </div>
          
          <div class="videopaging">
            {translate item='search_result.result_videos'} {$start_num} - {$end_num} {translate item='global.of'} {$total}
          </div>
        </div>
        <div id="fullbox-content">
          <div class="arrow-general">
            &nbsp;
          </div>
          <div id="videobox">
            <p>{$msg_}</p>
            {if $total gt "0"}
            <p>{translate item='search_result.related_tags'}:
                {section name=i loop=$tags}
                <a href="{seourl rewrite="tags/`$tags[i]`" url="search_result.php?search_id=`$tags[i]`"}">{$tags[i]}</a>
                {/section}
            </p>
            <p>Sort by: 
	    <a href="{seourl rewrite="search/`$viewtype`/`$page`/?sort=addate&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`" url="search_result.php?viewtype=`$viewtype`&page=`$page`&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`&sort=addate"}">{translate item='search_result.date_added'}</a> - 
	    <a href="{seourl rewrite="search/`$viewtype`/`$page`/?sort=title&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`" url="search_result.php?viewtype=`$viewtype`&page=`$page`&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`&sort=title"}">{translate item='search_result.title'}</a> - 
	    <a href="{seourl rewrite="search/`$viewtype`/`$page`/?sort=viewnum&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`" url="search_result.php?viewtype=`$viewtype`&page=`$page`&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`&sort=viewnum"}">{translate item='search_result.view_count'}</a> - 
	    <a href="{seourl rewrite="search/`$viewtype`/`$page`/?sort=rate&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`" url="search_result.php?viewtype=`$viewtype`&page=`$page`&search_type=`$smarty.request.search_type`&search_id=`$smarty.request.search_id`&sort=rate"}">{translate item='search_result.rating'}</a>
            </p>
             {assign var=totalData value=$answers|@count}
              {if $totalData le 6}
                {math equation="x * y" x=$total y=100 assign=tablewidth } 
              {else}
                {assign var=tablewidth value="99%"}    
              {/if}
            <table align="center" width="{$tablewidth}">
              <tr>
                <td>
                  {if $smarty.request.category eq ""}
                    {assign var="catgy" value=mr}
                  {else}
                    {assign var="catgy" value=$smarty.request.category}
                  {/if}
                  {insert name=tag_to_name assign=tagname tag=$catgy}
                  <!--{$tagname}-->
                  {if $viewtype eq "" or $viewtype eq "basic"}
                  {section name=i loop=$answers}
                  <div class="listchannel">
                    {if $smarty.section.i.index mod 4 eq "0" and $smarty.section.i.index gt "0"}
                    {/if}
                    {assign var=looprecord value=$smarty.section.i.index}
                    {if $looprecord%2 eq 0}
                    {assign var=colorLoop value=""}
                    {else}
                    {assign var=colorLoop value="class='blue'"}
                    {/if}
                    {insert name=cutText assign=cutTextVar un=$answers[i].title}
                    <div class="imagechannel">
                      <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$page`&amp;viewtype=`$viewtype`&amp;category=`$catgy`" clean=$answers[i].title"}">
                        <img class="moduleFeaturedThumb" height="90" src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width="120" />
                      </a>
                    </div>
                      <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$page`&amp;viewtype=`$viewtype`&amp;category=`$catgy`" clean=$answers[i].title"}">
                      <span class="title">{$cutTextVar}</span>
                    </a>
					<br/>                
                    {assign var=viddur value=$answers[i].duration}
                    {math equation="$viddur/60" format="%0.0f" assign=minutes}
                    {math equation="$viddur - ($minutes * 60)" format="%0.0f" assign=seconds}
                    {if $seconds < 0}
                    {math equation="$minutes - 1" assign=minutes}
                    {math equation="$seconds + 60" assign=seconds}
                    {/if}
                    <span class="duration">{$minutes}:{$seconds}</span>
                    <br/>
                    <span class="info">{translate item='global.added'}:</span>
                    {insert name=time_range assign=rtime field=addtime IDFR=VID id=$answers[i].VID tbl=video}
                    {$rtime}
                    <br />
                    <span class="info">{translate item='global.from'}</span>
                    {insert name=id_to_name assign=uname un=$answers[i].UID}
                    <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$answers[i].UID`"}" target="_parent">
                      {$uname}
                    </a><br />
                    <span class="info">{translate item='global.views'}:</span>
                    {$answers[i].viewnumber}
                    <br/>
                    {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                    <span class="info">{translate item='global.comments'}:</span>
                    {$commentcount}
                    <br/>
                    <div class="startratebox"> 
                        {insert name=show_rate assign=rate rte=$answers[i].rate}
                        <span class="info">{$rate}</span> 
                    </div>
                  </div>
                  {/section}
                  {/if}
                  {if $viewtype eq "detailed"}
                  {section name=i loop=$answers}
                  <div class="listchannellarge">
                    {assign var=looprecord value=$smarty.section.i.index}
                    {if $looprecord%2 eq 0}
                    {assign var=colorLoop value=""}
                    {else}
                    {assign var=colorLoop value="class='blue'"}
                    {/if}
                    <div class="imagechannel">
                      <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$page`&amp;viewtype=`$viewtype`&amp;category=`$catgy`" clean=$answers[i].title"}">
                        <img class="moduleFeaturedThumb" height="70" src="{$tmburl}/1_{$answers[i].VID}.jpg" width="100" />
                      </a>
                      <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$page`&amp;viewtype=`$viewtype`&amp;category=`$catgy`" clean=$answers[i].title"}">
                        <img class="moduleFeaturedThumb" height="70" src="{$tmburl}/2_{$answers[i].VID}.jpg" width="100" />
                      </a>
                      <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$page`&amp;viewtype=`$viewtype`&amp;category=`$catgy`" clean=$answers[i].title"}">
                        <img class="moduleFeaturedThumb" height="70" src="{$tmburl}/3_{$answers[i].VID}.jpg" width="100" />
                      </a>
                    </div>
                    <div class="imagechannelinfo">
                      <strong>
                        <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&amp;page=`$page`&amp;viewtype=`$viewtype`&amp;category=`$catgy`" clean=$answers[i].title}">
                          {$answers[i].title|escape:'html'}
                        </a>
                      </strong>
                      <br/>
                      {$answers[i].description}
                      <br/>
                      {translate item='global.added'}:
                      {insert name=time_range assign=rtime field=addtime IDFR=VID id=$answers[i].VID tbl=video}
                      {$rtime}
                      {translate item='global.from'}
                      {insert name=id_to_name assign=uname un=$answers[i].UID}
                      <a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$answers[i].UID`"}" target="_parent">
                        {$uname}
                      </a>
                      <br/>
                      {translate item='global.duration'}:
                      {$answers[i].duration|string_format:"%.2f"}
                      <br />
                      {translate item='global.views'}:
                      {$answers[i].viewnumber}
                      |
                      {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                      {translate item='global.comments'}:
                      {$commentcount}
                      <br/>
                      {if $answers[i].ratedby gt "0"}
                      <div class="startratebox"> 
                        {insert name=show_rate assign=rate rte=$answers[i].rate}
                        {$rate}
                      </div>
                      {/if}
                    </div>
                    
                  </div>
                  {/section}
                  {/if}
                  <!-- -->
                </td>
              </tr>
            </table>
            {/if}
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
{/if}