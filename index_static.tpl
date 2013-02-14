     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Static Pages</h2>
        <table width="80%" cellspacing="5" cellpadding="5" border="0">
        <tr class="view">
            <td align="center"><a href="#" id="static_page_about"><b>About</b></a></td>
            <td align="center"><a href="#" id="static_page_dev"><b>Developers</b></a></td>
            <td align="center"><a href="#" id="static_page_help"><b>Help</b></a></td>
            <td align="center"><a href="#" id="static_page_terms"><b>Terms Of Use</b></a></td>
            <td align="center"><a href="#" id="static_page_privacy"><b>Privacy Policy</b></a></td>
        </table>
        </div>
        </div>
        {if $edit && $page}
        <br>
        <div id="right">
        <div align="center">
        <h2>Editing: {$page}</h2>
        <div id="simpleForm">
        <form name="static_edit" method="POST" action="index.php?m=static&page={$page}" style="width: 96%;">
        <fieldset>
        <legend>Edit Static Page</legend>
            <textarea name="static_content" rows="25" class="adv">{include file=$page}</textarea><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_static" value="Update Static Page" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
        {else}
        <br>
        <div id="about" style="display:{if $page == 'about.tpl'}block{else}none{/if};">
        <b>Preview:</b> about.tpl <a href="index.php?m=static&a=edit&page=about.tpl"><b>Edit</b></a><br>
        <div class="static">
        {include file='about.tpl'}
        </div>
        </div>
        <div id="dev" style="display:{if $page == 'dev.tpl'}block{else}none{/if};">
        <b>Preview:</b> dev.tpl <a href="index.php?m=static&a=edit&page=dev.tpl"><b>Edit</b></a><br>
        <div class="static">
        {include file='dev.tpl'}
        </div>
        </div>
        <div id="help" style="display:{if $page == 'help.tpl'}block{else}none{/if};">
        <b>Preview:</b> help.tpl <a href="index.php?m=static&a=edit&page=help.tpl"><b>Edit</b></a><br>
        <div class="static">
        {include file='help.tpl'}
        </div>
        </div>
        <div id="terms" style="display:{if $page == 'terms.tpl'}block{else}none{/if};">
        <b>Preview:</b> terms.tpl <a href="index.php?m=static&a=edit&page=terms.tpl"><b>Edit</b></a><br>
        <div class="static">
        {include file='terms.tpl'}
        </div>
        </div>
        <div id="privacy" style="display:{if $page == 'privacy.tpl'}block{else}none{/if};">
        <b>Preview:</b> privacy.tpl <a href="index.php?m=static&a=edit&page=privacy.tpl"><b>Edit</b></a><br>
        <div class="static">
        {include file='privacy.tpl'}
        </div>
        </div>
        {/if}
     </div>     
