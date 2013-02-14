var url     = baseurl + '/thumb/';
var timers  = new Array;
var images  = new Array;
var thumbs  = 3;
function changeThumb( id, url )
{
        document.getElementById(id).src = url;
}

$j(document).ready(function() {
    $j("img[id*='rotate_']").mouseover(function(){
        var image_id    = $j(this).attr("id");
        var id_split    = image_id.split('_');
        var video_id    = id_split[1];
        for ( var i=1; i<=thumbs; i++ ) {
            var image_url = url + '/' + i + '_' + video_id + '.jpg';
            images[i]     = new Image();
            images[i].src = image_url;
        }
        for ( var i=1; i<=thumbs; i++ ) {
            timers[i] = setTimeout("changeThumb('" + image_id + "','" + url + '/' + i + '_' + video_id + '.jpg' + "')", i*50*10);
        }
    }).mouseout(function(){
        var image_id    = $j(this).attr("id");
        var id_split    = image_id.split('_');
        var video_id    = id_split[1];
        for ( var i=1; i<=thumbs; i++ ) {
            if ( typeof timers[i] == "number" ) {
                clearTimeout(timers[i]);
            }
        }
        $j(this).attr('src', url + '/1_' + video_id + '.jpg');
    });
});
