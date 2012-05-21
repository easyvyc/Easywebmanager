<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			{menu}
		</td>
	</tr>
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=editor_css_edit&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.settings.new_css_style}</a></td>
	</tr>
		
	<block name="empty" no>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr class="tblheader">
		<td width="5%">{phrases.common.edit_title}</td>
		<td nowrap>{phrases.common.title_title}</td>
		<td nowrap width="5%" align="center">{phrases.common.delete_title}</td>
	</tr>	
	
	<loop name="items">
	<tr class="tblcontent" id="row{items.id}">
		<td align="center"><a href="main.php?content=settings&page=editor_css_edit&id={items.id}"><img src="images/edit.gif" border="0"></a></td>
		<td onclick="javascript: window.location='main.php?content=settings&page=editor_css_edit&id={items.id}';" style="cursor:pointer;">{items.title}</td>
		<td align="center"><a href="javascript: if(confirm('{phrases.common.delete_confirm}')){ window.location = 'main.php?content=settings&page=editor_css_list&action=delete&id={items.id}'; }"><img src="images/delete.gif" border="0"></a></td>
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