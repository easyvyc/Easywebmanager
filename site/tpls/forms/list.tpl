<div id="id_{elm.name}" class="formElementsField" {block elm.extra_block_style}style="{elm.extra_block_style}"{-block elm.extra_block_style}>
	<div class="t">
		<span class="">{elm.title}:{block elm.required_field}*{-block elm.required_field}</span>
		{block elm.show_error}<br><span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e frm_list">

		<div class="lst">
		{loop items}
			<div class="item">
				{loop fields}
				<input type='{fields.elm_type}' alt="{fields.title}" value='{items.{fields.column_name}}' name='{elm.name}[{fields.column_name}][]' class='{style}_{fields.elm_type} vam {elm.style}' />
				{-loop fields}
				<input type="hidden" name="{elm.name}[id][]" value="{items.id}" />
				<input type="hidden" name="{elm.name}[_OK_][]" value="1" class="h" />
			</div>
		
		{-loop items}

			<div class="item">
				{loop fields}
				<input type='text' rel='{fields.elm_type}' alt="{fields.title}" value='' name='{elm.name}[{fields.column_name}][]' class='{style}_{fields.elm_type} vam {elm.style}' />
				{-loop fields}
				<input type="hidden" name="{elm.name}[id][]" value="0" />
				<input type="hidden" name="{elm.name}[_OK_][]" value="0" class="h" />
				<input type="button" class="radius3 btn vam" value="Add" onclick="javascript: _FRM_LIST_ADD('{elm.name}');" />
			</div>
		</div>
		
	</div>

	<div id="{elm.name}_LIST_H" style="display:none;">
	<div class="item">
		{loop fields}
		<input type='text' rel='{fields.elm_type}' alt="{fields.title}" value='' name='{elm.name}[{fields.column_name}][]' class='{style}_{fields.elm_type} vam {elm.style}' />
		{-loop fields}
		<input type="hidden" name="{elm.name}[id][]" value="0" />
		<input type="hidden" name="{elm.name}[_OK_][]" value="0" class="h" />
		<input type="button" class="radius3 btn vam" value="Add" onclick="javascript: _FRM_LIST_ADD('{elm.name}');" />
	</div>
	</div>

</div>

<script type="text/javascript">
$("#id_{elm.name} .frm_list .item input.{style}_date").datepicker({			
	changeMonth: true,
	changeYear: true,
	yearRange: '1990:2020'
});
</script>