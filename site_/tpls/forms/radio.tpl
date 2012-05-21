<div id="id_{elm.name}" class="formElementsField" {elm.extra_params}>
	<span class="{elm.style}">{elm.title}:<block name="elm.required_field">*</block name="elm.required_field"></span>
	<block name="elm.show_error"><span class="error_message">{elm.error_message}</span><br></block name="elm.show_error">
	<br>
		<loop name="list">
		<div style="float:left;width:170px;">
		<input type='radio' name='{elm.name}' value='{list.value}' class='{style}_{elm.elm_type}' id='id_{elm.name}_{list.value}' <block name="list.checked">checked</block name="list.checked"> />
		<label for="id_{elm.name}_{list.value}">{list.title}</label>
		</div>
		</loop name="list">	
		<div style="clear:left;"></div>	
</div>
