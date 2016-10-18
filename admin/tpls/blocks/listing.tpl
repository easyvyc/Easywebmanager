<div id="debug_info___{grid_data.grid_name}"></div>

<table class="rel" border="0" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td align="left">

			<span class="all_items_count">{phrases.main.catalog.import_data_items_count}: <b>{filter_elements_count}</b></span>

		</td>
		<td align="right" class="paging rel">


			{block grid_data.no_paging no}
			{block items_in_one_page}
			{block paging.paging_start_arrow}
			<a href="javascript: void($NAV.get('?{grid_data.base_url}&offset={paging.paging_start_arrow_value}'));" class="paging_0">«</a> 
			{-block paging.paging_start_arrow}
				
			{loop paging_loop}
				{block paging_loop.active no}
				<a href="javascript: void($NAV.get('?{grid_data.base_url}&offset={paging_loop.value}'));" class="paging_0">{paging_loop.title}</a> 
				{-block paging_loop.active no}
				{block paging_loop.active}
				<a class="a">{paging_loop.title}</a> 
				{-block paging_loop.active}
			{-loop paging_loop}

			{block paging.paging_end_arrow}
			<a href="javascript: void($NAV.get('?{grid_data.base_url}&offset={paging.paging_end_arrow_value}'));" class="paging_0">»</a> 
			{-block paging.paging_end_arrow}
		</td>
		<td width="20">
			<a onclick="javascript: void(gridObject___{grid_data.grid_name}.tools_toggle(this));" class="toggle_display_paging"><img src="admin/images/tools.gif" alt="" style="vertical-align:top" /></a>
			<div class="contextMenu display_paging hide">
				<div class="title">{phrases.main.catalog.listing_settings}</div>
				<div class="text">
				
					<form method="post" style="margin:3px 0px;padding:0px;" name="paging___{grid_data.grid_name}" id="paging___{grid_data.grid_name}">
					<input type="hidden" name="action" value="paging" />
					{phrases.main.common.display_paging}: 
					<select name="paging_items" onchange="javascript: $NAV.post('?{grid_data.base_url}', $('#paging___{grid_data.grid_name}'));" class="fo_select">
						
						{loop items_in_one_page}
						<option value="{items_in_one_page.value}" {block items_in_one_page.active}selected{-block items_in_one_page.active}> - {items_in_one_page.value} - </option> 
						{-loop items_in_one_page}
						
					</select>
					</form>	
					
					<a href="javascript: void(gridObject___{grid_data.grid_name}.cleanFilters());">{phrases.main.catalog.clean_listing_filters}</a>
			
				</div>
			</div>
			
			<script type="text/javascript">
			//$('.display_paging').mouseleave(function(){ $(this).hide(); });
			</script>
			
			{-block items_in_one_page}
			{-block grid_data.no_paging no}

		</td>	
	</tr>
</table>

<form style="margin:0px;" action="javascript: void($NAV.post('?{grid_data.base_url}', $('#filter___{grid_data.grid_name}')));" id="filter___{grid_data.grid_name}" name="filter___{grid_data.grid_name}">
<table id="grid_area___{grid_data.grid_name}" class="grid_area" border="0" cellspacing="1" cellpadding="0">

