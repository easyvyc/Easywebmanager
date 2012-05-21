<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" <?php echo TPL::getVar("elm.extra_params"); ?>>
	<div class="e">
		<input type='checkbox' name='<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("elm.name"); ?>" value='1' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?> vam' <?php if(TPL::getVar("elm.value")){ ?>checked<?php } ?> <?php echo TPL::getVar("elm.field_extra_params"); ?> />
		<span class=""><label for="ELMID_<?php echo TPL::getVar("elm.name"); ?>"><?php echo TPL::getVar("elm.title"); ?></label><?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
	</div>
</div>
