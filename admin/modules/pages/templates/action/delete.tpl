<block name="back2edit">
<script type="text/javascript">
PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={get.module}&id={get.id}', 'EDIT_area__action', 'edit')
</script>
</block name="back2edit">


<block name="confirm">
<br />
<b>{phrases.catalog.confirm_delete}</b><br /><br />
<input type="button" class="fo_submit" value="{phrases.catalog.confirm_delete_yes}" onclick="javascript: PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/delete&content={get.content}&module={get.module}&id={get.id}&confirm=1', 'EDIT_area__action', 'delete');" />
<input type="button" class="fo_submit" value="{phrases.catalog.confirm_delete_no_and_back}" onclick="javascript: PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={get.module}&id={get.id}', 'EDIT_area__action', 'edit');" />
</block name="confirm">

<block name="done">

<br />
<b>{phrases.catalog.delete_done}</b><br /><br />
<input type="button" class="fo_submit" value="{phrases.catalog.confirm_reset}" onclick="javascript: PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/delete&content={get.content}&module={get.module}&id={get.id}&reset=1', 'EDIT_area__action', 'delete')" />
<script type="text/javascript">
top.modules.TreeObj_{get.module}_s.create({item_data.parent_id});
if($('items_list_grid')) $('items_list_grid').style.display = 'none';
if($('LIST_menu')) $('LIST_menu').style.display = 'none';
if($('__new')) $('__new').style.display = 'none';
if($('__edit')) $('__edit').style.display = 'none';
if($('__module')) $('__module').style.display = 'none';
if($('__import')) $('__import').style.display = 'none';
if($('page_screenshot')) $('page_screenshot').style.display = 'none';
</script>
</block name="done">

<block name="reset">
<script type="text/javascript">
top.modules.TreeObj_{get.module}_s.create({get.id});
PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={get.module}&id={get.id}', 'EDIT_area__action', 'edit')
if($('items_list_grid')) $('items_list_grid').style.display = 'block';
if($('LIST_menu')) $('LIST_menu').style.display = 'block';
if($('__new')) $('__new').style.display = 'block';
if($('__edit')) $('__edit').style.display = 'block';
if($('__module')) $('__module').style.display = 'block';
if($('__import')) $('__import').style.display = 'block';
if($('page_screenshot')) $('page_screenshot').style.display = 'block';
</script>
</block name="reset">