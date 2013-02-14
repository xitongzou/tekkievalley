<div id="containersearch">
<div id="search">
  <form action="{$baseurl}/search_result.php" method="get" name="searchForm" id="searchForm">
    <p>
      <input size="40" tabindex="1" maxlength="22" name="search_id" value="{$smarty.request.search_id}" class="text"  />
      <input type="hidden" name="search_type"  value="search_users">
      <input type="image" src="{$imgurl}/search.gif" tabindex="3"  class="button" />
    </p>
  </form>
   <div id="clear"></div>
</div>
</div>