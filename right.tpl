<div id="rightside">
  <div id="statistic">
		<div id="statistic-content">
                <a href="{seourl rewrite='upload' url='upload.php'}">  <h3>{translate item='index.upload_now'}</h3></a>
                 <a href="{seourl rewrite='upload' url='upload.php'}">
				 <img src="{$imgurl}/upload3.jpg" alt="Upload" height="100" width="100" align="center" border="0" /></a>
                </div>
  </div>
  <div id="statistic">
		<div id="statistic-content">
				<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script src="{$baseurl}/js/twitter.js" type="text/javascript">
			</script>
			<script type="text/javascript">twitter("google apps OR JavaScript OR jquery OR starcraft OR facebook api OR twitter api");</script>
		</div>
  </div>
  { if $lfubannar ne 'Disable'}
  <div id="clear"></div>
  {/if}
  {if $pollinganel ne 'Disable'}
  {if isset($list) }
  <!-- 			# SOW VOTING -->
  <div id="vote"> 
		<div id="vote-title">{translate item='index.vote_here'}
			<div id='divVoteImage'></div>
		</div>
		<div id="vote-content">
  			<div class="arrow-general">&nbsp;</div>
            <div id="tblViewVote"></div>
			<div id="divShowVoting">
            	<div id="tblVote">
                {if $poll_qty ne ""}
                  <b>{$poll_qty}</b><br/>
                  <!-- 		{$poll_id}{$answers} -->
                  {section name=i loop=$list}
                  <input type="radio" name="xx" onclick="directMyvalueto('{$list[i]}','opAns')" />{$list[i]}<br/>
                  {/section}
                  <input type="hidden" id="opAns" />
                  <input type="submit" class="input_btn" id='btnVoteSubmit' value='Cast This' onclick="fxVote({$poll_id})" />
                  {/if}
                  <!--  			# END VOTING SECTION -->
                </div>
                <table id="tblPResult"><tr><td></td></tr></table>
				<div id="tblViewVote">            
				  <div id="tblViewVote">                 
                  	  <div id="divviewvresult"><a href="javascript:void(0)" onclick="viewVote({$poll_id});hideMe('divviewvresult')"> {translate item='index.vote_status'} </a></div>
                      <table id="tblViewVoteResult" width="100%"></table>
                  </div>
                </div>
                <table id="tblVoteResult" width="100%"></table>
            </div>
		</div>
	</div>
	<div id="clear"></div>
   {/if}
   {/if}
   <div id="adv">
		<div id="adv-title">{translate item='global.advertisment'}</div>
		<div id="adv-content">
  			<div class="arrow-general">&nbsp;</div>
            {insert name=advertise group='index_right'}
		</div>
	</div>  
	<div id="clear"></div>
</div>
<div class="clear"></div>
