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
				<?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?>
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>
	
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_module&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.module.new_module"]; ?></a></td>
	</tr>
		
	<?php if(!$templateVariables->vars["empty"]){ ?>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	
	<tr class="tblheader">
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.common.edit_title"]; ?></td>
		<td nowrap><?php echo $templateVariables->vars["phrases.settings.module.title"]; ?></td>
		
		<?php if($templateVariables->vars["super_admin"]){ ?>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.multilng"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.admin_catalog"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.catalog"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.mod_page"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.search"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.cache"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.no_delete"]; ?></td>
		<?php } ?>
		
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.no_sort"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.no_filter"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.rss"]; ?></td>
		
		<?php if($templateVariables->vars["super_admin"]){ ?>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.disabled"]; ?></td>
		<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.settings.module.no_rec"]; ?></td>
		<?php } ?>
		
		<td nowrap width="5%" align="center"><?php echo $templateVariables->vars["phrases.common.sort_title"]; ?></td>
		<td nowrap width="5%" align="center"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></td>
	</tr>	
	
	<?php foreach($templateVariables->loops["items"] as $items_key => $items_val){ ?>
	<tr class="tblcontent" id="row<?php echo $items_val["id"]; ?>" onmouseover="javascript: change_row_color(overRowColor,<?php echo $items_val["id"]; ?>);" onmouseout="javascript: change_row_color(outRowColor,<?php echo $items_val["id"]; ?>);">
		
		<td align="center">
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_module&id=<?php echo $items_val["id"]; ?>"><img src="images/edit.gif" border="0"></a>
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["id"]; ?>"><img src="images/inner.gif" border="0"></a>
		</td>
		<td onclick="javascript: window.location='main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=column_list&id=<?php echo $items_val["id"]; ?>';" style="cursor:pointer;"><?php echo $items_val["title"]; ?>(<?php echo $items_val["table_name"]; ?>)</td>
		
		<?php if($templateVariables->vars["super_admin"]){ ?>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=admin_catalog"><img src="images/status_<?php echo $items_val["admin_catalog"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=multilng"><img src="images/status_<?php echo $items_val["multilng"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=tree"><img src="images/status_<?php echo $items_val["tree"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=mod_pages"><img src="images/status_<?php echo $items_val["mod_pages"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=search"><img src="images/status_<?php echo $items_val["search"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=cache"><img src="images/status_<?php echo $items_val["cache"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=forbid_delete"><img src="images/status_<?php echo $items_val["forbid_delete"]; ?>.gif" border="0"></a></td>
		<?php } ?>
		
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=forbid_sort"><img src="images/status_<?php echo $items_val["forbid_sort"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=forbid_filter"><img src="images/status_<?php echo $items_val["forbid_filter"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=rss"><img src="images/status_<?php echo $items_val["rss"]; ?>.gif" border="0"></a></td>
		
		<?php if($templateVariables->vars["super_admin"]){ ?>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=disabled"><img src="images/status_<?php echo $items_val["disabled"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&id=<?php echo $items_val["id"]; ?>&action=no_record_table"><img src="images/status_<?php echo $items_val["no_record_table"]; ?>.gif" border="0"></a></td>
		<?php } ?>
		
		<td align="center" onclick="javascript: change_order(<?php echo $items_val["id"]; ?>, 0, '<?php echo $templateVariables->vars["get.content"]; ?>', '', 'modules');"><img src="images/sort.gif" border="0"></td>
		<td align="center"><a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.settings.module.delete_confirm"]; ?>')){ window.location = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules&action=delete&id=<?php echo $items_val["id"]; ?>'; }"><img src="images/delete.gif" border="0"></a></td>
		
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

<?php if($templateVariables->vars["refresh_tree"]){ ?>
<script language="javascript">
parent.frames.modules.createTree_catalog('<?php echo $templateVariables->vars["lng"]; ?>', 0); //location.reload();
</script>
<?php } ?>