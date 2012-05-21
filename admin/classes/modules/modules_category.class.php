<?php

include_once(CLASSDIR."main_module.class.php");
include_once(APP_CLASSDIR.'modules.class.php');
class modules_modules_category extends modules {
	
	function __construct() {
		
		basic::__construct();

		$this->module = new main_module();
		$this->admin = $_SESSION['admin'];
		
		$this->module_info = array('table_name'=>'module_category', 'default_sort'=>'id', 'default_sort_direction'=>'ASC');
		
		$this->loadActions();
		
		include(LANGUAGESDIR.$_SESSION['admin_interface_language'].".php");
		$this->phrases = $cms_phrases;
				
		$table_list = array();
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['title'], 'column_name'=>'title', 'editorship'=>0, 'elm_type'=>FRM_TEXT);
		
		$this->table_list = $table_list;
		
	}
	
	function getListingSum(){
		return $this->module->getModulesCategoriesSum($this->sqlQueryJoins, $this->sqlQueryWhere);
	}
	
	function getListingItems(){

    	$order_by = $this->listing_filter_data['order_by'];
    	$order_direction = $this->listing_filter_data['order_direction'];
    	$offset = $this->listing_filter_data['offset'];
    	$paging = $this->listing_filter_data['paging'];
    	
    	if($order_by=='') $order_by = $this->module_info['default_sort'];
    	if($order_direction=='') $order_direction = $this->module_info['default_sort_direction'];

    	$this->sqlQueryLimit = " LIMIT $offset, $paging ";
        if($order_by!='') $this->sqlQueryOrder = " ORDER BY $order_by $order_direction ";
        $list = $this->module->listModulesCategories($this->sqlQueryJoins, $this->sqlQueryWhere, $this->sqlQueryOrder, $this->sqlQueryLimit);
		
		return $list;     

    }	
	
}

?>