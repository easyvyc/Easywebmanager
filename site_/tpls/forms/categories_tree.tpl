<div id="id_{elm.name}" class="formElementsField" {elm.extra_params}>
	<div class="t">
	
		<span class="{elm.style}">{elm.title}<block name="elm.required_field">*</block name="elm.required_field"></span>
		<block name="elm.show_error"><span class="error_message">{elm.error_message}</span><br></block name="elm.show_error">
		
	</div>
	<div class="e">

		<select name='{elm.name}_tmp' class='{style}_{elm.elm_type}' {elm.extra_params} onchange="javascript: setValues('save', '{elm.name}', {categoriesCount}, this.selectedIndex);">
		<loop name="list">
		<block name="list.sub">
		<optgroup label="{list.opt_space}{list.title}">
		</block name="list.sub">
		<block name="list.sub" no>
		<option value="{list.id}" <block name="list.selected_field">selected</block name="list.selected_field">>{list.space}{list.title}</option>
		</block name="list.sub" no>
		</loop name="list">
		</select>
		
		<input type="hidden" name="{elm.name}" value="{elm.value}">
		
	</div>	
</div>