<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>&nbsp;
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">
		<input type='text' name='<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("elm.column_name"); ?>" value='<?php echo TPL::getVar("elm.value"); ?>' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(!TPL::getVar("elm.editable")){ ?>readonly<?php } ?> >
	</div>
</div>
