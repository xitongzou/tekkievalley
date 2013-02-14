     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_video" method="POST" action="videos.php?m=edit&VID={$video[0].VID}">
        <fieldset>
        <legend>Video Information</legend>
            <label for="VID">Vide ID: </label>
            <input type="text" name="VID" value="{$video[0].VID}" readonly="readonly"><br>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$video[0].UID}" readonly="readonly" class="large"><br>
            <label for="title">Title: </label>
            <input type="text" name="title" value="{$video[0].title}" class="large"><br>
            <label for="description">Description: </label>
            <textarea name="description">{$video[0].description}</textarea><br>
            <label for="feature_description">Feature Description: </label>
            <textarea name="featuredesc">{$video[0].featuredesc}</textarea><br>
            <label for="keyword">Keywords (tags): </label>
            <textarea name="keyword">{$video[0].keyword}</textarea><br>
            <label for="channel">Channel(s): </label>
            <table><tr><td>
            {insert assign=channels name=list_channel}
            {section name=i loop=$channels}
            {if $channels[i].id|in_array:$video[0].channel }
            <input type="checkbox" name="channel[]" value="{$channels[i].id}" checked="checked">{$channels[i].ch}<br>
            {else}
            <input type="checkbox" name="channel[]" value="{$channels[i].id}">{$channels[i].ch}<br>
            {/if}
            {/section}
            </td></tr></table>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $video[0].type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $video[0].type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
            <label for="active">Approved (active): </label>
            <select name="active">
            <option value="1"{if $video[0].active == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video[0].active == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="featured">Is Featured: </label>
            <select name="featured">
            <option value="yes"{if $video[0].featured == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $video[0].featured == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_comment">Can be commented? </label>
            <select name="be_comment">
            <option value="yes"{if $video[0].be_comment == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $video[0].be_comment == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_comment">Can be rated? </label>
            <select name="be_rated">
            <option value="yes"{if $video[0].be_rated == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $video[0].be_rated == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_comment">Can be embeded? </label>
            <select name="embed">
            <option value="enabled"{if $video[0].embed == 'enabled'} selected="selected"{/if}>Yes</option>
            <option value="disabled"{if $video[0].embed == 'disabled'} selected="selected"{/if}>No</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Video Thumb</legend>
            <label for="thumb">Thumb: </label>
            <table><tr><td>
            <input type="hidden" name="thumb" id="{$video[0].vkey}" value="{$video[0].thumb}">
            <img src="{$tmburl}/1_{$video[0].VID}.jpg" width="72" id="change_tmb_{$video[0].vkey}_1" class="{if $video[0].thumb == '1'}tmb_active{else}tmb{/if}">
            <img src="{$tmburl}/2_{$video[0].VID}.jpg" width="72" id="change_tmb_{$video[0].vkey}_2" class="{if $video[0].thumb == '2'}tmb_active{else}tmb{/if}">
            <img src="{$tmburl}/3_{$video[0].VID}.jpg" width="72" id="change_tmb_{$video[0].vkey}_3" class="{if $video[0].thumb == '3'}tmb_active{else}tmb{/if}">
            </td></tr></table>
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
            <label for="rate">Rating: </label>
            <input type="text" name="rate" value="{$video[0].rate}"><br>
            <label for="ratedby">Rated by: </label>
            <input type="text" name="ratedby" value="{$video[0].ratedby}"><br>
            <label for="viewnumber">Views: </label>
            <input type="text" name="viewnumber" value="{$video[0].viewnumber}"><br>
            <label for="com_num">Comments: </label>
            <input type="text" name="com_num" value="{$video[0].com_num}"><br>
            <label for="fav_num">Favorites: </label>
            <input type="text" name="fav_num" value="{$video[0].fav_num}"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="edit_video" value="Update Video" class="button">
            <input type="button" name="edit_video_advanced" id="edit_video_advanced" value="-- Show Advanced --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>