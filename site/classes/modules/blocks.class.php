<?php
include_once(CLASSDIR."catalog.class.php");
class blocks extends catalog {

    function __construct() {
    	parent::__construct("blocks");
    }
    
    function loadItem_byPageId($page_id, $block_name){
    	
    	$this->sqlQueryWhere = " page_id=$page_id AND block_name='$block_name' AND ";
    	$arr = $this->listSearchItems();
    	
    	return $arr[0]['description'];
    	
    }
    
}
?>