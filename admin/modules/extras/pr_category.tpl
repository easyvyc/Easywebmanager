<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">
		
		{block elm.multiple}
		<div>
		<input type="checkbox" {block elm.editorship no}disabled{-block elm.editorship no} onclick="javascript: setAllSelected(this, '{form_name}', '{elm.name}');" id="selectAll{elm.name}_id"> <label for="selectAll{elm.name}_id">{phrases.form.select_all}</label>
		</div>
		{-block elm.multiple}
		
		<select name='{elm.name}_tmp' class='{style}_{elm.elm_type}' onchange="javascript: setEdited('{elm.name}'); setValues('{form_name}', '{elm.name}'); {block elm.onchange}{elm.onchange}{-block elm.onchange}"  {block elm.editorship no}disabled{-block elm.editorship no} >
		<option value="">------------------</option>
		
		{loop options_list}
			<optgroup label="{options_list.title}">
			{loop options_list.sub}
			<option value="{options_list.sub.id}" {block options_list.sub.selected}selected{-block options_list.sub.selected}>{options_list.sub.title}</option>
			{-loop options_list.sub}
			</optgroup>
		{-loop options_list}
		
		
		</select>
		
		<input type="hidden" name="{elm.name}" value="{elm.value}">
		
		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />
		
	</div>
</div>