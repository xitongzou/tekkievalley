     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Question</b></td>
                <td align="center"><b>Answers/Voting</b></td>
                <td align="center"><b>Start Date</b></td>
                <td align="center"><b>End Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $polls}
            {section name=i loop=$polls}
            {insert name=pollanswer assign=ansarray anspot=$polls[i].poll_answer}
            {insert name=pollresult assign=resarray pollid=$polls[i].poll_id}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$polls[i].poll_id}</td>
                <td align="center" valign="top">{$polls[i].poll_qty}</td>
                <td align="center">
                <table width="100%" border="0" cellspacing="2" cellpadding="3" style="font-size: 1em;">
                {section name=j loop=$ansarray}
                <tr bgcolor="{cycle name="answers" values="#efe4e4,#f6eeee"}">
                    <td>{$ansarray[j]}</td>
                    <td width="15%" align="right">{$resarray[j]}%</td>
                </tr>
                {/section}
                </table>
                </td>
                <td align="center">{$polls[i].start_date}</td>
                <td align="center">{$polls[i].end_date}</td>
                <td align="center">
                    <a href="index.php?m=polls&a=delete&PID={$polls[i].poll_id}" onClick="javascript:return confirm('Are you sure you want to delete this poll?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO POLLS FOUND. CLICK <a href="index.php?m=polladd">HERE</a> TO ADD POLLS!</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>
