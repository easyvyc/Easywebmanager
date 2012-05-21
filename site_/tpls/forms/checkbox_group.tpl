<div class="formElementsField" {elm.extra_params}>
	<label class="{elm.style}" for="id_{elm.name}">{elm.title}{block elm.required_field}*{-block elm.required_field}</label>
	
	{block elm.show_error}<span class="error_message">{elm.error_message}</span><br />{-block elm.show_error}
	
	<br />
	{loop list}
	<div style="float:left;width:170px;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="25">
	<input type='checkbox' name='{elm.name}[]' value='{list.value}' class='{style}_{elm.elm_type}' id='{elm.name}_{list._INDEX}' {block list.checked}checked{-block list.checked}>
			</td>
			<td>
	<label for="{elm.name}_{list._INDEX}" style="vertical-align:top;">{list.title}</label>
			</td>
		</tr>
	</table>
	</div>
	{-loop list}
	
	<div style="clear:left;"></div>
	
</div>
