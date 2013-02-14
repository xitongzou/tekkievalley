     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Editing: {$player.profile} profile!</h2>
        <div id="simpleForm">
        <form name="player_settings" method="POST" action="index.php?m=playeredit&PID={$player.id}">
        <fieldset>
        <legend>Global Settings</legend>
            <label for="buffertime">Buffer Time: </label>
            <input name="buffertime" type="text" maxlength="3" value="{$player.buffertime}" class="small"><br>
            <label for="autorun">Autoplay: </label>
            <select name="autorun" id="autorun">
                <option value="true"{if $player.autorun == 'true'} selected{/if}>Enabled</option>
                <option value="false"{if $player.autorun == 'false'} selected{/if}>Disabled</option>
            </select><br>
            <label for="buttons">Controls{$player.buttons}: </label>
            <select name="buttons">
                <option value="0"{if $player.buttons == '0'} selected="selected"{/if}>Disabled</option>
                <option value="1"{if $player.buttons == '1'} selected="selected"{/if}>Enabled</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Skin Settings</legend>
            <label for="skin">Skin: </label>
            <select name="skin">
            {section name=i loop=$skins}
            <option value="{$skins[i]}"{if $player.skin == $skins[i]} selected="selected"{/if}>{$skins[i]}</option>
            {/section}
            </select><br>
            <label for="related">Related: </label>
            <select name="related">
                <option value="0"{if $player.related == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.related == '1'} selected{/if}>Enabled</option>
            </select><br>
            <label for="related_content">Related Content: </label>
            <select name="related_content">
                <option value="related"{if $player.related_content == 'related'} selected{/if}>Related</option>
                <option value="featured"{if $player.related_content == 'featured'} selected{/if}>Featured</option>
                <option value="commented"{if $player.related_content == 'commented'} selected{/if}>Commented</option>
                <option value="rated"{if $player.related_content == 'rated'} selected{/if}>Most Rated</option>
                <option value="viewed"{if $player.related_content == 'viewed'} selected{/if}>Most Viewed</option>
            </select><br>
            <label for="embed">Embed: </label>
            <select name="embed">
                <option value="0"{if $player.embed == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.embed == '1'} selected{/if}>Enabled</option>                
            </select><br>
            <label for="share">Share: </label>
            <select name="share">
                <option value="0"{if $player.share == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.share == '1'} selected{/if}>Enabled</option>                
            </select><br>
            <label for="mail">Mail: </label>
            <select name="mail">
                <option value="0"{if $player.mail == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.mail == '1'} selected{/if}>Enabled</option>                
            </select><br>
            <label for="replay">Replay: </label>
            <select name="replay">
                <option value="0"{if $player.replay == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.replay == '1'} selected{/if}>Enabled</option>                
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Colors</legend>
            <label for="">Mail Color: </label>
            <input name="mail_color" type="text" value="{$player.mail_color}" maxlength="8"><br>
            <label for="">Related Color: </label>
            <input name="related_color" type="text" value="{$player.related_color}" maxlength="8"><br>
            <label for="">Replay Color: </label>
            <input name="replay_color" type="text" value="{$player.replay_color}" maxlength="8"><br>
            <label for="">Embed Color: </label>
            <input name="embed_color" type="text" value="{$player.embed_color}" maxlength="8"><br>
            <label for="">Copy Color: </label>
            <input name="copy_color" type="text" value="{$player.copy_color}" maxlength="8"><br>
            <label for="">Time Color: </label>
            <input name="time_color" type="text" value="{$player.time_color}" maxlength="8"><br>
            <label for="">Share Color: </label>
            <input name="share_color" type="text" value="{$player.share_color}" maxlength="8"><br>
            <label for="">Adv Navigation Color: </label>
            <input name="adv_nav_color" type="text" value="{$player.adv_nav_color}" maxlength="8"><br>
            <label for="">Adv Title Color: </label>
            <input name="adv_title_color" type="text" value="{$player.adv_title_color}" maxlength="8"><br>
            <label for="">Adv Body Color: </label>
            <input name="adv_body_color" type="text" value="{$player.adv_body_color}" maxlength="8"><br>
            <label for="">Adv Link Color: </label>
            <input name="adv_link_color" type="text" value="{$player.adv_link_color}" maxlength="8"><br>
        </fieldset>        
        <fieldset>
        <legend>Advertise Settings</legend>
            <label for="text_adv">Text Advertising</label>
            <select name="text_adv">
                <option value="0"{if $player.text_adv == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.text_adv == '1'} selected{/if}>Enabled</option>
            </select><br>
            <label for="text_adv_type">Text Advertising Type: </label>
            <select name="text_adv_type">
                <option value="global">Global (Random)</option>
                <option value="video">Video</option>
                <option value="channel">Channel</option>
            </select><br>
            <label for="text_adv_delay">Text Advertising Delay: </label>
            <input name="text_adv_delay" type="text" maxlength="3" value="{$player.text_adv_delay}" class="small"><br>
            <label for="video_adv">Video Advertising: </label>
            <select name="video_adv">
                <option value="0"{if $player.video_adv == '0'} selected{/if}>Disabled</option>
                <option value="1"{if $player.video_adv == '1'} selected{/if}>Enabled</option>
            </select><br>
            <label for="video_adv_type">Video Advertising Type: </label>
            <select name="video_adv_type">
                <option value="global">Global (Random)</option>
                <option value="video">Video</option>
                <option value="channel">Channel</option>
            </select><br>
            <label for="video_adv_position">Video Advertising Position: </label>
            <select name="video_adv_position">
                <option value="b"{if $player.video_adv_position == 'b'} selected{/if}>Beginning</option>
                <option value="e"{if $player.video_adv_position == 'e'} selected{/if}>End</option>
                <option value="be"{if $player.video_adv_position == 'be'} selected{/if}>Both</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_settings" value="Update Player Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>