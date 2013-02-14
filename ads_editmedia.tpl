     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_adv" method="POST" enctype="multipart/form-data" action="ads.php?m=editmedia&AID={$adv.adv_id}">
        <fieldset>
        <legend>Preview</legend>
        <div style="width: 100%; text-align: center;">
        {if $adv.media == 'jpg'}
        <img src="{$baseurl}/player/adv/{$adv.adv_id}.{$adv.media}">
        {elseif $adv.media == 'flv'}
        <embed src="{$baseurl}/player.swf" width="300" height="220" allowscriptaccess="always" allowfullscreen="true" flashvars="height=220&width=300&file={$baseurl}/player/adv/{$adv.adv_id}.flv" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />
        {else}
        <embed src="{$baseurl}/player/adv/{$adv.adv_id}.swf" width="300" height="220" allowscriptaccess="always" allowfullscreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />
        {/if}
        </div>
        </fieldset>
        <fieldset>
        <legend>Add Media Banner</legend>
            <label for="name">Name: </label>
            <input name="adv_title" type="text" value="{$adv.title}" class="large"><br />
            <label for="desc">Description: </label>
            <input name="adv_desc" type="text" value="{$adv.descr}" class="large"><br />
            <label for="url">Url: </label>
            <input name="adv_url" type="text" value="{$adv.adv_url}" class="large"><br />
            <label for="duration">Duration: </label>
            <input name="adv_duration" type="text" value="{$adv.duration}" class="small">&nbsp; (seconds)<br />
            <label for="media">File: </label>
            <input name="adv_media" type="file">&nbsp; (*.jpg, *.swf, *.flv)<br />
            <label for="status">Status: </label>
            <select name="adv_status">
            <option value="1"{if $adv.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $adv.status == '0'} selected="selected"{/if}>Inactive</optio>
            </select>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="adv_edit" value="Update Media Advertise" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>