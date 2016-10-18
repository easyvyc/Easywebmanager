<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<input type='text' name='{elm.name}' id="ELMID_{elm.column_name}" value='{elm.value}' class='FRM {style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no} >
		<input type="checkbox" {block elm.editorship no}checked{-block elm.editorship no} value="1" name="generate_{elm.column_name}" id="gen_{elm.column_name}_auto_id" style="vertical-align:middle;" /> <label for="gen_{elm.column_name}_auto_id">Auto &lt;H1&gt;</label>
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
{block _form_data.generate_header_title.value}
$('#ELMID_{elm.column_name}').attr('readonly', true);
$("#gen_{elm.column_name}_auto_id").attr('checked', true);
{-block _form_data.generate_header_title.value}
</script>