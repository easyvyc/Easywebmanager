<block name="success" no>

{form}

<block name="data.isNew" no>
<div class="edit_item_info">

	{phrases.common.created}: {data.create_date} ({data.create_by_ip})
	<block name="record_author_create.id">{record_author_create.id} - {record_author_create.title} ({record_author_create.module_title})</block name="record_author_create.id">
	<block name="record_author_create.id" no> - {phrases.common.anonymous_record_author}</block name="record_author_create.id" no>
	<br />
	{phrases.common.modificated}: {data.last_modif_date} ({data.last_modif_by_ip})
	<block name="record_author_modify.id">{record_author_modify.id} - {record_author_modify.title} ({record_author_modify.module_title})</block name="record_author_modify.id">
	<block name="record_author_modify.id" no>{phrases.common.anonymous_record_author}</block name="record_author_modify.id" no>

</div>
</block name="data.isNew" no>

<block name="get.filters">
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">

</block name="success" no>

<block name="success">
<script type="text/javascript">
<block name="module.maxlevel">
parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=<block name="get.filters">filters</block name="get.filters"><block name="get.filters" no>list</block name="get.filters" no>&id=<block name="get.filters" no>{data.id}</block name="get.filters" no><block name="get.filters">{data.parent_id}</block name="get.filters">&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'items_list_grid');
<block name="get.filters" no>
if(top.modules.TreeObj_{module.table_name}_s) top.modules.TreeObj_{module.table_name}_s.create({data.id});
</block name="get.filters" no>
</block name="module.maxlevel">
<block name="data.isNew">
parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=<block name="get.filters">filters</block name="get.filters"><block name="get.filters" no>list</block name="get.filters" no>&id=<block name="get.filters" no>{data.parent_id}</block name="get.filters" no><block name="get.filters">{data.parent_id}</block name="get.filters">&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'items_list_grid');
parent.document.getElementById('formContent_{form_name}').innerHTML = '<p>{phrases.catalog.item_add_success}&nbsp;&nbsp;<a href="main.php?content={get.content}&module={module.table_name}&page=list&id={data.id}#edit"><img src="images/edit.gif" border="0" class="vam" alt="" /> {phrases.catalog.edit_element}</a></p>';
</block name="data.isNew">
<block name="data.isNew" no>
parent.PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/module&content={get.content}&module={module.table_name}&id={data.id}<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'edit');
</block name="data.isNew" no>
</script>
<block name="get.filters">
<script type="text/javascript">
parent.parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (parent.document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">

</block name="success">