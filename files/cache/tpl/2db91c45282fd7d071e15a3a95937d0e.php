
<div id="debug_info___<?php echo TPL::getVar("grid_data.grid_name"); ?>"></div>


<table class="paging" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="left">
		
			<span class="all_items_count"><?php echo TPL::getVar("phrases.main.catalog.import_data_items_count"); ?>: <b><?php echo TPL::getVar("filter_elements_count"); ?></b></span>


			<?php if(!TPL::getVar("grid_data.no_paging")){ ?>
			<?php if(TPL::getVar("items_in_one_page")){ ?>
			
			<form method="post" style="display:inline;" name="paging___<?php echo TPL::getVar("grid_data.grid_name"); ?>" id="paging___<?php echo TPL::getVar("grid_data.grid_name"); ?>">
			<input type="hidden" name="action" value="paging" />
			<?php echo TPL::getVar("phrases.main.common.display_paging"); ?>: 
			<select name="paging_items" onchange="javascript: $NAV.post('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>', $('#paging___<?php echo TPL::getVar("grid_data.grid_name"); ?>'));" class="fo_select">
				
				<?php $items_in_one_page_iterator=1; foreach(TPL::getLoop("items_in_one_page") as $items_in_one_page_key => $items_in_one_page_val){ $items_in_one_page_val['_FIRST']=0; if($items_in_one_page_iterator==1) $items_in_one_page_val['_FIRST']=1; if($items_in_one_page_iterator%2==1) $items_in_one_page_val['_EVEN']=0; else $items_in_one_page_val['_EVEN']=1; $items_in_one_page_val['_INDEX']=$items_in_one_page_iterator++; ?>
				<option value="<?php if(isset($items_in_one_page_val["value"])) echo $items_in_one_page_val["value"]; ?>" <?php if(isset($items_in_one_page_val["active"]) && $items_in_one_page_val["active"]){ ?>selected<?php } ?>> - <?php if(isset($items_in_one_page_val["value"])) echo $items_in_one_page_val["value"]; ?> - </option> 
				<?php } ?>
				
			</select>
			</form>	

		</td>
		<td align="right">
			
			<?php if(TPL::getVar("paging.paging_start_arrow")){ ?>
			<a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&offset=<?php echo TPL::getVar("paging.paging_start_arrow_value"); ?>'));" class="paging_0">«</a> 
			<?php } ?>
				
			<?php $paging_loop_iterator=1; foreach(TPL::getLoop("paging_loop") as $paging_loop_key => $paging_loop_val){ $paging_loop_val['_FIRST']=0; if($paging_loop_iterator==1) $paging_loop_val['_FIRST']=1; if($paging_loop_iterator%2==1) $paging_loop_val['_EVEN']=0; else $paging_loop_val['_EVEN']=1; $paging_loop_val['_INDEX']=$paging_loop_iterator++; ?>
				<?php if(!isset($paging_loop_val["active"]) || !$paging_loop_val["active"]){ ?>
				<a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&offset=<?php if(isset($paging_loop_val["value"])) echo $paging_loop_val["value"]; ?>'));" class="paging_0"><?php if(isset($paging_loop_val["title"])) echo $paging_loop_val["title"]; ?></a> 
				<?php } ?>
				<?php if(isset($paging_loop_val["active"]) && $paging_loop_val["active"]){ ?>
				<a class="a"><?php if(isset($paging_loop_val["title"])) echo $paging_loop_val["title"]; ?></a> 
				<?php } ?>
			<?php } ?>

			<?php if(TPL::getVar("paging.paging_end_arrow")){ ?>
			<a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&offset=<?php echo TPL::getVar("paging.paging_end_arrow_value"); ?>'));" class="paging_0">»</a> 
			<?php } ?>
			
			<?php } ?>
			<?php } ?>

		</td>	
	</tr>
</table>

