<?php

include_once(APP_CLASSDIR."model.class.php");
class model_phrases extends model {
	
	function __construct(){
		parent::__construct("phrases");
	}
	
	function listItems(){
		
		$arr = $this->db->select($this->table . " T")
						->fields("T.title, T.translation, R.id")
						->joins("LEFT JOIN cms_record R ON R.id=T.record_id")
						->where("R.trash!=1")
						->where("T.lng=:lng")
						->bind('lng', $this->language)
						->result_array();
		return $arr;
		
	}
	
}

?>
