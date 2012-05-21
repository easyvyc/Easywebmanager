<block name="not_empty_elements">
<script type="text/javascript">
 gridObject = new gridClass('grid_area');
</script>

<div id="debug_info"></div>

<div id="grid_area">

	<div class="header">
	
	<loop name="fields">
		<div rel="{fields.column_name}" id="header_{fields.column_name}" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div class="sorter">
			<div><a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&by={fields.column_name}&order=ASC&ajax=1&area=tpl_grid', 'items_list_grid'));"><img src="images/sort_up<block name="fields.sort_up">_a</block name="fields.sort_up">.gif" alt="" class="" border="0" <block name="fields.sort_up" no>onmouseover="javascript: this.src='images/sort_up_a.gif';" onmouseout="javascript: this.src='images/sort_up.gif';"</block name="fields.sort_up" no> /></a></div>
			<div><a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&by={fields.column_name}&order=DESC&ajax=1&area=tpl_grid', 'items_list_grid'));"><img src="images/sort_down<block name="fields.sort_down">_a</block name="fields.sort_down">.gif" alt="" class="" border="0" <block name="fields.sort_down" no>onmouseover="javascript: this.src='images/sort_down_a.gif';" onmouseout="javascript: this.src='images/sort_down.gif';"</block name="fields.sort_down" no> /></a></div>
			</div>
			
			<label title="{fields.title}">{fields.title}</label>
			
			<block name="fields.second_column_name">
			<div class="resize_column" id="resizer_{fields.column_name}" onmousedown="javascript: grid_mouseDownEvent(event, gridObject, '{fields.column_name}', '{fields.second_column_name}', {fields._INDEX});" onmouseout="javascript: grid_mouseOutEvent(event, gridObject);"></div>
			</block name="fields.second_column_name">
			
		</div>
		
		<script type="text/javascript">
		gridObject.columns.add('{fields.column_name}', {fields.w}, '{fields.elm_type}');
		
		<block name="fields.elm_choice">
		
		<loop name="fields.choice_arr">
		gridObject.columns.cols[{fields.I}].optionArray[gridObject.columns.cols[{fields.I}].optionArray.length] = {id:"{fields.choice_arr.id}", title:"{fields.choice_arr.title}"};
		</loop name="fields.choice_arr">
		
		</block name="fields.elm_choice">
		
		</script>
		
	</loop name="fields">


		<div rel="editbutton" id="header_editbutton" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';"></div>
		<script type="text/javascript">
		gridObject.columns.add('editbutton', 1);
		</script>

		<block name="module.forbid_delete" no>
		<div rel="dublicatebutton" id="header_dublicatebutton" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';"></div>
		<script type="text/javascript">
		gridObject.columns.add('dublicatebutton', 1);
		</script>

		<div rel="deletebutton" id="header_deletebutton" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';"></div>
		<script type="text/javascript">
		gridObject.columns.add('deletebutton', 1);
		</script>
		</block name="module.forbid_delete" no>

		<div rel="selectbutton" id="header_selectbutton" class="column center" onmouseover="javascript: this.className='column center over';" onmouseout="javascript: this.className='column center';">
		<input type="checkbox" onclick="javascript: selectAllItems(0, this.checked);" />
		</div>
		<script type="text/javascript">
		gridObject.columns.add('selectbutton', 1);
		</script>


		<div class="clear"></div>
	</div>
	
	
	<form name="items" style="margin:0px;">
	<ul>
	<?php foreach($templateVariables->loops['items'] as $k_items=>$v_items){ 
			$i=0; ?>
	<li class="item" id="item_row_<?php echo $v_items['id']; ?>" onmouseover="javascript: this.className='item a'" onmouseout="javascript: this.className='item'">
		
		<div id="contextmenu_<?php echo $v_items['id']; ?>" class="contextMenu">
			<div class="title"><?php echo $v_items['title']; ?></div>
			<div class="text">
				<?php foreach($v_items['context'] as $context_k=>$context_v){ ?>
				<div><a <?php if($context_v['action']){ ?>href="<?php echo $context_v['action']; ?>"<?php } ?>><img src="images/<?php echo $context_v['img']; ?>.gif" alt="" class="vam" border="0" /> <?php echo $context_v['title']; ?></a></div>
				<?php } ?>
			</div>
		</div>
		
		<?php foreach($templateVariables->loops['fields'] as $k_fields=>$v_fields){ ?>
		
		<div class="column" rel="<?php echo $v_fields['column_name']; ?>" id="item___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" <?php if($v_fields['editorship']==1){ ?>ondblclick="javascript: gridObject.cellEditItem_<?php echo $v_fields['elm_type']; ?>(this);"<?php } ?> >
			
			<?php if($v_fields['elm_text']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_vaue"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editorship']==1){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<input type="text" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam" onblur="javascript: gridObject.cellBlurEvent(this);" onkeydown="javascript: ctrlKeyPressed = isCtrlKeyPressed(event);" onkeyup="javascript: ctrlKeyPressed=0;" onkeypress="javascript: ajaxChangeFieldText('{config.site_url}', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event, ctrlKeyPressed);" />
			</div>
			<?php } ?>
			<?php } ?>


			<?php if($v_fields['elm_choice']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_vaue"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editorship']==1){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<select name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="fo_select vam" onblur="javascript: gridObject.cellBlurEvent(this);" onchange="javascript: ajaxChangeFieldSelect('{config.site_url}', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event);" /></select>
				<input type="hidden" name="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name'].'_ids']; ?>" />
			</div>
			<?php } ?>
			<?php } ?>


			<?php if($v_fields['elm_button']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_vaue center">
			<input type="hidden" id="chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" />
			<img id="buttonImg_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" src="images/status_<?php echo $v_items[$v_fields['column_name']]; ?>.gif" border="0" <?php if($v_fields['editorship']==1){ ?>style="cursor:pointer;" onclick="javascript: ajaxChangeFieldCheckbox('{config.site_url}', document.getElementById('chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event);"<?php } ?> alt="" />
			</div>
			<?php } ?>
			
			
			<?php if($v_fields['elm_date']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_vaue"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editorship']==1){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<input type="text" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam" onblur="javascript: gridObject.cellBlurEvent(this);" onkeydown="javascript: ctrlKeyPressed = isCtrlKeyPressed(event);" onkeyup="javascript: ctrlKeyPressed=0;" onkeypress="javascript: ajaxChangeFieldText('{config.site_url}', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event, ctrlKeyPressed);" />
			</div>
			<?php } ?>
			<?php } ?>


		</div>

		<script type="text/javascript">
		gridObject.columns.cols[<?php echo $i; ?>].cells[gridObject.columns.cols[<?php echo $i++; ?>].cells.length] = '<?php echo $v_items['id']; ?>';
		</script>

		<?php } ?>


		<div class="column center" rel="editbutton" id="item___editbutton___<?php echo $v_items['id']; ?>">
			<a href="main.php?content={get.content}&module={module.table_name}&page=edit&id=<?php echo $v_items['id']; ?>"><img src="images/<?php if($v_items['lng_saved']){ ?>edit<?php }else { ?>not_saved<?php } ?>.gif" border="0"></a>
		</div>
		<script type="text/javascript">
		gridObject.columns.cols[<?php echo $i; ?>].cells[gridObject.columns.cols[<?php echo $i++; ?>].cells.length] = '<?php echo $v_items['id']; ?>';
		</script>


		<block name="module.forbid_delete" no>
		<div class="column center" rel="dublicatebutton" id="item___dublicatebutton___<?php echo $v_items['id']; ?>">
			<a href="main.php?content={get.content}&module={module.table_name}&page=edit&id=0&parent_id={parent_id}&new=1&duplicate=<?php echo $v_items['id']; ?>"><img src="images/duplicate.gif" border="0"></a>
		</div>
		<script type="text/javascript">
		gridObject.columns.cols[<?php echo $i; ?>].cells[gridObject.columns.cols[<?php echo $i++; ?>].cells.length] = '<?php echo $v_items['id']; ?>';
		</script>

		<div class="column center" rel="deletebutton" id="item___deletebutton___<?php echo $v_items['id']; ?>">
			<a href="javascript: if(confirm('{phrases.common.delete_confirm}')){ PageClass.getPageContent('main.php?content={get.content}&module={module.table_name}&page=list&action=delete&deleteid=<?php echo $v_items['id']; ?>&id=<?php echo $v_items['parent_id']; ?><block name="get.offset">&offset={get.offset}</block name="get.offset">&ajax=1&area=tpl_grid', 'items_list_grid'); }"><img src="images/delete.gif" border="0"></a>
		</div>
		<script type="text/javascript">
		gridObject.columns.cols[<?php echo $i; ?>].cells[gridObject.columns.cols[<?php echo $i++; ?>].cells.length] = '<?php echo $v_items['id']; ?>';
		</script>
		</block name="module.forbid_delete" no>
		
		<div class="column center" rel="selectbutton" id="item___selectbutton___<?php echo $v_items['id']; ?>">
			<input type="checkbox" name="chk[]" id="chk_<?php echo $k_items; ?>" value="<?php echo $v_items['id']; ?>" style="height:12px;">
		</div>
		<script type="text/javascript">
		gridObject.columns.cols[<?php echo $i; ?>].cells[gridObject.columns.cols[<?php echo $i++; ?>].cells.length] = '<?php echo $v_items['id']; ?>';
		</script>		

		<div class="clear"></div>
	</li>
	<li class="sep" id="sep___<?php echo $v_items['id']; ?>">
		
	</li>
	
	<script type="text/javascript">
		
		new Draggable('item_row_<?php echo $v_items['id']; ?>', {revert:true});
		
		<block name="order_by_R.sort_order">
		Droppables.add('item_row_<?php echo $v_items['id']; ?>', 
							{ 
								accept:'item', 
								onDrop:function(element){ 
									arr = element.id.split('_');
									PageClass.getPageContent('main.php?content={get.content}&module={module.table_name}&page=list&id=<?php echo $v_items['parent_id']; ?>&action=change_order&firstid='+arr[2]+'&lastid=<?php echo $v_items['id']; ?><block name="get.offset">&offset={get.offset}</block name="get.offset">&ajax=1&area=tpl_grid', 'items_list_grid');
								}, 
								hoverclass:'item'
							}
						);
		</block name="order_by_R.sort_order">

	</script>		
	
	<?php } ?>
	</ul>
	</form>
	
