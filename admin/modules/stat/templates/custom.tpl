

<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

		{menu}

		</td>
	</tr>
	<tr>
		<td>


	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('last_visitors',10,40);" id="last_visitors_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.custom_visitors}</span>
			</td>
		</tr>
	</table>
	</div>



<block name="not_empty" no>
<center>
{phrases.stat.no_data}
</center>
</block name="not_empty" no>



<block name="not_empty">		
		<div class="stat_content search_results" id="last_visitors" style="display:block">
		
<script type="text/javascript">
document.write('<object id="flv_container_pages" height="350" width="100%" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">');
document.write('<param value="{config.site_url}files/data/amstock/amstock.swf" name="movie" />');
document.write('<param value="transparent" name="wmode" />');
document.write('<param value="true" name="allowfullscreen" />');
document.write('<param value="always" name="allowscriptaccess" />');
document.write('<param value="settings_file='+encodeURIComponent("{config.site_url}xml.php?get=stat/amstock_settings&datafile=stat/all_stat&stats[]=unique&stats[]=referer")+'" name="flashvars" />');
document.write('<object height="350" width="100%" data="{config.site_url}files/data/amstock/amstock.swf" type="application/x-shockwave-flash">');
document.write('<param value="transparent" name="wmode" />');
document.write('<param value="true" name="allowfullscreen" />');
document.write('<param value="always" name="allowscriptaccess" />');
document.write('<param value="settings_file='+encodeURIComponent("{config.site_url}xml.php?get=stat/amstock_settings&datafile=stat/all_stat&stats[]=unique&stats[]=referer")+'" name="flashvars" />');
document.write('</object>');
document.write('</object>');
</script>
		
		</div>






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
		
		<div class="stat_content search_results" id="referers" style="display:none;">
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
		
		<div class="stat_content search_results" id="countries" style="display:none;">
		
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


	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('browsers',10,40);" id="browsers_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_by_browser}</span>
			</td>
		</tr>
	</table>
	</div>	
		
		<div class="stat_content search_results" id="browsers" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=browsers&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>


	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('os',10,40);" id="os_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_by_os}</span>
			</td>
		</tr>
	</table>
	</div>	
		
		<div class="stat_content search_results" id="os" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=os&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>
		
		
	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('robots',10,40);" id="robots_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.stat.visitors_robots}</span>
			</td>
		</tr>
	</table>
	</div>	
		
		<div class="stat_content search_results" id="robots" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('{config.site_url}files/data/ampie/ampie_settings.php?stat=robots&from_date={from_date}&to_date={to_date}');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>
		</li>		
		
		
		
</block name="not_empty">

		
		
		</td>
	</tr>

</table>