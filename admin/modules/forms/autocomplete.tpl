<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}			
			
	</div>
	<div class="e">


		<div id="autocomplete_{elm.name}">
		{loop list}
		<div id="autocomplete_{elm.name}_{list.id}" class="autocomplete_values">
			<a href="javascript: void(delete_autocomplete('{elm.name}', {list.id}));" class="close">x</a>
			<a href="javascript: void();">{list.title}</a>
		</div>
		{-loop list}
		</div>
		
		<input type='text' id="auto_text_{elm.name}" value='' class='{style}_{elm.elm_type}' >

		<script type="text/javascript">

			var autocomplete_obj = new AutoComplete('auto_text_{elm.name}', '{config.site_url}xml.php?get=autocomplete&module={elm.list_values.module}&column={elm.list_values.columns}&left=1&right=1&q=', {
				delay: 0.25,
				onSelect: function(input){ 
					arr = input.value.split("---"); 
					setEdited('{elm.name}');
					add_autocomplete('{elm.list_values.module}', '{elm.name}', arr[0], arr[1], '{elm.multiple}');  
				},
				size: 10,
				cssClass: 'autocomplete_selector',
				resultFormat: AutoComplete.Options.RESULT_FORMAT_JSON
			});

			//autocomplete_obj.show = function(){  };
		
		</script>		
		
		<input type="hidden" id="ELMID_{elm.name}" name='{elm.name}' value="{elm.value}" />
		
		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

		{elm.extra_data}
		
		
	</div>
</div>