<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
                {block elm.value}
                <a href="{config.site_url}{site_lng}{elm.value}" target="_blank">Open Link</a>
                {-block elm.value}
	</div>
	<div class="e">
            
		<span class='{style}_{elm.elm_type}' style="padding-right:0px;overflow:hidden;">
                    <span class="FRM_input_text" style="padding-right:0px;border-right:none;vertical-align:middle;display:inline-block;width:auto;white-space:nowrap;">{config.site_url}{site_lng}</span><span id="ELMID_{elm.column_name}_editable" class="editable FRM_input_text" style="padding-left:0px;border-left:none;max-width:500px;overflow:hidden;vertical-align:middle;display:inline-block;width:auto;white-space:nowrap;">{elm.value}</span>
                    <input type='hidden' name='{elm.name}' id="ELMID_{elm.column_name}" value='{elm.value}' class='FRM {style}_{elm.elm_type}' style="border:none;margin-top:-3px;margin-right:-3px;" {block elm.editable no}readonly{-block elm.editable no} >
                </span>
                
		<input type="checkbox" {block elm.editorship no}checked{-block elm.editorship no} value="1" name="generate_url" id="gen_{elm.column_name}_auto_id" style="vertical-align:middle;" /> <label for="gen_{elm.column_name}_auto_id">Auto URL</label>
                
	</div>
</div>

<script type="text/javascript">
    
$("#ELMID_{elm.column_name}_editable").dblclick(function(){
	$("#gen_{elm.column_name}_auto_id").attr('checked', false);
        pageurl = $("#ELMID_{elm.column_name}_editable");
        pageurl.attr('contenteditable', true);
        pageurl.css({ background: '#FFF'});
});

$("#gen_{elm.column_name}_auto_id").change(function(){
	bool = $(this).is(':checked');
	pageurl = $("#ELMID_{elm.column_name}_editable");
	if(bool){
		pageurl.attr('contenteditable', false);
                pageurl.css({ background: 'none'});
	}else{
		pageurl.attr('contenteditable', true);
                pageurl.css({ background: '#FFF'});
	}
});

$('#ELMID_{elm.column_name}_editable').keypress(function(e) {
    if(e.keyCode == 13){
        return false;
    }
});

$('#ELMID_{elm.column_name}_editable').keyup(function(e) {
    if(!$("#gen_{elm.column_name}_auto_id").is(':checked')){
        $('#ELMID_{elm.column_name}').val($('#ELMID_{elm.column_name}_editable').html());
    }
});

{block _form_data.generate_url.value}
$("#gen_{elm.column_name}_auto_id").attr('checked', true);
{-block _form_data.generate_url.value}
{block _form_data.generate_url.value no}
pageurl = $("#ELMID_{elm.column_name}_editable");
pageurl.attr('contenteditable', true);
pageurl.css({ background: '#FFF'});
{-block _form_data.generate_url.value no}
</script>