<?php

include_once(APP_CLASSDIR."model.class.php");
class model_site_blocks extends model {
	
        private $ph_cache = array();
    
	function __construct(){
		parent::__construct("site_blocks");
	}
	
	function listItems(){
		
		$arr = $this->db->select($this->table . " T")
						->fields("T.title, T.block_content, R.id")
						->joins("LEFT JOIN cms_record R ON R.id=T.record_id")
						->where("R.trash!=1")
						->where("T.lng=:lng")
						->bind('lng', $this->language)
						->result_array();
		return $arr;
		
	}
        
	function loadBlocks(){
		
            if(empty($this->ph_cache)){
		$list = $this->listItems();
		$phrases = array();
		foreach($list as $val){
			$phrases[$val['title']] = $val['block_content'];
		}
		$this->ph_cache = $phrases;
            }
            
            return $this->ph_cache;
		
	}
	
        function get($key){
            if(empty($this->ph_cache)){
                $this->loadBlocks();
            }
            return $this->ph_cache[$key];
        }        
	
}

?>
