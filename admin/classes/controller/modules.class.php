<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_modules extends controller {
	
	public function __construct() {
		parent::__construct ("modules");
	}
	
	function checkExistTableName($value, $data){
		return $this->mod->checkExistTableName($value, $data);
	}
        
        function clean(){
            
            set_time_limit(0);
            ini_set("memory_limit", "10024M");
            
            $modules = array();
            
            $list = $this->mod->list_record_table();
            
            $counter = 0;
            foreach($list as $val){
                
                if(!$modules[$val['module_id']]){
                    $modules[$val['module_id']] = $this->mod->loadItem($val['module_id']);
                }
                
                if(empty($modules[$val['module_id']])){
                    $this->mod->remove_record_item($val['id']);
                }
                
                if($modules[$val['module_id']]['no_record_table'] != 1){
                    if(strlen($modules[$val['module_id']]['table_name'])>0){
                        $row = $this->registry->model->{$modules[$val['module_id']]['table_name']}->loadItem($val['id']);
                        if($row['id'] == 0){
                            $this->mod->remove_record_item($val['id']);
                            $counter++;
                        }
                    }
                }
                
            }

            // clean relations table
//            $list = $this->mod->list_relations_table();
//            
//            $counter = 0;
//            foreach($list as $val){
//                
//                if(!$modules[$val['module_id']]){
//                    $modules[$val['module_id']] = $this->mod->loadItem($val['module_id']);
//                }
//                
//                if(empty($modules[$val['module_id']])){
//                    $this->mod->remove_record_item($val['id']);
//                }
//                
//                if($modules[$val['module_id']]['no_record_table'] != 1){
//                    if(strlen($modules[$val['module_id']]['table_name'])>0){
//                        $row = $this->registry->model->{$modules[$val['module_id']]['table_name']}->loadItem($val['id']);
//                        if($row['id'] == 0){
//                            $this->mod->remove_record_item($val['id']);
//                            $counter++;
//                        }
//                    }
//                }
//                
//            }
            
            pae($counter);
            
        }

	function tree(){
		
		if($this->get['parent_id']){
			$parent_id = $this->get['parent_id'];
			$prefix = substr($parent_id, -1);
			$parent_id = substr($parent_id, 0, -1);
		}
		
		if(is_numeric($parent_id)){
			if($prefix == 'M'){
				$pid = $parent_id;
				$nav = "";
				$list = $this->mod->get_module_columns($pid);
				$list = $this->registry->controller->module_info->addContextToList($list);
                                $sum = array('_COUNT_'=>count($list));
				TPL::setVar('prefix', 'F');
			}else{
				$pid = $parent_id;
				$nav = "";
				$list = $this->addContextToList($this->mod->getListingItems($pid));
				$sum = array('_COUNT_'=>count($list));
				TPL::setVar('prefix', 'M');
				foreach($list as $i=>$val){
					$list[$i]['sub'] = true;
				}
			}
		}else{
			$pid = 0;
			$nav = parent::tree();
			$sum  = $this->registry->model->module_category->getListingSum();
			$list = $this->registry->model->module_category->getListingItems();
			
			$list = $this->registry->controller->module_category->addContextToList($list);
			
			foreach($list as $i=>$val){
				$list[$i]['sub'] = true;
			}
			TPL::setVar('prefix', 'C');
		}

		if(!empty($list)){
			$list[(count($list)-1)]['_LAST'] = true;
		}
		
		//pae($this->mod->module_info);
		
		TPL::setVar('tree_id', $pid);
		TPL::setVar('module', $this->mod->module_info);
		TPL::setVar('tree_list', $list);
		//TPL::setVar('paging', $paging);
		
		return $nav.TPL::parse(TPLDIR."blocks/tree_modules.tpl");			
		
	}

	function addLang(){
		
		benchmark::mode(true);
		
		if(!isset($_GET['lng']) || !isset($_GET['lng_from'])){
			exit;
		}

		$list = $this->mod->list_all_modules();
		$n = count($list);

		for($i=0; $i<$n; $i++){
	
			if($list[$i]['multilng'] == 1){

				$columns = $this->mod->get_module_columns($list[$i]['id']);
				$m = count($columns);
		
				for($j=0, $fld=array(); $j<$m; $j++){
					$fld[] = $columns[$j]['column_name'];
				}
		
				if(!empty($fld))
					$fields = implode(", ", $fld).", ";
				
					
				$sql = "INSERT INTO ".Config::$val['pr_code']."_{$list[$i]['table_name']} ($fields record_id, lng) " .
						" SELECT $fields record_id, '{$_GET['lng']}' FROM ".Config::$val['pr_code']."_{$list[$i]['table_name']} WHERE lng='{$_GET['lng_from']}'";
				
				$this->mod->db->query($sql);
				//$database->exec($sql, __FILE__, __LINE__);
		
			}
	
		}

		echo benchmark::result();
		
		exit;
		
	}
        
        function new_column(){
            return $this->registry->controller->module_info->new_item($this->get['id']);
        }
        
        function columns($module_id){
            return $this->registry->controller->module_info->listing($this->get['id']);            
        }
	
}

?>