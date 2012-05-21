<div id="id_{elm.name}" class="formElementsField">
	<div class="t">
		<span class="{elm.style}">{elm.title}:{block elm.required_field}*{-block elm.required_field}</span>
			
	</div>
	<div class="e">
	
		<input type='password' name='{elm.name}_1' value='' class='{style}_{elm.elm_type}'><br />
	
	</div>
	<div class="t">
	
		<span class="{elm.style}">Pakartokite slaptažodį:</span>
		{block elm.show_error}<br><span class="error_message">{elm.error_message}</span>{-block elm.show_error}
			
	</div>
	<div class="e">
	
		<input type='password' name='{elm.name}_2' value='' class='{style}_{elm.elm_type}'>
	
	</div>
</div>
