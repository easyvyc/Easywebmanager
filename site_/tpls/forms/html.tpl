<div id="id_{elm.name}" class="formElementsField" >
	<div class="t">
		{block elm.show_error}<br>{-block elm.show_error}
		<span class="{elm.style}">{elm.title}:<block name="elm.required_field">*</block name="elm.required_field"></span>
		{block elm.show_error}<br><span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e" style="height:100%;">
		{elm.editor}
	</div>
</div>
