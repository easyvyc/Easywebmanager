<?php

include_once (APP_CLASSDIR . 'controller.class.php');
class controller_users extends controller {
	
    public function __construct() {
        parent::__construct ("users");
    }
    
    function login_as(){
        
        $user_data = $this->mod->loadItem($this->get['id']);
        
        if(!empty($user_data) && $user_data['id']){
            $_SESSION['logged_user'] = $user_data;
            redirect(Config::$val['site_url']);
        }
        
    }
    
}

?>