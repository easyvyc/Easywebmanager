<div id="debug_info___<?php echo TPL::getVar("grid_data.grid_name"); ?>"></div>

<table class="rel" border="0" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td align="left">

			<span class="all_items_count"><?php echo TPL::getVar("phrases.main.catalog.import_data_items_count"); ?>: <b><?php echo TPL::getVar("filter_elements_count"); ?></b></span>

		</td>
		<td align="right" class="paging rel">


			<?php if(!TPL::getVar("grid_data.no_paging")){ ?>
			<?php if(TPL::getVar("items_in_one_page")){ ?>
			<?php if(TPL::getVar("paging.paging_start_arrow")){ ?>
			<a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&offset=<?php echo TPL::getVar("paging.paging_start_arrow_value"); ?>'));" class="paging_0">«</a> 
			<?php } ?>
				
			<?php $paging_loop_iterator=1; foreach(TPL::getLoop("paging_loop") as $paging_loop_key => $paging_loop_val){ if(!is_array($paging_loop_val)){ $tmp_val=$paging_loop_val; $paging_loop_val=array(); $paging_loop_val['_VALUE']=$tmp_val; } $paging_loop_val['_FIRST']=0; if($paging_loop_iterator==1) $paging_loop_val['_FIRST']=1; if($paging_loop_iterator%2==1) $paging_loop_val['_EVEN']=0; else $paging_loop_val['_EVEN']=1; $paging_loop_val['_INDEX']=$paging_loop_iterator++; $paging_loop_val['_KEY']=$paging_loop_key; ?>
				<?php if(!isset($paging_loop_val["active"]) || !$paging_loop_val["active"]){ ?>
				<a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&offset=<?php if(isset($paging_loop_val["value"])) echo $paging_loop_val["value"]; ?>'));" class="paging_0"><?php if(isset($paging_loop_val["title"])) echo $paging_loop_val["title"]; ?></a> 
				<?php } ?>
				<?php if(isset($paging_loop_val["active"]) && $paging_loop_val["active"]){ ?>
				<a class="a"><?php if(isset($paging_loop_val["title"])) echo $paging_loop_val["title"]; ?></a> 
				<?php } ?>
			<?php } ?>

			<?php if(TPL::getVar("paging.paging_end_arrow")){ ?>
			<a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&offset=<?php echo TPL::getVar("paging.paging_end_arrow_value"); ?>'));" class="paging_0">»</a> 
			<?php } ?>
		</td>
		<td width="20">
			<a onclick="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.tools_toggle(this));" class="toggle_display_paging"><img src="admin/images/tools.gif" alt="" style="vertical-align:top" /></a>
			<div class="contextMenu display_paging hide">
				<div class="title"><?php echo TPL::getVar("phrases.main.catalog.listing_settings"); ?></div>
				<div class="text">
				
					<form method="post" style="margin:3px 0px;padding:0px;" name="paging___<?php echo TPL::getVar("grid_data.grid_name"); ?>" id="paging___<?php echo TPL::getVar("grid_data.grid_name"); ?>">
					<input type="hidden" name="action" value="paging" />
					<?php echo TPL::getVar("phrases.main.common.display_paging"); ?>: 
					<select name="paging_items" onchange="javascript: $NAV.post('?<?php echo TPL::getVar("grid_data.base_url"); ?>', $('#paging___<?php echo TPL::getVar("grid_data.grid_name"); ?>'));" class="fo_select">
						
						<?php $items_in_one_page_iterator=1; foreach(TPL::getLoop("items_in_one_page") as $items_in_one_page_key => $items_in_one_page_val){ if(!is_array($items_in_one_page_val)){ $tmp_val=$items_in_one_page_val; $items_in_one_page_val=array(); $items_in_one_page_val['_VALUE']=$tmp_val; } $items_in_one_page_val['_FIRST']=0; if($items_in_one_page_iterator==1) $items_in_one_page_val['_FIRST']=1; if($items_in_one_page_iterator%2==1) $items_in_one_page_val['_EVEN']=0; else $items_in_one_page_val['_EVEN']=1; $items_in_one_page_val['_INDEX']=$items_in_one_page_iterator++; $items_in_one_page_val['_KEY']=$items_in_one_page_key; ?>
						<option value="<?php if(isset($items_in_one_page_val["value"])) echo $items_in_one_page_val["value"]; ?>" <?php if(isset($items_in_one_page_val["active"]) && $items_in_one_page_val["active"]){ ?>selected<?php } ?>> - <?php if(isset($items_in_one_page_val["value"])) echo $items_in_one_page_val["value"]; ?> - </option> 
						<?php } ?>
						
					</select>
					</form>	
					
					<a href="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cleanFilters());"><?php echo TPL::getVar("phrases.main.catalog.clean_listing_filters"); ?></a>
			
				</div>
			</div>
			
			<script type="text/javascript">
			//$('.display_paging').mouseleave(function(){ $(this).hide(); });
			</script>
			
			<?php } ?>
			<?php } ?>

		</td>	
	</tr>
