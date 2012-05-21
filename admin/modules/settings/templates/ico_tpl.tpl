<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">

	<div style="float:left;">
	<table border="0" id="img_table_{elm.name}" {block is_img no}style="display:none;"{-block is_img no}>
		<tr>
			<td>
			<input type="hidden" id="img_src_value_{elm.name}" value="{uploadurl}{elm.value}">
			<img src='../thumb.php?image={elm.list_values.dir}{elm.value}&w=200&h=200&t=0' border='0' id="img_src_{elm.name}" onclick="javascript: window.open('file.php?module={get.module}&column={elm.name}&id={data.id.value}&w=800&h=800&t=0');" onload="javascript: changeImageDisplaySize(this);" style="cursor:pointer;">
			</td>
		</tr>
		<tr {block is_img no}style="display:none;"{-block is_img no}>
			<td><input type='checkbox' name='delete_{elm.name}' value='1' id='id_{elm.name}' {block elm.editorship no}disabled{-block elm.editorship no}><label for='id_{elm.name}'>{phrases.form.delete_image}</label></td>
		</tr>
	</table>
	
	{block is_img}
	<input type='hidden' name='old_{elm.name}' value='{elm.value}'>
	{-block is_img}
	
	<input type='hidden' name='{elm.name}' value='{elm.value}'>
	<input type='hidden' name='resize_old_{elm.name}' id='resize_old_{elm.name}' value='0'>
	
	<input type='file' name='file_{elm.name}' class='{style}_{elm.elm_type}{block elm.editorship no} readonly{-block elm.editorship no}' style='width:250px;' {block elm.editorship no}readonly{-block elm.editorship no} onchange="javascript: changeImageSrc(this, '{elm.name}'); changeImageLink(this, '{elm.name}'); setEdited('{elm.name}');">
	
	
	<br>
	<span style="font-size:9px;">{phrases.common.max_file_size} - {max_file_size} Mb</span>
	</div>
	
	<div style="clear:both;" onmouseover="javascript: if(document.getElementById('id_noresize_{elm.name}').checked) document.getElementById('img_params_{elm.name}').style.display='block';">
	<input type="checkbox" name="noresize_{elm.name}" value="1" {block elm.editorship no}disabled{-block elm.editorship no} id="id_noresize_{elm.name}" {block resize_image}checked{-block resize_image} onclick="javascript: if(!this.checked) document.getElementById('img_params_{elm.name}').style.display='none'; else document.getElementById('img_params_{elm.name}').style.display='block';"><label for="id_noresize_{elm.name}">{phrases.form.change_image_size}</label>
	<br>
	<table id="img_params_{elm.name}" style="display:none;" border="0" cellpadding="0" cellspacing="0">
	{loop image_extra}
	<tr>
		<td style="font-size:9px;">
	<input type="text" name="resize_width_{elm.name}_{image_extra.prefix}" value="{image_extra.size_width}" class='{style}_{elm.elm_type}' style='width:25px;font-size:9px;' {block elm.editorship no}readonly{-block elm.editorship no} onchange="javascript: setEdited('{elm.name}'); document.getElementById('resize_old_{elm.name}').value='1'; if(!checkNumber(this.value)) alert('{phrases.common.bad_number_format}');">
	x
	<input type="text" name="resize_height_{elm.name}_{image_extra.prefix}" value="{image_extra.size_height}" class='{style}_{elm.elm_type}' style='width:25px;font-size:9px;' {block elm.editorship no}readonly{-block elm.editorship no} onchange="javascript: setEdited('{elm.name}'); document.getElementById('resize_old_{elm.name}').value='1'; if(!checkNumber(this.value)) alert('{phrases.common.bad_number_format}');">
	<b>{image_extra.prefix}</b> - {phrases.form.image_size}
		</td>
		<td><img src="image/0.gif" width="15" height="1"></td>
		<td style="font-size:9px;">
	<input type="text" name="resize_quality_{elm.name}_{image_extra.prefix}" value="{image_extra.quality}" class='{style}_{elm.elm_type}' style='width:25px;font-size:9px;' {block elm.editorship no}readonly{-block elm.editorship no} onchange="javascript: setEdited('{elm.name}'); document.getElementById('resize_old_{elm.name}').value='1'; if(!checkNumber(this.value) || this.value<1 || this.value>100) alert('{phrases.common.bad_number_format}');">
	{phrases.form.image_quality}
		</td>
	</tr>
	{-loop image_extra}
	</table>
	</div>
	
	<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" {block elm.edited no}value="0"{-block elm.edited no}{block elm.edited}value="1"{-block elm.edited} />
	
	</div>
</div>