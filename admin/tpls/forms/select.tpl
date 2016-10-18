<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<select {block elm.editable no}readonly disabled{-block elm.editable no} name='{elm.name}{block elm.list_values.multiple}[]{-block elm.list_values.multiple}' id="ELMID_{elm.column_name}" class='FRM {style}_{elm.elm_type}' {block elm.list_values.multiple}multiple size="6"{-block elm.list_values.multiple} {elm.extra_params}>
		<option value="">-------------</option>
		{loop list}<option value="{list.value}" {block list.selected}selected{-block list.selected} >{list.title}</option>{-loop list}
		</select>
		
		{elm.extra_data}
		
	</div>	
</div>
