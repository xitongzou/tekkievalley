<div id="fullside">
	<div id="fullbox">
		<div id="fullbox-title">Edit Video</div>
			<div id="fullbox-content">
  				<div class="arrow-general">&nbsp;</div>
			   <form action="{seourl rewrite="video/edit/`$smarty.request.VID`" url="my_vdo_edit.php?VID=`$smarty.request.VID`"}" method="post">
              <div class="contentbox">
              	<div class="fm-req">
                	<label for="fm-vtitle">Title</label><input maxLength="60" size="40" name="vtitle" id="fm-vtitle" value="{$answers[0].title}" type="text" class="inputtext" />
				</div>
                <div class="fm-req">
                    <label for="fm-vdescription">Description</label><textarea name="vdescription" rows="4" cols="50" id="fm-vdescription" class="inputtext">{$answers[0].description}</textarea>
                </div>
                    {if $answers[0].featured eq "yes"}
                 <div class="fm-req">
                    <label for="fm-featuredesc">Feature Description</label><textarea name="featuredesc" rows="4" cols="50" id="fm-featuredesc" class="inputtext">{$answers[0].featuredesc}</textarea>
                 </div>   
                    {/if}
                 <div class="formFieldInfo"> 
                    	Enter one or more tags, separated
                        by spaces.<br/>Tags are simply keywords used to describe
                        your video so they are easily searched and organized. For example,
                        if you have a surfing video, you might tag it: surfing beach
                        waves.
                    </div>
                 <div class="fm-opt">   
                    <label for="fm-vkeyword">Tags</label><input maxLength="120" size="40" name="vkeyword" id="fm-vkeyword" value="{$answers[0].keyword}" type="text" class="inputtext" />
                    
                  </div>
                  <div class="formFieldInfo">Select between one to three channels that best describe your video.<br />
                      It helps to use
                      relevant channels so that others can find your video!</div>
                  <div class="fm-opt">
                  	<label>Video Channels</label>&nbsp;
                  </div>
                    {insert name=list_channel assign=chinfo vid=$VID}
                    {section name=i loop=$chinfo}
                    	{assign var="status" value=""}
                    		{section name=j loop=$chid}
                    			{if $chid[j] eq $chinfo[i].id}{assign var="status" value="checked"}{/if}
                    		{/section}
                    		<div class="fm-opt">
            					<label>&nbsp;</label><input type="checkbox" name="chlist[]" value="{$chinfo[i].id}" {$status} />{$chinfo[i].ch}
                            </div>
                    {/section}
                    <div class="fm-opt">
                    	<strong>Date &amp; Location Details(Optional)</strong>
                    </div>
                    <div class="fm-opt">
                    	<label>Date Recorded</label>
                        <select name="month"><option>mm</option>{$months}</select>
                        <select name="day"><option>dd</option>{$days}</select>
                        <select name="year"><option>yyyy</option>{$years}</select>
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-field_address">Location Recorded</label>
                        <input maxLength="255" size="40" name="field_address" id="fm-field_address" value="{$answers[0].location}" type="text" class="inputtext" />
                        <div class=formFieldInfo>Examples: "165 University Ave, Palo Alto,
            			CA" &nbsp; "New York City, NY" &nbsp; "Tokyo"</div>
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-country">Country</label>
                        <select name="country" id="fm-country"><option>Select Country</option>{$country}</select>
                    </div>
                    <div class="fm-opt">
                    	<label>File Details</label>
                        Uploaded on {insert name=time_to_date assign=todate tm=$answers[i].addtime} {$todate}  as <i>{$answers[0].filehome}</i>
                    </div>
                    <div class="fm-opt">
                    	<strong>Broadcast</strong>
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-public_video_privacy">Public</label>
                        <input type="radio" CHECKED value="public" name="video_privacy" id="fm-public_video_privacy" {if $answers[0].type eq "public"}checked{/if} /> Share your video with the world! (Recommended)
                    </div>
                    <div class="fm-opt">
                    	<label id="public_video_privacy">Private</label>
                        <input type="radio" value="private" name="video_privacy" id="fm-private_video_privacy" {if $answers[0].type eq "private"}checked{/if} />
                        Only viewable by you and those you send the video to through <a href="javascript:openShare()">our share feature</a>.
                    </div>
                   
                    
                    <div class="fm-opt">
                    	<strong>Allow Comment</strong>
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-enabled_allow_comments">Enabled</label>
                        <input type="radio" value="yes" name="allow_comments" id="fm-enabled_allow_comments" {if $answers[0].be_comment eq "yes"}checked{/if}/> Allow comments to be added to your video.
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-disabled_allow_comments">Disabled</label>
                        <input type="radio" value="no" name="allow_comments" id="fm-disabled_allow_comments" {if $answers[0].be_comment eq "no"}checked{/if} /> Disallow comments to be added to your video.
                    </div>
                    
                    <div class="fm-opt">
                    	<strong>Allow Ratings</strong>
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-yes_allow_ratings">Yes</label>
                        <input type="radio" CHECKED value="yes" name="allow_ratings" id="fm-yes_allow_ratings" {if $answers[0].be_rated eq "yes"}checked{/if} />Allow people to rate your video.
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-no_allow_ratings">No</label>
                        <input type="radio" value="no" name="allow_ratings" id="fm-no_allow_ratings" {if $answers[0].be_rated eq "no"}checked{/if} />Disallow people from rating your video.
                    </div>
                    
                    <div class="fm-opt">
                    	<strong>Allow External Sites to Embed This Video</strong>
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-enable_allow_embed">Enabled</label>
                        <input type="radio" value="enabled" name="allow_embed" id="fm-enabled_allow_embed" {if $answers[0].embed eq "enabled"}checked{/if} />
                        External sites may embed and play this video.
                    </div>
                    <div class="fm-opt">
                    	<label for="fm-disabled_allow_embed">Disabled</label>
                        <input type="radio" value="disabled" name="allow_embed" id="fm-disabled_allow_embed" {if $answers[0].embed eq "disabled"}checked{/if} />External sites may NOT embed and play this video.
                    </div>
		    <div class="fm-opt">
			<strong>Select Video Thumb</strong>
		    </div>
		    <div class="fm-opt">
			<label for="fm-thumb">Thumb {$answers[0].VID}</label>
			<input name="thumb" type="radio" value="1"{if $answers[0].thumb == 1} checked="checked"{/if}><img src="{$tmburl}/1_{$answers[0].VID}.jpg">
			<input name="thumb" type="radio" value="2"{if $answers[0].thumb == 2} checked="checked"{/if}><img src="{$tmburl}/2_{$answers[0].VID}.jpg">
			<input name="thumb" type="radio" value="3"{if $answers[0].thumb == 3} checked="checked"{/if}><img src="{$tmburl}/3_{$answers[0].VID}.jpg">
		    </div>
                    <div class="submitbutton">
                        <input type="hidden" value="Update Video" name="update_video" />
                        <input type="image" src="{$baseurl}/images/btn_update_video.gif" name="Send Invite"/>
                    </div>
                </div>
                </form>
			  </div>
			</div>
  	</div>
</div>	
<div class="clear"></div>