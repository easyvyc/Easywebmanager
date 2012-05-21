<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_pages extends actions {

    function __construct() {
    	
    	parent::__construct();
    	
    	$this->mod_actions = array('edit'=>array(), 'translate'=>array(), 'new'=>array(), /*'import'=>array(), 'export'=>array(), 'pdf'=>array(),*/ 'delete'=>array(), 'fields'=>array('title'=>array('lt'=>'Kategorijos papildymai', 'en'=>'Category extra')));
    	    	
    }

    function _block(){
    }
    
    function _fields(){
    }
     
}

?>