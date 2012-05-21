<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_polls extends modules {

    function __construct($module) {
    
    	parent::__construct($module);
    
    }
    
    function activateOnlyOneCategory($data){
    	
    	if($data['is_category']==1 && $data['activated']==1){
    		
    		$sql = "UPDATE $this->table SET activated=0 WHERE record_id!={$data['id']}";
    		$this->db->exec($sql, __FILE__, __LINE__);
    		
    	}
    	
    }
}
?>