</div>


<div style="padding:5px;padding-right:12px;padding-left:0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
			<div class="paging">

			<form method="post" style="display:inline;" name="paging">
			<input type="hidden" name="action" value="paging">
			{phrases.common.display_paging}: 
			<select name="paging_items" onchange="javascript: PageClass.submitForm('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&ajax=1&area=tpl_grid', 'items_list_grid', document.forms['paging']);" class="fo_select">
				
				<loop name="items_in_one_page">
				<option value="{items_in_one_page.value}" <block name="items_in_one_page.active">selected</block name="items_in_one_page.active">> - {items_in_one_page.value} - </option> 
				</loop name="items_in_one_page">
				
			</select>
			</form>	
			
			<block name="paging.paging_start_arrow">
			<a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&offset={paging.paging_start_arrow_value}&ajax=1&area=tpl_grid', 'items_list_grid'));" class="paging_0">«</a> 
			</block name="paging.paging_start_arrow">
				
			<loop name="paging">
				<block name="paging.active" no>
				<a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&offset={paging.value}&ajax=1&area=tpl_grid', 'items_list_grid'));" class="paging_0">{paging.title}</a> 
				</block name="paging.active" no>
				<block name="paging.active">
				<span class="paging_1">{paging.title}</span> 
				</block name="paging.active">
			</loop name="paging">

			<block name="paging.paging_end_arrow">
			<a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&offset={paging.paging_end_arrow_value}&ajax=1&area=tpl_grid', 'items_list_grid'));" class="paging_0">»</a> 
			</block name="paging.paging_end_arrow">

			</div>
		</td>	
		<td align="right">
			
			<form name="btn_actions" style="display:inline;">
			{phrases.common.action_with_selected_items}: 
			<input type="hidden" name="action_elements" value="1">
			<input type="hidden" name="action" value="action_with_selected_items">
			
			<select name="action_choice" style="width:70px;" onchange="javascript: if(confirm('{phrases.common.confirm_action_with_selected_items}')) PageClass.submitForm('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={parent_id}&action=action_with_selected_items&action_choice='+this.options[this.selectedIndex].value+'&ajax=1&area=tpl_grid', 'items_list_grid', document.forms['items']); else this.selectedIndex=0; " class="fo_select vam">
				<option value="">-----</option>
				<loop name="fields">
				<block name="fields.editorship">
				<block name="fields.button">
					<option value="{fields.column_name}">{fields.title}</option>
				</block name="fields.button">
				</block name="fields.editorship">
				</loop name="fields">
				<block name="module.forbid_delete" no><option value="delete">{phrases.common.delete_title}</option></block name="module.forbid_delete" no>
				<block name="module.mail"><option value="mail">{phrases.common.mail_title}</option></block name="module.mail">
				<!--optgroup label="Trinti"></optgroup-->
			</select>
			</form>
			
		</td>
	</tr>
</table>
</div>

<div id="contextMenuArea" onmouseout="javascript: gridObject.hideItemContenxtMenu(event);"></div>

<script type="text/javascript">
 
 gridObject.init();

 window.onresize = function(){
 	gridObject.init();
 }
 
 <block name="tree_reload">
 top.modules.TreeObj_{module.table_name}_s.create({parent_id});
 </block name="tree_reload">


if(document.body.addEventListener){
	document.body.addEventListener('contextmenu', gridObject.mouseRightClick, true);
}else{
	$('grid_area').oncontextmenu = gridObject.mouseRightClick;
}

 
</script>

</block name="not_empty_elements">


<block name="not_empty_elements" no>
{phrases.common.empty_items}
</block name="not_empty_elements" no>