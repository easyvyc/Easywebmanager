<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}" {elm.extra_params}>
	<label>{elm.title}:{block elm.required}*{-block elm.required}</label>
	
	{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	
	<br />
	{loop list}
	<label class="table" style="float:left;width:170px;">
            <div class="cell" style="width:10px;">
		<input type='checkbox' name='{elm.name}[]' value='{list.value}' class='FRM {style}_{elm.elm_type}' id='ELMID_{form_settings.id}_{elm.name}_{list._INDEX}' {block list.selected}checked{-block list.selected} {block list.readonly}disabled{-block list.readonly} {list.field_extra_params}>
            </div>
            <div class="cell">
		<span style="vertical-align:top;{block list.readonly}color:#AAA;{-block list.readonly}">{list.title}</span>
            </div>
	</label>
	{-loop list}
	
	<div style="clear:left;"></div>
	
</div>
