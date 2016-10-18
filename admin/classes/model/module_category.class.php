<?php

include_once(APP_CLASSDIR.'model.class.php');
class model_module_category extends model {
	
	function __construct() {
		
		parent::__construct("module_category");

		//$this->table = Config::$val['pr_code'] . "_module_category";
		
		$this->admin = $_SESSION['admin'];
		
		$this->language = $_SESSION['site_lng'];
		
		$this->module_info = array('table_name'=>'module_category', 'default_sort'=>'id', 'default_sort_direction'=>'ASC');
		
		//$this->loadActions();
		
		$table_list = array();
		$table_list[] = array(
							'title'=>cms::$phrases['main']['settings']['module']['title'], 
							'column_name'=>'title', 
							'editable'=>1, 
							'elm_type'=>FRM_TEXT
		);
		
		$this->table_fields = $this->table_list = $table_list;
		$this->_table_fields['title'] = $table_list[0];
		
	}
	
	function getListingSum(){
		return $this->getModulesCategoriesSum($this->sqlQueryJoins, $this->sqlQueryWhere);
	}
	
	function getListingItems(){

    	$order_by = $this->listing_filter_data['order_by'];
    	$order_direction = $this->listing_filter_data['order_direction'];
    	$offset = $this->listing_filter_data['offset'];
    	$paging = $this->listing_filter_data['paging'];
    	
    	if($order_by=='') $order_by = $this->module_info['default_sort'];
    	if($order_direction=='') $order_direction = $this->module_info['default_sort_direction'];

    	$this->sqlQueryLimit = " $offset, $paging ";
        if($order_by!='') $this->sqlQueryOrder = " $order_by $order_direction ";
        $list = $this->listModulesCategories($this->sqlQueryJoins, $this->sqlQueryWhere, $this->sqlQueryOrder, $this->sqlQueryLimit);
		
		return $list;     

    }	
    
    function listItems(){
        return $this->listModulesCategories();
    }

    function loadItem($id){
    	
        $data = $this->db->select($this->table)
        				 ->where("id=:id")
        				 ->bind("id", $id)
        				 ->row_array();    	

        $data['title'] = $data['title_' . $this->language];
        
        return $data;

    }
    
    function delete($id){
        return $this->db->delete($this->table)
        				 ->where("id=:id")
        				 ->bind("id", $id)
        				 ->query();    	
    }
    
    function saveItem($data){
    	if($data['isNew']!=1){
            $this->db->update($this->table)
            		 ->values("title_" . $this->language . "=:title")
            		 ->where('id=:id')
            		 ->bind('title', $data['title'])
            		 ->bind('id', $data['id'])
            		 ->query();   
    		
    	}else{
            $this->db->insert($this->table)
            		 ->values("title_" . $this->language . "=:title")
            		 ->bind('title', $data['title'])
            		 ->query();    		
    	}
    }
    
    function changeOrder($lid, $fid){
    	//$this->module->changeOrder($lid, $fid);
    }   
    
    // TODO:
    function listModulesCategories(){
    	return $this->db->select($this->table . " T")
    					->fields("T.id, T.title_$this->language AS title, 1 AS editorship")
    					->result_array();    	
    }
    
    function getModulesCategoriesSum(){
    	return $this->db->select($this->table . " T")
		    			->fields("COUNT(DISTINCT id) as _COUNT_")
		    			->row_array();    	
    }    
    
}

?>