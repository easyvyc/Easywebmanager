<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		{block elm.title}<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;{-block elm.title}
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">
	
	{loop list}
	<div style="float:left;width:200px;">
	<input type='checkbox' style='vertical-align:middle;' {block list.readonly no}name='{elm.name}[]'{-block list.readonly no} value='{list.value}' id="id_{elm.name}_{list._INDEX}" class='{style}_{elm.elm_type}' {block list.checked}checked{-block list.checked} {block elm.editorship no}disabled{-block elm.editorship no} {block list.readonly}disabled{-block list.readonly} onclick="javascript: setEdited('{elm.name}'); {block elm.onclick}{elm.onclick}{-block elm.onclick}" ><label for="id_{elm.name}_{list._INDEX}">{list.title}</label>
	
	{block list.readonly}{block list.checked}<input type="hidden" name="{elm.name}[]" value="{list.value}">{-block list.checked}{-block list.readonly}	
	
	</div>
	{-loop list}
	
	<div style="clear:left;"></div>

	{block add_new_item_button}
	<!--div  align="right">
	<input type="button" class="{style}_select" value="{phrases.form.manage_list}" onclick="javascript: openCenteredWindow('main.php?content=catalog&page=list&filters=1&module={select_list_module}&id={select_list_parent_id}&filter_category_id={select_list_parent_id}&parent_module={elm.module_id}&parent_column={elm.column_name}', 'list', 750, 550);">
	</div-->
	{-block add_new_item_button}
	
	<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />
	
	</div>
</div>