<script type="text/javascript">
gridObject___{grid_data.grid_name} = new gridClass('{grid_data.grid_name}');
gridObject___{grid_data.grid_name}.cid = '{get.cid}';
</script>

	<thead>
	<tr class="header">

		{block grid_data.actions_button}
		<td rel="actionsbutton" id="header_actionsbutton" class="column w10 center">
                    <div class="col_">
                    <div class="sorter show">
                    <div><a href="javascript: void($NAV.get('?{grid_data.base_url}&by=R.sort_order&order=DESC'));"><img src="admin/images/sort_down{block fields.sort_down}_a{-block fields.sort_down}.gif" alt="" class="" border="0" {block fields.sort_down no}onmouseover="javascript: this.src='admin/images/sort_down_a.gif';" onmouseout="javascript: this.src='admin/images/sort_down.gif';"{-block fields.sort_down no} /></a></div>
                    <div><a href="javascript: void($NAV.get('?{grid_data.base_url}&by=R.sort_order&order=ASC'));"><img src="admin/images/sort_up{block fields.sort_up}_a{-block fields.sort_up}.gif" alt="" class="" border="0" {block fields.sort_up no}onmouseover="javascript: this.src='admin/images/sort_up_a.gif';" onmouseout="javascript: this.src='admin/images/sort_up.gif';"{-block fields.sort_up no} /></a></div>
                    </div>
                    <label>&nbsp;</label>
                    <div class="clear"></div>
                    </div>                    
                </td>
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('actionsbutton', 1);
		</script>
		{-block grid_data.actions_button}
	
	{loop fields}
		<td rel="{fields.column_name}" id="header_{fields.column_name}" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div class="col_">
			
                        {block grid_data.sort_form}
			{block fields.no_sort no}
			<div class="sorter show">
			<div><a href="javascript: void($NAV.get('?{grid_data.base_url}&by={fields.column_name}&order=DESC'));"><img src="admin/images/sort_down{block fields.sort_down}_a{-block fields.sort_down}.gif" alt="" class="" border="0" {block fields.sort_down no}onmouseover="javascript: this.src='admin/images/sort_down_a.gif';" onmouseout="javascript: this.src='admin/images/sort_down.gif';"{-block fields.sort_down no} /></a></div>
			<div><a href="javascript: void($NAV.get('?{grid_data.base_url}&by={fields.column_name}&order=ASC'));"><img src="admin/images/sort_up{block fields.sort_up}_a{-block fields.sort_up}.gif" alt="" class="" border="0" {block fields.sort_up no}onmouseover="javascript: this.src='admin/images/sort_up_a.gif';" onmouseout="javascript: this.src='admin/images/sort_up.gif';"{-block fields.sort_up no} /></a></div>
			</div>
			{-block fields.no_sort no}
                        {-block grid_data.sort_form}
			
			<label title="{fields.title}">{fields.title}</label>

			<div class="clear"></div>
			
			</div>
		</td>
	
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('{fields.column_name}', {fields.w}, '{fields.elm_type}');


		{block fields.elm_choice}
                {block fields.choice_arr_json}
		gridObject___{grid_data.grid_name}.columns.cols[{fields._INDEX}].optionArray = {fields.choice_arr_json};
                {-block fields.choice_arr_json}
		{-block fields.elm_choice}
		
		</script>		


	{-loop fields}

		{block grid_data.select_button}
		<td rel="selectbutton" id="header_selectbutton" class="column w10 center selectall" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">
		<input type="checkbox" onclick="javascript: gridObject___{grid_data.grid_name}.selectAllItems(this.checked);" style="vertical-align:top;" />
		</td>
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('selectbutton', 1);
		</script>
		{-block grid_data.select_button}

	</tr>
	

	{block grid_data.filter_form}
	<input type="hidden" name="action" value="filter" />
	<tr class="header">

		{block grid_data.actions_button}
		<td rel="actionsbutton" id="filter_actionsbutton" class="column w10 center" >&nbsp;</td>
		{-block grid_data.actions_button}


	{loop fields}
		<td rel="{fields.column_name}" id="filter_{fields.column_name}" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div id="filter___{fields.column_name}" class="list_item_filter">

				{block fields.elm_text}
				<input type="text" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" />
				{-block fields.elm_text}

				{block fields.elm_custom}
				&nbsp;
				{-block fields.elm_custom}

				{block fields.elm_image}
				&nbsp;
				{-block fields.elm_image}

				{block fields.elm_file}
				&nbsp;
				{-block fields.elm_file}

				{block fields.elm_choice}
				<input type="text" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" />
				{-block fields.elm_choice}

				{block fields.elm_autocomplete}
				<input type="text" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" />
				{-block fields.elm_autocomplete}

				{block fields.elm_button}
				<select name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" class="vam" onchange="javascript: this.form.submit();">
					<option value="">-</option>
					<option value="1" {block fields.value_1}selected{-block fields.value_1}>{phrases.main.common.yes}</option>
					<option value="0" {block fields.value_0}selected{-block fields.value_0}>{phrases.main.common.no}</option>
				</select>
				{-block fields.elm_button}

				{block fields.elm_date}
				{block fields.filter_value}
				<input type="image" style="width:auto;height:auto;" src="admin/images/back.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___{fields.column_name}___from').value!='') document.getElementById('filteritem___{fields.column_name}___from').value='{fields.filter_value_back_from}'; if(document.getElementById('filteritem___{fields.column_name}___to').value!='') document.getElementById('filteritem___{fields.column_name}___to').value='{fields.filter_value_back_to}'; document.forms['filter___{grid_data.grid_name}'].submit();" />
				{-block fields.filter_value}
				<input type="text" name="filteritem___{fields.column_name}[from]" id="filteritem___{fields.column_name}___from" class="date vam" placeholder="From" value="{fields.filter_value_from}" onchange="javascript: this.form.submit();" /><input type="text" placeholder="To" name="filteritem___{fields.column_name}[to]" id="filteritem___{fields.column_name}___to" class="date vam" value="{fields.filter_value_to}" onchange="javascript: this.form.submit();" />

				<script type="text/javascript">
					$(function() {
					$('#filteritem___{fields.column_name}___from').datepicker({ firstDay:1, altFormat:'yy-mm-dd', changeMonth:true, changeYear:true, dateFormat:'yy-mm-dd' });
					});
				</script>
				<script type="text/javascript">
					$(function() {
					$('#filteritem___{fields.column_name}___to').datepicker({ firstDay:1, altFormat:'yy-mm-dd', changeMonth:true, changeYear:true, dateFormat:'yy-mm-dd' });
					});
				</script>
				
				{block fields.filter_value}
				<input type="image" style="width:auto;height:auto;" src="admin/images/forward.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___{fields.column_name}___from').value!='') document.getElementById('filteritem___{fields.column_name}___from').value='{fields.filter_value_fwd_from}'; if(document.getElementById('filteritem___{fields.column_name}___to').value!='') document.getElementById('filteritem___{fields.column_name}___to').value='{fields.filter_value_fwd_to}'; document.forms['filter___{grid_data.grid_name}'].submit();" />
				{-block fields.filter_value}
				<!--input type="hidden" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" /-->
				{-block fields.elm_date}

				{block fields.filter_value}
				<a href="javascript: void(gridObject___{grid_data.grid_name}.cleanFilter('{fields.column_name}'));"><img src="admin/images/clear_filter.png" alt="{phrases.main.common.cancel_filter}" class="clear_filter vam" /></a>
				{-block fields.filter_value}

			</div>
			
		</td>
		
		
	{-loop fields}

		{block grid_data.select_button}
		<td rel="selectbutton" id="filter_selectbutton" class="column w10 center" >&nbsp;</td>
		{-block grid_data.select_button}

		<input type="submit" style="position:absolute;width:0px;height:0px;top:-20px;left:-50px;" />

	</tr>

	{-block grid_data.filter_form}
	</thead>

	<tbody>
	
	{block filter_elements_count}
	<?php $items = TPL::getVar("items"); foreach($items as $k_items=>$v_items){ 
			$i=0; ?>
	<tr class="item" id="item_row_<?php echo $v_items['id']; ?>">

		{block grid_data.actions_button}
		<td class="column w10 center rel" rel="actionsbutton" id="item___actionsbutton___<?php echo $v_items['id']; ?>">

			<img src="admin/images/flag.png" alt="" onclick="javascript: showItemContextMenu('_LISTING_CONTEXT_{grid_data.grid_name}_<?php echo $v_items['id']; ?>');" style="cursor:pointer;" />

			<div id="_LISTING_CONTEXT_{grid_data.grid_name}_<?php echo $v_items['id']; ?>" class="hide">
				<div class="title">(#<?php echo $v_items['id']; ?>) <?php echo $v_items['title_short']; ?></div>
				<div class="text">
					<?php foreach($v_items['context'] as $context_k=>$context_v){ ?>
					<div><a <?php if($context_v['action']){ ?>href="<?php echo $context_v['action']; ?>"<?php } ?>><img src="<?php echo Config::$val['admin_dir']; ?>images/actions/<?php echo $context_v['img']; ?>.gif" alt="" class="vam" border="0" /> <?php echo $context_v['title']; ?></a></div>
					<?php } ?>
				</div>
			</div>

		</td>
		{-block grid_data.actions_button}

		
		<?php $fields_list = TPL::getVar("fields"); foreach($fields_list as $k_fields=>$v_fields){ ?>
		
		<td title="<?php echo (isset($v_items[$v_fields['column_name'].'_ALT'])?$v_items[$v_fields['column_name'].'_ALT']:htmlspecialchars($v_items[$v_fields['column_name']])); ?>" class="column" rel="<?php echo $v_fields['column_name']; ?>" id="item___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>ondblclick="javascript: gridObject___{grid_data.grid_name}.cellEditItem_<?php echo $v_fields['elm_type']; ?>(this, event);"<?php } ?> >
			
			<?php if($v_fields['elm_text']==1 || $v_fields['elm_textarea']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<textarea id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam" ><?php echo $v_items[$v_fields['column_name']]; ?></textarea>
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___{grid_data.grid_name}.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));">{phrases.main.common.close}</a>
					<a href="javascript: void(gridObject___{grid_data.grid_name}.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val()));">{phrases.main.common.save}</a>
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
					<a href="javascript: void(gridObject___{grid_data.grid_name}.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));">{phrases.main.common.close}</a>
					<a href="javascript: void(gridObject___{grid_data.grid_name}.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val()));">{phrases.main.common.save}</a>
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
				<select id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="fo_select vam" onblur="javascript: gridObject___{grid_data.grid_name}.cellBlurEvent(this);" onchange="javascript: gridObject___{grid_data.grid_name}.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val());" />
				</select>
				<input type="hidden" id="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name'].'_ids']; ?>" />
			</div>
			<?php } ?>
			<?php } ?>


			<?php if($v_fields['elm_button']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value center">
			<input type="hidden" id="chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" value="<?php echo ($v_items[$v_fields['column_name']]==1?0:1); ?>" />
			<img id="buttonImg_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" src="admin/images/status_<?php echo $v_items[$v_fields['column_name']]; ?>.gif" border="0" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>style="cursor:pointer;" onclick="javascript: gridObject___{grid_data.grid_name}.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>').val());"<?php } ?> alt="" />
			</div>
			<?php } ?>
			
			
			<?php if($v_fields['elm_date']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<input type="text" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam"  onchange="javascript: gridObject___{grid_data.grid_name}.saveEditItem(<?php echo $v_items['id']; ?>, '<?php echo $v_fields['column_name']; ?>', $('#edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').val());" />
			</div>
			<?php } ?>
			<?php } ?>


		</td>


		<?php } ?>

		{block grid_data.select_button}
		<td class="column w10 center selectall" rel="selectbutton" id="item___selectbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<input type="checkbox" name="chk[]" onclick="javascript: gridObject___{grid_data.grid_name}.selectRow(this);" value="<?php echo $v_items['id']; ?>" style="vertical-align:top;" />
			<?php } ?>
		</td>
		{-block grid_data.select_button}

	</tr>
	<?php } ?>
	</tbody>

	<thead>
	<tr class="header">

		{block grid_data.actions_button}
		<td class="column center">&nbsp;</td>
		{-block grid_data.actions_button}

	{loop fields}
		<td class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			{fields.column_result}		
		</td>
	{-loop fields}
	
		{block grid_data.select_button}
		<td class="column center selectall">
			<input type="checkbox" onclick="javascript: gridObject___{grid_data.grid_name}.selectAllItems(this.checked);" style="vertical-align:top;" />
		</td>
		{-block grid_data.select_button}	
	
	</tr>


	{-block filter_elements_count}
	</thead>
	
