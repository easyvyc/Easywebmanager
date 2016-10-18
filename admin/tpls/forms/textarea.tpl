<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}" >
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<div id="ELMID_{elm.name}_r" class='{style}_{elm.elm_type}_r' {elm.extra_params}>
		<textarea name='{elm.name}' id="ELMID_{elm.name}" class='FRM {style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no}>{elm.value}</textarea>
		</div>
	</div>
</div>
