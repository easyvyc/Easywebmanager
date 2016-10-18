<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" <?php echo TPL::getVar("elm.extra_params"); ?>>
	<label><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></label>
	
	<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	
	<br />
        
        <div id="product_modif_list_options_area" style="max-height:300px;overflow:auto;">

            <?php echo TPL::getVar("product_modif_options_list"); ?>
            
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