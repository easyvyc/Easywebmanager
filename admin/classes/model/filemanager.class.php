<?php

include_once (CLASSDIR.'basic.class.php');
class model_filemanager extends basic {
	
	private $main_dir;
	
	public function __construct() {
		parent::__construct ();
		$this->main_dir = FILESDIR."Main/";
	}
	
	function folder($folder){
		
		$folder = trim($folder);
		$folder = trim($folder, "/");
		//echo $this->main_dir . $folder . "/*";
		$list = glob($this->main_dir . $folder . "/*");
		
		return $list;
		
	}
	
	function getMainDir(){
		return $this->main_dir;
	}
	
}

?>