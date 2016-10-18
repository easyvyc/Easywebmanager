<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_ordered_items extends actions {

    function __construct() {
    	
    	parent::__construct("ordered_items");
    	
        $this->remove("copy");
        $this->remove("info");
        
        $this->edit("edit", array(
                                'action' => "javascript: void(\$NAV.open_dialog('ordered_item_{id}', '?module=ordered_items&method=edit&id={id}&no_tree_reload=1&json=0', 'Edit item'));", 
        ));
        $this->edit("delete", array(
                                'action' => "javascript: void(\$NAV.open_dialog('ordered_item_{id}', '?module=ordered_items&method=delete&id={id}&no_tree_reload=1&json=0', 'Delete item'));", 
        ));
        
    }
    
}

?>