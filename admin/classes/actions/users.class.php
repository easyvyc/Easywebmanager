<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_users extends actions {

    function __construct() {
    	
    	parent::__construct("users");
    	
        $this->remove("copy");
        
        $this->add("login_as", array(
                                    'img'=>'user2',
                                    'name'=>'login_as',
                                    'hide_when_zero'=>true,
                                    'title'=>($_SESSION['admin_interface_language'] == 'lt' ? "Prisijungti" : "Login as user"),
                                    'action'=>"javascript: void(window.open('admin.php?module=users&method=login_as&id={id}&no_tree_reload=1&json=0'));"
                                    ),
                                    3
        );        
    	    	
    }
	
    
}

?>