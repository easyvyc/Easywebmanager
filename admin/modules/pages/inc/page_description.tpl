
<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">
	

		<textarea name='{elm.name}' class='{style}_{elm.elm_type}{block elm.editorship no} readonly {-block elm.editorship no}' onchange="javascript: setEdited('{elm.name}');" {block elm.editorship no}readonly{-block elm.editorship no} ondblclick="javascript: setReadonly(this, document.getElementById('gen_page_description_auto_id'), false, '{style}', '{elm.elm_type}'); ">{elm.value}</textarea>

		<input type="checkbox" {block elm.editorship no}checked{-block elm.editorship no} value="1" name="generate_description" id="gen_page_description_auto_id" onclick="javascript: setReadonly(this.form.elements['{elm.name}'], this, this.checked, '{style}', '{elm.elm_type}');" style="vertical-align:middle;" /> <label for="gen_page_description_auto_id">Auto description</label>
		
		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

	</div>
</div>