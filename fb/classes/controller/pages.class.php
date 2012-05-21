<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_pages extends controller {
	
	public function __construct() {
		parent::__construct ("pages");
	}
	
	function validateUrl($url, $data=array()){
		
		$url = $this->db->escape_str($url);
		
		if($data['generate_url']!=1){
			$error=0;
			if(isset($data['id']) && is_numeric($data['id'])){
				$sql = "SELECT * FROM {$this->mod->table} WHERE page_url='$url' AND record_id!={$data['id']} AND lng='$this->language'";
			}else{
				$sql = "SELECT * FROM {$this->mod->table} WHERE page_url='$url' AND lng='$this->language'";
			}
			$row = $this->db->query($sql)->row_array();
			if(!empty($row)) $error = 1;
			return $error;
		}

	}	
		
}

?>