</table>
</form>
	
	
<div style="padding:5px;padding-right:12px;padding-left:0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="right">
			
			{block grid_data.select_button}
			<form name="btn_actions___{grid_data.grid_name}" style="display:inline;">
			{phrases.main.common.action_with_selected_items}: 
			<input type="hidden" name="action_elements" value="1">
			<input type="hidden" name="action" value="action_with_selected_items">
			
			<select name="action_choice" style="width:70px;" onchange="javascript: if(confirm('{phrases.main.common.confirm_action_with_selected_items}')) $NAV.post('?{grid_data.base_url}&action=action_with_selected_items&action_choice='+this.options[this.selectedIndex].value+'', $('#filter___{grid_data.grid_name}')); else this.selectedIndex=0; " class="fo_select vam">
				<option value="">-----</option>
				{loop fields}
				{block fields.editable}
				{block fields.button}
					<option value="{fields.column_name}">{fields.title}</option>
				{-block fields.button}
				{-block fields.editable}
				{-loop fields}
				{block grid_data.delete_button}<option value="delete">{phrases.main.common.delete_title}</option>{-block grid_data.delete_button}
			</select>
			</form>
			{-block grid_data.select_button}
			
		</td>
	</tr>
</table>

<div class="hide" id="grid_area_rows_state_{grid_data.grid_name}"></div>

