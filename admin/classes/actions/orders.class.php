<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_orders extends actions {

    function __construct() {
    	
    	parent::__construct("orders");
    	
        $this->remove("copy");
        
        $this->edit("edit", array(
                                'title'=>cms::$phrases['modules']['context_menu']['view'], 
                                'img'=>'zoom'
        ));
        
        $this->add("products", array(
                                'title'=>cms::$phrases['orders']['context_menu']['ordered_items'], 
                                'img'=>'list1',
                                'hide_when_zero'=>true,
                                'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'products', '{id}'));"
                            ),
                    2);
    	    	
    }
    
}

?>