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
	
	
	// Start actions
	
	/**
	 * 
	 * Display item edit form
	 */
	function edit(){
		
		$id = $this->get['id'];
		//return $this->actions($id)."<div id='action_area_$id' class='action_area'>".$this->editItemForm($id)."</div>";
		return array('_WINDOW_content'=>$this->actions($id)."<div id='action_area_$id' class='action_area'>".$this->editItemForm($id)."</div>");
	}
	
	function delete(){
		
		$id = $this->get['id'];
		
		$data = $this->mod->loadItem($id);
		$mod = $this->mod->module_info;
		
		if(false){
			
		}else{
			$mod['name'] = 'delete';
			$mod['id'] = '_FORM_'.$id;
			$mod['action'] = "javascript: void(\$NAV.post('?module={$mod['table_name']}&method=delete&id=$id', $('#{$mod['id']}')));";
			
			$fields = array();
			$fields['delete_all'] = array(
										'type'=>FRM_CHECKBOX, 
										'title'=>$this->phrases['main']['catalog']['language_delete_all'], 
										'value'=>1, 
										'checked'=>1, 
										'editorship'=>1, 
										'field_extra_params'=>" onclick=\"javascript: var i=1; if(this.checked==true) while(document.getElementById('ELMID_language_actions_'+i)) document.getElementById('ELMID_language_actions_'+i++).checked=true; \""
									);
			
			if($mod['multilng']==1 && count(Config::$val['default_page'])>1){
				$fields['language_actions'] = array(
												'type'=>FRM_CHECKBOX_GROUP, 
												'title'=>$this->phrases['main']['catalog']['language_delete_item'], 
												'list_values'=>"source=DB::module={$mod['table_name']}::method=get_lngs_for_delete::parent_id=$id", 
												'field_extra_params'=>"onclick=\"javascript: if(this.checked!=true) $('#ELMID_delete_all').attr('checked',false);\" ", 
												'editorship'=>1
											);
			}
			
			$mod['hiddens']['id'] = $id;
			
			$form_obj = new Form($mod, $fields, $data);
			$html = $form_obj->process($this->post);
		}
		
		return $this->actions($id)."<div id='action_area_$id' class='action_area'>".$html."</div>";
	}
	
	// End actions
	
	function actions($id){
		$actions = $this->registry->actions->{$this}->listItems($id);
		foreach($actions as $key=>$val){
			$actions[$key]['action'] = preg_replace("/{id}/", $id, $actions[$key]['action']);
			$actions[$key]['active'] = ($this->get['method']==$key?1:0);
		}
		TPL::setVar('id', $id);
		TPL::setVar('actions', $actions);
		return TPL::parse(TPLDIR."blocks/actions.tpl");
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
		
		$data = array();
		$data[$column] = $value;
		$data['id'] = $id;
		$data['language'] = $this->language;
		
		$elm_obj = Form::createElement($column, $this->mod->_table_fields[$column]);
		if($elm_obj->validate($data)){
			$this->mod->updateField($id, $column, $value);
			$json->error = 0;
			$json->value = $value;
		}else{
			$json->error = 1;
			$json->error_message = $elm_obj->getMessage();
			$json->value = $value;
		}
		echo json_encode($json);
		exit;
	}
	
	function changeOrder(){
		$fid = $this->db->escape_str($this->get['firstid']);
		$lid = $this->db->escape_str($this->get['lastid']);
		$this->mod->changeOrder($fid, $lid);
		redirect("?module={$this->get['module']}&cid={$this->get['cid']}&offset={$this->get['offset']}&ajax={$this->get['ajax']}");
	}
	
	function save($data){
		
	}
	
	function tree(){
		
	}
	
	/**
	 * 
	 * return module name
	 */
	function __toString(){
		return $this->mod->module_info['table_name'];
	}
	
}

?>