<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" <?php echo TPL::getVar("elm.extra_params"); ?>>
	<div class="t">
	</div>
	<div class="e">

		<?php if(TPL::getVar("elm.captcha")){ ?>
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><br><?php } ?>
		<input type="text" name="<?php echo TPL::getVar("elm.name"); ?>" class="fo_text vam" style="width:50px;" />
		<img src="securimage_show.php" alt="" class="vam" />
		<br />
		<?php } ?>


		<input type="submit" id="ELMID_<?php echo TPL::getVar("elm.column_name"); ?>" value="<?php echo TPL::getVar("elm.title"); ?>" class="<?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.type"); ?>">
	</div>
</div>	
