<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="e">
	
		<input type='checkbox' name='{elm.name}' value='{block elm.default_value}{elm.default_value}{-block elm.default_value}{block elm.default_value no}1{-block elm.default_value no}' id="id_{elm.name}" class='{style}_{elm.elm_type} vam' {block elm.editorship no}disabled{-block elm.editorship no}  {block elm.value}checked{-block elm.value} onclick="javascript: setEdited('{elm.name}'); {block elm.onclick}{elm.onclick}{-block elm.onclick}" {elm.extra_params}>
		{block elm.editorship no}<input type="hidden" name="{elm.name}" value="{block elm.value}{block elm.default_value}{elm.default_value}{-block elm.default_value}{block elm.default_value no}1{-block elm.default_value no}{-block elm.value}">{-block elm.editorship no}

		{block elm.title}<label for="id_{elm.name}" class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}{block elm.require}*{-block elm.require}</label>&nbsp;{-block elm.title}
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			


		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

	</div>
</div>