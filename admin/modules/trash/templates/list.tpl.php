<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

<?php include $tpl_menu->cacheFile; ?>

		</td>
	</tr>	
	<tr>
		<td>
		
		
<div style="width:100%;">
		
	<div class="modulesMain" id="secondlist" style="width:100%;">



<ul style="width:100%;padding:0px;margin:0px;">	
<li class="dragLayer" id="secondlist_secondlist1" style="width:100%;">
<div id="elements_list" style="<?php if(!$templateVariables->vars["not_empty_elements"]){ ?>display:none;<?php } ?>">
	
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px;">
	
	<tr>
		
		<td>

		</td>
		<td align="right" nowrap>
	
	<form method="post" style="display:inline;">
	<input type="hidden" name="action" value="paging">
	<?php echo $templateVariables->vars["phrases.common.display_paging"]; ?>: 
	<select name="paging_items" onchange="javascript: this.form.submit();" class="fo_select">
		<option value=""> ----- </option> 
		
		<?php foreach($templateVariables->loops["items_in_one_page"] as $items_in_one_page_key => $items_in_one_page_val){ ?>
		<option value="<?php echo $items_in_one_page_val["value"]; ?>" <?php if($items_in_one_page_val["active"]){ ?>selected<?php } ?>> - <?php echo $items_in_one_page_val["value"]; ?> - </option> 
		<?php } ?>
		
	</select>
	</form>	
		
		</td>
	</tr>
</table>

