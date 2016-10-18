<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" >
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<block name="elm.required">*</block name="elm.required"></span>
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e" style="height:100%;">
		<textarea class="ckeditor" name="<?php echo TPL::getVar("elm.name"); ?>"><?php echo TPL::getVar("elm.value"); ?></textarea>
	</div>
</div>
<script type="text/javascript">
	CKEDITOR.replace( '<?php echo TPL::getVar("elm.name"); ?>', {
	    toolbar: '<?php if(TPL::getVar("elm.list_values.mode")){ ?><?php echo TPL::getVar("elm.list_values.mode"); ?><?php } ?><?php if(!TPL::getVar("elm.list_values.mode")){ ?>Default<?php } ?>',
	    uiColor: '#BCBCBC'
	});
</script>