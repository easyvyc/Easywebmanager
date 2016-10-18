<?php

include_once(APP_CLASSDIR."model.class.php");
class model_blocks extends model {
	
	function __construct() {
    	
    	parent::__construct("blocks");
    	
    }
    
    function getBlock($page_id, $page_area){
    	$row = $this->db->select($this->table)
    					->where("page_id=:page_id")
    					->where("block_name=:block_name")
    					->bind('page_id', $page_id)
    					->bind('block_name', $page_area)
    					->row_array();
    	return $row;
    }
    
    function loadItem_search($id){
        $data = parent::loadItem_search($id);

        $page_data = $this->registry->model->pages->loadItem($data['page_id']);

        $data['title'] = $page_data['title'];
        $data['page_url'] = $page_data['page_url'];

        return $data;
    }    
    
}

?>