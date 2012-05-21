<div id="id_{elm.name}" class="formElementsField">
	<div class="t">
		<span class="{elm.style}">{elm.title}:<block name="elm.required_field">*</block name="elm.required_field"></span>&nbsp;
		<block name="elm.show_error"><span class="error_message">{elm.error_message}</span><br></block name="elm.show_error">	
	</div>
	<div class="e">
		<input type='file' name='{elm.name}' value='{elm.value}' class='{style}_{elm.elm_type}' <block name="elm.readonly">readonly</block name="elm.readonly"> {elm.extra_params} >
	</div>
</div>