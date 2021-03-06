<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
	
		{block elm.value}
		<a id="lightbox_{form_settings.id}_{elm.column_name}" target="_blank" href="admin.php?module={_hiddens.module}&method=get_file&column={elm.column_name}&id={_hiddens.id}&t=download&rand={random}" >
                    {elm.value}
		</a>
		<br />
                <label><input type='checkbox' name='delete_{elm.name}' value='1' id='id_{form_settings.id}_{elm.name}_delete' {block elm.editorship no}disabled{-block elm.editorship no}>Delete</label>
                <br />
		{-block elm.value}

		<input type='hidden' name='{elm.name}' value='{elm.value}'>
		
		<input type='hidden' name='{elm.name}_type' value='upload'>

		<div class="img_upload_types"><a class="upload" href="#">Upload</a>&nbsp;&nbsp;<a href="#" class="url">URL</a></div>
		
		<div class="image_upload_type" id="img_{form_settings.id}_{elm.column_name}_upload">
		<input type='file' name='file_{elm.name}' id="ELMID_upload_{form_settings.id}_{elm.column_name}" value='' class='FRM {style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no} >
		</div>

		<div class="image_upload_type" id="img_{form_settings.id}_{elm.column_name}_url" style="display:none">
		<input type='text' name='url_{elm.name}' id="ELMID_url_{form_settings.id}_{elm.column_name}" value='' placeholder="Resource URL" class='FRM {style}_text' {block elm.editable no}readonly{-block elm.editable no} ><br />
		</div>

		
		<span style="font-size:9px;">{phrases.main.common.max_file_size} - {max_file_size} Mb</span>

	</div>
</div>
<script>
$(document).ready(function(){
    $('#id_{form_settings.id}_{elm.name} .img_upload_types .upload').click(function(){
        $("#id_{form_settings.id}_{elm.name} .image_upload_type").hide();
        $("#img_{form_settings.id}_{elm.name}_upload").show();
        $("#id_{form_settings.id}_{elm.name} [name={elm.name}_type]").val('upload');
    });

    $('#id_{form_settings.id}_{elm.name} .img_upload_types .url').click(function(){
        $("#id_{form_settings.id}_{elm.name} .image_upload_type").hide();
        $("#img_{form_settings.id}_{elm.name}_url").show();
        $("#id_{form_settings.id}_{elm.name} [name={elm.name}_type]").val('url');
    });

});
</script>
