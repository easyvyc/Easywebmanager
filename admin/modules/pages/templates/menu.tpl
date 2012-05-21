<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" class="tabMenu">
	<tr>
		
		<loop name="menu">
		<td width="20" class="<block name="menu.active">a</block name="menu.active"><block name="menu.active" no>p</block name="menu.active" no>" align="center">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" height="20">
			<tr>
				<td class="l" width="3"><img src="images/0.gif" width="3" height="1"><td>
				<td class="m">
				<img src="images/{menu.ico}.gif" alt="" class="vam" />
				<a href="{menu.page_url}" class="path" <block name="menu.reload">rel="reload"</block name="menu.reload">>{menu.title}</a>
				</td>
				<td class="r" width="3"><img src="images/0.gif" width="3" height="1"><td>
			<tr>
		</table>
		</td>
		<td width="2" class="p"><img src="images/0.gif" width="1" height="1"></td>
		</loop name="menu">


		<td class="p">
		&nbsp;
		</td>
		
	</tr>
</table>
