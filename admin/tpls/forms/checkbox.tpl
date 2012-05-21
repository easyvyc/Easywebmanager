<div id="id_{elm.name}" class="formElementsField {elm.style}" {elm.extra_params}>
	<div class="e">
		<input type='checkbox' name='{elm.name}' id="ELMID_{elm.name}" value='1' class='FRM {style}_{elm.elm_type} vam' {block elm.value}checked{-block elm.value} {elm.field_extra_params} />
		<span class=""><label for="ELMID_{elm.name}">{elm.title}</label>{block elm.required}*{-block elm.required}</span>
	</div>
</div>
