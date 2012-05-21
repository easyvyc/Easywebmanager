<?php

class cache {
	
	private $cachedir;
	private $filename;
	private $functionname;
	
	private static $instance;
	
	private function __construct(){
		
		$this->cachedir = CACHEDIR."data/";
		
	}
	
	static function getInstance(){
    	if(!is_object(self::$instance)){
    		self::$instance = new cache();
    	}
    	return self::$instance;		
	}
	
	function setFilename($filename){
		
		$this->filename = $filename;
		
	}
	
	function setFunctionname($filename){
		
		$this->functionname = $filename;
		
	}
	
	function generateCache($var){
		
		$begin = "<?php\r\n" .
				"/* cache generated: ".date("Y-m-d H:i:s")." */\r\n" .
				"\r\n" .
				"function $this->functionname(){\r\n\r\n";
				
		$str = $this->parseVariable($var);

		$end = "\r\n\treturn \$arr; \r\n\r\n}\r\n\r\n?>";
		
		$content = $begin.$str.$end;
		
		$file = fopen($this->filename, "w");
		fwrite($file, $content);
		fclose($file);
		chmod($this->filename, 0777);
		
	}

	function parseVariable($var, $path=array(), $level=0){
		
		if(is_array($var)){
			foreach($var as $key => $val){
				$path[$level] = $key;
				if(is_array($val)){
					$str .= $this->parseVariable($val, $path, $level+1);
				}else{
					$str .= $this->putVariable($val, $path);
				}
			}
		}else{
			$str .= $this->putVariable($var, $path);
		}
		
		return $str;
		
	}
	
	function putVariable($val, $path){
		
		$arr_path = implode("']['", $path);
		unset($value_str);
		if(is_bool($val) || is_float($val) || is_int($val))
			$value_str = $val;
		else
			$value_str = "'".addcslashes($val, "'")."'";
		$str .= "\t\$arr['".$arr_path."'] = ".$value_str.";\r\n";
		
		return $str;
	
	}
	
	function is_loadCache($cache_file, $check_time){
		
		// check if $check_date is date format Y-m-d H:i:s 
		if(is_string($check_time)){
			list($y,$m,$d,$h,$i,$s) = split("\s-:", $check_time);
			$check_time = mktime($s,$i,$h,$m,$d,$y);
		}
		
		if(file_exists($cache_file)){
			clearstatcache();
			$file_time = filemtime($cache_file);
			if($check_time < $file_time) return true;
		}
		
		return false; 
		
	}
	
	function createCache($file, $content){

		$h = fopen($file, "w");
		fwrite($h, $content);
		fclose($h);
		chmod($file, 0777);
	
	}


	function getContent($file){
		
		$h = fopen($file, "r");
		$contents = "";
		do {
		    $data = fread($h, 8192);
		    if (strlen($data) == 0) {
		        break;
		    }
		    $contents .= $data;
		} while (true);
		fclose($h);
		return $contents;
		
	}
	
}

?>