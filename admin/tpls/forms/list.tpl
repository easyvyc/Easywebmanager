<div id="id_{form_settings.id}_{elm.name}" class="formElementsField" {block elm.extra_block_style}style="{elm.extra_block_style}"{-block elm.extra_block_style}>
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
                <a class="new_listing" href="javascript: void($NAV.open_dialog('{elm.list_values.module}_{elm.list_values.column}_{frm_list_CID}', '?module={elm.list_values.module}&method=create_from_listing&column={elm.list_values.column}&cid={frm_list_CID}&area=id_frm_list_area_{elm.name}&no_tree_reload=1&json=0', '{phrases.main.catalog.new_element}'));"><img src="admin/images/actions/new.gif"> {phrases.main.catalog.new_element}</a>
		{block elm.show_error}<br><span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e frm_list" id="id_frm_list_area_{elm.name}">

            

	</div>

</div>
<script>

$NAV.get('?module={elm.list_values.module}&method={block elm.list_values.method}{elm.list_values.method}{-block elm.list_values.method}{block elm.list_values.method no}listing{-block elm.list_values.method no}&column={elm.list_values.column}&cid={frm_list_CID}&area=id_frm_list_area_{elm.name}&no_tree_reload=1');

</script>