<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" >
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">
		<div id="ELMID_<?php echo TPL::getVar("elm.name"); ?>_r" class='<?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>_r' <?php echo TPL::getVar("elm.extra_params"); ?>>
		<textarea name='<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("elm.name"); ?>" class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>'><?php echo TPL::getVar("elm.value"); ?></textarea>
		</div>
	</div>
</div>
