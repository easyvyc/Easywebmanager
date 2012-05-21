<?php

require_once(APP_CLASSDIR.'actions.class.php');
class actions_modules extends actions {
	
	public function __construct() {
		parent::__construct();
	}
	
	function _default(){
		return $this->_list();
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
		$sum_data = $this->registry->modules->{$this->get['module']}->getListingSum();		
		$list_items = $this->registry->modules->{$this->get['module']}->getListingItems();
    	
		$listing_obj->setItemsData($sum_data);
    	$listing_obj->setItems($list_items);
    	$listing_obj->paging($this->get['offset']);
    	$listing_obj->pagingSelect();
		
    	return $listing_obj->generate();		
		
	}
	
}

?>