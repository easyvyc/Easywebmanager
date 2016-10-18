<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_module_info extends controller {
	
	public function __construct() {
		parent::__construct ("module_info");
	}
	
        public function new_item($module_id){
            //$this->mod->_table_fields['module_id']['value'] = 81;
            return parent::new_item(array('module_id'=>$module_id));
        }
        
	function listing($module_id=0){

            if($this->get['change_order'] == 1){
                $this->mod->changeOrder($this->get['firstid'], $this->get['lastid']);
            }
            
            if($module_id == 0){
                $module_id = $_GET['cid'];
            }
            $_GET['cid'] = $module_id;
            
            benchmark::mark('start_listing', 'Listingo pradzia');

            $this->mod->listingActions();
            $this->mod->filterListing();

            include_once(APP_CLASSDIR . "listing.class.php");
            $listing_obj = new listing($this->mod->module_info['table_name']);

            $listing_obj->setFilters($_SESSION['filters'][$this->get['module']]);

            $listing_obj->setColumns($this->mod->table_list);

            $this->mod->prepareListing($listing_obj->columns);
            $sum_data = $this->mod->getListingSum($module_id);
            $list_items = $this->addContextToList($this->mod->getListingItems($module_id));
            //return "<pre>" . print_r($list_items, true) . "</pre>";

            $listing_obj->setItemsData($sum_data);
            $listing_obj->setItems($list_items);
            $listing_obj->paging($this->get['offset']);
            $listing_obj->pagingSelect();

            $listing_obj->set('base_url', 'module=' . $this->get['module'] . '&method=' . $this->get['method'] . '&id=' . $this->get['id'] );
            
            benchmark::mark('end_listing', 'Listingo pabaiga');

            return $listing_obj->generate();
		
	}
        
}
        
?>