<div class="block_title" ondblclick="javascript: switchMode('last_visitors');" style="padding:4px;margin:2px;">
&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('last_visitors');"><?php echo $templateVariables->vars["phrases.stat.day_visitors"]; ?> (<?php echo $templateVariables->vars["day_stat_count"]; ?>)</a>
</div>
		
<div class="stat_content" id="last_visitors" style="display:block">



<?php if(!$templateVariables->vars["empty"]){ ?>


<div class="paging" id="paging" style="overflow:auto;">
<?php foreach($templateVariables->loops["paging"] as $paging_key => $paging_val){ ?>
	<a onclick="javascript: if(this.className!='paging_1'){ ajaxContentReload(event, '<?php echo $templateVariables->vars["config.admin_site_url"]; ?>ajax.php?date=<?php echo $templateVariables->vars["get.date"]; ?>&date_to=<?php echo $templateVariables->vars["get.date_to"]; ?>&ipaddress=<?php echo $templateVariables->vars["filters_data.ipaddress"]; ?>&referer_domain=<?php echo $templateVariables->vars["filters_data.referer_domain"]; ?>&offset=<?php echo $paging_val["number"]; ?>', 'detail_visitors'); } " class="paging_<?php echo $paging_val["active"]; ?>"><?php echo $paging_val["_INDEX"]; ?></a>
<?php } ?>
</div>



<form name="detail_stat" method="post" style="margin:0px;" action="javascript: ajaxContentReload(event, '<?php echo $templateVariables->vars["config.admin_site_url"]; ?>ajax.php?date=<?php echo $templateVariables->vars["get.date"]; ?>&date_to=<?php echo $templateVariables->vars["get.date_to"]; ?>&ipaddress='+document.getElementById('ipaddress').value+'&referer_domain='+document.getElementById('referer_domain').value, 'detail_visitors');">
<table border="0" cellpadding="2" cellspacing="2" width="100%" style="border-collapse:collapse;">

<tr class="tblheader">
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.ip_address_title"]; ?></td>
	
	<?php if($templateVariables->vars["no"]){ ?>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.browser_title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.os_title"]; ?></td>
	<?php } ?>

	<td nowrap><?php echo $templateVariables->vars["phrases.stat.referer_title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.country_title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.enter_time_title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.past_time_title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.pages_count_title"]; ?></td>
</tr>

<tr class="tblheader">
	<td nowrap><input type="hidden" name="ipaddress" id="ipaddress" value="<?php echo $templateVariables->vars["filters_data.ipaddress"]; ?>" class="fo_text" style="width:99%;"></td>
	
	<?php if($templateVariables->vars["no"]){ ?>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.browser_title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.stat.os_title"]; ?></td>
	<?php } ?>

	<td nowrap><input type="text" name="referer_domain" id="referer_domain" value="<?php echo $templateVariables->vars["filters_data.referer_domain"]; ?>" class="fo_text" style="width:99%;"></td>
	<td nowrap><input type="submit" name="country" value="  ok  " class="fo_submit" style="width:99%;"></td>
	<td nowrap>&nbsp;</td>
	<td nowrap>&nbsp;</td>
	<td nowrap>&nbsp;</td>
</tr>

<?php foreach($templateVariables->loops["items"] as $items_key => $items_val){ ?>
<tr title="<?php echo $items_val["user_agent"]; ?>" class="tblcontent" id="row<?php echo $items_val["_INDEX"]; ?>" onmouseover="javascript: change_row_color(overRowColor,<?php echo $items_val["_INDEX"]; ?>);" onmouseout="javascript: change_row_color(outRowColor,<?php echo $items_val["_INDEX"]; ?>);">
	
	<td><?php echo $items_val["ipaddress"]; ?></td>

	<?php if($templateVariables->vars["no"]){ ?>
	<td><?php echo $items_val["browser"]; ?> <?php echo $items_val["browser_version"]; ?></td>
	<td><?php echo $items_val["os"]; ?></td>
	<?php } ?>

	<td><a href="<?php echo $items_val["referer"]; ?>" target="_blank" title="<?php echo $items_val["referer"]; ?>"><?php echo $items_val["referer_domain"]; ?></a></td>
	<td><img src="images/countries/<?php echo $items_val["country"]; ?>.gif" border="0" alt="<?php echo $items_val["country"]; ?>"></td>
	<td><?php echo $items_val["visit_time"]; ?></td>
	<td><?php echo $items_val["past_time"]; ?></td>
	<td align="center"><?php echo $items_val["page_count"]; ?> <img src="images/path.gif" border="0" align="absmiddle" style="cursor:pointer;" onclick="javascript: openCenteredWindow('<?php echo $templateVariables->vars["config.admin_site_url"]; ?>main.php?content=stat&module=stat&page=path&id=<?php echo $items_val["id"]; ?>', 'path', 400,400,0,0);"></td>
	
</tr>
<?php } ?>
</table>
</form>




<?php } ?>

<?php if($templateVariables->vars["empty"]){ ?>
<center>
<?php echo $templateVariables->vars["phrases.stat.no_data"]; ?>
</center>
<?php } ?>



</div>
