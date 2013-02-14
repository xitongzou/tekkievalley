<div id="fullside">
	<div id="fullbox">
		<div id="fullbox-title">
		<div class="titlepage">
		{translate item='mail.messages'} {translate item='mail.outbox'}</div><div class="videopaging">{if $total ne "0"}{translate item='mail.messages'} {$start_num} - {$end_num} {translate item='global.of'} {$total}{/if} </div>
		</div>
			<div id="fullbox-content">
  				<div class="arrow-general">&nbsp;</div>
			  <div class="inbox">
			  {if $total ne "0"}
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">{translate item='mail.subject'}</th>
                    <th scope="col">{translate item='mail.to'}</th>
                    <th scope="col">{translate item='mail.date'}</th>
                    <th scope="col">{translate item='mail.delete_action'}</th>
                  </tr>
				  {section name=i loop=$pm_id}
				  {assign var=looprecord value=$smarty.section.i.index}
					{if $looprecord%2 eq 0}
						{assign var=colorLoop value=""}	
					{else}
						{assign var=colorLoop value="blue"}	
					{/if}
                  <tr>
                    <td class="{$colorLoop}"><a href="{$baseurl}/msg.php?id={$pm_id[i]}" class="openedmail">{$subject[i]}</a></td>
                    <td class="{$colorLoop} center">{$receiver[i]}</td>
                    <td class="{$colorLoop} center">{$date[i]|date_format:"%A, %B %e, %Y"}</td>
                    <td class="{$colorLoop} center"><span class="blue center">
                    <form name="delete_mail" method="POST" action="{seourl rewrite='mail/outbox' url='outbox.php'}">
                    <input name="id" type="hidden" value="{$pm_id[i]}">
                    <input type="image" src="{$baseurl}/images/icon_delete.gif" alt="Delete Message">
                    </form>
                    </span></td>
                  </tr>
				  {/section}
                </table>
			  {else}
			  <p>Empty Outbox</p>
			  {/if}
			  </div>
			</div>
  	</div>
</div>	
<div class="clear"></div>
<div id="paging">
<div class="pagingnav">
    {$page_link}
</div>    
</div>
