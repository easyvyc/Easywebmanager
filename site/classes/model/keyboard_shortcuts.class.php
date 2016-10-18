<?php

include_once(APP_CLASSDIR."model.class.php");
class model_keyboard_shortcuts extends model {
	
	function __construct(){
		
		parent::__construct("keyboard_shortcuts");
		
	}
        
        function listSearchItems($query){
            $query['joins']['pages'] = "LEFT JOIN " . Config::$val['pr_code'] . "_pages P ON (P.record_id=T.page_link AND P.lng='$this->language')";
            $query['fields'][] = "DISTINCT R.id";
            $query['fields'][] = "T.*";
            $query['fields'][] = "R.*";
            $query['fields'][] = "P.page_url";
            $list = parent::listSearchItems($query);
            return $list;
        }
        
}

?>
