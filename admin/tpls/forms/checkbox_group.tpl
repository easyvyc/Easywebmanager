<div id="id_{elm.name}" class="formElementsField {elm.style}" {elm.extra_params}>
	<label>{elm.title}:{block elm.required}*{-block elm.required}</label>
	
	{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	
	<br />
	{loop list}
	<div style="float:left;width:170px;">
		<input type='checkbox' name='{elm.name}[]' value='{list.value}' class='FRM {style}_{elm.elm_type}' id='ELMID_{elm.name}_{list._INDEX}' {block list.selected}checked{-block list.selected} {list.field_extra_params}>
		<label for="ELMID_{elm.name}_{list._INDEX}" style="vertical-align:top;">{list.title}</label>
	</div>
	{-loop list}
	
	<div style="clear:left;"></div>
	
</div>
