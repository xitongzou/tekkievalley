<div id="fullside">
{if $upload_by_file == '1' && $upload_by_embed == '1'}
{if $secondpage eq "second" and $smarty.request.upload_final eq ""}
<script type="text/javascript" src="{$baseurl}/js/upload_embed.js"></script>
<div id="tabmenucontainer">
<ul>
	<script type="text/javascript">var buttons = new Array("buttonUploadFile", "buttonUploadEmbed");</script>
	<script type="text/javascript">var tabs = new Array("uploadFile", "uploadEmbed");</script>
	<li><a href="#File" id="buttonUploadFile" class="{if $upload_method eq 'File'}tabactive{/if}" onClick="toggleTab('uploadFile', 'buttonUploadFile');">Upload</a></li>
	<li><a href="#Embed" id="buttonUploadEmbed" class="{if $upload_method eq 'Embed'}tabactive{/if}" onClick="toggleTab('uploadEmbed', 'buttonUploadEmbed');">Embed</a></li>	
</ul>
</div>
<br style="clear: both;"><br>
{/if}
{/if}
  <div id="fullbox">
    {if $secondpage ne "second" and $smarty.request.upload_final eq ""}
    <div id="fullbox-title">
    {translate item='upload.step_one'}
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      <div class="contentbox">
        <form id="theForm" name="theForm" action="{seourl rewrite='upload' url='upload.php'}" method="post" enctype="multipart/form-data">
          <div class="fm-req">
            <label for="fm-title">{translate item='upload.title'}:</label>
            <input maxlength="60" size="40" name="field_myvideo_title" value="{$upl.title|escape:'html'}" class="inputtext"/>
          </div>
          <div class="fm-opt">
            <label for="fm-desc">{translate item='upload.desc'}:</label>
            <textarea name="field_myvideo_descr" rows="4" cols="50" class="inputtext">{$upl.desc|escape:'html'}</textarea>
          </div>
          <div class="fm-opt">
            <label for="fm-tag">{translate item='upload.tags'}: </label>
            <input maxlength="120" size="40" name="field_myvideo_keywords" value="{$upl.tags|escape:'html'}" class="inputtext" />
            <br /><br />
			<div class="formFieldInfo">
              <strong>{translate item='upload.tags_help'}</strong>
              <br />
	      {translate item='upload.tags_desc'}
            </div>
          </div>
		  <br /><br />
          <div class="fm-req">
            <label for="fm-vidchannel">{translate item='upload.channels'}:</label>
          </div>
          <br/>
          {insert name=list_channel assign=chinfo vid=$VID}
          {section name=i loop=$chinfo}
          <div class="fm-opt">
            <label>&nbsp;</label>
            {if is_array($chlist) && in_array($chinfo[i].id, $chlist) }
            <input type="checkbox" name="chlist[]" checked="checked" value="{$chinfo[i].id}"  />
            {else}
            <input type="checkbox" name="chlist[]" value="{$chinfo[i].id}"  />
            {/if}
            {$chinfo[i].ch}
          </div>
          {/section}
		  <br />
          <strong>{translate item='upload.channels_help'}</strong>
          <br />
	  {translate item='upload.channels_desc'}
         <input type="hidden" value="Continue -&gt;" name="action_upload" />
          <div class="submitbutton">
            <input type="image" src="images/btn_submit.gif" class="button" name="submit"/>
          </div>
        </form>
      </div>
    </div>
    {else}
    <div id="fullbox-title">
    {translate item='upload_step_two'}
    </div>
    <div id="fullbox-content">
      <div class="arrow-general">
        &nbsp;
      </div>
      {if $upload_by_file == '1'}
      <div id="uploadFile" style="display:{if $upload_method eq 'File'}block{else}none{/if};">
      <div class="contentbox">
	{if $UBR_embedded_upload_results eq 1 or $UBR_opera_browser eq 1 or $UBR_safari_browser eq 1}
	<div id="upload_div" style="display:none;"><iframe name="upload_iframe" frameborder="0" width="800" height="200" scrolling="auto"></iframe></div>
	{/if}
	<br>
	<!-- Start Upload Form -->
	<form name="form_upload" id="form_upload"{if $UBR_embedded_upload_results eq 1 or $UBR_opera_browser eq 1 or $UBR_safari_browser eq 1} target="upload_iframe"{/if} method="post" enctype="multipart/form-data"  action="#" style="margin: 0px; padding: 0px;">
	<noscript><font color='red'>Warning: </font>Javascript must be enabled to use this uploader.<br><br></noscript>
        <input type="hidden" name="MAX_FILE_SIZE" value="104857600" />
        <input type="hidden" name="upload_range" value="1" />
        <noscript><input type="hidden" name="no_script" value="1" /></noscript>
        <input type="hidden" name="adult" value="{$adult}" />
        <input type="hidden" name="field_myvideo_keywords" value="{$upl.tags}" />
        <input type="hidden" name="field_myvideo_title" value="{$upl.title|escape:'html'}" />
        <input type="hidden" name="field_myvideo_descr" value="{$upl.desc|escape:'html'}" />
        <input type="hidden" name="listch" value="{$listch}" />
        <div class="fm-req">
        <label for="fm-file">{translate item='upload.file'}:</label>
	<div id="upload_slots">
		<input type="file" name="upfile_0" size="40"{if $UBR_multi_upload_slots eq 1} onChange="addUploadSlot(1)"{/if}onkeypress="return handleKey(event)" value="">
	</div>
	</div>
          <div class="formHighlightText">
            <strong>{translate item='upload.file_info'}</strong>
            <br />
	    {translate item='upload.file_desc'}
          </div>
          <strong>{translate item='upload.broadcast'}:</strong>
          <div class="fm-opt">
            <label for="fm-title">{translate item='global.public'}:</label>
            <input name="field_privacy" type="radio" value="public" checked="checked" />
            {translate item='upload.broadcast_public'}
          </div>
          <div class="fm-opt">
            <label for="fm-title">{translate item='global.private'}:</label>
            <input name="field_privacy" type="radio" value="private" />
	    {translate item='upload.broadcast_private'}
          </div>
	<br>
	<input type="button" id="reset_button" name="reset_button" value="Reset" onClick="resetForm();">&nbsp;&nbsp;&nbsp;
	<input type="button" id="upload_button" name="upload_button" value="Upload" onClick="linkUpload();">
	</form>
	<!-- End Upload Form -->
        <!-- Start Progress Bar -->
    <br>    
	<div class="alert" id="ubr_alert"></div>
	<div id="progress_bar" style="display:none">
		<div class="bar1" id="upload_status_wrap">
			<div class="bar2" id="upload_status"></div>
		</div>
		{if $UBR_show_percent_complete eq 1 or $UBR_show_files_uploaded eq 1 or $UBR_show_current_position eq 1 or $UBR_show_elapsed_time eq 1 or $UBR_show_est_time_left eq 1 or $UBR_show_est_speed eq 1}
		<br>
		<table class="data" cellpadding='3' cellspacing='1'>
		{if $UBR_show_percent_complete eq 1}
		<tr>
			<td align="left"><b>Percent Complete:</b></td>
			<td align="center"><span id="percent">0%</span></td>
		</tr>
		{/if}
		{if $UBR_show_files_uploaded eq 1}
		<tr>
			<td><b>Files Uploaded:</b></td>
			<td align="center"><span id="uploaded_files">0</span> of <span id="total_uploads"></span></td>
		</tr>
		{/if}
		{if $UBR_show_current_position eq 1}
		<tr>
			<td align="left"><b>Current Position:</b></td>
			<td align="center"><span id="current">0</span> / <span id="total_kbytes"></span> KBytes</td>
		</tr>
		{/if}
		{if $UBR_show_elapsed_time eq 1}
		<tr>
			<td align="left"><b>Elapsed Time:</b></td>
			<td align="center"><span id="time">0</span></td>
		</tr>
		{/if}
		{if $UBR_show_est_time_left eq 1}
		<tr>
			<td align="left"><b>Est Time Left:</b></td>
			<td align="center"><span id="remain">0</span></td>
		</tr>
		{/if}
		{if $UBR_show_est_speed eq 1}
		<tr>
			<td align="left"><b>Est Speed:</b></td>
			<td align="center"><span id="speed">0</span> KB/s.</td>
		</tr>
		{/if}
		</table>
		{/if}
	</div>
	<!-- End Progress Bar -->
    </div>
    </div>
    {/if}
    {if $upload_by_embed == '1'}
    <div id="uploadEmbed" style="display:{if $upload_method eq 'Embed'}block{else}none{/if};">
    <form method="POST" action="{seourl rewrite='upload' url='upload.php'}" enctype="multipart/form-data">
          <input type="hidden" name="adult" value="{$adult}" />
          <input type="hidden" name="field_myvideo_keywords" value="{$upl.tags}" />
          <input type="hidden" name="field_myvideo_title" value="{$upl.title|escape:'html'}" />
          <input type="hidden" name="field_myvideo_descr" value="{$upl.desc|escape:'html'}" />
          <input type="hidden" name="listch" value="{$listch}" />
          <div class="fm-opt">
            <label for="fm-desc">{translate item='upload.embed_code'}:</label>
            <textarea name="embed_code" rows="4" cols="50" class="inputtext" style="width: 280px;"></textarea>
          </div>
	  <strong>{translate item='upload.embed_code_expl'}</strong>
          <div class="fm-opt">
            <label for="fm-desc">{translate item='upload.thumb'}:</label>
	    <input name="thumb" type="file">
          </div>
	  <strong>{translate item='upload.thumb_expl'}</strong>
          <div class="fm-opt">
            <label for="fm-desc">{translate item='upload.duration'}:</label>
	    <input maxlength="2" size="2" name="duration_minutes" value="" class="inputtext" style="width: 30px;"/>
	    &nbsp;<strong>:</strong>&nbsp;
	    <input maxlength="2" size="2" name="duration_seconds" value="" class="inputtext" style="width: 30px;"/>
          </div>
	  <strong>{translate item='upload.duration_expl'}</strong>
          <div class="fm-opt">
            <label for="fm-title">{translate item='global.public'}:</label>
            <input name="field_privacy" type="radio" value="public" checked="checked" />
            {translate item='upload.broadcast_public'}
          </div>
          <div class="fm-opt">
            <label for="fm-title">{translate item='global.private'}:</label>
            <input name="field_privacy" type="radio" value="private" />
	    {translate item='upload.broadcast_private'}
          </div>
	  <br>
	  <input type="submit" name="submit_embed" value="Upload">
    </form>
    </div>
    </div>
    {/if}
    {/if}
    <div class="clear">
    </div>
  </div>
  <!-- end div fullbox -->
</div>
<!-- end div fullside -->
<div class="clear">
</div>
