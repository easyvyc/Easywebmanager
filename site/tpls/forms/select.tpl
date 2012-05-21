<div id="id_{elm.name}" class="formElementsField">
	<div class="e {elm.style}">
		<select name='{elm.name}' id='{elm.name}' class='{style}_{elm.elm_type} vam {elm.style}' {elm.extra_params}>
		<option value="">---{elm.title}---</option>
		{loop list}<option value="{list.value}" {block list.checked}selected{-block list.checked} >{list.title}</option>{-loop list}
		</select>
		{block elm.required_field}*{-block elm.required_field}
		
		{elm.extra_data}
		
	</div>	
</div>
