<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<block name="filter_module" no><a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}list&id=0" class="path">{module.title}</a> → </block name="filter_module" no><loop name="path"><a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}list&id={path.id}" class="path">{path.title} ({path.id})</a> → </loop name="path">                             <block name="data.isNew" no>{data.title} <block name="data.id">({data.id})</block name="data.id"></block name="data.isNew" no>
			</td>
			
		</tr>
	</table>
</div>