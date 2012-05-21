<div id="id_{elm.name}" class="formElementsField {elm.style}" {block elm.extra_block_style}style="{elm.extra_block_style}"{-block elm.extra_block_style}>
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<input type='text' name='{elm.name}' id="ELMID_{elm.column_name}" value='{elm.value}' class='{style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no} {elm.extra_params} >
	</div>
</div>
