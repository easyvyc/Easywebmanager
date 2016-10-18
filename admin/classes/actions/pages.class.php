<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_pages extends actions {

    function __construct() {
    	
    	$this->add("blocks", array(), 1);
    	parent::__construct("pages");
    	$this->edit('edit', array('title'=>cms::$phrases['modules']['context_menu']['page_edit_title']));
    	$this->add("inner_list", array(
    									'name'=>'inner_list', 
    									'img'=>'list1', 
    									'title'=>($_SESSION['admin_interface_language'] == 'lt' ? "Vidiniai" : "Inner list"), 
    									'action'=>"javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=inner_list&cid={id}'));"
    				), 3);
    	$this->add("new_item", array(
    									'name'=>'new_item', 
    									'img'=>'new_item', 
    									'title'=>cms::$phrases['modules']['context_menu']['create_inner'], 
    									'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'new_item', '{id}'));"
    				), 4);
//    	$this->add("products", array(
//    									'name'=>'products', 
//    									'img'=>'app3', 
//    									'title'=>cms::$phrases['pages']['context_menu']['category_products'], 
//    									'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'products', '{id}'));"
//    				), 4);
    	
    }
    
    function getContextMenu($item){
    
    	$z_arr = array('edit', 'module', 'delete', 'translate', 'products');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
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