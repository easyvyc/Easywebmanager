<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">
	
		{block is_img}
		<div>
		<table border="0">
			<tr>
				<td><a href='file.php?module={get.module}&column={elm.name}&id={data.id.value}'><img src="images/extension_icons/{elm.file_extension}.gif" border="0" align="absmiddle"> {elm.value}</a></td>
			</tr>
			<tr>
				<td><input type='checkbox' name='delete_{elm.name}' value='1' id='id_{elm.name}' {block elm.editorship no}disabled{-block elm.editorship no}><label for='id_{elm.name}'>{phrases.form.delete_file}</label></td>
			</tr>
		</table>
		<input type='hidden' name='old_{elm.name}' value='{elm.value}'>
		</div>
		{-block is_img}
		
		<input type='hidden' name='{elm.name}' value='{elm.value}'>
		<input type='file' name='file_{elm.name}' class='{style}_{elm.elm_type}{block elm.editorship no} readonly{-block elm.editorship no}' onchange="javascript: setEdited('{elm.name}');" {block elm.editorship no}readonly{-block elm.editorship no}><br>
		<span style="font-size:9px;">{phrases.common.max_file_size} - {max_file_size} Mb</span>
		
		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

	</div>
</div>