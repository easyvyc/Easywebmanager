<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_products_fields_options extends actions {

    function __construct() {
    	
    	parent::__construct("products_fields_options");
    	
        $this->mod_actions = array();
        
    }
    
}

?>