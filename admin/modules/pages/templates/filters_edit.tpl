<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;" colspan="3">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
				<tr>
					<td class="pathcell">
			<block name="filter_module" no><a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}list" class="path">{module.title}</a> → </block name="filter_module" no><loop name="path"><a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}list&id={path.id}" class="path">{path.title}</a> → </loop name="path">                             <block name="data.isNew" no>{data.title}</block name="data.isNew" no><block name="data.isNew">{phrases.catalog.new_element}</block name="data.isNew">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	
	<block name="module.forbid_delete" no>
	<block name="is_category">
	<tr>
		<td colspan="3">
	<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id=0&parent_id={data.parent_id}&ce=1&new=1" class="path"><img src="images/new_category.gif" border="0" align="absmiddle">{phrases.catalog.new_category}</a>
		</td>
	</tr>
	</block name="is_category">
	<block name="is_category" no>
	<tr>
		<td colspan="3">
	<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id=0&parent_id={data.parent_id}&ce=0&new=1" class="path"><img src="images/new_element.gif" border="0" align="absmiddle">{phrases.catalog.new_element}</a>
		</td>
	</tr>
	</block name="is_category" no>
	</block name="module.forbid_delete" no>	
	
	
	<tr>
		<td colspan="3">
					
	
				{form}

			
		</td>
	</tr>
	
	<block name="super_admin">
	<tr>
		<td colspan="3" style="background-color:#EFEFEF;border:1px solid #CCCCCC;">
		{phrases.common.created}: {data.create_date}<block name="super_admin_info.creator.id"> {super_admin_info.creator.id} - <a href="main.php?content=admins&page=edit&admin_id={super_admin_info.creator.id}">{super_admin_info.creator.login}</a> ({super_admin_info.creator.firstname} {super_admin_info.creator.lastname})</block name="super_admin_info.creator.id"><br>
		{phrases.common.modificated}: {data.last_modif_date}<block name="super_admin_info.modifier.id"> {super_admin_info.modifier.id} - <a href="main.php?content=admins&page=edit&admin_id={super_admin_info.modifier.id}">{super_admin_info.modifier.login}</a> ({super_admin_info.modifier.firstname} {super_admin_info.modifier.lastname})</block name="super_admin_info.modifier.id">
		</td>
	</tr>
	</block name="super_admin">
	
</table>