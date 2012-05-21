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

<block name="refresh_tree">
<script language="javascript">
parent.frames.modules.TreeObj_catalog_c.create(0); //location.reload();
</script>
</block name="refresh_tree">