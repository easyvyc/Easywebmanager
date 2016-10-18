<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_chk_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" <?php echo TPL::getVar("elm.extra_params"); ?>>
	<div class="e">
                <label>
		<input type='checkbox' name='chk_<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" value='1' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?> vam' <?php if(TPL::getVar("elm.value")){ ?>checked<?php } ?> <?php echo TPL::getVar("elm.field_extra_params"); ?> />
		<span class=""><?php echo TPL::getVar("elm.title"); ?></span></label><?php if(TPL::getVar("elm.required")){ ?>*<?php } ?>
                <input type="hidden" id="ELMID_value_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" name="<?php echo TPL::getVar("elm.name"); ?>" value="<?php echo TPL::getVar("elm.value"); ?>">
	</div>
</div>
<script>
    $(document).ready(function(){
        $('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>').live('change', function(){
            $('#ELMID_value_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>').val($(this).is(':checked') ? $(this).val() : '');
        });
    });
</script>
