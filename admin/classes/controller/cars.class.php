<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_cars extends controller {
	
	public function __construct() {
            parent::__construct ("cars");
	}
        
        function select_car_modif(){
            
            $cars = $this->mod->getMarkes();
            TPL::setVar('cars', $cars);
            
            $car_modifs = $this->mod->getProductModifs($this->get['id']);
            TPL::setVar('car_modifs', $car_modifs);
            
            return TPL::parse(TPLDIR."forms/custom/cars.tpl");;
        }
        
        function list_model_by_mark(){
            $list = $this->mod->getModels($this->get['car_mark']);
            $arr = array();
            $arr[''] = "---";
            foreach($list as $val){
                $arr[$val['id']] = $val['title'];
            }
            return json_encode($arr);
        }
        
        function list_modif_by_modif(){
            $list = $this->registry->model->cars_modif->getItems($this->get['car_model']);
            $arr = array();
            $arr[''] = "---";
            foreach($list as $val){
                $arr[$val['id']] = $val['title'];
            }
            return json_encode($arr);
        }
        
	function something_after_success_submit($return_val){
		$data = $this->mod->loadItem($return_val);
		$parent_id = $data['parent_id'];
                return parent::something_after_success_submit($return_val).($return_val?"<script> _TREE_cars.list('$parent_id'); \$('.formElementsField').removeClass('edited'); </script>":"");
	}
	
	function something_after_success_delete($return_val){
		$data = $this->mod->loadItem($return_val);
		$parent_id = $data['parent_id'];
		return parent::something_after_success_delete($return_val).($return_val?"<script> _TREE_cars.list('$parent_id'); </script>":"");
	}
	
	function tree(){
		
		if(is_numeric($this->get['parent_id'])){
			$pid = $this->get['parent_id'];
			$nav = "";
		}else{
			$pid = 0;
			$nav = parent::tree();
		}
		
		$this->mod->listing_filter_data['parent_id'] = $pid;
		$sum  = $this->mod->getListingSum();
		$list = $this->addContextToList($this->mod->getTreeItems($pid));
		
		foreach($list as $i=>$val){
			$list[$i]['sub'] = $this->mod->isSub($val['id']);
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
        
        function editForm($mod, $fields, $data){
            
            if($data['parent_id'] == 0){
                unset($fields['cars_modif']);
            }
            
            return parent::editForm($mod, $fields, $data);
        }
		
}

?>