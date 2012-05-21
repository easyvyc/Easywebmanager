<block name="success" no>
<block name="show_import_data">	
<div id="import_data_area">

<b>{phrases.main.catalog.import_data_example}</b>
<table border="0" cellpadding="2" cellspacing="2" width="100%" style="border-collapse:collapse;">
	<tr class="tblheader">
		<loop name="columns">
		<td class="tbltop" title="{columns.title}">{columns.short}</td>
		</loop name="columns">
	</tr>
		
		<loop name="items">
		<tr class="tblcontent" id="row{items._INDEX}">
		<loop name="columns">
		<td>{items.{columns.name}}</td>
		</loop name="columns">
		</tr>
		</loop name="items">
		
	
</table>
<b>{phrases.main.catalog.import_data_items_count}: {all_items_count}</b>
</div>
</block name="show_import_data">


	
				{form}


</block name="success" no>

<block name="success">
<div id="success_area">
{phrases.main.catalog.import_success}
</div>
<script type="text/javascript">
if(parent.document.getElementById('formContent_{form_name}')) parent.document.getElementById('formContent_{form_name}').innerHTML = document.getElementById('success_area').innerHTML;
parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={get.id}&ajax=1&area=tpl_grid', 'items_list_grid');
top.modules.TreeObj_{module.table_name}_s.create({get.id});
</script>
</block name="success">