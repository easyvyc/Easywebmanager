<div id="id_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
	
	<div style="float:left;min-width:150px;">

			<img id="_IMGUPLOAD_FRM_{elm.column_name}_{form_elements.id.value}" src="{uploadurl}{elm.value}" alt="" /><br />
			
			<input type="hidden" name="old_{elm.column_name}" value="{elm.value}" >
			<input type="hidden" name="{elm.column_name}" class="FRM" id="_FRM_{form_elements.id.value}edititem___{elm.column_name}___{form_elements.id.value}" value="" />
			
			<span id="fsUploadProgress_FRM_{elm.column_name}_{form_elements.id.value}"></span>
			<div id="btnUpload_FRM_{elm.column_name}_{form_elements.id.value}"></div>
			<div id="btnCancel_FRM_{elm.column_name}_{form_elements.id.value}"></div>
			
			<script type="text/javascript">
			
				var settings = {
					flash_url : "js/swfupload/swfupload.swf",
					upload_url: "{config.site_url}ajax.php?content=uf&id={form_elements.id.value}&column={elm.column_name}",
					post_params: {"easywebmanager_sid" : getCookie('Eid') },
					file_size_limit : "50 MB",
					file_types : "*.jpg;*.png;*.gif",
					file_types_description : "All images",
					file_upload_limit : 0,
					file_queue_limit : 1,
					button_window_mode : "transparent",
					custom_settings : {
						progressTarget : "fsUploadProgress_FRM_{elm.column_name}_{form_elements.id.value}",
						cancelButtonId : "btnCancel_FRM_{elm.column_name}_{form_elements.id.value}"
					},
					debug: false,
			
					// Button settings
					button_image_url: "",
					button_width: "100%",
					button_height: "23",
					button_placeholder_id: 'btnUpload_FRM_{elm.column_name}_{form_elements.id.value}',
					button_text: '<b>{phrases.upload_attachements}</b>',
					button_text_style: ".theFont { font-size: 12; text-align:center; font-weight:bold; }",
					button_text_left_padding: 6,
					button_text_top_padding: 2,
					
					// The event handler functions are defined in handlers.js
					file_queued_handler : fileQueued,
					file_queue_error_handler : fileQueueError,
					file_dialog_complete_handler : fileDialogComplete,
					upload_start_handler : uploadStart,
					upload_progress_handler : uploadProgress,
					upload_error_handler : uploadError,
					upload_success_handler : function(file_object, server_data, response){ 
													$('#_IMGUPLOAD_FRM_{elm.column_name}_{form_elements.id.value}').attr('src', "ajax.php?content=call&module={form_data.module}&method=loadTempUploadFile_image&params[column]={elm.column_name}&params[id]={form_elements.id.value}&lng={form_data.language}&_="+Math.floor(Math.random()*10001));
													$('#_FRM_{form_elements.id.value}edititem___{elm.column_name}___{form_elements.id.value}').val(1); 
											},
					upload_complete_handler : uploadComplete,
					queue_complete_handler : function(){  }	// Queue plugin event
				};
				
				new SWFUpload(settings);
					
			</script>
			

	</div>
	<div style="clear:both;"></div>
	
	</div>
</div>
