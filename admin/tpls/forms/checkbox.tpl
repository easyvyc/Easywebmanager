<div id="id_{form_settings.id}_chk_{elm.name}" class="formElementsField {elm.style}" {elm.extra_params}>
	<div class="e">
                <label>
		<input type='checkbox' name='chk_{elm.name}' id="ELMID_{form_settings.id}_{elm.name}" value='1' class='FRM {style}_{elm.elm_type} vam' {block elm.value}checked{-block elm.value} {elm.field_extra_params} />
		<span class="">{elm.title}</span></label>{block elm.required}*{-block elm.required}
                <input type="hidden" id="ELMID_value_{form_settings.id}_{elm.name}" name="{elm.name}" value="{elm.value}">
	</div>
</div>
<script>
    $(document).ready(function(){
        $('#ELMID_{form_settings.id}_{elm.name}').live('change', function(){
            $('#ELMID_value_{form_settings.id}_{elm.name}').val($(this).is(':checked') ? $(this).val() : '');
        });
    });
</script>
