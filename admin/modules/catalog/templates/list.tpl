<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	<tr>
		<td>

<block name="filter_module" no>
<block name="main_menu_block">
{main_menu}
<br />
</block name="main_menu_block">

{path}
</block name="filter_module" no>

<div style="width:100%;">
		
	<div class="modulesMain" id="secondlist" style="width:100%;">
	



		<!--div class="block_title" ondblclick="javascript: switchMode('categories_list');">
		<table width="100%" cellpadding="0" cellspacing="4" border="0">
			<tr>
				<td>
			&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('categories_list');"><b>{phrases.catalog.categories_list}</b></a> <span style="font-weight:normal;"><block name="not_empty_categories">({not_empty_categories})</block name="not_empty_categories"><block name="not_empty_categories" no>({phrases.catalog.empty_categories})</block name="not_empty_categories" no></span> 
				</td>
				<td align="right">
			<a href="javascript: switchMode('categories_list');"><img id="img_categories_list" src="images/minus.gif" border="0" align="absmiddle" vspace="0" hspace="0"></a>&nbsp;
				</td>
			</tr>
		</table>
		</div-->
		
		<div id="categories_list">

	<div style="padding-top:10px;padding-bottom:10px;">
		
		<table class="list_menu" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			
			<block name="module.forbid_delete" no>
			
			<loop name="mod_actions">
			<td id="__{mod_actions.name}">
			<a href="javascript: void(eval('{mod_actions.action}'));" class="path"><img src="images/{mod_actions.img}.gif" border="0" class="vam" /> {mod_actions.title}</a>
			</td>
			<td width="1">&nbsp;</td>
			</loop name="mod_actions">			
	
			</block name="module.forbid_delete" no>
			
			<td width="99%">&nbsp;</td>
			
			</tr>
		</table>
		<div id="EDIT_area__action" class="list_menu_area"></div>
		<div id="close_EDIT_area" class="switch_area" onclick="javascript: togglePannelAnimatedStatus('EDIT_area__action',10,40);" onmouseover="javascript: if($('EDIT_area__action').style.display!='none') this.className='switch_area_close'; else  this.className='switch_area_open';" onmouseout="javascript: this.className='switch_area';"></div>

		<script type="text/javascript">

			var mod_actions = new Array;
			<loop name="mod_actions">
			mod_actions[mod_actions.length] = '{mod_actions.name}';
			if(location.hash=='#{mod_actions.name}'){ PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions&action={mod_actions.name}&content={get.content}&module={module.table_name}&id={get.id}<block name="filter_module">&filters={get.filters}</block name="filter_module">', 'EDIT_area__action', '{mod_actions.name}'); }
			</loop name="mod_actions">

		</script>

		
	</div>

		

<block name="no">
	<div style="padding-top:10px;padding-bottom:10px;" id="LIST_menu">
		
		<table class="list_menu" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			
			<block name="module.forbid_delete" no>
			
			
			<td id="__newinner">
			<a href="javascript: void(PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={module.table_name}&id=0&parent_id={parent_id}&new=1', 'LIST_area__action', 'newinner'));" class="path"><img src="images/new_element.gif" border="0" class="vam" /> {phrases.catalog.new_element}</a>
			</td>

			<!--td id="__list">
			<a href="javascript: void(PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/list&content={get.content}&module={module.table_name}&id={parent_id}&parent_id={parent_id}', 'LIST_area__action', 'list'));" class="path"><img src="images/inner.gif" border="0" class="vam" /> {phrases.catalog.elements_list}</a>
			</td-->

			<block name="import_from_zip">
			<td id="__zip">
			<a href="main.php?content={get.content}&module={module.table_name}&page={filter_page}zip&id={parent_id}" class="path"><img src="images/zip.gif" border="0" class="vam" /> {phrases.catalog.import_zip}</a>
			</td>
			</block name="import_from_zip">
		
			<td id="__import">
			<a href="javascript: void(PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/import&content={get.content}&module={module.table_name}&id={parent_id}', 'LIST_area__action', 'import'));" class="path"><img src="images/import.gif" border="0" class="vam" /> {phrases.catalog.import}</a>
			</td>
	
			<block name="items_count">
			<td id="__export">
			<a href="javascript: void(PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/export&content={get.content}&module={module.table_name}&id={parent_id}', 'LIST_area__action', 'export'));" class="path"><img src="images/export.gif" border="0" class="vam" /> {phrases.catalog.export}</a>
			</td>
			
			<td id="__pdf">
			<a href="javascript: void(PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/pdf&content={get.content}&module={module.table_name}&id={parent_id}', 'LIST_area__action', 'pdf'));" class="path"><img src="images/pdf.gif" border="0" class="vam" /> {phrases.catalog.pdf_print}</a>
			</td>
			
			<td id="__search">
			<a href="" class="path"><img src="images/preview.gif" border="0" alt="" class="vam" /> {phrases.catalog.search}</a>
			</td>
			</block name="items_count">
	
			</block name="module.forbid_delete" no>
			
			<td width="99%">&nbsp;</td>
			
			</tr>
		</table>
		
		<div id="LIST_area__action" class="list_menu_area"></div>
		<div id="close_LIST_area" class="switch_area_close" onclick="javascript: togglePannelAnimatedStatus('LIST_area__action',10,40);"></div>


		<!--script type="text/javascript">
			if(location.hash=='#new_inner') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/edit&content={get.content}&module={module.table_name}&id=0&parent_id={parent_id}&new=1', 'LIST_area__action', 'new');
			//if(location.hash=='#new_inner') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/edit&content={get.content}&module={module.table_name}&id=0&parent_id={parent_id}&new=1', 'LIST_area__action', 'list');
			if(location.hash=='#zip') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/edit&content={get.content}&module={module.table_name}&id=0&parent_id={parent_id}&new=1', 'LIST_area__action', 'zip');
			if(location.hash=='#import') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/import&content={get.content}&module={module.table_name}&id={parent_id}', 'LIST_area__action', 'import');
			if(location.hash=='#export') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/export&content={get.content}&module={module.table_name}&id={parent_id}', 'LIST_area__action', 'export');
			if(location.hash=='#pdf') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/pdf&content={get.content}&module={module.table_name}&id={parent_id}', 'LIST_area__action', 'pdf');
			if(location.hash=='#search') PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/edit&content={get.content}&module={module.table_name}&id=0&parent_id={parent_id}&new=1', 'LIST_area__action', 'edit');
		</script-->


		
	</div>	
</block name="no">


<block name="nomorefolders">
	<div id="items_list_grid">
		
		{items_list_content}
	
	</div>
</block name="nomorefolders">
	
	
	</div>




	</div>
	
</div>

		</td>
	</tr>
</table>


<block name="filter_module">
<script type="text/javascript">
parent.document.getElementById('list_iframe_{filter_arr.get_column_name.value}').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="filter_module">

<block name="filters_reload">
<script type="text/javascript">
window.opener.parent.frames.modules.reloadSelect('{lng}', '{filters.column_name}'); //location.reload();
</script>
</block name="filters_reload">

<block name="tree_reload">
<script type="text/javascript">
//parent.frames.modules.createTree_{module.table_name}('{lng}', {parent_id}); //location.reload();
parent.modules.parent.modules.TreeObj_{module.table_name}_s.create({parent_id});
</script>
</block name="tree_reload">