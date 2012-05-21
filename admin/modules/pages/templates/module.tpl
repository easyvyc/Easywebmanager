<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

{main_menu}

		</td>
	</tr>	
	<tr>
		<td>


<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<block name="filter_module" no><a href="main.php?content={get.content}&module={module.table_name}&page=list" class="path">{module.title}</a> → </block name="filter_module" no><loop name="path"><a href="main.php?content={get.content}&module={module.table_name}&page=module&id={path.id}" class="path">{path.title} ({path.id})</a> → </loop name="path">                             <block name="data.isNew" no>{data.title} <block name="data.id">({data.id})</block name="data.id"></block name="data.isNew" no>
			</td>
			
		</tr>
	</table>
</div>

<div style="width:100%;">
		
	<div class="modulesMain" id="secondlist" style="width:100%;">
	

		<div id="categories_list">

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px;">
	
	<tr>
		
		<td>
		<block name="module.forbid_delete" no>
	<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id={get.id}&parent_id={parent_id}&record_id=0&ce=1&new=1" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.catalog.new_element}</a>
		</block name="module.forbid_delete" no>	
		</td>
		<td>
		
	<form method="post" style="display:inline;">
	<input type="hidden" name="action" value="paging">
	{phrases.common.display_paging}: 
	<select name="paging_items" onchange="javascript: this.form.submit();" class="fo_select">
		
		<loop name="items_in_one_page">
		<option value="{items_in_one_page.value}" <block name="items_in_one_page.active">selected</block name="items_in_one_page.active">> - {items_in_one_page.value} - </option> 
		</loop name="items_in_one_page">
		
	</select>
	</form>	
		
		</td>
		<td align="right" nowrap>
	
			<div class="paging">
			<loop name="paging">
						<a href="main.php?content={get.content}&module={module.table_name}&page=module&id={get.id}&parent_id={get.id}&ce=1&offset={paging.value}<block name="get.c_offset">&c_offset={get.offset}</block name="get.c_offset">" class="paging_{paging.active}">{paging._INDEX}</a> 
			</loop name="paging">
			</div>
	
		</td>
	</tr>
</table>

	<block name="items_count">
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">

{table_header}

<block name="module.forbid_filter" no>
{elements_filter_form}
</block name="module.forbid_filter" no>


<form method="post" name="list">

