
<block name="superadmin" no>
<style>
<block name="data.no_standart_tpl" no>
#area_id_field_html {
	display:none;
}
</block name="data.no_standart_tpl" no>
<block name="data.list_values" no>
#area_id_list_values {
	display:none;
}
</block name="data.list_values" no>
<block name="data.extra_params" no>
#area_id_extra_params {
	display:none;
}
</block name="data.extra_params" no>
</style>

<script type="text/javascript">
function setColumnFields(obj){
	if(obj.options[obj.selectedIndex].value=='image'){
		document.getElementById('area_id_extra_params').style.display='block';
	}else{
		document.getElementById('area_id_extra_params').style.display='none';
	}
	if(obj.options[obj.selectedIndex].value=='select' || obj.options[obj.selectedIndex].value=='radio' || obj.options[obj.selectedIndex].value=='checkbox_group'){
		document.getElementById('area_id_list_values').style.display='block';
	}else{
		document.getElementById('area_id_list_values').style.display='none';
	}
}
</script>
</block name="superadmin" no>

<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			{menu}
		</td>
	</tr>

	<tr>
		<td>	
<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<a href="main.php?content={get.content}&module={module.table_name}&page=modules" class="path">{phrases.settings.modules_title}</a> → <a href="main.php?content={get.content}&module={module.table_name}&page=column_list&id={module_data.id}" class="path">{module_data.title}</a> → <block name="data.isNew" no>{data.title}</block name="data.isNew" no><block name="data.isNew">{phrases.settings.module.new_column}</block name="data.isNew">
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>
	
	<tr>
		<td height="30" valign="middle"><a href="main.php?content={get.content}&page=edit_column&parent_id={module_id}&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.settings.module.new_column}</a></td>
	</tr>
		
	<tr>
		<td colspan="3">
					
	
				{form}

			
		</td>
	</tr>
</table>

<script language="javascript">
if(location.hash=='#delete'){
	if(confirm('{phrases.common.delete_confirm}')) location = "main.php?content=mod&page=column_list&id={module_id}&action=delete&deleteid={data.id}";
}
</script>