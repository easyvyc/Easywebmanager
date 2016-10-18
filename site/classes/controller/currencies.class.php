<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_currencies extends controller {
	
        private $current;
    
	function __construct(){
            parent::__construct("currencies");
            
            $this->current = array('title'=>'€', 'title_eur'=>'LTL', 'code'=>'EUR');
            
	}
        
        function getCurrent(){
            return $this->current;
        }
		
}

?>