<div id="contextMenuArea" onmouseout="javascript: gridObject___{grid_data.grid_name}.hideItemContenxtMenu(event);"></div>



{block filter_elements_count no}
<div>
{phrases.main.common.empty_items}
</div>
{-block filter_elements_count no}



<script type="text/javascript">

gridObject___{grid_data.grid_name}.init('{grid_data.grid_name}');
gridObject___{grid_data.grid_name}.base_url = '{grid_data.base_url}';

{block fields.elm_choice}
{loop fields.choice_arr}
gridObject___{grid_data.grid_name}.columns.cols[{fields.I}].optionArray[gridObject___{grid_data.grid_name}.columns.cols[{fields.I}].optionArray.length] = {id:"{fields.choice_arr.id}", title:"{fields.choice_arr.title}"};
{-loop fields.choice_arr}
{-block fields.elm_choice}

{block grid_data.dragndrop}
gridObject___{grid_data.grid_name}.make_sortable();
{-block grid_data.dragndrop}

 
if(document.body.addEventListener){
	document.body.addEventListener('contextmenu', gridObject___{grid_data.grid_name}.mouseRightClick, true);
}else{
	document.getElementById('grid_area___{grid_data.grid_name}').oncontextmenu = gridObject___{grid_data.grid_name}.mouseRightClick;
}

$('a[rel=lightbox]').lightBox();

</script>
</div>