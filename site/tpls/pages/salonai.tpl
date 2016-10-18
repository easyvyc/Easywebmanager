<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a>
        
        {loop path}
        {block path._FIRST no}
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        <a href="{path.page_url}" title="{path.page_title}">{path.title}</a>
        {-block path._FIRST no}
        {-loop path}
    </nav>
    
    <div id="social">
        
        <div class="contenteditable" contenteditable="true" id="blocks-social-0">{main_blocks.social.description}</div>
        
    </div>
    
</div>    

<div id="inner_content" class="overflow">
    
    {inner_menu_content}
            
    <article {block inner_menu no}class="no_inner_menu"{-block inner_menu no}>
    
        <h1 class="title">{page_data.header_title}</h1>
        
<style>
#contacts-list {
    margin:15px 0;
}
#contacts-list .item {
    border:1px solid #CCC;
    margin:3px 0px;
    padding:8px;
}
</style>        
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
             
        <script>
        function initialize() {
          var mapOptions = {
            zoom: 7,
            center: new google.maps.LatLng(56.93298739609704, 24.06005859375),
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
          var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          var infowindow = new google.maps.InfoWindow({maxWidth: 500});
          
          setMarkers(map, contacts, infowindow);
        }
        
        var contacts = [
        {loop contacts}
          ['{contacts.title}', {contacts.lon}, {contacts.lat}, '{contacts.short_description}'],
        {-loop contacts}
        ];

        function setMarkers(map, locations, infowindow) {
          var image = {
            url: 'site/images/marker.png',
            size: new google.maps.Size(40, 20),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(0, 20)
          };
          for (var i = 0; i < locations.length; i++) {
            var contact = locations[i];
            var myLatLng = new google.maps.LatLng(contact[2], contact[1]);
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: image,
                title: ''
            });
            
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(locations[i][3]);
                infowindow.open(map, marker);
              }
            })(marker, i));
      
          }
        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>             
        
        <div id="map-canvas" style="height:500px;width:100%"></div>
        
        <div class="contenteditable" contenteditable="true" id="blocks-description-{page_data.id}">{page_data.page_area.description}</div>


        <div id="contacts-list">
            
            {loop contacts}
            <div class="item">
              {contacts.short_description}
            </div>
            {-loop contacts}
            
            
        </div>
        
        
    </article>
    
</div>