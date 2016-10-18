<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
            <span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>&nbsp;
            {block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">

		<input type='text' id="ELMID_{form_settings.id}_{elm.name}" name='{elm.name}_date' value='{elm.value}' class='FRM vam {style}_{elm.elm_type}' style="width:150px;" readonly {block elm.editable}style="cursor:pointer;"{-block elm.editable} />

		{block elm.list_values.time}
		&nbsp;
		<input type='text' id="ELMID_{form_settings.id}_{elm.name}_hour" name='{elm.name}_hour' value='{elm.hour}' class='FRM vam {style}_text' style="width:20px;" readonly />
		<div id="slider_{elm.name}_hour" class="hide" style="position:absolute;left:190px;top:-30px;z-index:2;"></div>
		:
		<input type='text' id="ELMID_{form_settings.id}_{elm.name}_min" name='{elm.name}_min' value='{elm.min}' class='FRM vam {style}_text' style="width:20px;" readonly />
		<div id="slider_{elm.name}_min" class="hide" style="position:absolute;left:230px;top:-30px;z-index:2;"></div>
		{-block elm.list_values.time}

{block elm.editable}
<script type="text/javascript">
$(function() {
$('#ELMID_{form_settings.id}_{elm.name}').datepicker({ firstDay:1, altFormat:'yy-mm-dd', changeMonth:true, changeYear:true, showOtherMonths: true, selectOtherMonths: true , dateFormat:'yy-mm-dd'{block elm.extra_params}, {elm.extra_params}{-block elm.extra_params} });
});

{block elm.list_values.time}

$('#ELMID_{form_settings.id}_{elm.name}_hour').focus(function(){ $("#slider_{form_settings.id}_{elm.name}_hour").show(); });
$('#ELMID_{form_settings.id}_{elm.name}_hour').click(function(){ $("#slider_{form_settings.id}_{elm.name}_hour").show(); });
$("#slider_{form_settings.id}_{elm.name}_hour").slider({ {block elm.hour}value:{elm.hour}, {-block elm.hour} min:0, max: 24, orientation: 'vertical', stop: function(event, ui){ $("#slider_{form_settings.id}_{elm.name}_hour").hide(); }, slide: function(event, ui) { $('#ELMID_{form_settings.id}_{elm.name}_hour').val(ui.value); } });

$('#ELMID_{form_settings.id}_{elm.name}_min').focus(function(){ $("#slider_{elm.name}_min").show(); });
$('#ELMID_{form_settings.id}_{elm.name}_min').click(function(){ $("#slider_{elm.name}_min").show(); });
$("#slider_{form_settings.id}_{elm.name}_min").slider({ {block elm.hour}value:{elm.hour}, {-block elm.hour} min:0, max: 60, orientation: 'vertical', stop: function(event, ui){ $("#slider_{form_settings.id}_{elm.name}_min").hide(); }, slide: function(event, ui) { $('#ELMID_{form_settings.id}_{elm.name}_min').val(ui.value); } });


$("#ELMID_{form_settings.id}_{elm.name}_hour").change(function(){ if(!checkDateTimeVal($(this).val(), 0,24)) $(this).val('12'); });
$("#ELMID_{form_settings.id}_{elm.name}_min").change(function(){ if(!checkDateTimeVal($(this).val(), 0, 60)) $(this).val('00'); });
{-block elm.list_values.time}

</script>
{-block elm.editable}

	</div>
</div>
