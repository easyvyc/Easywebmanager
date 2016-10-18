<?php

include_once(CLASSDIR."main_module.class.php");
include_once (APP_CLASSDIR.'controller.class.php');
class controller_columns extends controller {
	
	public function __construct() {
		parent::__construct ("columns");
                $this->module = new main_module();
	}
	
	function checkExistName($value, $data){
		return $this->mod->checkExistName($value, $data);
	}

        
        function getListingItems($module_id){
            
            if(!is_numeric($module_id)) return false;

            $this->mod->listingActions();
            $this->mod->filterListing();

            include_once(APP_CLASSDIR."listing.class.php");
            $listing_obj = new listing($this->mod->module_info['table_name']);

            $listing_obj->setFilters($_SESSION['filters'][$this->get['module']]);

            $listing_obj->setColumns($this->mod->table_list);

            $this->mod->prepareListing($listing_obj->columns);
            $sum_data = $this->mod->getListingSum($_GET['id']);

            $list_items = $this->addContextToList($this->module->listColumns($module_id, $order_by, $order_direction));

            $listing_obj->setItemsData($sum_data);
            $listing_obj->setItems($list_items);
            $listing_obj->paging($this->get['offset']);
            $listing_obj->pagingSelect();

            return $listing_obj->generate();    
            
        }
	
}
?>