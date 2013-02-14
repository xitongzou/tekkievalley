     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Media Settings</h2>
        <div id="simpleForm">
        <form name="media_settings" method="POST" action="index.php?m=media">
        <fieldset>
        <legend>Media Settings</legend>
            <label for="phppath" style="width: 35%;">PHP CLI Path: </label>
            <input type="text" name="phppath" value="{$phppath}" class="large"><br>
            <label for="mplayer" style="width: 35%;">MPlayer Path: </label>
            <input type="text" name="mplayer" value="{$mplayer}" class="large"><br>
            <label for="mencoder" style="width: 35%;">Mencoder Path: </label>
            <input type="text" name="mencoder" value="{$mencoder}" class="large"><br>
            <label for="ffmpeg" style="width: 35%;">FFMpeg Path: </label>
            <input type="text" name="ffmpeg" value="{$ffmpeg}" class="large"><br>
            <label for="metainject" style="width: 35%;">FLVtool2 Path: </label>
            <input type="text" name="metainject" value="{$metainject}" class="large"><br>
            <label for="thumbs_tool" style="width: 35%;">Thumbs Tool: </label>
            <select name="thumbs_tool">
            <option value="mplayer"{if $thumbs_tool == 'mplayer'} selected="selected"{/if}>MPlayer</option>
            <option value="ffmpeg"{if $thumbs_tool == 'ffmpeg'} selected="selected"{/if}>FFMpeg</option>
            </select><br>
            <label for="vbirate" style="width: 35%;">Bit-rate for converted videos (in Kbps): </label>
            <input type="text" name="vbitrate" value="{$vbitrate}"><br>
            <label for="sbirate" style="width: 35%;">Sound sampling rate, for converted videos (in KHz): </label>
            <input type="text" name="sbitrate" value="{$sbitrate}"><br>
            <label for="vresize" style="width: 35%;">Video resize: </label>
            <select name="vresize">
            <option value="1"{if $vresize == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $vresize == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="vresize_x" style="width: 35%;">Width (in pixels) for converted videos, IF resized: </label>
            <input type="text" name="vresize_x" value="{$vresize_x}" class="small"><br>
            <label for="vresize_y" style="width: 35%;">Height (in pixels) for converted videos, IF resized: </label>
            <input type="text" name="vresize_y" value="{$vresize_y}" class="small"><br>            
            <label for="img_max_width" style="width: 35%;">Max thumbnail width (in pixels): </label>
            <input type="text" name="img_max_width" value="{$img_max_width}" class="small"><br>
            <label for="img_max_height" style="width: 35%;">Max thumbnail height (in pixels): </label>
            <input type="text" name="img_max_height" value="{$img_max_height}" class="small"><br>
            <label for="allowed_extensions" style="width: 35%;">Allowed extensions (separated by comas): </label>
            <textarea rows="4" name="video_allowed_extensions" style="overflow: hidden;">{$video_allowed_extensions|wordwrap:48:"\n":true}</textarea><br>
            <label for="video_max_size" style="width: 35%;">Max video size (in MB): </label>
            <input type="text" name="video_max_size" value="{$video_max_size}" class="small"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_media" value="Update Media Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>