<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Files</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
    
    <link rel="stylesheet" type="text/css" href="css/tree.css" />        
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/filemanager.css" />
    <link rel="stylesheet" type="text/css" href="css/forms.css" />
            
	<script type="text/javascript" src="js/admin.js"></script>
	
	<script type="text/javascript" src="js/nav.js"></script>
	
    <script type="text/javascript" src="js/jcrop/jquery.min.js"></script>
    
    <script type="text/javascript" src="js/filemanager.js"></script>
     
    <script type="text/javascript" src="js/jquery/ui.base.js"></script>
    <script type="text/javascript" src="js/jquery/ui.selectable.js"></script>
    
    <script type="text/javascript" src="js/cookie.js"></script>
    
    <script type="text/javascript" src="js/flash_detect_min.js"></script>
    
	<script type="text/javascript" src="lib/swfupload/swfupload.js"></script>
	<script type="text/javascript" src="lib/swfupload/handlers.js"></script>
	<script type="text/javascript" src="lib/swfupload/fileprogress.js"></script>
	<script type="text/javascript" src="lib/swfupload/swfupload.queue.js"></script>
    
    
	</head>
	<body  oncontextmenu="javascript: return false;">

<div id="nav">
<form name="upload" method="post" enctype="multipart/form-data">

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
				button_text_style: ".theFont { font-size: 14; text-align:center; font-family: Tahoma; }",
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
    
    &nbsp;&nbsp;&nbsp;&nbsp;
    {phrases.filemanager.sort_files_by}
    <input type="radio" value="fname" id="id_fname" class="vam" onclick="javascript: location='main.php?content=filemanager&page=files&path={get.path}&sort='+$(this).val();" /> <label for="id_fname">{phrases.filemanager.sort_files_by_title}</label>
    <input type="radio" value="date" id="id_date" class="vam" onclick="javascript: location='main.php?content=filemanager&page=files&path={get.path}&sort='+$(this).val();" /> <label for="id_date">{phrases.filemanager.sort_files_by_date}</label>
    <input type="radio" value="size" id="id_size" class="vam" onclick="javascript: location='main.php?content=filemanager&page=files&path={get.path}&sort='+$(this).val();" /> <label for="id_size">{phrases.filemanager.sort_files_by_size}</label>
    <input type="radio" value="ext" id="id_ext" class="vam" onclick="javascript: location='main.php?content=filemanager&page=files&path={get.path}&sort='+$(this).val();" /> <label for="id_ext">{phrases.filemanager.sort_files_by_ext}</label>
    
    <script type="text/javascript">
    if('{get.sort}'!='')$('#id_{get.sort}').attr('checked', true); 
    else $('#id_fname').attr('checked', true);
    </script>
        
</form>
</div>

<div id="path">
<loop name="path"><block name="path.first" no> » </block name="path.first" no><a href="main.php?content=filemanager&page=files&path={path.path}">{path.title}</a></loop name="path">
</div>

<span id="fsUploadProgress"></span>

<div id="playground">
<ul id="files">
<loop name="files">
<li class="thumb float" title="{files.alt_text}" ondblclick="javascript: selectFile('{files.title}', '{config.site_url}', '{project_dir}', '{folder_path_}');" id="file_{files._INDEX}">
    <input type="hidden" id="file_val_{files._INDEX}" value="{files.title}" />
    <p>{files.title}</p>
    <block name="files.img">
    <img src="{config.site_url}thumb.php?image={files.file}&w=60&h=60&t=0" alt="" />
    </block name="files.img">
    <block name="files.img" no>
    <img src="images/extension_icons/{files.ext}.gif" alt="" width="40" />
    </block name="files.img" no>



</li>
</loop name="files">
</ul>
<div class="clear"></div>
</div>

<loop name="files">
<div id="contextmenu_{files._INDEX}" class="contextMenu">
	<div class="title">{files.title} ({files.size_kb}Kb)</div>
	<div class="text">
	<loop name="files.context">
		<div><a onclick="javascript: {files.context.action}"><img src="images/{files.context.img}.gif" alt="" class="vam" border="0" /> {files.context.title}</a></div>
	</loop name="files.context">
	</div>
</div>
</loop name="files">

<div id="contextMenuArea" class="contextMenu"></div>

<div id="contextmenu_multiple" style="dislpay:none;" class="contextMenu">
	<div class="title">{phrases.modules.context_menu.select_multiple}</div>
	<div class="text">
		<div><a onclick="javascript: selectMultilpe('{config.site_url}', '{project_dir}', '{folder_path_}');"><img src="images/reset.gif" alt="" class="vam" border="0" /> {phrases.modules.context_menu.select}</a></div>
		<div><a onclick="javascript: location='main.php?content={get.content}&page={get.page}&path={get.path}&multiple=1&downloadfile='+getSelectedFiles();"><img src="images/zip.gif" alt="" class="vam" border="0" /> {phrases.modules.context_menu.download}</a></div>
		<div><a onclick="javascript: if(confirm('{phrases.modules.context_menu.delete_confirm}')) location='main.php?content={get.content}&page={get.page}&path={get.path}&multiple=1&deletefile='+getSelectedFiles();"><img src="images/delete.gif" alt="" class="vam" border="0" /> {phrases.modules.context_menu.delete}</a></div>
	</div>
</div>

<div id="proxy"></div>

<script type="text/javascript">
	
	$('#contextMenuArea').bind('mouseleave', hideItemContenxtMenu);
	
	if(document.body.addEventListener){
		document.body.addEventListener('files', filesContextMenu, true);
		document.getElementById('files').oncontextmenu = filesContextMenu;
	}else{
		document.getElementById('files').oncontextmenu = filesContextMenu;
	}
    
    <block name="error">
      alert('{error_msg}');  
    </block name="error">


	$("#playground").selectable({ autoRefresh: false });
	
	$(window).resize(function(){
	  $("#playground").selectable('refresh');
	});
	
</script>
    
	</body>
</html>