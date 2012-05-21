<div class="stat_content" id="last_visitors" style="display:block">
<table border="0" cellpadding="2" cellspacing="2" width="100%" style="border-collapse:collapse;">
	<tr class="tblheader">
		<td nowrap>URL</td>
		<td nowrap>Laikas</td>
	</tr>
	<loop name="list">
	<tr class="tblcontent" id="row{list._INDEX}" onmouseover="javascript: change_row_color(overRowColor,{list._INDEX});" onmouseout="javascript: change_row_color(outRowColor,{list._INDEX});">
		<td>{list.url}</td>
		<td>{list.visit_time}</td>
	</tr>
	</loop name="list">
</table>
</div>