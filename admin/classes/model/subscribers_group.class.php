<?php

include_once(APP_CLASSDIR."model.class.php");
class model_subscribers_group extends model {
	
	function __construct() {
    	parent::__construct("subscribers_group");
    	
    }

    function listItemsForNewsletter(){
        
        $this->sqlQueryJoins[] = "LEFT JOIN " . Config::$val['pr_code'] . "_subscribers S ON (S.category=T.record_id)";
        $this->sqlQueryFields = " COUNT(S.id) AS subscriber_count ";
        $this->sqlQueryGroup[] = " R.id ";
        $list = $this->listSearchItems();
        $categories = array();
        foreach($list as $i => $val){
            $categories[] = array('title' => $val['title'] . " <b>(" . $val['subscriber_count'] . ")</b>", 'id' => $val['id']);
        }
        return $categories;
        
    }
    
}

?>