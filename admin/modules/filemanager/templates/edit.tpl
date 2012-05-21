<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Files</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
    
    <link rel="stylesheet" type="text/css" href="css/tree.css" />        
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/filemanager.css" />
    <link rel="stylesheet" type="text/css" href="css/forms.css" />
            
	<script language="JavaScript" type="text/javascript" src="js/admin.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/nav.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/popup.js"></script>
	
	<script src="js/jcrop/jquery.min.js"></script>
	<script src="js/jcrop/jquery.Jcrop.min.js"></script>
	<link rel="stylesheet" href="js/jcrop/jquery.Jcrop.css" type="text/css" />
     
    
	<script language="JavaScript" type="text/javascript" src="js/filemanager.js"></script>
	
	<!-- script language="JavaScript" type="text/javascript" src="js/genresize.js"></script-->
	
	<script language="JavaScript" type="text/javascript">
		$(start);
	</script>

    <script type="text/javascript" src="js/cookie.js"></script>
    
    <script type="text/javascript" src="js/flash_detect_min.js"></script>
    
	<script type="text/javascript" src="lib/swfupload/swfupload.js"></script>
	<script type="text/javascript" src="lib/swfupload/handlers.js"></script>
	<script type="text/javascript" src="lib/swfupload/fileprogress.js"></script>
	<script type="text/javascript" src="lib/swfupload/swfupload.queue.js"></script>
        
	</head>
	<body oncontextmenu="javascript: return false;">

<div id="nav">
<form name="upload" method="post" enctype="multipart/form-data" action="main.php?content=filemanager&page=files&path={get.path}">

	<span id="btn_upload">
    <input type="file" name="upload" class="fo_file vam" style="width:auto;" />
    <input type="submit" name="submit" class="fo_submit vam" value="   ok   " />
	</span>

	<span id="btnCancel"></span>
	
	<script type="text/javascript">
		if(FlashDetect.installed){
			var settings = {
				flash_url : "lib/swfupload/swfupload.swf",
				upload_url: "{config.site_url}xml.php?get=filemanager_fu",
				post_params: {"fusid" : getCookie('PHPSESSID'), "path" : "{get.path}" },
				file_size_limit : "8 MB",
				file_types : "*.*",
				file_types_description : "All files",
				file_upload_limit : 0,
				file_queue_limit : 0,
				button_window_mode : "transparent",
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,
	
				// Button settings
				button_image_url: "images/form_element_bgr.jpg",
				button_width: "100",
				button_height: "23",
				button_placeholder_id: 'btn_upload',
				button_text: '<b>{phrases.filemanager.upload_files}</b>',
				button_text_style: ".theFont { font-size: 14; text-align:center; }",
				button_text_left_padding: 6,
				button_text_top_padding: 2,
				
				// The event handler functions are defined in handlers.js
				file_dialog_start_handler : fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete
			};
			
			new SWFUpload(settings);
		}			
	</script>


    <!--input type="checkbox" id="select_all" class="vam" > <label for="select_all">Select all</label-->
    
</form>
</div>

<div id="path">
<loop name="path"><block name="path.first" no> » </block name="path.first" no><a href="main.php?content=filemanager&page=files&path={path.path}">{path.title}</a></loop name="path">
 » {get.file}
</div>

<span id="fsUploadProgress"></span>

<div id="debug"></div>

<div id="edit_image">

	<!-- This is the image we're attaching Jcrop to -->
	<div id="cropbox_area">
	<img src="{folder_path}{get.file}" id="cropbox" />
	</div>
	
	<br />

	<!-- This is the form that our event handler fills -->
	<div id="size_img_form">
	<form method="post" onsubmit="return checkCoords();">

		<div id="preview_box" class="resizeMe">
		<div id="preview_box_drag">{phrases.filemanager.preview}</div>
		<div id="preview_container"><img src="{folder_path}{get.file}" id="preview" /></div>

		<div id="preview_box_">
			<input type="checkbox" name="resize_img" checked value="1" id="resize_img" class="vam" onclick="javascript: if(this.checked==true) document.getElementById('preview_box_resizer').style.display='block'; else document.getElementById('preview_box_resizer').style.display='none';" /> <label for="resize_img">{phrases.filemanager.change_size}</label>
			<div id="preview_box_resizer">
			{phrases.filemanager.max_x}: <input type="text" value="200" id="img_sizing_value_x" name="img_sizing_value_x" class="fo_text vam" style="width:30px;" onchange="javascript: ;" />
			{phrases.filemanager.max_y}: <input type="text" value="150" id="img_sizing_value_y" name="img_sizing_value_y" class="fo_text vam" style="width:30px;" onchange="javascript: ;" />
			<input type="button" value="ok" class="fo_submit vam" onclick="javascript: showPreview_size(jcropApi_coords);" />
			</div>
		</div>
		</div>

<script type="text/javascript">
SKIRTUMAS = 5;
popup_show('preview_box', 'preview_box_drag', '', 'screen-top', 10, 10);
</script>


		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input type="hidden" id="file" name="file" value="{get.file}" />
		
		<input type="hidden" name="action" value="size" />
		<input type="submit" value="{phrases.filemanager.do_changes}" class="vam fo_submit" />
																														
		<input type="button" value="{phrases.filemanager.select}" class="vam fo_submit" onclick="javascript: selectFile('{get.file}', '{config.site_url}', '{project_dir}', '{folder_path_}');" />
	
		
		
	</form>
	</div>

	<iframe name="iframe_img" id="iframe_img" style="display:none;"></iframe>	

</div>

	</body>
</html>