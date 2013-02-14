     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        {if $video}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="70%">
                <h2>Video Information</h2>
                <table width="100%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Video ID</b></td>
                    <td>{$video[0].VID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Active</b></td>
                    <td><b>{if $video[0].active == 1}yes{else}no{/if}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Title</b></td>
                    <td>{$video[0].title|escape:'html'}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Description</b></td>
                    <td>{$video[0].description}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Tags</b></td>
                    <td>{$video[0].keyword}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Channels</b></td>
                    <td>
                        {insert name=video_channel assign=channel vid=$video[0].VID}
                        {section name=j loop=$channel}
                            {$channel[j].name}<br>
                        {/section}
                    </td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Duration</b></td>
                    <td>{$video[0].duration}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Type</b></td>
                    <td>{$video[0].type}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Date Added</b></td>
                    <td>{$video[0].adddate|date_format}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Rate</b></td>
                    <td>{$video[0].rate}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Is Featured</b></td>
                    <td>{$video[0].featured}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Can be commented?</b></td>
                    <td>{$video[0].be_commen}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Can be rated?</b></td>
                    <td>{$video[0].be_rated}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Can be embeded?</b></td>
                    <td>{$video[0].embed}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Views</b></td>
                    <td>{$video[0].viewnumber}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Comments</b></td>
                    <td>{$video[0].com_num}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Favorites</b></td>
                    <td>{$video[0].fav_num}</td>
                </tr>
                <tr class="view">
                    <td><b>Type</b></td>
                    <td>
                        {if $video[0].embed_code != ''}embeded{else}uploaded{/if}
                    </td>
                </tr>
                {if $video[0].embed_code == ''}
                <tr class="view">
                    <td><b>Video FLV name</b></td>
                    <td>{$video[0].flvdoname}</td>
                </tr>
                <tr class="view">
                    <td><b>Video name</b></td>
                    <td>{$video[0].vdoname}</td>
                </tr>
                {/if}
                </table>
                <br>
            </td>
            <td width="30%" valign="top" align="center">
                <h2>View Video</h2>
                {if $video[0].embed_code == ''}
				<embed src="{$baseurl}/player.swf" width="300" height="220" allowscriptaccess="always" allowfullscreen="true" flashvars="height=220&width=300&file={$flvdourl}/{$video[0].flvdoname}&image={$tmburl}/{$video[0].thumb}_{$video[0].VID}.jpg&displayheight=220&searchbar=false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />
				<br><br>
                {else}
                {$video[0].embed_code}
                {/if}
                <br><br>
                <img src="{$tmburl}/1_{$video[0].VID}.jpg" width="72" class="thumb"> &nbsp;
                <img src="{$tmburl}/2_{$video[0].VID}.jpg" width="72" class="thumb"> &nbsp;
                <img src="{$tmburl}/3_{$video[0].VID}.jpg" width="72" class="thumb"><br>
                <a href="videos.php?m=edit&VID={$video[0].VID}" class="view">Edit</a><br>
                <a href="videos.php?m=all&a=delete&VID={$video[0].VID}" class="view" onClick="javascript:return confirm('Are you sure you want to delete this video?');">Delete</a><br>
                {if $approve == '1'}
                {if $video[0].active == 0}
                <a href="videos.php?m=view&a=approve&VID={$video[0].VID}" onClick="javascript:return confirm('Are you sure you want to approve this video?');" class="view">Approve</a><br>
                {else}
                <a href="videos.php?m=view&a=suspend&VID={$video[0].VID}" onClick="javascript:return confirm('Are you sure you want to suspend this video?');" class="view">Approve</a><br>
                {/if}
                {/if}
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>