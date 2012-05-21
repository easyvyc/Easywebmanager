<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

		<?php include $tpl_menu->cacheFile; ?>

		</td>
	</tr>

	<tr>
		<td>

		<ul class="modulesMain" id="secondlist">


		<li class="dragLayer" id="secondlist_secondlist0">
		<div class="block_title" ondblclick="javascript: switchMode('select_form');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('select_form');"><?php echo $templateVariables->vars["phrases.stat.show_stat_by_date"]; ?></a>
		</div>
		
		<div class="stat_content" id="select_form">

<center>
<table border="0" height=40">
	<tr>
		<form name="stat" style="margin:0px;">
		<td valign="middle"><?php echo $templateVariables->vars["phrases.stat.select_date"]; ?>: </td>
		<td valign="middle">nuo:&nbsp;<input type='text' id='stat_date' name='stat_date' value='<?php echo $templateVariables->vars["get.date"]; ?>' class='fo_date' style="width:150px;" readonly style="cursor:pointer;"  ></td>
		<td valign="middle"><input type="button" value="..." class="fo_date" style="width:50px;" onclick="javascript: displayCalendar(document.forms['stat'].stat_date,'yyyy-mm-dd',this);return false;"></td>
		<td valign="middle">iki:&nbsp;<input type='text' id='stat_date_to' name='stat_date_to' value='<?php echo $templateVariables->vars["get.date_to"]; ?>' class='fo_date' style="width:150px;" readonly style="cursor:pointer;"  ></td>
		<td valign="middle"><input type="button" value="..." class="fo_date" style="width:50px;" onclick="javascript: displayCalendar(document.forms['stat'].stat_date_to,'yyyy-mm-dd',this);return false;"></td>
		

<td valign="middle"><input type="button" value="  OK  " class="fo_submit" onclick="javascript: location='main.php?content=stat&page=day&date='+document.getElementById('stat_date').value+'&date_to='+document.getElementById('stat_date_to').value;"></td>
		</form>
	</tr>
</table>
</center>

		</div>
		</li>

<li class="" id="">
<div id="detail_visitors">
<?php include $tpl_detail->cacheFile; ?>
</div>
</li>


<?php if(!$templateVariables->vars["empty"]){ ?>		
		<li class="dragLayer" id="secondlist_secondlist0">
		<div class="block_title" ondblclick="javascript: switchMode('referers');" style="padding:4px;margin:2px;">
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('referers');"><?php echo $templateVariables->vars["phrases.stat.visitors_by_referer"]; ?></a>
		</div>
		
		<div class="stat_content" id="referers">
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=referers&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
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
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('countries');"><?php echo $templateVariables->vars["phrases.stat.visitors_by_country"]; ?></a>
		</div>
		
		<div class="stat_content" id="countries" style="display:block">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=countries&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
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
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('keywords');"><?php echo $templateVariables->vars["phrases.stat.visitors_by_keyword"]; ?></a>
		</div>
		
		<div class="stat_content" id="keywords" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=keywords&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
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
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('pages');"><?php echo $templateVariables->vars["phrases.stat.visitors_by_pages"]; ?></a>
		</div>
		
		<div class="stat_content" id="pages" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=pages&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
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
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('browsers');"><?php echo $templateVariables->vars["phrases.stat.visitors_by_browser"]; ?></a>
		</div>
		
		<div class="stat_content" id="browsers" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=browsers&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
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
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('os');"><?php echo $templateVariables->vars["phrases.stat.visitors_by_os"]; ?></a>
		</div>
		
		<div class="stat_content" id="os" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=os&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
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
		&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('robots');"><?php echo $templateVariables->vars["phrases.stat.visitors_robots"]; ?></a>
		</div>
		
		<div class="stat_content" id="robots" style="display:none;">
		
<center>

<script type="text/javascript">
var ampie_path = '../files/data/ampie/' 
var ampie_settingsFile = escape('<?php echo $templateVariables->vars["config.site_url"]; ?>files/data/ampie/ampie_settings.php?stat=robots&from_date=<?php echo $templateVariables->vars["from_date"]; ?>&to_date=<?php echo $templateVariables->vars["to_date"]; ?>');
var ampie_flashWidth = '100%';
var ampie_flashHeight = '220';
var ampie_backgroundColor = "#FFFFFF";
</script>
<script type="text/javascript" src="../files/data/ampie/ampie.js"></script><br>


</center>
		
		
		</div>
		</li>		
		
<?php } ?>

		
	</ul>

 <script language="javascript">
 
   /*Sortable.create("secondlist",
     {dropOnEmpty:true,handle:'stat_title',containment:["secondlist"],constraint:false,
     onChange:function(){}});*/

 </script>
		
		</td>
	</tr>
</table>
