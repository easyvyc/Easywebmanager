<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			<?php include $tpl_menu->cacheFile; ?>
		</td>
	</tr>
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=editor_tpl_edit&tpl_id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.new_template"]; ?></a></td>
	</tr>
		
	<?php if(!$templateVariables->vars["empty"]){ ?>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr class="tblheader">
		<td width="5%"><?php echo $templateVariables->vars["phrases.common.edit_title"]; ?></td>
		<td nowrap><?php echo $templateVariables->vars["phrases.common.title_title"]; ?></td>
		<td nowrap width="5%" align="center"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></td>
	</tr>	
	
	<?php foreach($templateVariables->loops["items"] as $items_key => $items_val){ ?>
	<tr class="tblcontent" id="row<?php echo $items_val["id"]; ?>">
		<td align="center"><a href="main.php?content=settings&page=editor_tpl_edit&id=<?php echo $items_val["id"]; ?>"><img src="images/edit.gif" border="0"></a></td>
		<td onclick="javascript: window.location='main.php?content=settings&page=editor_tpl_edit&id=<?php echo $items_val["id"]; ?>';" style="cursor:pointer;"><?php echo $items_val["title"]; ?></td>
		<td align="center"><a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.common.delete_confirm"]; ?>')){ window.location = 'main.php?content=settings&page=editor_tpl_list&action=delete&id=<?php echo $items_val["id"]; ?>'; }"><img src="images/delete.gif" border="0"></a></td>
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