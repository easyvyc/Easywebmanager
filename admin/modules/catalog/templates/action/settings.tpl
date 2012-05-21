<block name="success" no>

{form}

<block name="get.filters">
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">

</block name="success" no>

<block name="success">
<script type="text/javascript">
//parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=<block name="get.filters">filters</block name="get.filters"><block name="get.filters" no>list</block name="get.filters" no>&id=<block name="get.filters" no>{data.id}</block name="get.filters" no><block name="get.filters">{data.parent_id}</block name="get.filters">&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'items_list_grid');
parent.PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/settings&content={get.content}&module={get.module}&id={get.id}<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'settings');
</script>
<block name="get.filters">
<script type="text/javascript">
parent.parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (parent.document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">

</block name="success">