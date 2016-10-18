<?php

include_once(APP_CLASSDIR."model.class.php");
class model_subscribers extends model {

    function __construct() {
    	parent::__construct("subscribers");
    }

    function insertEmail($email, $category=0){
        // valid email 
        if(valid_email($email)){
                return false;
        }

        // email exist
        if($this->checkDataExist(array('column_name'=>'title', 'value'=>$email), array('id'=>0))==1){
                return false;
        }

        $data['isNew'] = 1;
        $data['id'] = 0;
        $data['parent_id'] = 0;

        $data['title'] = $email;
        $data['category'] = $category;
        $data['active'] = 1;

        return $this->saveItem($data);

    }
    
    function listForSend($groups, $offset){
        if(!empty($groups)){
            $query['where'] = " T.category IN (" . implode(",", $groups) . ") ";
            $list = $this->loadSearchItems($query);
        }
        return $list;
    }
    
}

?>