{php}
	function insert_cutText($array){
        $text = @$array["un"]["title"];
        $size = @$array["un"]["size"];
		$useDot = @$array["un"]["useDot"];
        $useDot == "" ? $useDot = true : $useDot = false ;
        $size == "" ? $size = 15 : $size = $size ;
        $dot = "";
        if ($useDot == "true"){$dot = "...";}
        if ((strlen($text)-1) <=  $size){
            $dot = "";
        }
        return substr($text,0,$size).$dot;
	}
    
    function insert_removeTag($array){
    	$tag = $array["tag"];
        $text = $array["text"];
        return str_replace($tag," ",$text);
    }
	
	function insert_cutTextDesc($array){
        $text = @$array["un"]["descrip"];
        $size = @$array["un"]["size"];
		$useDot = @$array["un"]["useDot"];
        $useDot == "" ? $useDot = true : $useDot = false ;
        $size == "" ? $size = 18 : $size = $size ;
        $dot = "";
        if ($useDot == "true"){$dot = "...";}
        if ((strlen($text)-1) <=  $size){
            $dot = "";
        }
        return substr($text,0,$size).$dot;
	}
{/php}
<div id="fullside">
  {insert name=advertise assign=adv group='video_top'}
  {$adv}
  <div id="fullbox">
    <div id="fullbox-title">
      <div class="titlepage">{translate item='video.watch_videos'}</div>
      <div class="navvideo">
        <p class="basicdetailed"><img src="{$imgurl}/arrowright.gif" />
          <a href="{seourl rewrite="videos/basic/`$page`" url="video.php?page=`$page`&amp;viewtype=basic"}">{translate item='video.basic'}</a>
        </p>
        <p class="basicdetailed"><img src="{$imgurl}/arrowright.gif" />
          <a href="{seourl rewrite="videos/detailed/`$page`" url="video.php?page=`$page`&amp;viewtype=detailed"}">{translate item='video.detailed'}</a>
        </p>
      </div>
      <div class="videopaging">{translate item='global.videos'} {$start_num} - {$end_num} {translate item='global.of'} {$total}</div>
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {if $total le 5}
      	{math equation="x * y" x=$total y=150 assign=tablewidth } 
      {else}
  		{assign var=tablewidth value="99%"}    
      {/if}
	  <div id="categories">
	  <h4>{translate item='video.cat'}</h4>
        <div class="listchannel">
{foreach from=$channels item=chan}
<a href="{seourl rewrite="categories/`$chan.CHID`" url="channel_detail.php?chid=`$chan.CHID`" clean=$chan.name}">{$chan.name}</a><br />
{/foreach}		
         </div>
	  </div>
      <div id="videobox">
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
              {if $smarty.request.viewtype eq "" or $smarty.request.viewtype eq "basic"}
              {section name=i loop=$answers}
              <div class="listchannel"  style="height: 210px;">
                {if $smarty.section.i.index mod 4 eq "0" and $smarty.section.i.index gt "0"}
                {/if}
                {assign var=looprecord value=$smarty.section.i.index}
                
                {if $looprecord%2 eq 0}
                	{assign var=colorLoop value=""}
                {else}
                	{assign var=colorLoop value="class='blue'"}
                {/if}
                <div class="imagechannel">
                  <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&page=`$page`&viewtype=`$viewtype`&category=$catgy" clean=$answers[i].title}">
                    <img src="{$tmburl}/{$answers[i].thumb}_{$answers[i].VID}.jpg" width="120" id="rotate_{$answers[i].VID}" />
                  </a>
                </div>                
                {insert name=cutText assign=cutTextVar un=$answers[i]}
                <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&page=`$page`&viewtype=`$viewtype`&category=$catgy" clean=$answers[i].title}" title="{$answers[i].title|escape:'html'}">
                  <span class="title">{$cutTextVar|escape:'html'}</span>
                </a>
				<br />
				{insert name=duration assign=duration duration=$answers[i].duration}
                <span class="duration">{$duration}</span>
                <br/>
                <span class="info">{translate item='global.added'}:</span> {insert name=time_range assign=rtime field=addtime IDFR=VID id=$answers[i].VID tbl=video} {$rtime} <br />
                <span class="info">{translate item='global.from'}:</span>
                <a href="{seourl rewrite="users/`$answers[i].username`" url="uprofile.php?UID=`$answers[i].UID`"}" target="_parent">{$answers[i].username|truncate:10:'...':true|escape:'html'}</a><br />
                <span class="info">{translate item='global.views'}:</span> {$answers[i].viewnumber} <br/>
                {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                <span class="info">{translate item='global.comments'}:</span> {$commentcount}
                <br/>
                <div class="startratebox"> 
                    {insert name=show_rate assign=rate rte=$answers[i].rate}
                    <span class="info">{$rate}</span> 
                </div>
              </div>
              {/section}
              {/if}
	      
              {if $smarty.request.viewtype eq "detailed"}
              {section name=i loop=$answers}
              <div class="listchannellarge">
                {assign var=looprecord value=$smarty.section.i.index}
                {if $looprecord%2 eq 0}
                {assign var=colorLoop value=""}
                {else}
                {assign var=colorLoop value="class='blue'"}
                {/if}
                <div class="imagechannel">
                  <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&page=`$page`&viewtype=`$viewtype`&category=$catgy" clean=$answers[i].title}">
                    <img  src="{$tmburl}/1_{$answers[i].VID}.jpg" width="100" />
                  </a>
                  <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&page=`$page`&viewtype=`$viewtype`&category=$catgy" clean=$answers[i].title}">
                    <img  src="{$tmburl}/2_{$answers[i].VID}.jpg" width="100" />
                  </a>
                  <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&page=`$page`&viewtype=`$viewtype`&category=$catgy" clean=$answers[i].title}">
                    <img  src="{$tmburl}/3_{$answers[i].VID}.jpg" width="100" />
                  </a>
                </div>
                <div class="imagechannelinfo">
                  <a href="{seourl rewrite="video/`$answers[i].VID`" url="view_video.php?viewkey=`$answers[i].vkey`&page=`$page`&viewtype=`$viewtype`&category=$catgy" clean=$answers[i].title}"><span class="title">{$answers[i].title|escape:'html'|wordwrap:40:"<br>":true}</span></a><br/>
				  {assign var=viddur value=$answers[i].duration}
                {math equation="$viddur/60" format="%0.0f" assign=minutes}
                {math equation="$viddur - ($minutes * 60)" format="%0.0f" assign=seconds}
                
                {if $seconds < 0}
                	{math equation="$minutes - 1" assign=minutes}
                	{math equation="$seconds + 60" assign=seconds}
                {/if}
                
                <span class="duration">{$minutes}:{$seconds}</span><br/>
                  {$answers[i].description|wordwrap:45:"<br />":true}<br/>
                  <span class="info">{translate item='global.added'}:</span>{insert name=time_range assign=rtime field=addtime IDFR=VID id=$answers[i].VID tbl=video} {$rtime}
                  <span class="info">{translate item='global.from'}:</span><a href="{$baseurl}/uprofile.php?UID={$answers[i].UID}" target="_parent"> {$answers[i].username}</a><br/>
                  <span class="info">{translate item='global.views'}:</span> {$answers[i].viewnumber} | {insert name=comment_count assign=commentcount vid=$answers[i].VID}
                  <span class="info">{translate item='global.comments'}:</span> {$commentcount}<br/>
                  <div class="startratebox"> 
                  
                  	{insert name=show_rate assign=rate rte=$answers[i].rate}
                  	<span class="info">{$rate}</span>
                  
                  </div>
                </div>
              </div>
              {/section}
              {/if}
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
  <div id="paging">
    <div class="pagingnav">
        {insert name=removeTag assign=pageLink tag="<BR>" text=$page_link}
        {insert name=removeTag assign=pageLink tag="&nbsp;" text=$pageLink}
      	{$pageLink}
    </div>
  </div>
</div>