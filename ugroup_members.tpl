{if $total gt "0"}
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
<TBODY>
<TR vAlign=top>
        <TD style="PADDING-RIGHT: 15px">
        <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#cccccc border=0>
        <FORM action=/groups_members method=post>
        <TBODY>
        <TR>
        <TD><IMG height=1 src="YouTube - Broadcast Yourself_files/pixel.gif" width=5></TD>
        <TD>

                <DIV class=watchTitleBar>
                <TABLE cellSpacing=0 cellPadding=3 width="100%" border=0>
                <TBODY>
                <TR vAlign=top>
                <TD><DIV class=moduleTitle>
                <A href="">{$groupname}</A> // Members</DIV>
                </td>
                <td><DIV style="FONT-WEIGHT: bold; FONT-SIZE: 12px; FLOAT: right; VERTICAL-ALIGN: bottom; COLOR: #444;
                MARGIN-RIGHT: 5px">Results {$start_num}-{$end_num} of {$total} </DIV></TD>
                </TR>
                </TBODY>
                </TABLE>
                </DIV>

                {section name=i loop=$answers}
                {insert name=get_photo assign=imgid uid=$answers[i].MID}
                {insert name=video_count assign=vdocount uid=$answers[i].MID}
                {insert name=favour_count assign=favcount uid=$answers[i].MID}
                {insert name=check_group_own assign=WONID gid=$answers[i].GID}
                <DIV class=moduleEntry>
                <TABLE cellSpacing=0 cellPadding=0 width=565 border=0>
                <TBODY>
                <TR vAlign=top>
                <TD align=middle>
                <A href="{$baseurl}/uprofile.php?UID={$answers[i].MID}">
                {if $imgid ne ""}
                <IMG class=moduleEntryThumb height=45 src="{$tmburl}/1_{$imgid}.jpg" width=60>
                {else}<IMG class=moduleEntryThumb height=45 src="{$tmburl}/no_videos_groups.gif" width=60>{/if}
                </A>
                </TD>
                <TD width="100%">
                <DIV style="FONT-WEIGHT: bold; FONT-SIZE: 14px; PADDING-BOTTOM: 3px">
                <A href="{$baseurl}/uprofile.php?UID={$answers[i].MID}">
                {insert name=id_to_name assign=uname un=$answers[i].MID}{$uname}
                </A>&nbsp;
                {if $answers[i].MID eq "$WONID"}<SPAN style="FONT-SIZE: 12px">(Owner)</SPAN>{/if}</DIV>
                <DIV style="FONT-SIZE: 12px; PADDING-BOTTOM: 5px">
                Videos: <A href="{$baseurl}/uvideos.php?UID={$answers[i].MID}">{$vdocount}</A> |
                Favorites: <A href="{$baseurl}/ufavour.php?UID={$answers[i].MID}">{$favcount}</A> |
                Friends: <A href="http://www.youtube.com/profile_friends?user=craigmcf">22</A>
                </DIV>
                <DIV style="FONT-SIZE: 11px">
                {insert name=time_to_date assign=todate tm=$answers[i].addtime}Member Since: {$todate}</DIV>
                </TD>
                </TR>
                </TBODY>
                </TABLE>
                </DIV>
                {/section}

        <!-- begin paging --><!-- end paging -->
        <TD><IMG height=1src="YouTube - Broadcast Yourself_files/pixel.gif" width=5></TD>
        </TR>
        </FORM>
        </TBODY>
        </TABLE>
        </TD>
        <TD width=180>
        <TABLE cellSpacing=0 cellPadding=0 width=180 align=center bgColor=#ffeebb border=0>
        <TBODY>
        <TR>
        <TD><IMG height=1 src="YouTube - Broadcast Yourself_files/pixel.gif" width=5></TD>
        <TD width=170>
        <DIV style="PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 16px; PADDING-BOTTOM: 10px; PADDING-TOP: 5px; TEXT-ALIGN: center">
        <A href="{seourl rewrite='invite' url='invite_friends.php'}">Invite your friends to join this Group!</A>
        </DIV>
        </TD>
        <TD><IMG height=1 src="YouTube - Broadcast Yourself_files/pixel.gif" width=5></TD>
        </TR></TBODY></TABLE>
</TD></TR></TBODY></TABLE>
</TD>
</TR>
</TBODY>
</TABLE>
{/if}
