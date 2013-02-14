<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">
      {translate item='upload_success.success'}
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <div class="contentbox">
        {if $smarty.request.upload eq "yes"}
        <h4>{translate item='upload_success.added'}</h4>
        {/if}
        <h4>{translate item='upload_success.converting'}</h4>
        {translate item='upload_success.more'} <a href="{seourl rewrite='upload' url='upload.php'}">{translate item='upload_success.click_here'}</a>
        <br />
        {translate item='upload_success.share'}<br />
        <br />
        <!-- KEEP THIS IN SYNC WITH WATCH.PHP! -->
        <!-- Begin Video URL Section-->
        <form name="linkForm">
        <strong>{translate item='upload_success.video_url'}: </strong><br />
        <input class="fullboxtext" onclick="javascript:document.linkForm.video_link.focus();document.linkForm.video_link.select();" readonly="readOnly" value="{seourl rewrite="video/`$vinfo.VID`" url="view_video.php?viewkey=`$smarty.request.viewkey`" clean=$vinfo.title}" name="video_link" />
        <!--End Video URL Section-->
        <br /><br />
        <!--Begin Embed your video Section-->
        <strong>{translate item='upload_success.embed'}: </strong><br/>
        {translate item='upload_success.embed_expl'}. <br/>
        <textarea class="fullboxtext" onclick="javascript:document.linkForm.video_play.focus();document.linkForm.video_play.select();" name="video_play" readonly="readOnly" wrap="physical">{if $vinfo.embed_code == ''}
<embed src="{$baseurl}/player.swf" width="360" height="270" allowscriptaccess="always" allowfullscreen="true" flashvars="width=360&amp;height=270&amp;file={$flvdourl}/{$vinfo.flvdoname}&amp;image={$tmburl}/{$vinfo.thumb}_{$vinfo.VID}.jpg&amp;displayheight=270&amp;link={seourl rewrite="video/`$vinfo.VID`" url="view_video.php?viewkey=`$viewkey`" clean=$vinfo.title}&amp;searchbar=false&amp;linkfromdisplay=true&amp;recommendations={$baseurl}/feed_embed.php?v={$vinfo.vkey}" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />
{else}
{$vinfo.embed_code}
{/if}
        </textarea>
        </form><br />
        <form action="{$baseurl}/upload_success.php?viewkey={$smarty.request.viewkey}" method="post">
          <input type="hidden" value="{$smarty.request.viewkey}" name="viewkey" />
          <strong>{translate item='upload_success.update'}:</strong> <br/>
          {translate item='upload_success.record_date'}:<br/>
          <select name="month">
            <option>mm</option>
            <option>
            {$months}
            </option>
          </select>
          <select name="day">
            <option>dd</option>
            <option>
            {$days}
            </option>
          </select>
          <select name="year">
            <option>yyyy</option>
            <option>
            {$years}
            </option>
          </select><br/>
          {translate item='upload_success.location'}: <br/>
          <input maxlength="255" size="40" name="field_address" value="{$smarty.request.field_address}" class="fullboxtext"/>
          <div>{translate item='upload_success.location_expl'}</div>
          {translate item='upload_success.country'}:<br/>
          <select name="country">
            <option>Select Country</option>
            <option>
            {$country}
            </option>
          </select><br/>
          <input type="hidden" value="1" name="action_update" />
          <input type="hidden" value="Update Video" name="action_update" />
	<br/>
        	<input type="image" src="{$imgurl}/btn_updatevideo.gif" value="Update Video"  />
        </form>
      </div>
    </div>
  </div>
</div>
<div class="clear">
</div>
<div class="clear">
</div>
