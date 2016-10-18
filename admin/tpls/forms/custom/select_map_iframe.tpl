<html>
<head>
</head>
<body style="margin:0px;">

<div id="GMap" style="width:100%;height:100%;"></div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

function initialize() {

	var marker;
	
	var map_options = {
		zoom: {default_values.googlemaps_zoom},
		center: new google.maps.LatLng({default_values.googlemaps_centerlat},{default_values.googlemaps_centerlon}),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById("GMap"), map_options);
	
	google.maps.event.addListener(map, 'click', function(event) {
		marker = placeMarker(map, event.latLng, marker);
	});
	
	{block data_values.lon}
	marker = placeMarker(map, new google.maps.LatLng({data_values.lat}, {data_values.lon}), marker);
	map.setCenter(new google.maps.LatLng({data_values.lat}, {data_values.lon}));
	{-block data_values.lon}

}

function placeMarker(map, location, marker) {
	  
	if(typeof(marker)!='undefined'){
		marker.setPosition(location);
	}else{
		var marker = new google.maps.Marker({
			position: location,
			map: map
		});
	}
	//map.setCenter(location);
	  
	frm = window.parent.document;
	  
	frm.getElementById('ELMID_{column_name_lat}').value = location.lat();
	frm.getElementById('ELMID_{column_name_lon}').value = location.lng();
	
	return marker;

}

function clean(map){
	
}


</script>

<script type="text/javascript">
initialize();
</script>
</body>
</html>
