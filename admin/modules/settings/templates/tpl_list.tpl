<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			{menu}
		</td>
	</tr>
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=template&tpl_id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> Naujas šablonas</a></td>
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
		<td height="30" valign="middle">Įrašų nėra.</td>
	</tr>	
	</block name="empty">
</table>