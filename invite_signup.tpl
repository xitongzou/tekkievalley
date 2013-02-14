<H1 class=tableSubTitle>Welcome to {$site_name}, {$smarty.session.USERNAME}!</H1>
        <P>We hope you enjoy your experience. Write anytime to let us know how we
        can serve you better.<BR>- <I>The {$site_name} Team</I> </P>
        <TABLE class=roundedTable cellSpacing=0 cellPadding=0 width=777
        align=center bgColor=#e5ecf9 border=0>
        <TBODY>
        <TR>
        <TD><IMG height=1 src="{$site_name} - Broadcast Yourself_files/pixel.gif" width=5></TD>
        <TD width=767>
            <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR vAlign=top>
                <TD class=highLight
                style="PADDING-RIGHT: 10px; PADDING-LEFT: 10px; FONT-WEIGHT: bold; PADDING-BOTTOM: 13px; PADDING-TOP: 3px; BORDER-RIGHT-STYLE: none">What
                  would you like to do next?</TD>
                <TD
                style="PADDING-RIGHT: 10px; PADDING-LEFT: 10px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">&nbsp;</TD></TR>
              <TR vAlign=top>
                <TD
                style="BORDER-RIGHT: #369 1px dashed; PADDING-RIGHT: 10px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px"
                width="50%">
                  <DIV style="FONT-SIZE: 13px; MARGIN-BOTTOM: 5px">
                  <UL>
                    <LI><A
                    href="{$baseurl}/my_profile.php"><STRONG>Complete
                    your profile page</STRONG></A>
                    <DIV
                    style="PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 15px; PADDING-TOP: 4px">The
                    {$site_name} community wants to know about you.</DIV>
                    <LI><A
                    href="{$baseurl}/upload.php"><STRONG>Upload
                    your videos</STRONG></A>
                    <DIV
                    style="PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 15px; PADDING-TOP: 4px">Share
                    your experiences with the world.</DIV></LI></UL></DIV></TD>
                <TD
                style="PADDING-RIGHT: 10px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px"
                width="50%">
                  <DIV style="FONT-SIZE: 13px; MARGIN-BOTTOM: 0px">
                  <UL>
                    <LI><A href="{$baseurl}/channels.php"><STRONG>Browse
                    the channels</STRONG></A>
                    <DIV
                    style="PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 15px; PADDING-TOP: 4px">Watch
                    videos organized into categories.</DIV>
                    <LI><A href="{$baseurl}/video.php"><STRONG>Start
                    watching videos </STRONG></A>
                    <DIV
                    style="PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 15px; PADDING-TOP: 4px">Search
                    and browse 1000's of streaming
              videos.</DIV></LI></UL></DIV></TD></TR></TBODY></TABLE></TD>
          <TD><IMG height=1 src="{$site_name} - Broadcast Yourself_files/pixel.gif"
            width=5></TD></TR>
        </TBODY></TABLE>

        <P><H1 class=tableSubTitle>{$site_name} is...</H1><BR><SPAN class=highLight><I>For
        Families:</I></SPAN> <I>Have family members that you wish to share baby or
        event videos with? Invite them to join!</I> <BR><BR>
        <FORM action="{$baseurl}/invite_signup.php" method=post>
        <TABLE cellSpacing=5 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Family"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Family"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Family"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Family"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD colSpan=2>&nbsp;</TD></TR>
        <TR>
          <TD colSpan=2><SPAN class=highLight><I>For Friends and
            Co-Workers:</I></SPAN> <I>Have co-workers and friends you want to
            share funny videos with? Invite them to join!</I></TD></TR>
        <TR>
          <TD align=right colSpan=2>&nbsp;</TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Friends"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Friends"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Friends"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD align=right><SPAN class=label><NOBR>Email Address:</NOBR>
          </SPAN></TD>
          <TD><input type="hidden" name="type[]" value="Friends"><INPUT maxLength=60 size=30 name=friends_email[]>
          <SPAN class=label style="MARGIN-LEFT: 3em"><NOBR>First Name:</NOBR>
            </SPAN><INPUT maxLength=30 name=friends_fname[]></TD></TR>
        <TR>
          <TD style="FONT-SIZE: 1px" colSpan=2>&nbsp;</TD></TR>
        <TR vAlign=top>
          <TD align=right><SPAN class=label>Your Message:</SPAN></TD>
          <TD>
            <DIV class=formHighlight>Hello [{$first_name}], <BR><BR>{$site_name} is a
            new site for sharing and hosting personal videos. I have been
            <BR>using {$site_name} to share videos with my friends and family. I
            would like to add <BR>you to the list of people I may share videos
            with. <BR><BR>Personal message from [first name]: <BR><BR>
            <TEXTAREA name=message rows=5 cols=45>Have you heard about {$site_name}? I love this site.</TEXTAREA>
            <BR><BR>Thanks, <BR>{$smarty.session.USERNAME} <BR><BR></DIV></TD></TR>
        <TR>
          <TD>&nbsp;</TD>
          <TD><INPUT type=submit value="Send Invite" name="invite_signup">
          <INPUT onclick="document.location='{$baseurl}/index.php';" type=button value=Skip name=cancel>
          </TD>
        </TR>
        </TBODY>
        </TABLE>
        </FORM>
        </DIV>
        </TD>
</TR>
</TBODY>
</TABLE>
