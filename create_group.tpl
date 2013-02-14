<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">{translate item='group_create.create_group'}</div>
    <div id="fullbox-content">
      <div class="arrow-general">&nbsp;</div>
      <div class="contentbox">
        <form action="{seourl rewrite='create/group' url='create_group.php'}" method="post" name="groups_create" id="groups_create">
          <input type="hidden" value="create_group_submit" name="field_command" class="fullboxtext" />
          <div class="fm-req">
            <label for="fm-group_name">{translate item='group_create.group_name'}: </label>
            <input maxlength="60"  name="group_name" value="{$smarty.request.group_name}" class="fullboxtext" />
          </div>
          <div class="fm-opt">
            <label for="fm-tags">{translate item='group_create.group_tags'}:</label>
            <input maxlength="60"  name="tags" value="{$smarty.request.tags}" class="fullboxtext" />
          </div>
          <p><strong>{translate item='group_create.group_tags_expl_strong'}</strong> <br />
	  {translate item='group_create.group_tags_expl'}
          </p>
          <div class="fm-opt">
            <label for="fm-desciption">{translate item='group_create.group_desc'}: </label>
            <textarea  name="description" class="fullboxtext" >{$smarty.request.description}</textarea>
          </div>
          <div class="fm-req">
            <label for="fm-short_name">{translate item='group_create.group_url'}:</label>
            {seourl rewrite='group/' url='groups_home.php?urlkey='}<br>
            <input maxlength="60" name="short_name" value="{$smarty.request.short_name}" class="fullboxtext" />
          </div>
          <p>{translate item='group_create.group_url_expl'}</p>
         <fieldset>
          <legend>{translate item='group_create.group_channels'}:</legend>
           
          {insert name=list_channel assign=chinfo vid=$VID}
          {section name=i loop=$chinfo}
          <div class="fm-opt">
            <label>&nbsp;</label>
            <input type="checkbox" name="chlist[]" value="{$chinfo[i].id}"/>
            {$chinfo[i].ch} </div>
          {/section}
		  </fieldset>
          <p><strong>{translate item='group_create.group_channels_expl_strong'}</strong><br />
            {translate item='group_create.group_channels_expl'}</p>
          <fieldset>
          <legend>{translate item='group_create.group_type'}:</legend>
          <div class="fm-opt">
            <label for="fm-public">&nbsp;</label>
            <input type="radio" checked="checked" value="public" name="group_type" />{translate item='group_create.group_type_public'}
          </div>
          <div class="fm-opt">
            <label for="fm-private_owner_approval">&nbsp;</label>
            <input type="radio" value="private_owner_approval" name="group_type" />{translate item='group_create.group_type_protected'}
          </div>
          <div class="fm-opt">
            <label for="fm-group_type">&nbsp;</label>
            <input type="radio" value="private_owner_invite" name="group_type" />{translate item='group_create.group_type_private'}
          </div>
		  </fieldset>
          <fieldset>
          <legend>{translate item='group_create.upload_type'}:</legend>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" checked="checked" value="immediate" name="video_upload_type" />{translate item='group_create.upload_type_immediate'}
          </div>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" value="owner_approve" name="video_upload_type" />{translate item='group_create.upload_type_approve'}
          </div>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" value="owner_only" name="video_upload_type" />{translate item='group_create.upload_type_owner'}
          </div>
		  </fieldset>
          <fieldset>
          <legend>{translate item='group_create.forum_type'}:</legend>
          <div class="fm-opt">
            <label for="fm-forum_upload_type">&nbsp;</label>
            <input type="radio" checked="checked" value="immediate" name="forum_upload_type" />{translate item='group_create.forum_type_immediate'}
          </div>
          <div class="fm-opt">
            <label for="fm-forum_upload_type">&nbsp;</label>
            <input type="radio" value="owner_approve" name="forum_upload_type" />{translate item='group_create.forum_type_approve'}
          </div>
          <div class="fm-opt">
            <label for="fm-forum_upload_type">&nbsp;</label>
            <input type="radio" value="owner_only" name="forum_upload_type" />{translate item='group_create.forum_type_owner'}
          </div>
          </fieldset>
          <fieldset>
          <legend>{translate item='group_create.group_icon'}:</legend>
          <div class="fm-opt">
            <label for="fm-group_icon">&nbsp;</label>
            <input type="radio" checked="checked"  value="immediate" name="group_icon" />{translate item='group_create.group_icon_immediate'}
          </div>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" value="owner_only" name="group_icon" />{translate item='group_create.group_icon_owner'}
          </div>
          </fieldset>
          	<div class="submitbutton">
		  	<input type="hidden" value="Submit" name="creategroup" />
		  	<input type="image" src="{$imgurl}/btn_submit.gif" name="submit"/>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<div class="clear"> </div>
