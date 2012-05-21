<?php

function download_file($filename){
	if(!file_exists($filename)){
		trigger_error("File '$filename' not exist.");
		return false;
	}
	$path_parts = pathinfo($filename);
	download_data($path_parts['basename'], file_get_contents($filename));
}

function download_data($filename = '', $data = ''){
	
	if ($filename == '' OR $data == ''){
		return FALSE;
	}

	// Try to determine if the filename includes a file extension.
	// We need it in order to set the MIME type
	if (FALSE === strpos($filename, '.')){
		return FALSE;
	}

	// Grab the file extension
	$x = explode('.', $filename);
	$extension = end($x);

	// Load the mime types
	if (file_exists(HELPERDIR.'mimes.php')){
		include(HELPERDIR.'mimes.php');
	}

	// Set a default mime if we can't find it
	if ( ! isset($mimes[$extension])){
		$mime = 'application/octet-stream';
	}else{
		$mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
	}

	// Generate the server headers
	if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE){
		header('Content-Type: "'.$mime.'"');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header("Content-Transfer-Encoding: binary");
		header('Pragma: public');
		header("Content-Length: ".strlen($data));
	}else{
		header('Content-Type: "'.$mime.'"');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		header('Pragma: no-cache');
		header("Content-Length: ".strlen($data));
	}

	exit($data);
}

?>