<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			
			{menu}
			
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;" colspan="3">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
				<tr>
					<td class="pathcell">
			<a href="main.php?content={get.content}&page=list" class="path">{module.title}</a> → 
			<loop name="path">{path.title} → </loop name="path"> {data.title}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	

	
	<tr>
		<td colspan="3">
	
	<a href="javascript: if(confirm('{phrases.trash.reset_confirm}')){ $('show_trash_item_main').style.display='none'; PageClass.getPageContent('{config.admin_site_url}main.php?content=trash&page=list&action=reset&resetid={data.id}&ajax=1&area=tpl_grid', 'items_list_grid'); }"><img src="images/reset.gif" border="0" align="absmiddle">&nbsp;&nbsp;{phrases.trash.reset_title}</a>
	&nbsp;&nbsp;&nbsp;
	<a href="javascript: if(confirm('{phrases.trash.delete_confirm}')){ $('show_trash_item_main').style.display='none'; PageClass.getPageContent('{config.admin_site_url}main.php?content=trash&page=list&action=delete&deleteid={data.id}&ajax=1&area=tpl_grid', 'items_list_grid'); }"><img src="images/delete.gif" border="0" align="absmiddle">&nbsp;&nbsp;{phrases.trash.delete_title}</a>
	
		</td>
	</tr>
	
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
	
	
</table>