<block name="back2edit">
<script type="text/javascript">
PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={get.module}&id={get.id}<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'edit')
</script>
</block name="back2edit">


<block name="confirm">
<br />
<b>{phrases.catalog.confirm_delete}</b><br /><br />

{form}

<!--
<input type="button" class="fo_submit" value="{phrases.catalog.confirm_delete_yes}" onclick="javascript: PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/delete&content={get.content}&module={get.module}&id={get.id}&confirm=1<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'delete');" />
<input type="button" class="fo_submit" value="{phrases.catalog.confirm_delete_no_and_back}" onclick="javascript: PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={get.module}&id={get.id}<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'edit');" />
-->
</block name="confirm">


<block name="success">
<br />
<b>{phrases.catalog.delete_done}</b>
</block name="success">


<block name="done">

<br />
<b>{phrases.catalog.delete_done}</b><br /><br />
<block name="reset_access">
<!--input type="button" class="fo_submit" value="{phrases.catalog.confirm_reset}" onclick="javascript: PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/delete&content={get.content}&module={get.module}&id={get.id}&reset=1<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'delete')" /-->
</block name="reset_access">
<script type="text/javascript">
<block name="module.maxlevel">
<block name="get.filters" no>
if(top.modules.TreeObj_{get.module}_s) top.modules.TreeObj_{get.module}_s.create({item_data.parent_id});
</block name="get.filters" no>
//if(parent.$('__new')) parent.$('__new').style.display = 'none';
</block name="module.maxlevel">
//if(parent.$('__edit')) parent.$('__edit').style.display = 'none';
//if(parent.$('__module')) parent.$('__module').style.display = 'none';
<block name="module.maxlevel">
//if(parent.$('__import')) parent.$('__import').style.display = 'none';
</block name="module.maxlevel">
parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={get.module}&page=<block name="get.filters">filters</block name="get.filters"><block name="get.filters" no>list</block name="get.filters" no>&id={item_data.parent_id}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'items_list_grid');
parent.PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/delete&content={get.content}&module={get.module}&id={get.id}&filters={get.filters}&confirm=1', 'EDIT_area__action', 'delete');
</script>
</block name="done">

<block name="reset">
<script type="text/javascript">
<block name="module.maxlevel">
<block name="get.filters" no>
if(top.modules.TreeObj_{get.module}_s) top.modules.TreeObj_{get.module}_s.create({get.id});
</block name="get.filters" no>
</block name="module.maxlevel">
parent.PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={get.module}&id={get.id}<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'EDIT_area__action', 'edit')
//if($('__new')) $('__new').style.display = 'block';
//if($('__edit')) $('__edit').style.display = 'block';
//if($('__module')) $('__module').style.display = 'block';
//if($('__import')) $('__import').style.display = 'block';
parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={get.module}&page=<block name="get.filters">filters</block name="get.filters"><block name="get.filters" no>list</block name="get.filters" no>&id={get.id}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', 'items_list_grid');
</script>
</block name="reset">

<block name="get.filters">
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">