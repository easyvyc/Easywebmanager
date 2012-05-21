<form action="javascript: void(setBanner());" method="post">

<script type="text/javascript">

$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "fb.php?module=fb_app&method=upload&params[id]={id}&ajax=1",
		file_size_limit : "10240",
		post_params: {"_SESSION_ID_" : "{session_id}" },
		file_types : "*.jpg;*.gif,*.png",
		file_types_description : "All Images",
		file_upload_limit : 0,
		file_queue_limit : 1,
		flash_url : "fb/js/swfupload/swfupload.swf",
		button_image_url : 'fb/js/swfupload/XPButtonUploadText_61x22.png',
		button_width : 61,
		button_height : 22,
		button_placeholder : $('#swfupload_button')[0],
		debug: false,
		custom_settings : {something : "here"}
	})
		.bind('swfuploadLoaded', function(event){
			//$('#log').append('<li>Loaded</li>');
			$('#swfupload_error').hide();
			$('#swfupload_success').hide();
			$('#swfupload_progress').hide();
			$('#swfupload_progress .mark').css('width', '0%');
		})
		.bind('fileQueued', function(event, file){
			//$('#log').append('<li>File queued - '+file.name+'</li>');
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			//$('#log').append('<li>File queue error - '+message+'</li>');
		})
		.bind('fileDialogStart', function(event){
			//$('#log').append('<li>File dialog start</li>');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			//$('#log').append('<li>File dialog complete</li>');
		})
		.bind('uploadStart', function(event, file){
			//$('#log').append('<li>Upload start - '+file.size+'</li>');
			$('#swfupload_progress').show();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//$('#log').append('<li>Upload progress - '+bytesLoaded+'</li>');
			$('#swfupload_progress .mark').css('width', parseInt(bytesLoaded*100/file.size) + '%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			//$('#log').append('<li>Upload success - '+file.name+'</li>');
		})
		.bind('uploadComplete', function(event, file){
			//$('#log').append('<li>Upload complete - '+file.name+'</li>');
			$('#swfupload_success').show().html('Upload complete - '+file.name+'');
			$('#swfupload_img').html("<img src='"+$FB_APP.uploadurl+"{id}/"+file.name+"' height='35' >");
			$('#swfupload_file').val(file.name);
			// upload has completed, lets try the next one in the queue
			$(this).swfupload('startUpload');
		})
		.bind('uploadError', function(event, file, errorCode, message){
			//$('#log').append('<li>Upload error - '+message+'</li>');
			$('#swfupload_error').show().html('Upload error - '+message+'');
		});
	
});	


if(typeof($FB_APP.info.data.{id})!='undefined'){
	if(typeof($FB_APP.info.data.{id}.url)!='undefined'){
		$('#swfupload_img').html("<img src='"+$FB_APP.uploadurl+"{id}/"+$FB_APP.info.data.{id}.url+"' height='35' >");
		$('#swfupload_file').val($FB_APP.info.data.{id}.url);
	}
	if(typeof($FB_APP.info.data.{id}.link)!='undefined'){
		$('#hiperlink').val($FB_APP.info.data.{id}.link);
	}
}else{
	/*
	$FB_APP.info.{id} = $FB_APP.info.{id}
	*/
}

function setBanner(){
	$FB_APP.change("{id}", "url", $('#swfupload_file').val());
	$FB_APP.change("{id}", "link", $('#hiperlink').val());
	$FB_APP.save();
	$FB_APP.load_block_info($FB_APP.info.data.{id}.type, '{id}');
	eDIALOG.closeDialog();
}

</script>

	<div id="swfupload-control" class="frm">
		
		<div id="swfupload_img"></div>
	
		<ol id="log"></ol>
		
		<div id="swfupload_progress"><div class="mark"></div></div>
		<div id="swfupload_error"></div>
		<div id="swfupload_success"></div>
		
		<input type="hidden" name="filename" id="swfupload_file" value="" />
		
		<input type="button" id="swfupload_button" />
	</div>
	
	<div class="frm">
		<label for="hiperlink">Link:</label><input type="url" class="fo_text" name="hiperlink" id="hiperlink" value="" />
	</div>
	
	<div class="frm">
		<input type="submit" class="fo_submit radius5" value="Apply" />
	</div>

</form>