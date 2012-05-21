<div id="id_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}{block elm.required}*{-block elm.required}</span>
		<span class="mini">{phrases.autocomplete_field_text}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		
		<div id="autocomplete_{elm.name}">
		{loop list}
		<div id="autocomplete_{elm.name}_{list.id}" class="autocomplete_values">
			<a href="javascript: void(delete_autocomplete('{elm.name}', {list.id}));" class="close">x</a>
			<a href="javascript: void(showAjaxDialog('ajax.php?content=call&module={elm.list_values.module}&method=viewItem&params[id]={list.id}'));">{list.title}</a>
		</div>
		{-loop list}
		</div>
		
		<input type='text' id="auto_text_{elm.column_name}" value='' class='{style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no} {elm.extra_params} />
		
		{block elm.list_values.create_new}
		<a class="dotted" href="javascript: void(showAjaxDialog('ajax.php?content=call&module={elm.list_values.module}&method=showAutocompleteForm&params[id]=0&params[module]={form_data.module}&params[column]={elm.column_name}'));">[new]</a>
		{-block elm.list_values.create_new}
		
		<script type="text/javascript">
		
			$("#auto_text_{elm.column_name}").autocomplete({
				source: "ajax.php?content=autocomplete&module={elm.list_values.module}&column={elm.list_values.columns}&left=1&right=1",
				select: function(event, ui) {
					add_autocomplete('{elm.list_values.module}', '{elm.name}', ui.item.title, ui.item.id, '{elm.list_values.multiple}');
					{block elm.list_values.func}
					{elm.list_values.func}(ui.item);
					{-block elm.list_values.func}
				},
				delay: 1000,
				minLength: 2,
				close: function(event, ui) {
					$('#auto_text_{elm.column_name}').val('');
				}
			});
		
		</script>		
		
		<input type="hidden" id="ELMID_{elm.name}" name='{elm.name}' value="{elm.value}" />
		
		{elm.extra_data}
		
	</div>	
</div>