<loop name="fields">
	<script language="javascript">
	var list_{fields.column_name} = new Array;
	
	<?php foreach($templateVariables->loops["arr_".$fields_val['column_name']] as $arr_fields_key => $arr_fields_val){ ?>
	
	list_{fields.column_name}[list_{fields.column_name}.length] = {id:"<?php echo $arr_fields_val['id']; ?>", title:"<?php echo addcslashes($arr_fields_val['title'], '"'); ?>"};
	
	<?php } ?>
	
	var ctrlKeyPressed = 0;
	
	</script>	
</loop name="fields">


<loop name="items">
<tr class="tblcontent" id="row{items.id}" onmouseover="javascript: change_row_color(overRowColor,{items.id});" onmouseout="javascript: change_row_color(outRowColor,{items.id});">
	<!--td class="tblcontent" align="center"><a href="{base_url}{categories.page_url}" target="_blank"><img src="images/preview.gif" border="0"></a></td-->
	<td align="center"><a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&record_id={items.id}&id={get.id}&ce=0"><img src="images/<block name="items.lng_saved">edit</block name="items.lng_saved"><block name="items.lng_saved" no>no_saved</block name="items.lng_saved" no>.gif" border="0"></a></td>
	<block name="module.forbid_delete" no>
	<td align="center"><a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id={get.id}&record_id=0&parent_id={parent_id}&ce=1&new=1&duplicate={items.id}"><img src="images/duplicate.gif" border="0"></a></td>
	</block name="module.forbid_delete" no>

	
	<loop name="fields">
	
	<td style="cursor:default;" <block name="fields.text"><block name="fields.editorship"><?php if(!$fields_val["list_values"]["multiple"]){ ?>ondblclick="javascript: editField_{fields.type}('{items.id}', '{fields.column_name}', 'fieldEdit_{items.id}_{fields.column_name}', 'fieldContent_{items.id}_{fields.column_name}', list_{fields.column_name});"<?php } ?></block name="fields.editorship"></block name="fields.text">>
	<block name="fields.text"><input type="hidden" name="fieldContent_{items.id}_{fields.column_name}_tmp" value="<?php $items_val[$fields_val["column_name"]."_ids"]; ?>"><div id="fieldContent_{items.id}_{fields.column_name}">{items.{fields.column_name}}</div></block name="fields.text">
	<block name="fields.image"><div id="fieldContent_{items.id}_{fields.column_name}" align="center"><?php if($items_val[$fields_val["column_name"]]){ ?><img src="{upload_url}{fields.image_extra_prefix}{items.{fields.column_name}}" height="20" align="absmiddle" onclick="javascript: openCenteredWindow('{config.site_url}img.php?img={upload_url}{items.{fields.column_name}}', '', 10,10,0,0,0,0);" style="cursor:pointer;"><?php } ?></div></block name="fields.image">
	<block name="fields.file"><div id="fieldContent_{items.id}_{fields.column_name}"><a href="{upload_url}{items.{fields.column_name}}" target="_blank">{items.{fields.column_name}}</a></div></block name="fields.file">
	<block name="fields.button"><div id="fieldContent_{items.id}_{fields.column_name}">
	<input type="hidden" id="chk_{items.id}_{fields.column_name}" value="{items.{fields.column_name}}">
	<center><img id="buttonImg_{items.id}_{fields.column_name}" src="images/status_{items.{fields.column_name}}.gif" border="0" <block name="fields.editorship">style="cursor:pointer;" onclick="javascript: ajaxChangeFieldCheckbox('{config.site_url}', document.getElementById('chk_{items.id}_{fields.column_name}').value, {items.id}, {items.parent_id}, '{fields.column_name}', '{child_module.table_name}', '{lng}', event);"</block name="fields.editorship">></center>
	</div></block name="fields.button">
	<div id="fieldEdit_{items.id}_{fields.column_name}" style="display:none;">
	

	<block name="fields.elm_text">
	<input type="text" id="id_{fields.column_name}_{items.id}" class="listFrmText" onkeydown="javascript: ctrlKeyPressed = isCtrlKeyPressed(event);" onkeyup="javascript: ctrlKeyPressed=0;" onkeypress="javascript: ajaxChangeFieldText('{config.site_url}', this.value, {items.id}, {items.parent_id}, '{fields.column_name}', '{child_module.table_name}', '{lng}', event, ctrlKeyPressed);" onblur="javascript: show_hide('fieldContent_{items.id}_{fields.column_name}', 'fieldEdit_{items.id}_{fields.column_name}');">
	</block name="fields.elm_text">
	
	<block name="fields.elm_textarea">
	<textarea id="id_{fields.column_name}_{items.id}" class="listFrmText" onkeypress="javascript: ajaxChangeFieldTextarea('{config.site_url}', this.value, {items.id}, {items.parent_id}, '{fields.column_name}', '{child_module.table_name}', '{lng}', event);"></textarea>
	</block name="fields.elm_textarea">
	
	<block name="fields.elm_choice">
	<select id="id_{fields.column_name}_{items.id}" class="listFrmSelect" onkeypress="javascript: if(window.event.keyCode == 27) show_hide('fieldContent_{items.id}_{fields.column_name}', 'fieldEdit_{items.id}_{fields.column_name}');" onchange="javascript: ajaxChangeFieldSelect('{config.site_url}', this.options[this.selectedIndex].value, {items.id}, {items.parent_id}, '{fields.column_name}', '{child_module.table_name}', '{lng}', event);" ></select>
	</block name="fields.elm_choice">

	<block name="fields.elm_date">
	<table border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
				<input type='text' class='listFrmDate' name='id_{fields.column_name}_{items.id}' id='id_{fields.column_name}_{items.id}' onclick="javascript: ajaxChangeFieldDate('{config.site_url}', this.value, {items.id}, {items.parent_id}, '{fields.column_name}', '{child_module.table_name}', '{lng}', event);">
			</td>
			<td>
				<input type="button" value="..." class="listFrmDateBtn" onclick="javascript: displayCalendar(document.forms['list'].elements['id_{fields.column_name}_{items.id}'],'yyyy-mm-dd',this); return false;">
			</td>
		</tr>
	</table>
	</block name="fields.elm_date">


	</div>
	<img src="images/0.gif" width="1" height="1" align="absmiddle" style="position:absolute;">
	</td>
	</loop name="fields">
	
	<td align="center">
		<input type="checkbox" name="chk[{items._INDEX}]" id="chk_{items._INDEX}" value="{items.id}" style="height:12px;">
	</td>
	
	<block name="module.forbid_sort" no>
	<block name="order_by_R.sort_order">
	<td align="center" onclick="javascript: change_order({items.id}, {get.id}, '{get.content}', '{module.table_name}', 'module', 0<block name="get.offset">, {get.offset}</block name="get.offset">);"><img src="images/sort.gif" border="0"></td>
	</block name="order_by_R.sort_order">
	<block name="order_by_R.sort_order" no>
	<td align="center"><img src="images/sort_disabled.gif" border="0"></td>
	</block name="order_by_R.sort_order" no>
	</block name="module.forbid_sort" no>
	
	<block name="module.forbid_delete" no>
	<td align="center"><a href="javascript: if(confirm('{phrases.common.delete_confirm}')){ window.location = 'main.php?content={get.content}&module={module.table_name}&page=module&id={get.id}&action=delete&deleteid={items.id}&record_id={items.parent_id}<block name="get.offset">&offset={get.offset}</block name="get.offset">'; }"><img src="<block name="easyweb.filepath">file://{easyweb.filepath}</block name="easyweb.filepath">images/delete.gif" border="0"></a></td>
	</block name="module.forbid_delete" no>
	
</tr>
</loop name="items">

{table_header}

	<tr>
		<!--td class="tbltop" width="5%">Peržiūra</td-->
		<td width="5"></td>
		<td align="right" colspan="{fields_list_count}">{phrases.common.action_with_selected_items}: 
			<input type="hidden" name="action_categories" value="1">
			<input type="hidden" name="action" value="action_with_selected_items">
		</td>
		<td>
			<select name="action_choice" onchange="javascript: submitCatalogItemsForm(this); " class="fo_select">
				<option value="">-----</option>
				<loop name="fields">
				<block name="fields.editorship">
				<block name="fields.button">
					<option value="{fields.column_name}">{fields.title}</option>
				</block name="fields.button">
				</block name="fields.editorship">
				</loop name="fields">
				<block name="module.forbid_delete" no><option value="delete">{phrases.common.delete_title}</option></block name="module.forbid_delete" no>
				<!--optgroup label="Trinti"></optgroup-->
			</select>
		</td>
		<td colspan="3" align="right">
		</td>
	</tr>	
	</form>		
	</table>
	</block name="items_count">
	
	</div>


	</div>
	
</div>

		</td>
	</tr>
</table>