<form style="margin:0px;" action="javascript: void($NAV.post('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>', $('#filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>')));" id="filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>" name="filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>">
<table id="grid_area___<?php echo TPL::getVar("grid_data.grid_name"); ?>" class="grid_area" border="0" cellspacing="1" cellpadding="0">

<script type="text/javascript">
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?> = new gridClass('<?php echo TPL::getVar("grid_data.grid_name"); ?>');
</script>

	<thead>
	<tr class="header">
	
	<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
		<td rel="<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="header_<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div class="col_">
			
			<?php if(!isset($fields_val["no_sort"]) || !$fields_val["no_sort"]){ ?>
			<div class="sorter show">
			<div><a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&by=<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>&order=DESC'));"><img src="admin/images/sort_up<?php if(isset($fields_val["sort_down"]) && $fields_val["sort_down"]){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!isset($fields_val["sort_down"]) || !$fields_val["sort_down"]){ ?>onmouseover="javascript: this.src='admin/images/sort_up_a.gif';" onmouseout="javascript: this.src='admin/images/sort_up.gif';"<?php } ?> /></a></div>
			<div><a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&by=<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>&order=ASC'));"><img src="admin/images/sort_down<?php if(isset($fields_val["sort_up"]) && $fields_val["sort_up"]){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!isset($fields_val["sort_up"]) || !$fields_val["sort_up"]){ ?>onmouseover="javascript: this.src='admin/images/sort_down_a.gif';" onmouseout="javascript: this.src='admin/images/sort_down.gif';"<?php } ?> /></a></div>
			</div>
			<?php } ?>
			
			<label title="<?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?>"><?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?></label>

			<div class="clear"></div>
			
			</div>
		</td>
	
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>', <?php if(isset($fields_val["w"])) echo $fields_val["w"]; ?>, '<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?>');


		<?php if(isset($fields_val["elm_choice"]) && $fields_val["elm_choice"]){ ?>
		
		<?php $fields_choice_arr_iterator=1; if(isset($fields_val["choice_arr"])){ foreach($fields_val["choice_arr"] as $fields_choice_arr_key => $fields_choice_arr_val){ $fields_choice_arr_val['_FIRST']=0; if($fields_choice_arr_iterator==1) $fields_choice_arr_val['_FIRST']=1; if($fields_choice_arr_iterator%2==1) $fields_choice_arr_val['_EVEN']=0; else $fields_choice_arr_val['_EVEN']=1; $fields_choice_arr_val['_INDEX']=$fields_choice_arr_iterator++; ?>
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php if(isset($fields_val["I"])) echo $fields_val["I"]; ?>].optionArray[gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php if(isset($fields_val["I"])) echo $fields_val["I"]; ?>].optionArray.length] = {id:"<?php if(isset($fields_choice_arr_val["id"])) echo $fields_choice_arr_val["id"]; ?>", title:"<?php if(isset($fields_choice_arr_val["title"])) echo $fields_choice_arr_val["title"]; ?>"};
		<?php }} ?>
		
		<?php } ?>
		
		</script>		


	<?php } ?>

		<?php if(TPL::getVar("grid_data.edit_button")){ ?>
		<td rel="editbutton" id="header_editbutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('editbutton', 1);
		</script>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.dublicate_button")){ ?>
		<td rel="dublicatebutton" id="header_dublicatebutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('dublicatebutton', 1);
		</script>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.delete_button")){ ?>
		<td rel="deletebutton" id="header_deletebutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('deletebutton', 1);
		</script>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td rel="selectbutton" id="header_selectbutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">
		<input type="checkbox" onclick="javascript: selectAllItems(0, this.checked);" style="vertical-align:top;" />
		</td>
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('selectbutton', 1);
		</script>
		<?php } ?>


		<!--div class="clear"></div-->
	</tr>
	

	<?php if(TPL::getVar("grid_data.filter_form")){ ?>
	<input type="hidden" name="action" value="filter" />
	<tr class="header">

	<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
		<td rel="<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filter_<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div id="filter___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" class="list_item_filter">

				<?php if(isset($fields_val["elm_text"]) && $fields_val["elm_text"]){ ?>
				<input type="text" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" value="<?php if(isset($fields_val["filter_value"])) echo $fields_val["filter_value"]; ?>" class="vam" />
				<?php } ?>

				<?php if(isset($fields_val["elm_custom"]) && $fields_val["elm_custom"]){ ?>
				&nbsp;
				<?php } ?>

				<?php if(isset($fields_val["elm_image"]) && $fields_val["elm_image"]){ ?>
				&nbsp;
				<?php } ?>

				<?php if(isset($fields_val["elm_file"]) && $fields_val["elm_file"]){ ?>
				&nbsp;
				<?php } ?>

				<?php if(isset($fields_val["elm_choice"]) && $fields_val["elm_choice"]){ ?>
				<input type="text" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" value="<?php if(isset($fields_val["filter_value"])) echo $fields_val["filter_value"]; ?>" class="vam" />
				<?php } ?>

				<?php if(isset($fields_val["elm_autocomplete"]) && $fields_val["elm_autocomplete"]){ ?>
				<input type="text" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" value="<?php if(isset($fields_val["filter_value"])) echo $fields_val["filter_value"]; ?>" class="vam" />
				<?php } ?>

				<?php if(isset($fields_val["elm_button"]) && $fields_val["elm_button"]){ ?>
				<select name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" class="vam" onchange="javascript: this.form.submit();">
					<option value="">-</option>
					<option value="1" <?php if(isset($fields_val["value_1"]) && $fields_val["value_1"]){ ?>selected<?php } ?>><?php echo TPL::getVar("phrases.main.common.yes"); ?></option>
					<option value="0" <?php if(isset($fields_val["value_0"]) && $fields_val["value_0"]){ ?>selected<?php } ?>><?php echo TPL::getVar("phrases.main.common.no"); ?></option>
				</select>
				<?php } ?>

				<?php if(isset($fields_val["elm_date"]) && $fields_val["elm_date"]){ ?>
				<?php if(isset($fields_val["filter_value"]) && $fields_val["filter_value"]){ ?>
				<input type="image" style="width:auto;height:auto;" src="images/back.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value='<?php if(isset($fields_val["filter_value_back_from"])) echo $fields_val["filter_value_back_from"]; ?>'; if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value='<?php if(isset($fields_val["filter_value_back_to"])) echo $fields_val["filter_value_back_to"]; ?>'; document.forms['filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>'].submit();" />
				<?php } ?>
				<input type="text" dir="rtl" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>[from]" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from" class="date vam" value="<?php if(isset($fields_val["filter_value_from"])) echo $fields_val["filter_value_from"]; ?>" onchange="javascript: this.form.submit();" /><input type="text" dir="rtl" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>[to]" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to" class="date vam" value="<?php if(isset($fields_val["filter_value_to"])) echo $fields_val["filter_value_to"]; ?>" onchange="javascript: this.form.submit();" />

				<script type="text/javascript">
					$(function() {
					$('#filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').datepicker({ firstDay:1, altFormat:'yy-mm-dd', changeMonth:true, changeYear:true, dateFormat:'yy-mm-dd' });
					});
				</script>
				<script type="text/javascript">
					$(function() {
					$('#filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').datepicker({ firstDay:1, altFormat:'yy-mm-dd', changeMonth:true, changeYear:true, dateFormat:'yy-mm-dd' });
					});
				</script>
				
				<?php if(isset($fields_val["filter_value"]) && $fields_val["filter_value"]){ ?>
				<input type="image" style="width:auto;height:auto;" src="images/forward.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value='<?php if(isset($fields_val["filter_value_fwd_from"])) echo $fields_val["filter_value_fwd_from"]; ?>'; if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value='<?php if(isset($fields_val["filter_value_fwd_to"])) echo $fields_val["filter_value_fwd_to"]; ?>'; document.forms['filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>'].submit();" />
				<?php } ?>
				<!--input type="hidden" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" value="<?php if(isset($fields_val["filter_value"])) echo $fields_val["filter_value"]; ?>" class="vam" /-->
				<?php } ?>

			</div>
			
		</td>
		
		
	<?php } ?>

		<?php if(TPL::getVar("grid_data.edit_button")){ ?>
		<td rel="editbutton" id="filter_editbutton" class="column w10 center">&nbsp;</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.dublicate_button")){ ?>
		<td rel="dublicatebutton" id="filter_dublicatebutton" class="column w10 center">&nbsp;</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.delete_button")){ ?>
		<td rel="deletebutton" id="filter_deletebutton" class="column w10 center">&nbsp;</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td rel="selectbutton" id="filter_selectbutton" class="column w10 center" >&nbsp;</td>
		<?php } ?>

		<input type="submit" style="position:absolute;width:0px;height:0px;top:-20px;left:-50px;" />

	</tr>

	<?php } ?>
	</thead>

	<tbody>
	
	<?php if(TPL::getVar("filter_elements_count")){ ?>
	<?php $items = TPL::getVar("items"); foreach($items as $k_items=>$v_items){ 
			$i=0; ?>
	<tr class="item" id="item_row_<?php echo $v_items['id']; ?>">
		
		<div id="contextmenu_<?php echo $v_items['id']; ?>" class="contextMenu">
			<div class="title"><?php echo $v_items['title_short']; ?></div>
			<div class="text">
				<?php foreach($v_items['context'] as $context_k=>$context_v){ ?>
				<div><a <?php if($context_v['action']){ ?>href="<?php echo $context_v['action']; ?>"<?php } ?>><img src="images/<?php echo $context_v['img']; ?>.gif" alt="" class="vam" border="0" /> <?php echo $context_v['title']; ?></a></div>
				<?php } ?>
			</div>
		</div>
		
		<?php $fields_list = TPL::getVar("fields"); foreach($fields_list as $k_fields=>$v_fields){ ?>
		
		<td title="<?php echo (isset($v_items[$v_fields['column_name'].'_ALT'])?$v_items[$v_fields['column_name'].'_ALT']:htmlspecialchars($v_items[$v_fields['column_name']])); ?>" class="column" rel="<?php echo $v_fields['column_name']; ?>" id="item___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>ondblclick="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cellEditItem_<?php echo $v_fields['elm_type']; ?>(this, event);"<?php } ?> >
			
			<?php if($v_fields['elm_text']==1 || $v_fields['elm_textarea']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<textarea id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam" ><?php echo $v_items[$v_fields['column_name']]; ?></textarea>
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));"><?php echo TPL::getVar("phrases.main.common.close"); ?></a>
					<a href="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val()));"><?php echo TPL::getVar("phrases.main.common.save"); ?></a>
				</div>
			</div>
			<?php } ?>
			<?php } ?>
			
			<?php if($v_fields['elm_autocomplete']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<textarea id="autocomplete___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam fo_autocomplete" ><?php echo $v_items[$v_fields['column_name']]; ?></textarea>
				<input type="hidden" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="" />
				<script type="text/javascript">
				
					$("#autocomplete___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>").autocomplete({
						source: "ajax.php?content=autocomplete&module=<?php echo $v_fields['list_values']['module']; ?>&column=<?php echo $v_fields['list_values']['columns']; ?>&left=1&right=1",
						select: function(event, ui) {
							$('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val(ui.item.id);
						},
						delay: 1000,
						minLength: 2,
						close: function(event, ui) {
						}
					});
				
				</script>
		
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));"><?php echo TPL::getVar("phrases.main.common.close"); ?></a>
					<a href="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val()));"><?php echo TPL::getVar("phrases.main.common.save"); ?></a>
				</div>

			</div>
			<?php } ?>
			<?php } ?>

			<?php if($v_fields['elm_custom']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value">
			<?php echo ereg_replace("<id>", $v_items['id'], $v_fields['tpl']); ?>
			</div>
			<?php } ?>

			<?php if($v_fields['elm_image']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value">
			<?php echo ($v_items[$v_fields['column_name']]?"<img src=\"thumb.php?w=100&h=35&t=0&image=".ereg_replace(DOCROOT_, "", UPLOADDIR).$v_items[$v_fields['column_name']]."\" alt=\"".$v_items[$v_fields['column_name']]."\" />":""); ?>
			</div>
			<?php } ?>

			<?php if($v_fields['elm_file']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value">
			<?php echo ($v_items[$v_fields['column_name']]?"<a href=\"".UPLOADURL.$v_items[$v_fields['column_name']]."\" target=\"_blank\">".$v_items[$v_fields['column_name']]."</a>":""); ?>
			</div>
			<?php } ?>

			<?php if($v_fields['elm_choice']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<select id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="fo_select vam" onblur="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cellBlurEvent(this);" onchange="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val());" />
				</select>
				<input type="hidden" id="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name'].'_ids']; ?>" />
			</div>
			<?php } ?>
			<?php } ?>


			<?php if($v_fields['elm_button']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value center">
			<input type="hidden" id="chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" value="<?php echo ($v_items[$v_fields['column_name']]==1?0:1); ?>" />
			<img id="buttonImg_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" src="admin/images/status_<?php echo $v_items[$v_fields['column_name']]; ?>.gif" border="0" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>style="cursor:pointer;" onclick="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>').val());"<?php } ?> alt="" />
			</div>
			<?php } ?>
			
			
			<?php if($v_fields['elm_date']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<input type="text" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam"  onchange="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val());" />
			</div>
			<?php } ?>
			<?php } ?>


		</td>


		<?php } ?>


		<?php if(TPL::getVar("grid_data.edit_button")){ ?>
		<td class="column w10 center" rel="editbutton" id="item___editbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&method=edit&id=<?php echo $v_items['id']; ?>'));"><img src="admin/images/<?php if($v_items['lng_saved']){ ?>edit<?php }else { ?>not_saved<?php } ?>.gif" border="0"></a>
			<?php } ?>
		</td>
		<?php } ?>


		<?php if(TPL::getVar("grid_data.dublicate_button")){ ?>
		<td class="column w10 center" rel="dublicatebutton" id="item___dublicatebutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="javascript: void($NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&parent_id=<?php echo TPL::getVar("parent_id"); ?>&new=1&duplicate=<?php echo $v_items['id']; ?><?php if(TPL::getVar("get.filters")){ ?>&filters=<?php echo TPL::getVar("get.filters"); ?><?php } ?>'));"><img src="admin/images/duplicate.gif" border="0"></a>
			<?php } ?>
		</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.delete_button")){ ?>
		<td class="column w10 center" rel="deletebutton" id="item___deletebutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="javascript: if(confirm('<?php echo TPL::getVar("phrases.modules.context_menu.delete_confirm"); ?>')) $NAV.get('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&action=delete&deleteid=<?php echo $v_items['id']; ?>');"><img src="admin/images/delete.gif" border="0" alt="" /></a>
			<?php } ?>
		</td>
		<?php } ?>
		
		
		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td class="column w10 center" rel="selectbutton" id="item___selectbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<input type="checkbox" name="chk[]" onclick="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.selectRow(this);" id="chk_<?php echo $k_items; ?>" value="<?php echo $v_items['id']; ?>" style="vertical-align:top;" />
			<?php } ?>
		</td>
		<?php } ?>

		<!--div class="clear"></div-->
	</tr>
	<?php } ?>

	<tr class="header">
	<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
		<td class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			<?php if(isset($fields_val["column_result"])) echo $fields_val["column_result"]; ?>		
		</td>
	<?php } ?>
	
		<?php if(TPL::getVar("grid_data.edit_button")){ ?>
		<td class="column">&nbsp;</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.dublicate_button")){ ?>
		<td class="column">&nbsp;</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.delete_button")){ ?>
		<td class="column">&nbsp;</td>
		<?php } ?>

		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td class="column">&nbsp;</td>
		<?php } ?>	
	
	</tr>


	<?php } ?>

	</tbody>
