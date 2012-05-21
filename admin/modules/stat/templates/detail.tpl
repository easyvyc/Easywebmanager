<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

		{menu}

		</td>
	</tr>

	<tr>
		<td>


	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('items_list_grid',10,40);" id="items_list_grid_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.show_stat_by_date}</span>
			</td>
		</tr>
	</table>
	</div>	

<div id="items_list_grid">
{detail_content}
</div></div>


<div id="visitor_map">


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key={stat_config.google_map_code}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
document.write('<div id="gmap201081015255" style="width:100%; height:450px;">.<\/div>');
function CreateGMap201081015255() {
	if(!GBrowserIsCompatible()) return;
	var allMapTypes = [G_NORMAL_MAP, G_SATELLITE_MAP, G_HYBRID_MAP, G_PHYSICAL_MAP] ;
	var map = new GMap2(document.getElementById("gmap201081015255"), {mapTypes:allMapTypes});
	map.setCenter(new GLatLng(44.9648,-23.20312), 3);
	map.setMapType( allMapTypes[ 0 ] );
	map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	
	markers = new Array;

	<loop name="markers">
	markers[markers.length] = { lat:{markers.latitude}, lon:{markers.longitude}, text:"{markers.text}" };
	</loop name="markers">

	AddMarkers( map, markers ) ;
}
</script>
<script type="text/javascript">
// FCK googlemapsEnd v1.97
function AddMarkers( map, aPoints )
{
	for (var i=0; i<aPoints.length ; i++)
	{
		var point = aPoints[i] ;
		map.addOverlay( createMarker(new GLatLng(point.lat, point.lon), point.text) );
	}
}
function createMarker( point, html )
{
	var marker = new GMarker(point);
	GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(html, {maxWidth:200});
	});
	return marker;
}
if (window.addEventListener) {
    window.addEventListener("load", CreateGMap201081015255, false);
} else {
    window.attachEvent("onload", CreateGMap201081015255);
}
onunload = GUnload ;
</script>


</div>

<block name="no">
<block name="empty" no>		
		
		
	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('referers',10,40);" id="referers_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_by_referer}</span>
			</td>
		</tr>
	</table>
	</div>	
		
		<div class="stat_content search_results" id="referers" style="display:none">
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=referers&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		</div>

	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('countries',10,40);" id="countries_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_by_country}</span>
			</td>
		</tr>
	</table>
	</div>	

		
		<div class="stat_content search_results" id="countries" style="display:none">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=countries&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>


	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('keywords',10,40);" id="keywords_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_by_keyword}</span>
			</td>
		</tr>
	</table>
	</div>	
		
		<div class="stat_content search_results" id="keywords" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=keywords&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>


	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('pages',10,40);" id="pages_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_by_pages}</span>
			</td>
		</tr>
	</table>
	</div>	
		
		<div class="stat_content search_results" id="pages" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=pages&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>

		
</block name="empty" no>
</block name="no">
		

		
		</td>
	</tr>
</table>


<div class="formElementsFieldWYSIWYG" id="show_stat_item_main" style="position:absolute;z-index:1000;width:400px;display:none;">

	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('show_stat_item',10,40);" id="show_stat_item_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{elm.title}</span>
			</td>
			<td align="right">
	<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('show_stat_item',10,40);" ><img src="images/minus.gif" border="0" style="vertical-align:middle;" vspace="0" hspace="0" alt="" /></a>&nbsp;
	<a style="cursor:pointer;" onclick="javascript: $('show_stat_item_main').style.display='none';" ><img src="images/close.gif" border="0" style="vertical-align:middle;" vspace="0" hspace="0" alt="" /></a>&nbsp;
			</td>
		</tr>
	</table>
	</div>
	
	
	<div id="show_stat_item" style="padding:3px;margin-top:-10px;">
	</div>
	
</div>

<script type="text/javascript">
popup_show('show_stat_item_main', 'show_stat_item_drag', '', 'screen-right', 10, 100);
</script>