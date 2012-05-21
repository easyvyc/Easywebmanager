<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	
	<block name="no">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			
			{main_menu}
			
		</td>
	</tr>	
	</block name="no">
	
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;" colspan="3">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
				<tr>
					<td class="pathcell">
			<block name="filter_module" no><a href="main.php?content={get.content}&module={module.table_name}" class="path">{module.title}</a> → </block name="filter_module" no><loop name="path"><a href="main.php?content={get.content}&module={module.table_name}&page=list&id={path.id}" class="path">{path.title} ({path.id})</a> → </loop name="path">                             <block name="data.isNew" no>{data.title} ({data.id})<block name="data.lng_saved" no> <img src="images/not_saved_.gif" alt="" style="vertical-align:middle;" /></block name="data.lng_saved" no></block name="data.isNew" no><block name="data.isNew">{phrases.catalog.new_element}</block name="data.isNew">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	
	<block name="nomorecategories" no>
	<block name="module.forbid_delete" no>
	
	<tr>
		<td colspan="3">
	<block name="is_category">
	<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id=0&parent_id={data.parent_id}&ce=1&new=1" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.catalog.new_element}</a>
	</block name="is_category">
	<block name="is_category" no>
	<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id=0&parent_id={data.parent_id}&ce=0&new=1" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.catalog.new_element}</a>	
	</block name="is_category" no>
	
	<block name="data.isNew" no>
	&nbsp;&nbsp;&nbsp;<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}edit&id=0&parent_id={data.parent_id}&ce={data.is_category}&new=1&duplicate={data.id}" class="path"><img src="images/duplicate.gif" border="0" align="absmiddle">&nbsp;&nbsp;{phrases.common.duplicate_title}</a>
	&nbsp;&nbsp;&nbsp;<a href="javascript: if(confirm('{phrases.common.delete_confirm}')){ window.location = 'main.php?content={get.content}&module={module.table_name}&page={filter_page}list&action=delete&deleteid={data.id}&id={data.parent_id}'; }"><img src="images/delete.gif" border="0" align="absmiddle">&nbsp;&nbsp;{phrases.common.delete_title}</a>
	</block name="data.isNew" no>
	
		</td>
	</tr>
	</block name="module.forbid_delete" no>
	
	<tr>
		<td colspan="3">
					
	
				{form}

			
		</td>
	</tr>
	
	<block name="data.isNew" no>
	<tr>
		<td colspan="3" style="background-color:#EFEFEF;border:1px solid #CCCCCC;">
		
		{phrases.common.created}: {data.create_date} ({data.create_by_ip})
		<block name="record_author_create.id">{record_author_create.id} - {record_author_create.title} ({record_author_create.module_title})</block name="record_author_create.id">
		<block name="record_author_create.id" no> - {phrases.common.anonymous_record_author}</block name="record_author_create.id" no>
		<br>
		{phrases.common.modificated}: {data.last_modif_date} ({data.last_modif_by_ip})
		<block name="record_author_modify.id">{record_author_modify.id} - {record_author_modify.title} ({record_author_modify.module_title})</block name="record_author_modify.id">
		<block name="record_author_modify.id" no>{phrases.common.anonymous_record_author}</block name="record_author_modify.id" no>
		
		</td>
	</tr>
	</block name="data.isNew" no>
	</block name="nomorecategories" no>
	
	<block name="nomorecategories">
	<tr>
	<td>
	{phrases.pages.max_level_text}
	</td>
	</tr>
	</block name="nomorecategories">
	
	
</table>

<block name="tree_reload">
<script type="text/javascript" language="javascript">
top.modules.TreeObj_{module.table_name}_s.create({data.id});
</script>
</block name="tree_reload">