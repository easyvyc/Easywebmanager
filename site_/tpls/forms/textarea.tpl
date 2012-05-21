<div id="id_{elm.name}" class="formElementsField" >
	<div class="t">
		<span class="{elm.style}">{elm.title}:<block name="elm.required_field">*</block name="elm.required_field"></span>
		{block elm.show_error}<br><span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<textarea name='{elm.name}' class='{style}_{elm.elm_type}' {elm.extra_params}>{elm.value}</textarea>
	</div>
</div>
