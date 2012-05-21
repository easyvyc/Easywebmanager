<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">
	
		<input type='text' id='{elm.name}' name='{elm.name}' value='{elm.value}' class='{style}_{elm.elm_type}' style="width:150px;" readonly {block elm.editorship}onclick="javascript: scwShow(this, event);" style="cursor:pointer;" onchange="javascript: setEdited('{elm.name}');"{-block elm.editorship}>
		
		{block elm.list_values.time}
		<select name="{elm.name}_hour" class="fo_select vam" {block elm.editorship no}disabled{-block elm.editorship no}>
			{loop hours}
			<option value="{hours.value}" {block hours.selected}selected{-block hours.selected}>{hours.title}</option>
			{-loop hours}
		</select>
		<input type="text" name="{elm.name}_minute" class="fo_text vam" value="{minute}" style="width:20px;" {block elm.editorship no}readonly{-block elm.editorship no} />
		{-block elm.list_values.time}

		<div id="{elm.name}_calendar_area"></div>

		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

	</div>
</div>