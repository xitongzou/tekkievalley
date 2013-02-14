     <div id="rightcontent">
        {include file="siteadmin/errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_poll" method="POST" action="index.php?m=polladd" onSubmit="return fxvalidation();">
        <fieldset>
        <legend>Add Poll</legend>
            <label for="start_date">Start Date: </label>
            {html_select_date prefix='start_' time=$start_date end_year='+10'}<br>
            <label for="end_date">End Date: </label>
            {html_select_date prefix='end_' time=$end_date end_year='+10'}<br>
            <label for="question">Question: </label>
            <textarea name="question" id="txtQtn" onBlur="txtBoxValidation('txtQtn','#EAEAEA','#FFB3B3');">{$question}</textarea><br>
            <label for="answers">Number of answers? </label>
            <input type="text" name="answers" value="{$answers}" id="txtAnsQty"  class="small" onBlur="pollAnsBox('txtAnsQty');" onFocus="delteRow();"><br>
            <label for="questions"></label>
            <table id="tblViweAnsBox"></table>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_poll" value="Add Poll" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>