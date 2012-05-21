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
				<a href="main.php?content={get.content}&module={module.table_name}&page=modules" class="path">{phrases.settings.modules_title}</a> → {module_data.title} 
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>

	<tr>
		<td height="30" valign="middle"><a href="main.php?content={get.content}&page=edit_column&parent_id={module_id}&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.settings.module.new_column}</a></td>
	</tr>
		
	<block name="empty" no>
	<tr>
		<td>

	<div id="items_list_grid">
		
		{items_list_content}
	
	</div>

		</td>
	</tr>
	</block name="empty" no>

	<block name="empty">
	<tr>
		<td height="30" valign="middle">{phrases.common.empty_items}</td>
	</tr>	
	</block name="empty">
</table>