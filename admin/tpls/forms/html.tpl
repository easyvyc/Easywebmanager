<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}" >
	<div class="t">
		<span class="">{elm.title}:<block name="elm.required">*</block name="elm.required"></span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e" style="height:100%;">
		<textarea class="ckeditor" name="{elm.name}">{elm.value}</textarea>
	</div>
</div>
<script type="text/javascript">
	CKEDITOR.replace( '{elm.name}', {
	    toolbar: '{block elm.list_values.mode}{elm.list_values.mode}{-block elm.list_values.mode}{block elm.list_values.mode no}Default{-block elm.list_values.mode no}',
	    uiColor: '#BCBCBC'
	});
</script>