<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_cars extends actions {

    function __construct() {
    	
    	parent::__construct("cars");
    	$this->add("new_item", array(
                                    'name'=>'new_item', 
                                    'img'=>'new_item', 
                                    'title'=>($_SESSION['admin_interface_language'] == 'lt' ? "Sukurti modelį" : "Create Model"), 
                                    'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'new_item', '{id}'));"
    				), 2);
    	
    }
    
    function getContextMenu($item){
    
    	$z_arr = array('edit', 'module', 'delete', 'translate', 'products');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
                
                if($item['parent_id']!=0 && $key == 'new_item') continue;
                
                // tik su sablonu products puslapiai turi action products
                if($key == 'products' && $item['template'] != 'products') continue;
    		$act = str_replace("{id}", $item['id'], $val['action']);
    		$context[] = array(
    			'img'=>($val['img'] ? $val['img'] : $key), 
    			'name'=>$key, 
    			'title'=>$val['title'], 
    			'action'=>$act, 
    			'main_action'=>$act
    		);
    	}

	return $context;
		
    }    

    function _block(){
    }
    
    function _fields(){
    }
     
}

?>