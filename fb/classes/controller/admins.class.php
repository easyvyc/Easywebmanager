<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_admins extends controller {
	
	public function __construct() {
		parent::__construct ("admins");
	}
	
	function login(){
		$login_data = $this->mod->checkLogin($_POST);
		$json = new stdClass();
		if(!empty($login_data)){
			
			$_SESSION['admin'] = $login_data;
			$_SESSION['admin']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['admin']['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
			$this->mod->registerAdminLogin();
			
			// Remove old data from trash
//			include_once(CLASSDIR."trash.class.php");
//			$trash_obj = & new trash();
//			$trash_obj->deleteOldItems($XML_CONFIG['max_trash_items']);			
			
			$lng_rights = $this->mod->loadLanguageRights($login_data['id']);
			if(in_array(Config::$val['default_lng'], $lng_rights)){
				foreach(Config::$val['default_page'] as $key=>$val){
					if(!in_array($key, $lng_rights)){
						$_SESSION['site_lng'] = $key;
						break;
					}
				}
			}else{
				$_SESSION['site_lng'] = Config::$val['default_lng'];
			}			
			
			$json->loged = true;
		}else{
			$json->loged = false;
			$json->message = $this->phrases['login']['wrong_login'];
		}
		return json_encode($json);
	}

	function remind(){
		$login_data = $this->mod->checkEmail($_POST['email']);
		$json = new stdClass();
		if(!empty($login_data) && $_POST['email']!=''){
			$this->mod->sendRemindConfirm($login_data);
			$json->message = $this->phrases['login']['confirm_code_sent'];
			$json->remind = true;
		}else{
			$json->remind = false;
			$json->message = $this->phrases['login']['wrong_remind'];
		}
		return json_encode($json);
	}
		
}

?>