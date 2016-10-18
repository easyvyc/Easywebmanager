<?php

include_once(CLASSDIR."basic.class.php");
class files extends basic {

    var $path = '';
    var $dir;
    
    function __construct() {
        parent::__construct();
        $this->dir = UPLOADDIR;
        $this->info($this->dir);
    }
    
    function setDir($dir){
        if(is_dir($dir)) $this->path = $dir;
    }
    
    function info($dir){
        $this->path = $dir;
        if(!is_dir($this->path))
            mkdir($this->path, 0777);
        chmod($this->path, 0777);
    }
    
    function create_dir($target, $dir_name){
        if(!is_dir($target.$dir_name))
            mkdir($target.$dir_name, 0777);
        chmod($target.$dir_name, 0777);
    }
    
    function upload($file){
        $filename = $this->setFilename($file['name']);
        if(copy($file['tmp_name'], $this->path.$filename)){
            chmod($this->path.$filename, 0777);
        }
        unlink($file['tmp_name']);
        return $filename;
    }
    
    function save($file){
    	if(!empty($file) && isset($file['name']) && $file['name']!=''){
            $filename = $this->upload($file);
            return $filename;
        }
    }
    
    function download($fullPath){

	  // Must be fresh start 
	  if( headers_sent() ) 
	    die('Headers Sent'); 
	
	  // Required for some browsers 
	  if(ini_get('zlib.output_compression')) 
	    ini_set('zlib.output_compression', 'Off'); 
	
	  // File Exists? 
	  if( file_exists($fullPath) ){ 
	    
	    // Parse Info / Get Extension 
	    $fsize = filesize($fullPath); 
	    $path_parts = pathinfo($fullPath); 
	    $ext = strtolower($path_parts["extension"]); 
	    
	    // Determine Content Type 
	    switch ($ext) { 
	      case "pdf": $ctype="application/pdf"; break; 
	      case "exe": $ctype="application/octet-stream"; break; 
	      case "zip": $ctype="application/zip"; break; 
	      case "doc": $ctype="application/msword"; break; 
	      case "xls": $ctype="application/vnd.ms-excel"; break; 
	      case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
	      case "gif": $ctype="image/gif"; break; 
	      case "png": $ctype="image/png"; break; 
	      case "jpeg": 
	      case "jpg": $ctype="image/jpg"; break; 
	      default: $ctype="application/force-download"; 
	    } 
	
	    header("Pragma: public"); // required 
	    header("Expires: 0"); 
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	    header("Cache-Control: private",false); // required for certain browsers 
	    header("Content-Type: $ctype"); 
	    header("Content-Disposition: filename=\"".basename($fullPath)."\";" ); 
	    header("Content-Transfer-Encoding: binary"); 
	    header("Content-Length: ".$fsize); 
	    ob_clean(); 
	    flush(); 
	    readfile( $fullPath ); 
	
	  } else 
	    die('File Not Found'); 
	
	}    	

    // sugeneruojamas file vardas
    function setFilename($filename){
        $filename = ereg_replace("%", "", $filename);
        if(file_exists($this->path . $filename)){
            $arr = explode(".", $filename);
            $filenamefragment = $arr[(count($arr)-2)];
            preg_match("/(\(([0-9]{1,})\)$)/", $filenamefragment, $reg);
	    if(!empty($reg)){
                $counter = (int)$reg[2] + 1;
                //$counter = ($counter<10?'0'.$counter:''.$counter);
                $filenamefragment = preg_replace("/\(" . $reg[2] . "\)$/", '(' . $counter . ')', $filenamefragment);
            }else{
                $filenamefragment = $filenamefragment . '(1)';
            }
            $arr[(count($arr)-2)] = $filenamefragment;
            $filename = implode(".", $arr);
            $filename = $this->setFilename($filename);
        }
        
        return $filename;
    }


    function remove($file){
    	@unlink($this->path.$file);
    }
    
    function unzip($zip_file, $target_folder){

		global $denied_upload_files;
		
		$zip = zip_open($zip_file);
		if ($zip) {
		
			while ($zip_entry = zip_read($zip)) {
				$filename_ = zip_entry_name($zip_entry);
				
				$arr = explode("/", $filename_);
				if(strlen($arr[(count($arr)-1)])>0){
					$filename = $arr[(count($arr)-1)];
					if(count($arr)>0){
						$folders = $arr;
						unset($folders[(count($arr)-1)]);
					}
				}else{
					continue;
				}
				
				$arr = explode(".", $filename);
				if(in_array($arr[count($arr)-1], $denied_upload_files)){
					continue;
				}
				
				if (zip_entry_open($zip, $zip_entry, "r") && zip_entry_filesize($zip_entry) > 0) {

					$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
		
					zip_entry_close($zip_entry);
			        
			        $zip_target_folder = $target_folder;
			        foreach($folders as $i=>$val){
			        	$this->create_dir($zip_target_folder, $val);
			        	$zip_target_folder = $zip_target_folder.$val."/";
			        }
			        $this->path = $zip_target_folder;
			        $filename = $this->setFilename($filename);
			        $target_file = $zip_target_folder.$filename;
			        $h = fopen($target_file, "w");
			        fwrite($h, $buf);
			        fclose($h);
			        
				}
			}
			zip_close($zip);
		}
    	
    }
    
}
?>
