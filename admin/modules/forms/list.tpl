{block record_data_id}
<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="e">
		
		<div style="padding:3px;font-weight:bold;background:#FFF;display:inline;">
		<a style="color:#777;" href="main.php?content=catalog&module={select_list_module}&page=filters&filters={elm.column_name}&parent_module={elm.module_id}&parent_column={elm.column_name}&parent_record_id={record_data_id}" target="list_iframe_{elm.name}">{elm.title}</a>
		</div>
		
		
		<iframe name="list_iframe_{elm.name}" id="list_iframe_{elm.name}" width="100%" height="0" frameborder="0" style="margin:0px;display:none;" onload="javascript: this.style.display='block';"></iframe>
		
		<input type="hidden" name="{elm.name}" value="{elm.value}">
		
		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />
		
	</div>
</div>
{-block record_data_id}