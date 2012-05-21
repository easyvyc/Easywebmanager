<script type="text/javascript">
function showImageExtras(obj){
	
	context_obj = document.getElementById('contextMenu_{elm.name}_text');
	
	html = "<table cellpadding=1 cellspacing=1 width=100%><tr><td>Prefix</td><td>Size (WxH)</td><td>Quality</td><td>Watermark</td><td></td></tr>";
	
	if(obj.value!=''){
		arr1 = obj.value.split("::");
		for(i=0; i<arr1.length; i++){
			arr2 = arr1[i].split("||");
			prefix_val = size_val = quality_val = watermark_val = '';
			for(j=0; j<arr2.length; j++){
				arr3 = arr2[j].split("=");
				if(arr3[0]=='prefix'){
					prefix_val = arr3[1];
				}
				if(arr3[0]=='size'){
					size_val = arr3[1];
				}
				if(arr3[0]=='quality'){
					quality_val = arr3[1];
				}
				if(arr3[0]=='watermark'){
					watermark_val = arr3[1];
				}
			}
			html += "<tr><td><input type='text' id='prefix_" + i + "' class='fo_text' value='" + prefix_val + "' style='width:35px;' /></td><td><input type='text' id='size_" + i + "' value='" + size_val + "' class='fo_text' style='width:35px;' /></td><td><input type='text' value='" + quality_val + "' id='quality_" + i + "' class='fo_text' style='width:25px;' /></td><td><input type='checkbox' id='watermark_" + i + "' value=1 " + (watermark_val==1?"checked":"") + " class='fo_checkbox' /></td><td><input type='button' class='fo_submit' value=' x ' onclick=\"javascript: removeImageExtra(" + i + ")\" /></td></tr>";
		}
		arr1_length = arr1.length;
	}else{
		arr1_length = 0;
	}
		
	html += "<tr><td><input type='text' id='prefix_" + arr1_length + "' class='fo_text' style='width:35px;' /></td><td><input type='text' id='size_" + arr1_length + "' class='fo_text' style='width:35px;' /></td><td><input type='text' id='quality_" + arr1_length + "' class='fo_text' style='width:25px;' /></td><td><input type='checkbox' id='watermark_" + arr1_length + "' class='fo_checkbox' /></td><td><input type='button' class='fo_submit' value=' add ' onclick=\"javascript: addImageExtra(" + arr1_length + ")\" /></td></tr></table>";
	
	context_obj.innerHTML = html;
	
	document.getElementById('contextMenu_{elm.name}').style.display = 'block';
}
</script>

<style>
#contextMenu_{elm.name} input {
	vertical-align:middle;
}
</style>

<div id="contextMenu_{elm.name}" class="contextMenu" style="display:none;width:220px;" >
<div class='title' id='contextMenu_{elm.name}_title'>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>{elm.title}</td>
		<td align="right"><a href="javascript: void(document.getElementById('contextMenu_{elm.name}').style.display='none');" style="color:#FFF;font-weight:bold;">X</a></td>
	</tr>
</table>
</div>
<div class='text' id='contextMenu_{elm.name}_text'></div>
</div>

<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">
	
		<input type='text' name='{elm.name}' value='{elm.value}' class='{style}_{elm.elm_type}{block elm.editorship no} readonly{-block elm.editorship no}' onchange="javascript: setEdited('{elm.name}');" {block elm.editorship no}readonly{-block elm.editorship no} {elm.extra_params} />
		
		<input type="button" value=" ... " class="fo_submit" style="vertical-align:middle;height:17px;width:40px;" onclick="javascript: showImageExtras(this.form.elements['{elm.name}']);" />
		
		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

	</div>
</div>