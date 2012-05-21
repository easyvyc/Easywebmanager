<div id="id_{elm.name}" class="formElementsField" {elm.extra_params}>
	<div class="e {elm.style}">
		<input type='checkbox' name='{elm.name}' value='1' id="id_{elm.name}_chk" class='{style}_{elm.elm_type} vam {elm.style}' {block elm.value}checked{-block elm.value}  {elm.field_extra_params}>
		<span ><label for="id_{elm.name}_chk">{elm.title}</label>{block elm.required_field}*{-block elm.required_field}</span>
	</div>
</div>
