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
				{phrases.settings.modules_title}
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>
	
	<tr>
		<td height="30" valign="middle"><a href="main.php?content={get.content}&page=edit_module&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.settings.module.new_module}</a></td>
	</tr>
		
	<block name="empty" no>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	
	<tr class="tblheader">
		<td nowrap width="5%">{phrases.common.edit_title}</td>
		<td nowrap>{phrases.settings.module.title}</td>
		
		<block name="super_admin">
		<td nowrap width="5%">{phrases.settings.module.multilng}</td>
		<td nowrap width="5%">{phrases.settings.module.admin_catalog}</td>
		<td nowrap width="5%">{phrases.settings.module.catalog}</td>
		<td nowrap width="5%">{phrases.settings.module.mod_page}</td>
		<td nowrap width="5%">{phrases.settings.module.search}</td>
		<td nowrap width="5%">{phrases.settings.module.cache}</td>
		<td nowrap width="5%">{phrases.settings.module.no_delete}</td>
		</block name="super_admin">
		
		<td nowrap width="5%">{phrases.settings.module.no_sort}</td>
		<td nowrap width="5%">{phrases.settings.module.no_filter}</td>
		<td nowrap width="5%">{phrases.settings.module.rss}</td>
		
		<block name="super_admin">
		<td nowrap width="5%">{phrases.settings.module.disabled}</td>
		<td nowrap width="5%">{phrases.settings.module.no_rec}</td>
		</block name="super_admin">
		
		<td nowrap width="5%" align="center">{phrases.common.sort_title}</td>
		<td nowrap width="5%" align="center">{phrases.common.delete_title}</td>
	</tr>	
	
	<loop name="items">
	<tr class="tblcontent" id="row{items.id}" onmouseover="javascript: change_row_color(overRowColor,{items.id});" onmouseout="javascript: change_row_color(outRowColor,{items.id});">
		
		<td align="center">
			<a href="main.php?content={get.content}&page=edit_module&id={items.id}"><img src="images/edit.gif" border="0"></a>
			<a href="main.php?content={get.content}&page=column_list&id={items.id}"><img src="images/inner.gif" border="0"></a>
		</td>
		<td onclick="javascript: window.location='main.php?content={get.content}&page=column_list&id={items.id}';" style="cursor:pointer;">{items.title}({items.table_name})</td>
		
		<block name="super_admin">
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=admin_catalog"><img src="images/status_{items.admin_catalog}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=multilng"><img src="images/status_{items.multilng}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=tree"><img src="images/status_{items.tree}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=mod_pages"><img src="images/status_{items.mod_pages}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=search"><img src="images/status_{items.search}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=cache"><img src="images/status_{items.cache}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=forbid_delete"><img src="images/status_{items.forbid_delete}.gif" border="0"></a></td>
		</block name="super_admin">
		
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=forbid_sort"><img src="images/status_{items.forbid_sort}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=forbid_filter"><img src="images/status_{items.forbid_filter}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=rss"><img src="images/status_{items.rss}.gif" border="0"></a></td>
		
		<block name="super_admin">
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=disabled"><img src="images/status_{items.disabled}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content={get.content}&page=modules&id={items.id}&action=no_record_table"><img src="images/status_{items.no_record_table}.gif" border="0"></a></td>
		</block name="super_admin">
		
		<td align="center" onclick="javascript: change_order({items.id}, 0, '{get.content}', '', 'modules');"><img src="images/sort.gif" border="0"></td>
		<td align="center"><a href="javascript: if(confirm('{phrases.settings.module.delete_confirm}')){ window.location = 'main.php?content={get.content}&page=modules&action=delete&id={items.id}'; }"><img src="images/delete.gif" border="0"></a></td>
		
	</tr>
	</loop name="items">	
	
	
	</table>
		</td>
	</tr>
	</block name="empty" no>

	<block name="empty">
	<tr>
		<td height="30" valign="middle">{phrases.common.empty_items}</td>
	</tr>	
	</block name="empty">
</table>

<block name="refresh_tree">
<script language="javascript">
parent.frames.modules.createTree_catalog('{lng}', 0); //location.reload();
</script>
</block name="refresh_tree">