</table>

<form style="margin:0px;" action="javascript: void($NAV.post('?<?php echo TPL::getVar("grid_data.base_url"); ?>', $('#filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>')));" id="filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>" name="filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>">
<table id="grid_area___<?php echo TPL::getVar("grid_data.grid_name"); ?>" class="grid_area" border="0" cellspacing="1" cellpadding="0">

<script type="text/javascript">
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?> = new gridClass('<?php echo TPL::getVar("grid_data.grid_name"); ?>');
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cid = '<?php echo TPL::getVar("get.cid"); ?>';
</script>

	<thead>
	<tr class="header">

		<?php if(TPL::getVar("grid_data.actions_button")){ ?>
		<td rel="actionsbutton" id="header_actionsbutton" class="column w10 center">
                    <div class="col_">
                    <div class="sorter show">
                    <div><a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&by=R.sort_order&order=DESC'));"><img src="admin/images/sort_down<?php if(TPL::getVar("fields.sort_down")){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!TPL::getVar("fields.sort_down")){ ?>onmouseover="javascript: this.src='admin/images/sort_down_a.gif';" onmouseout="javascript: this.src='admin/images/sort_down.gif';"<?php } ?> /></a></div>
                    <div><a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&by=R.sort_order&order=ASC'));"><img src="admin/images/sort_up<?php if(TPL::getVar("fields.sort_up")){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!TPL::getVar("fields.sort_up")){ ?>onmouseover="javascript: this.src='admin/images/sort_up_a.gif';" onmouseout="javascript: this.src='admin/images/sort_up.gif';"<?php } ?> /></a></div>
                    </div>
                    <label>&nbsp;</label>
                    <div class="clear"></div>
                    </div>                    
                </td>
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('actionsbutton', 1);
		</script>
		<?php } ?>
	
	<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ if(!is_array($fields_val)){ $tmp_val=$fields_val; $fields_val=array(); $fields_val['_VALUE']=$tmp_val; } $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; $fields_val['_KEY']=$fields_key; ?>
		<td rel="<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="header_<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div class="col_">
			
                        <?php if(TPL::getVar("grid_data.sort_form")){ ?>
			<?php if(!isset($fields_val["no_sort"]) || !$fields_val["no_sort"]){ ?>
			<div class="sorter show">
			<div><a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&by=<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>&order=DESC'));"><img src="admin/images/sort_down<?php if(isset($fields_val["sort_down"]) && $fields_val["sort_down"]){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!isset($fields_val["sort_down"]) || !$fields_val["sort_down"]){ ?>onmouseover="javascript: this.src='admin/images/sort_down_a.gif';" onmouseout="javascript: this.src='admin/images/sort_down.gif';"<?php } ?> /></a></div>
			<div><a href="javascript: void($NAV.get('?<?php echo TPL::getVar("grid_data.base_url"); ?>&by=<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>&order=ASC'));"><img src="admin/images/sort_up<?php if(isset($fields_val["sort_up"]) && $fields_val["sort_up"]){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!isset($fields_val["sort_up"]) || !$fields_val["sort_up"]){ ?>onmouseover="javascript: this.src='admin/images/sort_up_a.gif';" onmouseout="javascript: this.src='admin/images/sort_up.gif';"<?php } ?> /></a></div>
			</div>
			<?php } ?>
                        <?php } ?>
			
			<label title="<?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?>"><?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?></label>

			<div class="clear"></div>
			
			</div>
		</td>
	
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>', <?php if(isset($fields_val["w"])) echo $fields_val["w"]; ?>, '<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?>');


		<?php if(isset($fields_val["elm_choice"]) && $fields_val["elm_choice"]){ ?>
                <?php if(isset($fields_val["choice_arr_json"]) && $fields_val["choice_arr_json"]){ ?>
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php if(isset($fields_val["_INDEX"])) echo $fields_val["_INDEX"]; ?>].optionArray = <?php if(isset($fields_val["choice_arr_json"])) echo $fields_val["choice_arr_json"]; ?>;
                <?php } ?>
		<?php } ?>
		
		</script>		


	<?php } ?>

		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td rel="selectbutton" id="header_selectbutton" class="column w10 center selectall" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">
		<input type="checkbox" onclick="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.selectAllItems(this.checked);" style="vertical-align:top;" />
		</td>
		<script type="text/javascript">
		gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.add('selectbutton', 1);
		</script>
		<?php } ?>

	</tr>
	

	<?php if(TPL::getVar("grid_data.filter_form")){ ?>
	<input type="hidden" name="action" value="filter" />
	<tr class="header">

		<?php if(TPL::getVar("grid_data.actions_button")){ ?>
		<td rel="actionsbutton" id="filter_actionsbutton" class="column w10 center" >&nbsp;</td>
		<?php } ?>


	<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ if(!is_array($fields_val)){ $tmp_val=$fields_val; $fields_val=array(); $fields_val['_VALUE']=$tmp_val; } $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; $fields_val['_KEY']=$fields_key; ?>
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
				<input type="image" style="width:auto;height:auto;" src="admin/images/back.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value='<?php if(isset($fields_val["filter_value_back_from"])) echo $fields_val["filter_value_back_from"]; ?>'; if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value='<?php if(isset($fields_val["filter_value_back_to"])) echo $fields_val["filter_value_back_to"]; ?>'; document.forms['filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>'].submit();" />
				<?php } ?>
				<input type="text" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>[from]" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from" class="date vam" placeholder="From" value="<?php if(isset($fields_val["filter_value_from"])) echo $fields_val["filter_value_from"]; ?>" onchange="javascript: this.form.submit();" /><input type="text" placeholder="To" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>[to]" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to" class="date vam" value="<?php if(isset($fields_val["filter_value_to"])) echo $fields_val["filter_value_to"]; ?>" onchange="javascript: this.form.submit();" />

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
				<input type="image" style="width:auto;height:auto;" src="admin/images/forward.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___from').value='<?php if(isset($fields_val["filter_value_fwd_from"])) echo $fields_val["filter_value_fwd_from"]; ?>'; if(document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value!='') document.getElementById('filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>___to').value='<?php if(isset($fields_val["filter_value_fwd_to"])) echo $fields_val["filter_value_fwd_to"]; ?>'; document.forms['filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>'].submit();" />
				<?php } ?>
				<!--input type="hidden" name="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" id="filteritem___<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>" value="<?php if(isset($fields_val["filter_value"])) echo $fields_val["filter_value"]; ?>" class="vam" /-->
				<?php } ?>

				<?php if(isset($fields_val["filter_value"]) && $fields_val["filter_value"]){ ?>
				<a href="javascript: void(gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.cleanFilter('<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>'));"><img src="admin/images/clear_filter.png" alt="<?php echo TPL::getVar("phrases.main.common.cancel_filter"); ?>" class="clear_filter vam" /></a>
				<?php } ?>

			</div>
			
		</td>
		
		
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

		<?php if(TPL::getVar("grid_data.actions_button")){ ?>
		<td class="column w10 center rel" rel="actionsbutton" id="item___actionsbutton___<?php echo $v_items['id']; ?>">

			<img src="admin/images/flag.png" alt="" onclick="javascript: showItemContextMenu('_LISTING_CONTEXT_<?php echo TPL::getVar("grid_data.grid_name"); ?>_<?php echo $v_items['id']; ?>');" style="cursor:pointer;" />

			<div id="_LISTING_CONTEXT_<?php echo TPL::getVar("grid_data.grid_name"); ?>_<?php echo $v_items['id']; ?>" class="hide">
				<div class="title">(#<?php echo $v_items['id']; ?>) <?php echo $v_items['title_short']; ?></div>
				<div class="text">
					<?php foreach($v_items['context'] as $context_k=>$context_v){ ?>
					<div><a <?php if($context_v['action']){ ?>href="<?php echo $context_v['action']; ?>"<?php } ?>><img src="<?php echo Config::$val['admin_dir']; ?>images/actions/<?php echo $context_v['img']; ?>.gif" alt="" class="vam" border="0" /> <?php echo $context_v['title']; ?></a></div>
					<?php } ?>
				</div>
			</div>

		</td>
		<?php } ?>

		
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
						source: "?module=<?php echo $v_fields['list_values']['module']; ?>&method=<?php echo ($v_fields['list_values']['method'] ? $v_fields['list_values']['method'] : 'listAutocompleteItems'); ?>&columns=<?php echo $v_fields['list_values']['columns']; ?>&left=1&right=1",
						select: function(event, ui) {
							$('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val(ui.item.value);
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
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value" style="text-align:center;">
			<?php echo ($v_items[$v_fields['column_name']]?"<a rel=\"lightbox\" href=\"admin.php?module=".TPL::getVar("grid_data.grid_name")."&method=show_image&column=".$v_fields['column_name']."&id=".$v_items['id']."&w=800&h=800&t=0&rand=".rand(100,999)."\"><img src=\"admin.php?module=".TPL::getVar("grid_data.grid_name")."&method=show_image&column=".$v_fields['column_name']."&id=".$v_items['id']."&w=70&h=35&t=0&rand=".rand(100,999)."\" alt=\"".$v_items[$v_fields['column_name']]."\" /></a>":""); ?>
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

		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td class="column w10 center selectall" rel="selectbutton" id="item___selectbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<input type="checkbox" name="chk[]" onclick="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.selectRow(this);" value="<?php echo $v_items['id']; ?>" style="vertical-align:top;" />
			<?php } ?>
		</td>
		<?php } ?>

	</tr>
	<?php } ?>
	</tbody>

	<thead>
	<tr class="header">

		<?php if(TPL::getVar("grid_data.actions_button")){ ?>
		<td class="column center">&nbsp;</td>
		<?php } ?>

	<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ if(!is_array($fields_val)){ $tmp_val=$fields_val; $fields_val=array(); $fields_val['_VALUE']=$tmp_val; } $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; $fields_val['_KEY']=$fields_key; ?>
		<td class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			<?php if(isset($fields_val["column_result"])) echo $fields_val["column_result"]; ?>		
		</td>
	<?php } ?>
	
		<?php if(TPL::getVar("grid_data.select_button")){ ?>
		<td class="column center selectall">
			<input type="checkbox" onclick="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.selectAllItems(this.checked);" style="vertical-align:top;" />
		</td>
		<?php } ?>	
	
	</tr>


	<?php } ?>
	</thead>
	
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
			
			<select name="action_choice" style="width:70px;" onchange="javascript: if(confirm('<?php echo TPL::getVar("phrases.main.common.confirm_action_with_selected_items"); ?>')) $NAV.post('?<?php echo TPL::getVar("grid_data.base_url"); ?>&action=action_with_selected_items&action_choice='+this.options[this.selectedIndex].value+'', $('#filter___<?php echo TPL::getVar("grid_data.grid_name"); ?>')); else this.selectedIndex=0; " class="fo_select vam">
				<option value="">-----</option>
				<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ if(!is_array($fields_val)){ $tmp_val=$fields_val; $fields_val=array(); $fields_val['_VALUE']=$tmp_val; } $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; $fields_val['_KEY']=$fields_key; ?>
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

