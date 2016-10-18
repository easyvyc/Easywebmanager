<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<textarea name='{elm.name}' id="ELMID_{elm.name}" class='FRM {style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no}>{elm.value}</textarea>
		<input type="checkbox" {block elm.editorship no}checked{-block elm.editorship no} value="1" name="generate_{elm.column_name}" id="gen_{elm.column_name}_auto_id" style="vertical-align:middle;" /> <label for="gen_{elm.column_name}_auto_id">Auto description</label>
	</div>
</div>

<script type="text/javascript">
$("#ELMID_{elm.column_name}").dblclick(function(){
	$(this).attr('readonly', false);
	$("#gen_{elm.column_name}_auto_id").attr('checked', false);
});
$("#gen_{elm.column_name}_auto_id").change(function(){
	bool = $(this).is(':checked');
	pageurl = $("#ELMID_{elm.column_name}");
	if(bool){
		pageurl.attr('readonly', true);
	}else{
		pageurl.attr('readonly', false);
	}
});
{block _form_data.generate_description.value}
$('#ELMID_{elm.column_name}').attr('readonly', true);
$("#gen_{elm.column_name}_auto_id").attr('checked', true);
{-block _form_data.generate_description.value}
</script>