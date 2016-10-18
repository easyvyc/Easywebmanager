<?php

include_once(APP_CLASSDIR."model.class.php");
class model_blocks extends model {
	
	function __construct(){
		parent::__construct("blocks");
	}
	
	function get($page_id, $area_id){
		$row = $this->db->select($this->table)
						->fields("description")
						->where("page_id=:page_id")
						->where("block_name=:area_id")
						->bind('page_id', $page_id)
						->bind('area_id', $area_id)
						->row_array();
		return $row['description'];
	}
	
	function getBlocks($page_id){
            $blocks_obj = $this->registry->model->create("blocks");
            $blocks_obj->sqlQueryWhere[] = " page_id=:page_id ";
            $blocks_obj->sqlQueryBinds['page_id'] = $page_id;
            $arr = $blocks_obj->listSearchItems();
            foreach($arr as $val){
                    $blocks[$val['block_name']] = $val;
            }
            return $blocks;
	}
        
    function loadItem_search($id){
        $data = parent::loadItem_search($id);
        
        if($data['page_id']){
            $page_data = $this->registry->model->pages->loadItem_search($data['page_id']);
            $data['page_url'] = $page_data['page_url'];
            $data['title'] = $page_data['title'];
        }
        
        return $data;
    }        
    
}

?>
