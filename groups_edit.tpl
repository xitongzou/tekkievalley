     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_group" method="POST" enctype="multipart/form-data" action="groups.php?m=edit&GID={$group[0].GID}">
        <fieldset>
        <legend>Editing: {$group[0].gname}</legend>
            <label for="GID">Group ID: </label>
            <input type="text" name="GID" value="{$group[0].GID}" readonly="readonly"><br>
            <label for="gname">Group Name: </label>
            <input type="text" name="gname" value="{$group[0].gname}" class="large"><br>
            <label for="gdescn">Description: </label>
            <textarea name="gdescn">{$group[0].gdescn}</textarea><br>
            <label for="keyword">Tags: </label>
            <textarea name="keyword">{$group[0].keyword}</textarea><br>            
            <label for="gurl">URL Key (name): </label>
            <input type="text" name="gurl" value="{$group[0].gurl}" class="large"><br>
            <label for="channels">Channel(s): </label>
            {insert assign=channels name=list_channel}
            <table><tr><td>
            {section name=i loop=$channels}
            {if $channels[i].id|in_array:$group[0].channel }
            <input type="checkbox" name="channel[]" value="{$channels[i].id}" checked="checked">{$channels[i].ch|escape:'html'}<br>
            {else}
            <input type="checkbox" name="channel[]" value="{$channels[i].id}">{$channels[i].ch|escape:'html'}<br>
            {/if}
            {/section}
            </td></tr></table>
            <label for="type">Group Type: </label>
            <select name="type">
            <option value="public"{if $group[0].type == 'public'} selected="selected"{/if}>Public</option>
            <option value="private"{if $group[0].type == 'private'} selected="selected"{/if}>Private</option>
            <option value="protected"{if $group[0].type == 'protected'} selected="selected"{/if}>Protected</option>
            </select><br>            
            <label for="gupload">Video Uploads: </label>
            <select name="gupload">
            <option value="immediate"{if $group[0].gupload == 'immediate'} selected="selected"{/if}>Immediate</option>
            <option value="owner_approve"{if $group[0].gupload == 'owner_approve'} selected="selected"{/if}>Owner Approve</option>
            <option value="owner_only"{if $group[0].gupload == 'owner_only'} selected="selected"{/if}>Owner Only</option>
            </select><br>
            <label for="gposting">Forum Posting: </label>
            <select name="gposting">
            <option value="immediate"{if $group[0].gposting == 'immediate'} selected="selected"{/if}>Immediate</option>
            <option value="owner_approve"{if $group[0].gposting == 'owner_approve'} selected="selected"{/if}>Owner Approve</option>
            <option value="owner_only"{if $group[0].gposting == 'owner_only'} selected="selected"{/if}>Owner Only</option>
            </select><br>
            <label for="gimage">Group Image: </label>
            <select name="gimage">
            <option value="immediate"{if $group[0].gimage == 'immediate'} selected="selected"{/if}>Immediate</option>
            <option value="owner_only"{if $group[0].gimage == 'owner_only'} selected="selected"{/if}>Owner Only</option>
            </select><br>
            <label for="featured">Featured: </label>
            <select name="featured">
            <option value="yes"{if $group[0].featured == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $group[0].featured == 'no'} selected="selected"{/if}>No</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_group" value="Update Group" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>