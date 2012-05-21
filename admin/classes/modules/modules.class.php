<?php

include_once(CLASSDIR."main_module.class.php");
include_once(APP_CLASSDIR.'modules.class.php');
class modules_modules extends modules {
	
	private $module;
	
	public function __construct() {
		
		basic::__construct();
		
		$this->module = new main_module();
		$this->admin = $_SESSION['admin'];
		
		$this->module_info = array('table_name'=>'modules', 'default_sort'=>'sort_order', 'default_sort_direction'=>'ASC');
		
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
				
		$this->table_list();
		
		$this->table_fields();
		
	}
	
	function table_fields(){
		$this->_table_fields = & $this->module->_table_fields;
	}
	
	function table_list(){
		$table_list = array();
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['title'], 'column_name'=>'title_'.$_SESSION['admin_interface_language'], 'editorship'=>0, 'elm_type'=>FRM_TEXT);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['table_name'], 'column_name'=>'table_name', 'editorship'=>0, 'elm_type'=>FRM_TEXT);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['multilng'], 'column_name'=>'multilng', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['catalog'] , 'column_name'=>'tree', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['cache'], 'column_name'=>'cache', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['no_delete'], 'column_name'=>'forbid_delete', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['no_sort'], 'column_name'=>'forbid_sort', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['no_filter'], 'column_name'=>'forbid_filter', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['no_record_table'], 'column_name'=>'no_record_table', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['rss'], 'column_name'=>'rss', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['search'], 'column_name'=>'search', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		$table_list[] = array('title'=>$this->phrases['main']['settings']['module']['disabled'], 'column_name'=>'disabled', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		
		$this->table_list = $table_list;
	} 
	
	public function list_menu(){
		
		$cat = $this->module->listFolders();
		$items = $this->module->listAdminModules($this->admin['id']);
		
		$mods = array();
		foreach($items as $i=>$val){
			if($val['folder_id']==0) continue;
			$mods[$val['folder_id']][] = $val;
		}
		
		$modules = array();
		foreach($cat as $i=>$val){
			if(!empty($mods[$val['id']])){
				$val['sub'] = $mods[$val['id']];
				$modules[] = $val;
			}
		}
		
		return $modules;
		
	}
	
	function getListingSum(){
		return $this->module->getModulesSum($this->sqlQueryJoins, $this->sqlQueryWhere);
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
        $list = $this->module->listModules($this->sqlQueryJoins, $this->sqlQueryWhere, $this->sqlQueryOrder, $this->sqlQueryLimit);
		
		return $list;     

    }
	
    function loadItem($id){
    	return $this->module->getModule($id);
    }
    
    function delete($id){
    	$this->module->deleteModule($id);
    }
    
    function changeOrder($lid, $fid){
    	$this->module->changeOrder($lid, $fid);
    }
	
}

?>