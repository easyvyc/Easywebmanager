<div id="id_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
			
	</div>
	<div class="e">
	
		<input type='password' name='{elm.name}_1' value="" class='FRM {style}_{elm.elm_type}' autocomplete="off" /><br />
	
	</div>
	<div class="t">
	
		<span class="">Pakartokite slaptažodį:</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
			
	</div>
	<div class="e">
	
		<input type='password' name='{elm.name}_2' value="" class='FRM {style}_{elm.elm_type}' autocomplete="off" />
	
	</div>
</div>
