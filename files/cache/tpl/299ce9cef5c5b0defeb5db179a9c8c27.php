<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
            <span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>&nbsp;
            <?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">

		<input type='text' id="ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" name='<?php echo TPL::getVar("elm.name"); ?>_date' value='<?php echo TPL::getVar("elm.value"); ?>' class='FRM vam <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' style="width:150px;" readonly <?php if(TPL::getVar("elm.editable")){ ?>style="cursor:pointer;"<?php } ?> />

		<?php if(TPL::getVar("elm.list_values.time")){ ?>
		&nbsp;
		<input type='text' id="ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour" name='<?php echo TPL::getVar("elm.name"); ?>_hour' value='<?php echo TPL::getVar("elm.hour"); ?>' class='FRM vam <?php echo TPL::getVar("style"); ?>_text' style="width:20px;" readonly />
		<div id="slider_<?php echo TPL::getVar("elm.name"); ?>_hour" class="hide" style="position:absolute;left:190px;top:-30px;z-index:2;"></div>
		:
		<input type='text' id="ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min" name='<?php echo TPL::getVar("elm.name"); ?>_min' value='<?php echo TPL::getVar("elm.min"); ?>' class='FRM vam <?php echo TPL::getVar("style"); ?>_text' style="width:20px;" readonly />
		<div id="slider_<?php echo TPL::getVar("elm.name"); ?>_min" class="hide" style="position:absolute;left:230px;top:-30px;z-index:2;"></div>
		<?php } ?>

<?php if(TPL::getVar("elm.editable")){ ?>
<script type="text/javascript">
$(function() {
$('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>').datepicker({ firstDay:1, altFormat:'yy-mm-dd', changeMonth:true, changeYear:true, showOtherMonths: true, selectOtherMonths: true , dateFormat:'yy-mm-dd'<?php if(TPL::getVar("elm.extra_params")){ ?>, <?php echo TPL::getVar("elm.extra_params"); ?><?php } ?> });
});

<?php if(TPL::getVar("elm.list_values.time")){ ?>

$('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour').focus(function(){ $("#slider_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour").show(); });
$('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour').click(function(){ $("#slider_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour").show(); });
$("#slider_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour").slider({ <?php if(TPL::getVar("elm.hour")){ ?>value:<?php echo TPL::getVar("elm.hour"); ?>, <?php } ?> min:0, max: 24, orientation: 'vertical', stop: function(event, ui){ $("#slider_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour").hide(); }, slide: function(event, ui) { $('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour').val(ui.value); } });

$('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min').focus(function(){ $("#slider_<?php echo TPL::getVar("elm.name"); ?>_min").show(); });
$('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min').click(function(){ $("#slider_<?php echo TPL::getVar("elm.name"); ?>_min").show(); });
$("#slider_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min").slider({ <?php if(TPL::getVar("elm.hour")){ ?>value:<?php echo TPL::getVar("elm.hour"); ?>, <?php } ?> min:0, max: 60, orientation: 'vertical', stop: function(event, ui){ $("#slider_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min").hide(); }, slide: function(event, ui) { $('#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min').val(ui.value); } });


$("#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_hour").change(function(){ if(!checkDateTimeVal($(this).val(), 0,24)) $(this).val('12'); });
$("#ELMID_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_min").change(function(){ if(!checkDateTimeVal($(this).val(), 0, 60)) $(this).val('00'); });
<?php } ?>

</script>
<?php } ?>

	</div>
</div>
