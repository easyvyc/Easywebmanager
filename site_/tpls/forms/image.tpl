<div id="id_{elm.name}" class="formElementsField">
	<div class="t">
		<span class="{elm.style}">{elm.title}:{block elm.required_field}*{-block elm.required_field}</span>
		{block elm.show_error}<br><span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
	
	<div style="float:left;">
	<table border="0" id="img_table_{elm.name}" {block is_img no}style="display:none;"{-block is_img no}>
		<tr>
			<td>
			<input type="hidden" id="img_src_value_{elm.name}" value="{uploadurl}{elm.value}">
			<a href="{uploadurl}{elm.value}" target="_blank"><img src='{uploadurl}thumb_{elm.value}' border='0' alt="" /></a>
			</td>
		</tr>
		<!--tr>
			<td><input type='checkbox' name='delete_{elm.name}' value='1' id='id_{elm.name}' {block elm.editorship no}disabled{-block elm.editorship no}><label for='id_{elm.name}'>Pašalinti nuotrauką</label></td>
		</tr-->
	</table>
	
	{block is_img}
	<input type='hidden' name='old_{elm.name}' value='{elm.value}'>
	{-block is_img}
	
	
	<input type='hidden' name='{elm.name}' value='{elm.value}'>
	<input type='file' name='file_{elm.name}' class='{style}_{elm.elm_type}' {block elm.editorship no}readonly{-block elm.editorship no}>
	<span style="font-size:9px;">Maximalus failo dydis - {max_file_size} Mb</span>
	</div>	
	<div style="clear:both;"></div>
	
	</div>
</div>
