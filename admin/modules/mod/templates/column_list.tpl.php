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
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=modules" class="path"><?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?></a> → <?php echo $templateVariables->vars["module_data.title"]; ?> 
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>

	<tr>
		<td height="30" valign="middle"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_column&id=<?php echo $templateVariables->vars["module_id"]; ?>&column_id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.module.new_column"]; ?></a></td>
	</tr>
		
	<?php if(!$templateVariables->vars["empty"]){ ?>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr class="tblheader">
		<td width="5%"><?php echo $templateVariables->vars["phrases.common.edit_title"]; ?></td>
		<td nowrap><?php echo $templateVariables->vars["phrases.settings.module.column_title"]; ?></td>
		<!--td nowrap>Stulpelio vardas</td-->
		<!--td nowrap>Laukelio tipas</td-->
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.require"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.list"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.multilng"]; ?></td>
		
		<?php if($templateVariables->vars["super_admin"]){ ?>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.editable"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.superadmin"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.index"]; ?></td>
		<?php } ?>
		
		<td nowrap width="5%" align="center"><?php echo $templateVariables->vars["phrases.common.sort_title"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></td>
	</tr>	
	
	<?php foreach($templateVariables->loops["items"] as $items_key => $items_val){ ?>
	<tr class="tblcontent" id="row<?php echo $items_val["id"]; ?>" onmouseover="javascript: change_row_color(overRowColor,<?php echo $items_val["id"]; ?>);" onmouseout="javascript: change_row_color(outRowColor,<?php echo $items_val["id"]; ?>);">
		
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_column&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>"><img src="images/edit.gif" border="0"></a></td>
		<td onclick="javascript: window.location='main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_column&column_id=<?php echo $items_val["id"]; ?>&id=<?php echo $items_val["module_id"]; ?>';" style="cursor:pointer;"><?php echo $items_val["title"]; ?>(<?php echo $items_val["column_name"]; ?>)</td>
		<!--td onclick="javascript: window.location='main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&id=<?php echo $items_val["module_id"]; ?>&page=edit_column&column_id=<?php echo $items_val["id"]; ?>';" style="cursor:pointer;"><?php echo $items_val["column_name"]; ?></td-->
		<!--td onclick="javascript: window.location='main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&id=<?php echo $items_val["module_id"]; ?>&page=edit_column&column_id=<?php echo $items_val["id"]; ?>';" style="cursor:pointer;"><?php echo $items_val["elm_type"]; ?></td-->
		
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>&action=require"><img src="images/status_<?php echo $items_val["require"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>&action=list"><img src="images/status_<?php echo $items_val["list"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>&action=multilng"><img src="images/status_<?php echo $items_val["multilng"]; ?>.gif" border="0"></a></td>
		
		<?php if($templateVariables->vars["super_admin"]){ ?>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>&action=editorship"><img src="images/status_<?php echo $items_val["editorship"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>&action=super_user"><img src="images/status_<?php echo $items_val["super_user"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["module_id"]; ?>&column_id=<?php echo $items_val["id"]; ?>&action=index"><img src="images/status_<?php echo $items_val["index"]; ?>.gif" border="0"></a></td>
		<?php } ?>
		
		<td align="center" onclick="javascript: change_order(<?php echo $items_val["id"]; ?>, <?php echo $items_val["module_id"]; ?>, '<?php echo $templateVariables->vars["get.content"]; ?>', '', 'column_list');"><img src="images/sort.gif" border="0"></td>
		<td align="center"><a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.settings.module.delete_column_confirm"]; ?>')){ window.location = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&action=delete&column_id=<?php echo $items_val["id"]; ?>&id=<?php echo $items_val["module_id"]; ?>'; }"><img src="images/delete.gif" border="0"></a></td>
		
	</tr>
	<?php } ?>	
	
	
	</table>
		</td>
	</tr>
	<?php } ?>

	<?php if($templateVariables->vars["empty"]){ ?>
	<tr>
		<td height="30" valign="middle"><?php echo $templateVariables->vars["phrases.common.empty_items"]; ?></td>
	</tr>	
	<?php } ?>
</table>