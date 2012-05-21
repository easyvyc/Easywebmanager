
<style>
<?php if(!$templateVariables->vars["data.no_standart_tpl"]){ ?>
#area_id_field_html {
	display:none;
}
<?php } ?>
<?php if(!$templateVariables->vars["data.list_values"]){ ?>
#area_id_list_values {
	display:none;
}
<?php } ?>
<?php if(!$templateVariables->vars["data.extra_params"]){ ?>
#area_id_extra_params {
	display:none;
}
<?php } ?>
</style>

<script type="text/javascript">
function setColumnFields(obj){
	if(obj.options[obj.selectedIndex].value=='image'){
		document.getElementById('area_id_extra_params').style.display='block';
	}else{
		document.getElementById('area_id_extra_params').style.display='none';
	}
	if(obj.options[obj.selectedIndex].value=='select' || obj.options[obj.selectedIndex].value=='radio' || obj.options[obj.selectedIndex].value=='checkbox_group'){
		document.getElementById('area_id_list_values').style.display='block';
	}else{
		document.getElementById('area_id_list_values').style.display='none';
	}
}
</script>

<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			<?php include $tpl_menu->cacheFile; ?>
		</td>
	</tr>

	<tr>
		<td>	
<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=modules" class="path"><?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?></a> → <a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=column_list&module_id=<?php echo $templateVariables->vars["module_data.id"]; ?>" class="path"><?php echo $templateVariables->vars["module_data.title"]; ?></a> → <?php if(!$templateVariables->vars["data.isNew"]){ ?><?php echo $templateVariables->vars["data.title"]; ?><?php } ?><?php if($templateVariables->vars["data.isNew"]){ ?><?php echo $templateVariables->vars["phrases.settings.module.new_column"]; ?><?php } ?>
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>
	
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=edit_column&module_id=<?php echo $templateVariables->vars["module_id"]; ?>&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.module.new_column"]; ?></a></td>
	</tr>
		
	<tr>
		<td colspan="3">
					
	
				<?php echo $templateVariables->vars["form"]; ?>

			
		</td>
	</tr>
</table>