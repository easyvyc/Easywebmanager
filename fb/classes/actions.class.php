<?php

include_once(CLASSDIR."basic.class.php");
class actions extends basic {

	public $mod_actions = array(
							'list'=>array(), 
							'edit'=>array(), 
							'translate'=>array(), 
							'new'=>array(), 
							'import'=>array(), 
							'export'=>array(), 
							'pdf'=>array(), 
							'delete'=>array()
	);
	
    function __construct($module) {
    	
    	parent::__construct();
    	
		include(LANGUAGESDIR.$_SESSION['admin_interface_language'].".php");
		$this->phrases = $cms_phrases;
    	
    }
    
    function _default(){
    	return $this->_list();
    }    
    
    // action methods
    function _edit(){
    	
    }

    function _list(){

		$this->registry->modules->{$this->get['module']}->listingActions();
		$this->registry->modules->{$this->get['module']}->filterListing();
    	
    	include_once(APP_CLASSDIR."listing.class.php");
		$listing_obj = new listing();
    	
		$listing_obj->set('grid_name', $this->registry->modules->{$this->get['module']}->module_info['table_name']);
		
		$listing_obj->setFilters($_SESSION['filters'][$this->get['module']]);
		
		$listing_obj->setColumns($this->registry->modules->{$this->get['module']}->table_list);
		
		$this->registry->modules->{$this->get['module']}->prepareListing($listing_obj->columns);
		$sum_data = $this->registry->modules->{$this->get['module']}->getListingSum($parent_id);
    	$list_items = $this->registry->modules->{$this->get['module']}->getListingItems($parent_id);
    	
    	$listing_obj->setItemsData($sum_data);
    	$listing_obj->setItems($list_items);
    	$listing_obj->paging($this->get['offset']);
    	$listing_obj->pagingSelect();
		
    	return $listing_obj->generate();
    	
    }
        
    function _translate(){
    }

    function _import(){
    }

    function _export(){
    }

    function _pdf(){
    }

    function _delete(){
    }
    
    function _settings(){
    }
    
    function __call($func, $args){
    	trigger_error("Method ".__CLASS__."::$func() not exist.");
    }
    
}
?>