<?php

include_once (CLASSDIR.'basic.class.php');
class controller extends basic {
	
	protected $mod;
	
	function __construct($module) {
		parent::__construct ();
		benchmark::mark('construct_controller', 'Controller objectas '.$module);
		$this->mod = $this->registry->modules->$module;
        // Module language
		$this->language = $_SESSION['site_lng'];
    	    	
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
		
	}
	
	function _default(){
		return $this->listing();
	}
	
	function listing($parent_id=0){

		benchmark::mark('start_listing', 'Listingo pradzia');
		
		$this->mod->listingActions();
		$this->mod->filterListing();
    	
    	include_once(APP_CLASSDIR."listing.class.php");
		$listing_obj = new listing($this->mod->module_info['table_name']);
    	
		$listing_obj->setFilters($_SESSION['filters'][$this->get['module']]);
		
		$listing_obj->setColumns($this->mod->table_list);
		
		$this->mod->prepareListing($listing_obj->columns);
		$sum_data = $this->mod->getListingSum($parent_id);
    	$list_items = $this->mod->getListingItems($parent_id);
    	
    	$listing_obj->setItemsData($sum_data);
    	$listing_obj->setItems($list_items);
    	$listing_obj->paging($this->get['offset']);
    	$listing_obj->pagingSelect();
		
    	benchmark::mark('end_listing', 'Listingo pabaiga');
    	
    	return $listing_obj->generate();
		
	}
	
	function edit(){
		
		$id = $this->get['id'];
		return $this->editItemForm($id);
		
	}
	
	function editItemForm($id, $parent_id=0){
		
		$data = $this->mod->loadItem($id);
		$mod = $this->mod->module_info;
		$mod['name'] = 'save';
		$mod['id'] = '_FORM_'.$id;
		$mod['action'] = "javascript: void(\$NAV.post('?module={$mod['table_name']}&method=edit&id=$id', $('#{$mod['id']}')));";
		$fields = $this->mod->_table_fields;
		
		$mod['hiddens']['id'] = $id;
		$mod['hiddens']['isNew'] = ($id?0:1);
		$mod['hiddens']['language'] = $this->language;
		$mod['hiddens']['parent_id'] = ($parent_id?$parent_id:$data['parent_id']);
		
		$form_obj = new Form($mod, $fields, $data);
		return $form_obj->process($this->post);
		//return array('_WINDOW'=>$form_obj->process($this->post));
		
	}
	
	function change_field(){
		$id = $this->post['id'];
		$column = $this->post['column']; 
		$value = $this->post['value'];
		$json = new stdClass();
		// TODO: padaryt duomenu tikrinima (validate)
		if($this->mod->updateField($id, $column, $value)){
			$json->error = 0;
			$json->value = $value;
		}else{
			$json->error = 1;
			$json->error_message = 1;
			$json->value = $value;
		}
		return json_encode($json);
	}
	
	function save($data){
		
	}
	
	function tree(){
		
	}
	
}

?>