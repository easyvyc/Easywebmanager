<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}" {elm.extra_params}>
	<label>{elm.title}:{block elm.required}*{-block elm.required}</label>
	
	{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	
	<br />
        
        <div id="product_modif_list_options_area" style="max-height:300px;overflow:auto;">

            {product_modif_options_list}
            
        </div>
	
	<div style="clear:left;"></div>
	
</div>
<script>
$(document).ready(function(){
    $('#ELMID_title').change(function(){
        $NAV.get('?module=products_modifications_options&method=load_form_list&modif_id=' + $(this).val() + '&ajax=1&json=1&no_tree_reload=1');
    });
});
</script>