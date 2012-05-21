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
		<td height="30" valign="middle"><a href="main.php?content=settings&page=<block name="menu_module">menu_</block name="menu_module">edit_column&module_id={module_id}&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.settings.module.new_column}</a></td>
	</tr>
		
	<block name="empty" no>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr class="tblheader">
		<td width="5%">{phrases.common.edit_title}</td>
		<td nowrap>{phrases.settings.module.column_title}</td>
		<!--td nowrap>Stulpelio vardas</td-->
		<!--td nowrap>Laukelio tipas</td-->
		<td nowrap width="5%">{phrases.settings.module.require}</td>
		<td nowrap width="5%">{phrases.settings.module.list}</td>
		<td nowrap width="5%">{phrases.settings.module.multilng}</td>
		
		<block name="super_admin">
		<td nowrap width="5%">{phrases.settings.module.editable}</td>
		<td nowrap width="5%">{phrases.settings.module.superadmin}</td>
		<td nowrap width="5%">{phrases.settings.module.index}</td>
		</block name="super_admin">
		
		<td nowrap width="5%" align="center">{phrases.common.sort_title}</td>
		<td nowrap width="5%">{phrases.common.delete_title}</td>
	</tr>	
	
	<loop name="items">
	<tr class="tblcontent" id="row{items.id}" onmouseover="javascript: change_row_color(overRowColor,{items.id});" onmouseout="javascript: change_row_color(outRowColor,{items.id});">
		
		<td align="center"><a href="main.php?content=settings&page=edit_column&id={items.id}"><img src="images/edit.gif" border="0"></a></td>
		<td onclick="javascript: window.location='main.php?content=settings&page=edit_column&id={items.id}';" style="cursor:pointer;">{items.title}({items.column_name})</td>
		<!--td onclick="javascript: window.location='main.php?content=settings&page=edit_column&id={items.id}';" style="cursor:pointer;">{items.column_name}</td-->
		<!--td onclick="javascript: window.location='main.php?content=settings&page=edit_column&id={items.id}';" style="cursor:pointer;">{items.elm_type}</td-->
		
		<td align="center"><a href="main.php?content=settings&page=column_list&module_id={items.module_id}&id={items.id}&action=require"><img src="images/status_{items.require}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=settings&page=column_list&module_id={items.module_id}&id={items.id}&action=list"><img src="images/status_{items.list}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=settings&page=column_list&module_id={items.module_id}&id={items.id}&action=multilng"><img src="images/status_{items.multilng}.gif" border="0"></a></td>
		
		<block name="super_admin">
		<td align="center"><a href="main.php?content=settings&page=column_list&module_id={items.module_id}&id={items.id}&action=editorship"><img src="images/status_{items.editorship}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=settings&page=column_list&module_id={items.module_id}&id={items.id}&action=super_user"><img src="images/status_{items.super_user}.gif" border="0"></a></td>
		<td align="center"><a href="main.php?content=settings&page=column_list&module_id={items.module_id}&id={items.id}&action=index"><img src="images/status_{items.index}.gif" border="0"></a></td>
		</block name="super_admin">
		
		<td align="center" onclick="javascript: change_order({items.id}, {items.module_id}, 'settings', '', 'column_list');"><img src="images/sort.gif" border="0"></td>
		<td align="center"><a href="javascript: if(confirm('{phrases.settings.module.delete_column_confirm}')){ window.location = 'main.php?content=settings&page=column_list&action=delete&id={items.id}&module_id={items.module_id}'; }"><img src="images/delete.gif" border="0"></a></td>
		
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