<?php if($templateVariables->vars["not_empty_elements"]){ ?>
<table border="0" cellpadding="2" cellspacing="2" width="100%" style="border-collapse:collapse;">




<tr class="tblheader">

	<td width="5"><?php echo $templateVariables->vars["phrases.common.view_title"]; ?></td>
	
	<td nowrap>ID</td>
	<td nowrap><?php echo $templateVariables->vars["phrases.trash.title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.trash.is_category"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.trash.module"]; ?></td>
	
	<td nowrap width="5%"><a href="javascript: selectAllItems('chk', 1);"><?php echo $templateVariables->vars["phrases.common.select_title"]; ?></a></td>
	<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.trash.reset_title"]; ?></td>
	<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></td>

</tr>




<?php if(!$templateVariables->vars["module.forbid_filter"]){ ?>
<?php echo $templateVariables->vars["elements_filter_form"]; ?>
<?php } ?>

<?php if($templateVariables->vars["not_empty_filters_elements"]){ ?>
<form method="post" name="list">

	<script language="javascript">
	var list_modules = new Array;
	
	<?php foreach($templateVariables->loops["modules"] as $modules_key => $modules_val){ ?>
	list_modules[list_modules.length] = {id:"<?php echo $modules_val["id"]; ?>", title:"<?php echo $modules_val["title"]; ?>"};
	<?php } ?>
	
	</script>	

<?php foreach($templateVariables->loops["items"] as $items_key => $items_val){ ?>
<tr class="tblcontent" id="row<?php echo $items_val["id"]; ?>" onmouseover="javascript: change_row_color(overRowColor,<?php echo $items_val["id"]; ?>);" onmouseout="javascript: change_row_color(outRowColor,<?php echo $items_val["id"]; ?>);">
	
	<td align="center"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=item&id=<?php echo $items_val["id"]; ?>&ce=<?php echo $items_val["is_category"]; ?>"><img src="images/preview.gif" border="0"></a></td>
	
	<td nowrap><?php echo $items_val["id"]; ?></td>
	<td nowrap><?php echo $items_val["title"]; ?></td>
	<td nowrap><img src="images/<?php if($items_val["is_category"]){ ?>new_category.gif<?php } ?><?php if(!$items_val["is_category"]){ ?>new_element.gif<?php } ?>"></td>
	<td nowrap><?php echo $items_val["module_title"]; ?></td>	
	
	<td align="center">
		<input type="checkbox" name="chk[<?php echo $items_val["_INDEX"]; ?>]" id="chk_<?php echo $items_val["_INDEX"]; ?>" value="<?php echo $items_val["id"]; ?>" style="height:12px;">
	</td>

	<td align="center"><a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.trash.reset_confirm"]; ?>')){ window.location = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=list&action=reset&resetid=<?php echo $items_val["id"]; ?><?php if($templateVariables->vars["get.offset"]){ ?>&offset=<?php echo $templateVariables->vars["get.offset"]; ?><?php } ?>'; }"><img src="images/reset.gif" border="0"></a></td>	
	<td align="center"><a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.common.delete_confirm"]; ?>')){ window.location = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=list&action=delete&deleteid=<?php echo $items_val["id"]; ?><?php if($templateVariables->vars["get.offset"]){ ?>&offset=<?php echo $templateVariables->vars["get.offset"]; ?><?php } ?>'; }"><img src="images/delete.gif" border="0"></a></td>
	
</tr>
<?php } ?>


<tr class="tblheader">

	<td width="5"><?php echo $templateVariables->vars["phrases.common.view_title"]; ?></td>
	
	<td nowrap>ID</td>
	<td nowrap><?php echo $templateVariables->vars["phrases.trash.title"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.trash.is_category"]; ?></td>
	<td nowrap><?php echo $templateVariables->vars["phrases.trash.module"]; ?></td>
	
	<td nowrap width="5%"><a href="javascript: selectAllItems('chk', 1);"><?php echo $templateVariables->vars["phrases.common.select_title"]; ?></a></td>
	<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.trash.reset_title"]; ?></td>
	<td nowrap width="5%"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></td>

</tr>


<tr>
	
	<td colspan="5">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>
				<div class="paging">
				
				<?php if($templateVariables->vars["paging.paging_start_arrow"]){ ?>
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["filter_page"]; ?>list&id=<?php echo $templateVariables->vars["parent_id"]; ?>&ce=1&offset=<?php echo $templateVariables->vars["paging.paging_start_arrow_value"]; ?>" class="paging_0">«</a> 
				<?php } ?>
					
				<?php foreach($templateVariables->loops["paging"] as $paging_key => $paging_val){ ?>
					<?php if(!$paging_val["active"]){ ?>
					<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["filter_page"]; ?>list&id=<?php echo $templateVariables->vars["parent_id"]; ?>&ce=1&offset=<?php echo $paging_val["value"]; ?>" class="paging_0"><?php echo $paging_val["title"]; ?></a> 
					<?php } ?>
					<?php if($paging_val["active"]){ ?>
					<span class="paging_1"><?php echo $paging_val["title"]; ?></span> 
					<?php } ?>
				<?php } ?>

				<?php if($templateVariables->vars["paging.paging_end_arrow"]){ ?>
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["filter_page"]; ?>list&id=<?php echo $templateVariables->vars["parent_id"]; ?>&ce=1&offset=<?php echo $templateVariables->vars["paging.paging_end_arrow_value"]; ?>" class="paging_0">»</a> 
				<?php } ?>

				</div>
			</td>	
			<td align="right">
				<?php echo $templateVariables->vars["phrases.common.action_with_selected_items"]; ?>: 
				<input type="hidden" name="action_elements" value="1">
				<input type="hidden" name="action" value="action_with_selected_items">
			</td>
		</tr>
	</table>
	</td>
	<td>
		<select name="action_choice" onchange="javascript: submitCatalogItemsForm(this); " class="fo_select">
			<option value="">-----</option>
			<option value="reset"><?php echo $templateVariables->vars["phrases.trash.reset_title"]; ?></option>
			<option value="delete"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></option>
		</select>
	</td>	
	
</tr>	
</form>
<?php } ?>

<?php if(!$templateVariables->vars["not_empty_filters_elements"]){ ?>
<tr>
	<td><?php echo $templateVariables->vars["phrases.common.empty_items"]; ?></td>
</tr>
<?php } ?>

</table>
<?php } ?>

</div>
</li>
</ul>



	</div>
	
</div>

		</td>
	</tr>
</table>