<block name="success" no>

<div id="translate_form_area" style="padding:5px;background:#AAA;">
<p style="color:#FFF;margin:5px;font-weight:bold;">{phrases.catalog.language_translate_text}</p>
{translate_form}
</div>

<block name="post.translate" no>
<div id="edit_form_area">
{form}
</div>
</block name="post.translate" no>

<block name="post.translate">
<script type="text/javascript">
parent.PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/translate&content={get.content}&module={module.table_name}&id={data.id}&lng_from={post.lng_from}&lng_to={post.lng_to}<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'translate', 1);
</script>
</block name="post.translate">

<block name="get.filters">
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">

</block name="success" no>

<block name="success">
<script type="text/javascript">
parent.closeLoading();
parent.document.getElementById('edit_form_area').innerHTML = '<p>{phrases.catalog.translate_success}</p>';
</script>
<block name="get.filters">
<script type="text/javascript">
parent.parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (parent.document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">

</block name="success">