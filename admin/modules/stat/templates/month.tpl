<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

		{menu}

		</td>
	</tr>

	<tr>
		<td>

		<ul class="modulesMain" id="secondlist">



		<li class="dragLayer" id="secondlist_secondlist0">
		<div class="block_title" ondblclick="javascript: switchMode('select_form');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('select_form');">{phrases.stat.show_stat_by_month}</a>
		</div>
		
		<div class="stat_content" id="select_form">

<center>
<loop name="menu_months">
<div style="float:left;width:100px;border:1px solid #000;margin:1px;">
<a href="main.php?content=stat&page=month&date={menu_months.date}">{menu_months.title}</a>
</div>
</loop name="menu_months">
<div style="clear:left;"></div>
</center>

		</div>
		</li>


		<li class="dragLayer" id="secondlist_secondlist1">
		<div class="block_title" ondblclick="javascript: switchMode('last_visitors');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('last_visitors');">{phrases.stat.month_visitors}</a>
		</div>


<block name="not_empty" no>
<center>
{phrases.stat.no_data}
</center>
</block name="not_empty" no>


<block name="not_empty">		
		<div class="stat_content" id="last_visitors" style="display:block">


<center>
<script type="text/javascript">
var amline_path = '../files/data/amline/'; 
var amline_settingsFile = '{config.site_url}files/data/amline/settings.xml';
var amline_dataFile = escape('{config.site_url}xml.php?get=stat/month_visitors&from_date={from_date}&to_date={to_date}');
var amline_flashWidth = '100%';
var amline_flashHeight = '200';
var amline_backgroundColor = "#FFFFFF";
var amline_preloaderColor = "#000000"
</script>
<script type="text/javascript" src="../files/data/amline/amline.js"></script>
</center>


		</div>
		</li>

		
		<li class="dragLayer" id="secondlist_secondlist0">
		<div class="block_title" ondblclick="javascript: switchMode('referers');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('referers');">{phrases.stat.visitors_by_referer}</a>
		</div>
		
		<div class="stat_content" id="referers">
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
		</li>

		<li class="dragLayer" id="secondlist_secondlist2">
		<div class="block_title" ondblclick="javascript: switchMode('countries');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('countries');">{phrases.stat.visitors_by_country}</a>
		</div>
		
		<div class="stat_content" id="countries" style="display:block">
		
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
		</li>

		<li class="dragLayer" id="secondlist_secondlist2">
		<div class="block_title" ondblclick="javascript: switchMode('keywords');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('keywords');">{phrases.stat.visitors_by_keyword}</a>
		</div>
		
		<div class="stat_content" id="keywords" style="display:none;">
		
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
		</li>

		<li class="dragLayer" id="secondlist_secondlist2">
		<div class="block_title" ondblclick="javascript: switchMode('pages');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('pages');">{phrases.stat.visitors_by_pages}</a>
		</div>
		
		<div class="stat_content" id="pages" style="display:none;">
		
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
		</li>



		<li class="dragLayer" id="secondlist_secondlist2">
		<div class="block_title" ondblclick="javascript: switchMode('browsers');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('browsers');">{phrases.stat.visitors_by_browser}</a>
		</div>
		
		<div class="stat_content" id="browsers" style="display:none;">
		
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
		</li>



		<li class="dragLayer" id="secondlist_secondlist2">
		<div class="block_title" ondblclick="javascript: switchMode('os');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('os');">{phrases.stat.visitors_by_os}</a>
		</div>
		
		<div class="stat_content" id="os" style="display:none;">
		
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
		</li>


		<li class="dragLayer" id="secondlist_secondlist2">
		<div class="block_title" ondblclick="javascript: switchMode('robots');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('robots');">{phrases.stat.visitors_robots}</a>
		</div>
		
		<div class="stat_content" id="robots" style="display:none;">
		
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

		
	</ul>

 <script language="javascript">
 
   Sortable.create("secondlist",
     {dropOnEmpty:true,handle:'stat_title',containment:["secondlist"],constraint:false,
     onChange:function(){}});

 </script>
		
		</td>
	</tr>

</table>