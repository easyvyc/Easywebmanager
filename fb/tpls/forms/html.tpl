<div id="id_{elm.name}" class="formElementsField {elm.style}" >
	<div class="t">
		<span class="">{elm.title}:<block name="elm.required">*</block name="elm.required"></span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e" style="height:100%;">
		{elm.editor}
	</div>
</div>
