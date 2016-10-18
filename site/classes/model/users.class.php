<?php

include_once(APP_CLASSDIR."model.class.php");
class model_users extends model {
	
	function __construct(){
		parent::__construct("users");
	}
	
        function try_login($username, $password){
            
            $cond['email'] = trim($username);
            $cond['pswd'] = md5($password);
            
            $data = $this->loadBy($cond);
            
            if(!empty($data)){
                return $data[0]['id'];
            }else{
                return false;
            }
            
        }
    
}

?>
