var $j = jQuery.noConflict();
$j(document).ready(function() {
    var lis = $j('#lang > li');
    $j.each(lis, function() {
        var liclass = $j(this).attr('class');
        if ( liclass == 'lang-select' ) {
            $j(this).mouseover(function() {
                $j(this).attr('class', 'over');
            }).mouseout(function() {
                $j(this).attr('class', '');
            });
        }
    });
    
    $j("a[id*='language_']").click(function(event) {
        event.preventDefault();
        var click_id  = $j(this).attr('id');
        var id_split  = click_id.split('_');
        var lang      = id_split[1] + '_' + id_split[2];
	var clickable = id_split[3];
	if ( clickable != 'disabled' ) {
    	    $j("input[name=session_language]").val(lang);
    	    $j('#language_form').submit();
	}
    });    
});
