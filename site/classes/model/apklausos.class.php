<?php

include_once(APP_CLASSDIR."model.class.php");
class model_apklausos extends model {
	
    function __construct(){
        parent::__construct("apklausos");
    }

    function get_top(){
        $query['limit'] = "1";
        $list = $this->listSearchItems($query);
        
        $apklausa = $list[0];
        
        return $apklausa;
    }

    function add_vote($id){
        $data = $this->loadItem($id);
        $value = $data['vote_count'] + 1;
        $this->updateField($id, 'vote_count', $value);
    }
    
}

?>
