$(document).ready(function () {
    $('figure.easy_maps').each(function(){
        $map = $(this);
        var json_data = JSON.parse(decodeURIComponent($map.attr('data-map')));
        //load_easy_map($map.attr('id'), json_data);
        google.maps.event.addDomListener(window, 'load', function(){ load_easy_map($map.attr('id'), json_data) });
    });    
});
