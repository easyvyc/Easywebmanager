<?php

include_once(APP_CLASSDIR."model.class.php");
class model_apklausos_variantai extends model {
	
    function __construct(){
        parent::__construct("apklausos_variantai");
    }

    function list_variantai($apklausa_id){
        $query['where']['apklausa_id'] = $apklausa_id;
        $list = $this->listSearchItems($query);
        return $list;
    }
    
    function add_vote($id){
        $data = $this->loadItem($id);
        $value = $data['vote_count'] + 1;
        $this->updateField($id, 'vote_count', $value);
    }
        
}

?>
