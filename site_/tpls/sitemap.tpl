<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td width="266" height="25" class="title_example" style="padding-left:25px;border-left:1px dotted #8C8C8C;border-bottom:1px dotted #8C8C8C;">{phrases.examples}</td>
		<td class="title" style="padding-left:25px;border-left:1px dotted #8C8C8C;border-bottom:1px dotted #8C8C8C;" bgcolor="#F4F4F4">{phrases.sitemap}</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="border-left:1px dotted #8C8C8C;"><img src="images/example1.jpg"></td>
		<td valign="top" style="padding:25px;border-left:1px dotted #8C8C8C;" bgcolor="#F4F4F4">
		
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<loop name="tree_list">
					<tr>
						<td>
						<img src="images/0.gif" height="1" width="{tree_list.level}0" >
				<a href="{tree_list.page_url}" class="sitemap"><block name="tree_list.level" no><b></block name="tree_list.level" no>{tree_list.title}<block name="tree_list.level" no></b></block name="tree_list.level" no></a>
						</td>
					</tr>
				</loop name="tree_list">
				</table>		
		
		</td>
	</tr>
</table>