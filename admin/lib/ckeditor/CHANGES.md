<script class="doksoft_maps_google" src="http://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;libraries=places,weather"></script>
<script src="http://maps.gstatic.com/cat_js/intl/lt_ALL/mapfiles/api-3/17/8/%7Bmain,places,weather%7D.js" type="text/javascript"></script>
<script class="doksoft_maps_google" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel_packed.js"></script>
<script class="doksoft_maps_loadmap">
_loadmap = function(id,json){
        var canva = document.getElementById(id);
        canva.style.width=json.width+"px";
        canva.style.height=json.height+"px";
        var map = new google.maps.Map(canva, {zoom: parseInt(json.zoom), center: new google.maps.LatLng(parseFloat(json.lat), parseFloat(json.lng)),mapTypeId:json.type});
        if( json.settings ){ 
            for( var id in json.settings )
                map.set(id,json.settings[id]?true:false);
        };
        if( json.objects ) 
            for( var type in json.objects ){  
                for( var i in json.objects[type] ){
                    var object = 0;
                    switch( type ){
                        case 'Marker':object = new google.maps.Marker({position: new google.maps.LatLng( json.objects[type][i][0], json.objects[type][i][1]),map: map,title: json.objects[type][i][2]});(function(txt){google.maps.event.addListener(object, 'click', function() {(new google.maps.InfoWindow({content: txt})).open( map,object );});})(json.objects[type][i][2]);break;
                        case 'Rectangle':object = new google.maps.Rectangle({bounds: new google.maps.LatLngBounds(new google.maps.LatLng( json.objects[type][i][0][0], json.objects[type][i][0][1]),new google.maps.LatLng( json.objects[type][i][1][0], json.objects[type][i][1][1])),map: map,});break;
                        case 'Polygon':case 'Polyline':var path = json.objects[type][i],array_path = [];for( var j in path )array_path.push(new google.maps.LatLng( path[j][0], path[j][1]));object = new google.maps[type]({path: array_path,map: map,});break;
                        case 'Text':object = new MarkerWithLabel({position: new google.maps.LatLng( json.objects[type][i][0], json.objects[type][i][1]),map: map,labelContent: json.objects[type][i][2],labelAnchor: new google.maps.Point(22, 0),labelClass: "labels",labelStyle: {opacity: 1.0, minWidth:'200px',textAlign:'left'},icon: {}});break;
                        case 'Circle':object = new google.maps.Circle({radius: json.objects[type][i][2],center:new google.maps.LatLng( json.objects[type][i][0], json.objects[type][i][1]),map: map,});break;
                        case 'WeatherLayer':object = new google.maps.weather.WeatherLayer({temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT});object.setMap(map);break;
                        case 'TrafficLayer':object = new google.maps.TrafficLayer();object.setMap(map);break;}  
                } 
            }
};

loadmap = function( id,json ){
                google.maps.event.addDomListener(window, 'load', function(){ _loadmap(id,json) } ); 
};

</script>
<p>&nbsp;</p>

<p>&nbsp;</p>

<div id="doksoft_maps3">&nbsp;</div>
<script class="doksoft_maps">
    loadmap("doksoft_maps3",{"lat":55.810544235706125,"lng":21.203613124999947,"zoom":9,"type":"roadmap","width":400,"height":300,"settings":{"mapTypeControl":1,"zoomControl":1,"rotateControl":0,"scaleControl":1,"streetViewControl":0,"panControl":0,"overviewMapControl":0,"draggable":1,"disableDoubleClickZoom":0},"objects":{"Marker":[[55.8290586885836,21.21185302734375,"Hello World!"]],"Circle":[],"Polyline":[],"Text":[],"Polygon":[],"Rectangle":[],"TrafficLayer":[],"WeatherLayer":[]}});</script>
<p>&nbsp;</p>
&nbsp;