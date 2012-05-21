<?php

include_once(CLASSDIR."basic.class.php");
class actions_fb_app extends basic {

    function __construct() {
    	
    	parent::__construct();
    	
    }
    
    function _default(){
    	return $this->_show_app();
    }
    
    function _show_app(){
    	
    	include TPL::parse(TPLDIR."app.tpl");
		$buffer = cms::getInstance()->ob_get_contents();
		cms::getInstance()->ob_start();
    	
		$css_html = "<style type=\"text/css\">".generate_css('fb', array('app'))."</style>";
		
		$script_html = "<script type=\"text/javascript\" src=\"fb/js/app.js\"></script>" .
						"<script type=\"text/javascript\">" .
						"\$FB_APP.set_upload_url('".UPLOADURL."');" .
						"\$FB_APP.load();" .
						"</script>";
		
		
		return $css_html.$buffer.$script_html;
    	
    }
    
	function _editBlock($params){
		
		$call = "edit_{$params['type']}";
		return $this->$call($params['id']);
		
	}
	
	function _save_banners(){
		$file = DATADIR."fb_app.js";
		file_put_contents($file, stripslashes($this->post['data']));
		return file_get_contents($file);
	}

	function _save_menu(){
		$file = DATADIR."fb_menu.js";
		file_put_contents($file, stripslashes($this->post['data']));
		return file_get_contents($file);
	}
	
	function _upload(){

		//FILE::uploadImage();
		
		ini_set("memory_limit", "256MB");
		set_time_limit(0);
		
		//mail("v@adme.lt", "test", "Memory limit: ".ini_get("memory_limit")."\npost_max_size: ".ini_get('post_max_size')."\nupload_max_filesize: ".ini_get('upload_max_filesize'));
		
		// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
		$POST_MAX_SIZE = ini_get('post_max_size');
		$unit = strtoupper(substr($POST_MAX_SIZE, -1));
		$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

		if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
			header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
			echo "POST exceeded maximum allowed size.";
			exit(0);
		}

		// Settings
		$save_path = UPLOADDIR;				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
		$upload_name = "Filedata";
		$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
		$extension_whitelist = array("jpg", "gif", "png");	// Allowed file extensions
		$extension_blacklist = array("php", "php3", "php4", "php5", "phtml", "pl");
		$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)
		
		// Other variables	
		$MAX_FILENAME_LENGTH = 255;
		$file_name = "";
		$file_extension = "";
		$uploadErrors = array(
	        0=>"There is no error, the file uploaded with success",
	        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
	        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
	        3=>"The uploaded file was only partially uploaded",
	        4=>"No file was uploaded",
	        6=>"Missing a temporary folder"
		);

		// Validate the upload
		if (!isset($_FILES[$upload_name])) {
			trigger_error("No upload found in \$_FILES for " . $upload_name);
			exit(0);
		} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
			trigger_error($uploadErrors[$_FILES[$upload_name]["error"]]);
			exit(0);
		} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
			trigger_error("Upload failed is_uploaded_file test.");
			exit(0);
		} else if (!isset($_FILES[$upload_name]['name'])) {
			trigger_error("File has no name.");
			exit(0);
		}
		
	// Validate the file size (Warning: the largest files supported by this code is 2GB)
		$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			trigger_error("File exceeds the maximum allowed size");
			exit(0);
		}
		
		if ($file_size <= 0) {
			trigger_error("File size outside allowed lower bound");
			exit(0);
		}
	
	
	// Validate file name (for our purposes we'll just remove invalid characters)
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			trigger_error("Invalid file name");
			exit(0);
		}


		$path_info = pathinfo($_FILES[$upload_name]['name']);
		$file_extension = $path_info["extension"];
		$is_valid_extension = true;
		foreach ($extension_blacklist as $extension) {
			if (strcasecmp($file_extension, $extension) == 0) {
				$is_valid_extension = false;
				break;
			}
		}
		if (!$is_valid_extension) {
			trigger_error("Invalid file extension");
			exit(0);
		}
	
		// Item files list
		if(isset($this->get['params']['id'])){
			$target_dir = UPLOADDIR."{$this->get['params']['id']}/";
			if(!is_dir($target_dir)){
				mkdir($target_dir);
			}
		}
		
		if(!(move_uploaded_file($_FILES[$upload_name]['tmp_name'], $target_dir.$_FILES[$upload_name]['name']))){
			trigger_error("File can not be moved. ".$target_dir.$_FILES[$upload_name]["name"]);
		}else{
			echo $_FILES[$upload_name]['name'];
		}
		exit(0);
		
	}	
	
    private function edit_menu($id){

    	TPL::setVar('id', $id);
		include TPL::parse(TPLDIR."edit/menu.tpl");
		$buffer = cms::getInstance()->ob_get_contents();
		cms::getInstance()->ob_start();
    	
		return $buffer;
    	
    }
	
	private function edit_banner($id){
		
    	TPL::setVar('session_id', session_id());
    	TPL::setVar('id', $id);
		include TPL::parse(TPLDIR."edit/banner.tpl");
		$buffer = cms::getInstance()->ob_get_contents();
		cms::getInstance()->ob_start();
    	
		return $buffer;
		
	}
        
}

?>