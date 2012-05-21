<script type="text/javascript">

	var params = { dragndrop:"{elm.property.dragndrop}",checkbox:"{elm.property.checkbox}",context:"{elm.property.context}" };
	var phrases = {move_confirm_text:"{phrases.move_confirm_text1}"};
	var TreeObj_{elm.property.module}_{elm.name} = _TreeClass('{config.site_url}', '{config.admin_dir}', '{elm.property.script}', '{elm.property.module}', '{elm.name}', '{lng}', params, phrases, {block elm.property.click_handler}'{elm.property.click_handler}'{-block elm.property.click_handler}{block elm.property.click_handler no}null{-block elm.property.click_handler no});
	
	{block elm.property.active}
	TreeObj_{elm.property.module}_{elm.name}.create(id);
	{-block elm.property.active}
	
</script>


<script type="text/javascript">

		var form_tree_visible_{elm.name} = 0;
		
		//createFormTree_{elm.name}('{lng}', {elm.value});

		function sh_tree_{elm.name}(){
			TreeObj_{elm.property.module}_{elm.name}.show_hide_tree('{elm.name}', '{elm.value}');
		}

		{block elm.property.expanded}
		sh_tree_{elm.name}();
		{-block elm.property.expanded}
		
</script>			
		

<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" width="100">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}{block elm.require}*{-block elm.require}</span>
		<div id="{elm.name}_tree_hide_button" {block elm.property.expanded no}style="display:none;"{-block elm.property.expanded no}>
		<input type="button" value="{phrases.form.hide_tree}" class="{style}_{elm.elm_type}" id="btn_id_{elm.name}_hide" >
		</div>
		<div id="{elm.name}_tree_show_button" {block elm.property.expanded}style="display:none;"{-block elm.property.expanded}>
			<input type="button" value="{phrases.form.show_tree}" class="{style}_{elm.elm_type}" id="btn_id_{elm.name}_show" >
		</div>	
		
			
	</div>
			</td>
			<td valign="top">
	<div class="e">

	{block elm.show_error}<span class="error_message">{elm.error_message}</span><br />{-block elm.show_error}
	<input type="hidden" name="{elm.name}" id="{elm.name}" value="{elm.value}" onchange="javascript: setEdited('{elm.name}');">
		<div id="{elm.name}_tree_id" style="display:none;">
		
<div id="module_tree_{elm.property.module}_{elm.name}"  class="module_tree_box"></div>

		</div>

		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" {block elm.edited no}value="0"{-block elm.edited no}{block elm.edited}value="1"{-block elm.edited} />
		
	</div>
			</td>
		</tr>
	</table>
	
</div>

<script type="text/javascript">
{block elm.editorship}
document.getElementById('btn_id_{elm.name}_hide').onclick = sh_tree_{elm.name};
document.getElementById('btn_id_{elm.name}_show').onclick = sh_tree_{elm.name};
{-block elm.editorship}		
</script>