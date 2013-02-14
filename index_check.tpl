     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>System Check</h2>
        <div class="check">FLVIDEO Directory</div>
        <div class="check_output"><b>{$paths.flvideo}</b> ({$paths_perms.flvideo}) ({$flvideo_dir})</div><br>
        <div class="check">VIDEO Directory</div>
        <div class="check_output"><b>{$paths.video}</b> ({$paths_perms.video}) ({$video_dir})</div>
        <div class="check">THUMBS Directory</div>
        <div class="check_output"><b>{$paths.thumbs}</b> ({$paths_perms.thumbs}) ({$thumbs_dir})</div>
        <div class="check">CHANNEL Directory</div>
        <div class="check_output"><b>{$paths.chimg}</b> ({$paths_perms.chimg}) ({$chimg_dir})</div>
        <div class="check">PHOTO Directory</div>
        <div class="check_output"><b>{$paths.photo}</b> ({$paths_perms.photo}) ({$photo_dir})</div>
        <div class="check">TMP Directory</div>
        <div class="check_output"><b>{$paths.tmp}</b> ({$paths_perms.tmp}) ({$tmp_dir})</div>
        <div style="clear: both;"></div>
        <br>
        <div class="check">Safe Mode</div>
        <div class="check_output">{$restrictions.safe_mode}&nbsp;</div>
        <div class="check">Open Basedir</div>
        <div class="check_output">{$restrictions.open_basedir}&nbsp;</div>
        <div style="clear: both;"></div>
        <br>
        <div class="check">Maximum Upload Filesize</div>
        <div class="check_output"><b>{$upload.max_upload_size}</b> (max_upload_filesize)</div>
        <div class="check">Maximum Post Filesize</div>
        <div class="check_output"><b>{$upload.max_post_size}</b> (max_post_size)</div>
        <div style="clear: both;"></div>
        <br>
        <div class="check">PHP CLI</div>
        <div class="check_output"><b>{$binaries.php}</b> ({$phppath})</div>
        <div class="check">MEncoder</div>
        <div class="check_output"><b>{$binaries.mencoder}</b> ({$mencoder})</div>
        <div class="check">MPlayer</div>
        <div class="check_output"><b>{$binaries.mplayer}</b> ({$mplayer})</div>
        <div class="check">FFMpeg</div>
        <div class="check_output"><b>{$binaries.ffmpeg}</b> ({$ffmpeg})</div>
        <div class="check">FLVTool2</div>
        <div class="check_output"><b>{$binaries.metainject}</b> ({$metainject})</div>
        {if $formats_error == '' }
        <div style="clear: both;"></div>
        <br>
        <div class="check">JPEG Support</div>
        <div class="check_output"><b>{$formats.jpeg}</b> ({$formats_paths.jpeg})</div>
        <div class="check">LAME Support</div>
        <div class="check_output"><b>{$formats.lame}</b> ({$formats_paths.lame})</div>
        <div class="check">XVID Support</div>
        <div class="check_output"><b>{$formats.xvid}</b> ({$formats_paths.xvid})</div>
        <div class="check">THEORA Support</div>
        <div class="check_output"><b>{$formats.theora}</b> ({$formats_paths.theora}</div>
        <div class="check">X264 Support</div>
        <div class="check_output"><b>{$formats.x264}</b> ({$formats_paths.x264})</div>
        <div class="check">FAAC Support</div>
        <div class="check_output"><b>{$formats.faac}</b> ({$formats_paths.faac})</div>
        <div style="clear:both;"></div>
        {else}
        <div class="check_error">{$formats_error}</div>
        {/if}
        </div>
        </div>
     </div>
     