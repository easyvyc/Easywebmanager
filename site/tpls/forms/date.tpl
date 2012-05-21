<div id="id_{elm.name}" class="formElementsField">
	<div class="t">
		{block elm.show_error}<br>{-block elm.show_error}
		<span class="{elm.style}">{elm.title}:{block elm.required_field}*{-block elm.required_field}</span>&nbsp;
	
	</div>
	<div class="e">
	
		{block elm.show_error}<span class="error_message">{elm.error_message}</span><br>{-block elm.show_error}

		<input type='text' id='{elm.name}' name='{elm.name}' value='{elm.value}' class='{style}_{elm.elm_type}' style="width:150px;" readonly {block elm.editorship}style="cursor:pointer;"{-block elm.editorship}>
	
		{block elm.editorship}
		<script type="text/javascript"> 
		$("#frm_{elm.name}").datepicker({
			changeMonth: true,
			changeYear: true
		});
		</script>
		{-block elm.editorship}
	
	
	</div>
</div>
