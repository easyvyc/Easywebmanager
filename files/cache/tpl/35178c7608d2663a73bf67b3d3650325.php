<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
			
	</div>
	<div class="e">
	
		<input type='password' name='<?php echo TPL::getVar("elm.name"); ?>_1' value="" class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' autocomplete="off" /><br />
	
	</div>
	<div class="t">
	
		<span class="">Pakartokite slaptažodį:</span>
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
			
	</div>
	<div class="e">
	
		<input type='password' name='<?php echo TPL::getVar("elm.name"); ?>_2' value="" class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' autocomplete="off" />
	
	</div>
</div>
