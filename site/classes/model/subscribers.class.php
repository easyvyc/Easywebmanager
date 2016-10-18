<?php

include_once(APP_CLASSDIR."model.class.php");
class model_subscribers extends model {
	
	function __construct(){
		parent::__construct("subscribers");
	}
	
	function insert($data){

            $existing_data = $this->loadByOne(array('title' => $data['title']));
            if(empty($existing_data)){
                return parent::insert($data);
            }
            
            return false;
            
	}
	
        function insert_email($email){
            $data = array();
            $data['title'] = $email;
            $data['active'] = 1;
            return $this->insert($data);
        }

}

?>