<div class="hide" id="grid_area_rows_state_<?php echo TPL::getVar("grid_data.grid_name"); ?>"></div>

<div id="contextMenuArea" onmouseout="javascript: gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.hideItemContenxtMenu(event);"></div>



<?php if(!TPL::getVar("filter_elements_count")){ ?>
<div>
<?php echo TPL::getVar("phrases.main.common.empty_items"); ?>
</div>
<?php } ?>



<script type="text/javascript">

gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.init('<?php echo TPL::getVar("grid_data.grid_name"); ?>');
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.base_url = '<?php echo TPL::getVar("grid_data.base_url"); ?>';

<?php if(TPL::getVar("fields.elm_choice")){ ?>
<?php $fields_choice_arr_iterator=1; if(isset($fields_val["choice_arr"])){ foreach($fields_val["choice_arr"] as $fields_choice_arr_key => $fields_choice_arr_val){ if(!is_array($fields_choice_arr_val)){ $tmp_val=$fields_choice_arr_val; $fields_choice_arr_val=array(); $fields_choice_arr_val['_VALUE']=$tmp_val; } $fields_choice_arr_val['_FIRST']=0; if($fields_choice_arr_iterator==1) $fields_choice_arr_val['_FIRST']=1; if($fields_choice_arr_iterator%2==1) $fields_choice_arr_val['_EVEN']=0; else $fields_choice_arr_val['_EVEN']=1; $fields_choice_arr_val['_INDEX']=$fields_choice_arr_iterator++; $fields_choice_arr_val['_KEY']=$fields_choice_arr_key;  ?>
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php echo TPL::getVar("fields.I"); ?>].optionArray[gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.columns.cols[<?php echo TPL::getVar("fields.I"); ?>].optionArray.length] = {id:"<?php if(isset($fields_choice_arr_val["id"])) echo $fields_choice_arr_val["id"]; ?>", title:"<?php if(isset($fields_choice_arr_val["title"])) echo $fields_choice_arr_val["title"]; ?>"};
<?php }} ?>
<?php } ?>

<?php if(TPL::getVar("grid_data.dragndrop")){ ?>
gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.make_sortable();
<?php } ?>

 
if(document.body.addEventListener){
	document.body.addEventListener('contextmenu', gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.mouseRightClick, true);
}else{
	document.getElementById('grid_area___<?php echo TPL::getVar("grid_data.grid_name"); ?>').oncontextmenu = gridObject___<?php echo TPL::getVar("grid_data.grid_name"); ?>.mouseRightClick;
}

$('a[rel=lightbox]').lightBox();

</script>
</div>