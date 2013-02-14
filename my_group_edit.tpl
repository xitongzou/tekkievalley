<div id="fullside">
  <div id="fullbox">
    <div id="fullbox-title">Edit Group <a href="{$baseurl}/groups_home.php?urlkey={$smarty.request.urlkey}">{$smarty.request.urlkey}</a></div>
    <div id="fullbox-content">
      <div class="arrow-general">&nbsp;</div>
      <div class="contentbox">
        <form name="groups_create" method="post" action="{seourl rewrite="group/edit/`$smarty.request.urlkey`" url="my_group_edit.php?urlkey=`$smarty.request.urlkey`"}">
          <input type="hidden" value="create_group_submit" name="field_command" />
          <div class="fm-req">
            <label for="fm-group_name">Group Name: </label>
            <input maxlength="60"  name="group_name" value="{$group.gname}" class="fullboxtext" />
          </div>
          <div class="fm-opt">
            <label for="fm-tags">Tags:</label>
            <input maxlength="60"  name="tags" value="{$group.keyword}" class="fullboxtext" />
          </div>
          <p><strong>Enter one or more tags, separated
            by spaces.</strong> <br />
            Tags are simply keywords used to describe
            your group so they are easily searched and organized.<br />
            For
            example, if you have a group for surfers, you might tag it: surfing
            beach waves.<br />
          </p>
          <div class="fm-opt">
            <label for="fm-desciption">Description: </label>
            <textarea  name="description" class="fullboxtext" >{$group.gdescn}</textarea>
          </div>
          <div class="fm-req">
            <label for="fm-short_name">Choose a unique group name URL:</label>
            {$baseurl}/groups_home.php?urlkey=
            <input maxlength="60" name="short_name" value="{$group.gurl}" class="fullboxtext" />
          </div>
          <p>Enter
            3-18 characters with no spaces (such as &quot;skateboarding''),
            that will become part of your group's web address. Please
            note, the group name URL you pick is permanent and can not be
            changed. </p>
         <fieldset>
          <legend>Group Channels:</legend>{$ch_checkbox}
         </fieldset>
          <p><strong>Select between one to three
            channels that your group belong to.</strong><br />
            It helps to use
            relevant channels so that others can find your group!
		 </p>
          <fieldset>
          <legend>Type:</legend>
          <div class="fm-opt">
            <label for="fm-public">&nbsp;</label>
            <input type="radio" {if $group.type eq "public"}checked="checked"{/if} value="public" name="group_type" />Public,anyone can join.
          </div>
          <div class="fm-opt">
            <label for="fm-private_owner_approval">&nbsp;</label>
            <input type="radio" value="protected"  {if $group.type eq "protected"}checked="checked"{/if}  name="group_type" />Protected, requires founder approval to join.
          </div>
          <div class="fm-opt">
            <label for="fm-group_type">&nbsp;</label>
            <input type="radio" value="private" {if $group.type eq "private"}checked="checked"{/if} name="group_type" />Private, by founder invite only, only members can view group details.
          </div>
		  </fieldset>
          <fieldset>
          <legend>Video Uploads:</legend>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gupload eq "immediate"}checked{/if} value="immediate" name="video_upload_type" />Post videos immediately.
          </div>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gupload eq "owner_approve"}checked{/if} value="owner_approve" name="video_upload_type" />Founder approval required before video is available.
          </div>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gupload eq "owner_only"}checked{/if} value="owner_only" name="video_upload_type" />Only Founder can add new videos.
          </div>
		  </fieldset>
          <fieldset>
          <legend>Forum Postings:</legend>
          <div class="fm-opt">
            <label for="fm-forum_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gposting eq "immediate"}checked="checked" {/if} value="immediate" name="forum_upload_type" />Post topics immediately.
          </div>
          <div class="fm-opt">
            <label for="fm-forum_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gposting eq "owner_approve"}checked="checked" {/if} value="owner_approve" name="forum_upload_type" />Founderapproval required before topic is available.
          </div>
          <div class="fm-opt">
            <label for="fm-forum_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gposting eq "owner_only"}checked="checked"{/if} value="owner_only" name="forum_upload_type" />Only Founder can create a new topic.
          </div>
          </fieldset>
          <fieldset>
          <legend>Group Icon:</legend>
          <div class="fm-opt">
            <label for="fm-group_icon">&nbsp;</label>
            <input type="radio" {if $group.gimage eq "immediate"}checked="checked"{/if} checked="checked"  value="immediate" name="group_icon" />Automatically set group icon to last uploaded video.
          </div>
          <div class="fm-opt">
            <label for="fm-video_upload_type">&nbsp;</label>
            <input type="radio" {if $group.gimage eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_icon" />Let owner pick the video as group icon.
          </div>
          </fieldset>
          	<div class="submitbutton">
		  	<input type="hidden" value="Update" name="edit_group" />
		  	<input type="image" src="{$baseurl}/images/btn_edit.gif" name="submit"/>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<div class="clear"> </div>
