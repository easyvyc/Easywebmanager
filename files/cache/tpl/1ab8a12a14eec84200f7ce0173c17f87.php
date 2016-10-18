<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>&nbsp;
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">
		<textarea name='<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("elm.name"); ?>" class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(!TPL::getVar("elm.editable")){ ?>readonly<?php } ?>><?php echo TPL::getVar("elm.value"); ?></textarea>
		<input type="checkbox" <?php if(!TPL::getVar("elm.editorship")){ ?>checked<?php } ?> value="1" name="generate_<?php echo TPL::getVar("elm.column_name"); ?>" id="gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id" style="vertical-align:middle;" /> <label for="gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id">Auto description</label>
	</div>
</div>

<script type="text/javascript">
$("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>").dblclick(function(){
	$(this).attr('readonly', false);
	$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").attr('checked', false);
});
$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").change(function(){
	bool = $(this).is(':checked');
	pageurl = $("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>");
	if(bool){
		pageurl.attr('readonly', true);
	}else{
		pageurl.attr('readonly', false);
	}
});
<?php if(TPL::getVar("_form_data.generate_description.value")){ ?>
$('#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>').attr('readonly', true);
$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").attr('checked', true);
<?php } ?>
</script>