</table>
</form>
	
	
<div style="padding:5px;padding-right:12px;padding-left:0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="right">
			
			<?php if(TPL::getVar("grid_data.select_button")){ ?>
			<form name="btn_actions___<?php echo TPL::getVar("grid_data.grid_name"); ?>" style="display:inline;">
			<?php echo TPL::getVar("phrases.main.common.action_with_selected_items"); ?>: 
			<input type="hidden" name="action_elements" value="1">
			<input type="hidden" name="action" value="action_with_selected_items">
			
			<select name="action_choice" style="width:70px;" onchange="javascript: if(confirm('<?php echo TPL::getVar("phrases.main.common.confirm_action_with_selected_items"); ?>')) $NAV.post('?module=<?php echo TPL::getVar("grid_data.grid_name"); ?>&cid=<?php echo TPL::getVar("get.cid"); ?>&action=action_with_selected_items&action_choice='+this.options[this.selectedIndex].value+'', $('#filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>')); else this.selectedIndex=0; " class="fo_select vam">
				<option value="">-----</option>
				<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
				<?php if(isset($fields_val["editable"]) && $fields_val["editable"]){ ?>
				<?php if(isset($fields_val["button"]) && $fields_val["button"]){ ?>
					<option value="<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>"><?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?></option>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<?php if(TPL::getVar("grid_data.delete_button")){ ?><option value="delete"><?php echo TPL::getVar("phrases.main.common.delete_title"); ?></option><?php } ?>
			</select>
			</form>
			<?php } ?>
			
		</td>
	</tr>
</table>


<div id="contextMenuArea" onmouseout="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.hideItemContenxtMenu(event);"></div>



<?php if(!TPL::getVar("filter_elements_count")){ ?>
<div>
<?php echo TPL::getVar("phrases.main.common.empty_items"); ?>
</div>
<?php } ?>



<script type="text/javascript">

gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.init('<?php echo TPL::getVar("grid_data.grid_name"); ?>');

<?php if(TPL::getVar("fields.elm_choice")){ ?>
<?php $fields_choice_arr_iterator=1; if(isset($fields_val["choice_arr"])){ foreach($fields_val["choice_arr"] as $fields_choice_arr_key => $fields_choice_arr_val){ $fields_choice_arr_val['_FIRST']=0; if($fields_choice_arr_iterator==1) $fields_choice_arr_val['_FIRST']=1; if($fields_choice_arr_iterator%2==1) $fields_choice_arr_val['_EVEN']=0; else $fields_choice_arr_val['_EVEN']=1; $fields_choice_arr_val['_INDEX']=$fields_choice_arr_iterator++; ?>
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php echo TPL::getVar("fields.I"); ?>].optionArray[gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php echo TPL::getVar("fields.I"); ?>].optionArray.length] = {id:"<?php if(isset($fields_choice_arr_val["id"])) echo $fields_choice_arr_val["id"]; ?>", title:"<?php if(isset($fields_choice_arr_val["title"])) echo $fields_choice_arr_val["title"]; ?>"};
<?php }} ?>
<?php } ?>

<?php if(TPL::getVar("grid_data.dragndrop")){ ?>

<?php } ?>

 
if(document.body.addEventListener){
	document.body.addEventListener('contextmenu', gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.mouseRightClick, true);
}else{
	document.getElementById('grid_area___<?php echo TPL::getVar("grid_data.grid_name"); ?>').oncontextmenu = gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.mouseRightClick;
}

 
</script>
</div>