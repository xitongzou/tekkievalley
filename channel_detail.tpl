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
    
    function insert_removeBold($text){
    	$text = $text["un"];
    	$text = str_replace("<b>", "", "$text");
        $text = str_replace("<b>", "", "$text");
        return $text;
    }    
{/php}
<div id="categories">
<div class="clear"></div>
	  <div id="categories">
	  <h4>{translate item='video.cat'}</h4>
        <div class="listchannel">
{foreach from=$channels item=chan}
<a href="{seourl rewrite="categories/`$chan.CHID`" url="channel_detail.php?chid=`$chan.CHID`" clean=$chan.name}">{$chan.name}</a><br />
{/foreach}		
         </div>
	  </div>
</div>
<div id="videobox">
  <div id="topwatched">
      <div id="topwatched-title">{translate item='channel.top_watched_in'} {$answers[0].name} {translate item='channel.upper'}</div>
      <div id="topwatched-content">
        <div class="arrow-general">&nbsp;</div>
        <div class="contentbox">
          <ul id="mostactiveuser">
             {section name=k loop=$mostview}
            {assign var=looprecord value=$smarty.section.k.index}
            {if $looprecord%2 eq 0}
                {assign var=colorLoop value=""}	
            {else}
                {assign var=colorLoop value="class='blue'"}	
            {/if}
             <li class="boxshow">
                {insert name=duration assign=duration duration=$mostview[k].duration}
			    {insert name=comment_count assign=commentcount vid=$recadd[j].VID}
				{insert name=show_rate assign=rate rte=$mostview[k].rate}
                {insert name=cutText assign=cutTextVar un=$mostview[k].title}        
                <a href="{seourl rewrite="video/`$mostview[k].VID`" url="view_video.php?viewkey=`$mostview[k].vkey`" clean=$mostview[k].title}">
					<img src="{$tmburl}/{$mostview[k].thumb}_{$mostview[k].VID}.jpg" class="thumb"/>
				</a><br/>
                <a href="{seourl rewrite="video/`$mostview[k].VID`" url="view_video.php?viewkey=`$mostview[k].vkey`" clean=$mostview[k].title}" title="{$mostview[k].title|escape:'html'}"><span class="title">{$cutTextVar}</span></a><br/>
				<span class="duration">{$duration}</span><br/>
				<span class="info">{translate item='global.from'}:</span> <a href="{seourl rewrite="users/`$mostview[k].username`" url="uprofile.php?UID=`$mostview[k].UID`"}">{$mostview[k].username}</a><br/>
                <span class="info">{translate item='global.views'}:</span> {$mostview[k].viewnumber}<br/>
                <span class="info">{translate item='global.comments'}:</span> {$commentcount}<br/>
                        <div class="startratebox">
                       
                            <span class="info">{$rate}
                            <br />
                            (Rated by </span>{$mostview[k].ratedby}<span class="info">)</span>
                        
                        </div>
                	
            </li>
            {/section}
          </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  <br/>
  
  
  <div id="recently-added">
      <div id="recently-added-title">{translate item='channel.recently_added_in'} {$answers[0].name}</div>
      <div id="recently-added-content">
        <div class="arrow-general">&nbsp;</div>
        <div class="contentbox">
          <ul id="mostactiveuser">
            {section name=j loop=$recadd}
             <li class="boxshow">
			    {if $smarty.section.j.index mod 4 eq "0" and $smarty.section.j.index gt "0"}{/if}
                    {insert name=duration assign=duration duration=$recadd[j].duration}
                    {insert name=comment_count assign=commentcount vid=$recadd[j].VID}
                    {insert name=show_rate assign=rate rte=$recadd[j].rate}
                    {insert name=cutText assign=cutTextVar un=$recadd[j].title}        
                <a href="{seourl rewrite="video/`$recadd[j].VID`" url="view_video.php?viewkey=`$recadd[j].vkey`" clean=$recadd[j].title}">
                <img src="{$tmburl}/{$recadd[j].thumb}_{$recadd[j].VID}.jpg" class="thumb"/></a><br/>
                <a href="{seourl rewrite="video/`$recadd[j].VID`" url="view_video.php?viewkey=`$recadd[j].vkey`" clean=$recadd[j].title}"><span class="title">{$cutTextVar}</span></a><br/>
                <span class="duration">{$duration}</span><br/>
				<span class="info">{translate item='global.from'}:</span> <a href="{seourl rewrite="users/`$recadd[j].username`" url="uprofile.php?UID=`$recadd[j].UID`"}">{$recadd[j].username}</a><br/>
                <span class="info">{translate item='global.views'}:</span> {$recadd[j].viewnumber} <br/>
                <span class="info">{translate item='global.comments'}:</span> {$commentcount}<br/>
                <div class="startratebox">
                        <span class="info">{$rate}</span> 
                        <br />
                        <span class="info">(Rated by</span> {$recadd[j].ratedby}<span class="info">)</span>
                </div>
            </li>
			{/section}
            <!--{$prev}{$page_link}{$next}-->
            </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  <br/>
  
  <div id="paging">
    		<div class="pagingnav">
            {insert name=removeBold assign=prevVar un=$prev}        
 			{insert name=removeBold assign=pageLinkVar un=$page_link}        
            {insert name=removeBold assign=nextVar un=$next}
            {$prevVar} {$pageLinkVar} {$nextVar}
    		</div>
	
  		</div>
</div>
<div class="clear"></div>