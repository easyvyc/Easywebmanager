<div id="id_{elm.name}" class="formElementsField" {block elm.extra_block_style}style="{elm.extra_block_style}"{-block elm.extra_block_style}>
	<div class="e">
		<input type='text' rel="{elm.title}" id="input_{elm.name}" name='{elm.name}' value='{elm.value}' class='{style}_{elm.elm_type} vam {elm.style}' {block elm.readonly}readonly{-block elm.readonly} {elm.extra_params} >
		{block elm.required_field}*{-block elm.required_field} 
		
		<script type="text/javascript">
		if($('#input_{elm.name}').val()==''){ 
			$('#input_{elm.name}').val($('#input_{elm.name}').attr('rel'));
			$('#input_{elm.name}').focus(function(){
				if($('#input_{elm.name}').val()==$('#input_{elm.name}').attr('rel')){
					$('#input_{elm.name}').val('');
				}
			});
			$('#input_{elm.name}').blur(function(){
				if($('#input_{elm.name}').val()==''){
					$('#input_{elm.name}').val($('#input_{elm.name}').attr('rel'));
				}
			})
		}
		</script>
		
	</div>
</div>
