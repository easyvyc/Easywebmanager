<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_products extends controller {
	
	public function __construct() {
		parent::__construct ("products");
	}

        function category_select_element($elm_obj){
            if(is_array($elm_obj->get('value'))){
                TPL::setVar('elm_values', $elm_obj->get('value'));
                TPL::setVar('elm_value_arr', "[" . implode(",", $elm_obj->get('value')) . "]");
            }
            $list_values = $elm_obj->get('list_values');
            $list = $this->registry->model->pages->loadTree($list_values['parent_id']);
            return $list;
        }
        
        function new_item($default_data = array()) {
            
            if($this->get['cid']){
                $default_data['category'] = $this->get['cid'];
            }
            
            return parent::new_item($default_data);
        }

        function modif(){
            
            $id = $this->get['id'];
            //return $this->actions($id)."<div id='action_area_$id' class='action_area'>".$this->editItemForm($id)."</div>";

            $data = $this->mod->loadItem($id);
            $mod = $this->mod->module_info;

            $mod['name'] = 'save';
            $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
            $mod['action'] = "javascript: void();";
            
            $mod['hiddens']['id'] = $id;
            $mod['hiddens']['isNew'] = ($id ? 0 : 1);
            $mod['hiddens']['language'] = $this->language;
            $mod['hiddens']['parent_id'] = ($parent_id ? $parent_id : $data['parent_id']);
            $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

            $list_values = array('source' => 'DB', 'module' => 'products_modifications_values', 'column' => 'category_id');
            
            $fields = array();
            $fields[] = array('title' => cms::$phrases['products']['context_menu']['modif_title'], 'elm_type' => FRM_LIST, 'list_values' => $list_values);

            $form_content = $this->editForm($mod, $fields, $data);

            return $this->actions($id) . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
            
            
        }
        
        function filters(){
            return $this->registry->controller->products_fields->listing($this->get['cid']);
        }

	function tree(){
		
		if(is_numeric($this->get['parent_id'])){
			$pid = $this->get['parent_id'];
			$nav = "";
		}else{
			$pid = 0;
			$nav = parent::tree();
		}
		
		$this->registry->model->pages->listing_filter_data['parent_id'] = $pid;
                
                $this->registry->model->pages->sqlQueryWhere[] = "T.template = 'products'";
		$sum  = $this->registry->model->pages->getListingSum();
		
                $list = $this->addContextToList($this->registry->model->pages->getListingItems($pid));
		
		foreach($list as $i=>$val){
			$list[$i]['sub'] = $this->registry->model->pages->isSub($val['id']);
		}
		if(!empty($list)){
			$list[(count($list)-1)]['_LAST'] = true;
		}
		
		TPL::setVar('tree_id', $pid);
		TPL::setVar('module', $this->mod->module_info);
		TPL::setVar('tree_list', $list);
		//TPL::setVar('paging', $paging);
		
		return $nav.TPL::parse(TPLDIR."blocks/tree.tpl");		
		
	}
        
}

?>