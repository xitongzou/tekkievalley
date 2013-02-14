$(document).ready(function() {
    $("img[id*='change_tmb_']").click(function(event) {
        event.preventDefault();
        var click_id    = $(this).attr('id');
        var id_split    = click_id.split('_');
        var vkey        = id_split[2];
        var thumb       = id_split[3];
        for( var i=1; i<=20; i++ ) {
            if ( i == thumb ) {
                $(this).css('border-color', '#ff4800');
            } else {
                $("img[id='change_tmb_" + vkey + "_" + i + "']").css('border-color', '#ccc');
            }
        }
        $("input[id='" + vkey + "']").val(thumb);
    });
    
    $("input[id='edit_video_advanced'],input[id='edit_user_advanced'],input[id='edit_game_advanced']").click(function() {
        var val = $(this).val();
        if ( val == '-- Show Advanced --' ) {
            $('#advanced').fadeIn();
            $(this).val('-- Hide Advanced --');
        } else {
            $('#advanced').fadeOut();
            $(this).val('-- Show Advanced --');
        }
    });
    
    $("input[id='edit_user_password']").click(function() {
        var val = $(this).val();
        if ( val == '-- Change Password --' ) {
            $("#password").fadeIn();
            $(this).val('-- Hide Password --');
        } else {
            $("#password").fadeOut();
            $(this).val('-- Change Password --');
        }
    });
    
    $("input[id*='_check_all']").click(function() {
        var input_id = $(this).attr('id');
        var id_split = input_id.split('_');
        var type     = id_split[0];
        var checkboxes = $("input[id*='" + type + "_checkbox_']");
        if ( $(this).attr('checked') == false ) {
            jQuery.each($(checkboxes), function() {
                $(this).attr('checked', false);
            });
        } else {
            jQuery.each($(checkboxes), function() {
                $(this).attr('checked', true);
            });
        }
    });
	
	$("a[id*='static_page_']").click(function(event) {
		event.preventDefault();
		var page_id  = $(this).attr('id');
		var id_split = page_id.split('_');
		var div_id   = id_split[2];
		var pages    = new Array('about', 'dev', 'help', 'terms', 'privacy');
		jQuery.each(pages, function() {
			if (this == div_id) {
				$('#' + this).show();
			} else {
				$('#' + this).hide();
			}
		});
	});
});
