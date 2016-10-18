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
			$json->message = cms::$phrases['login']['wrong_login'];
		}
		return json_encode($json);
	}

	function remind(){
		$login_data = $this->mod->checkEmail($_POST['email']);
		$json = new stdClass();
		if(!empty($login_data) && $_POST['email']!=''){
			$this->mod->sendRemindConfirm($login_data);
			$json->message = cms::$phrases['login']['confirm_code_sent'];
			$json->remind = true;
		}else{
			$json->remind = false;
			$json->message = cms::$phrases['login']['wrong_remind'];
		}
		return json_encode($json);
	}
	
	function is_loged(){
		return isset($_SESSION["admin"]["id"]);
	}
	
	function logout(){
		unset($_SESSION['admin']);
		redirect(Config::$val['admin_url']);
	}

	function checkLoginData($value, $column, $data){
		$value = trim($value);
		return $this->mod->checkLoginData($value, $column, $data);
	}
        
        
        
    function logins(){
    	
        benchmark::mark('start_listing', 'Listingo pradzia');

        include_once(APP_CLASSDIR."listing.class.php");
        $listing_obj = new listing("admin_stat");

        $listing_obj->set('edit_button', 0);
        $listing_obj->set('delete_button', 0);
        $listing_obj->set('select_button', 0);
        $listing_obj->set('dragndrop', 0);
        $listing_obj->set('actions_button', 0);
        $listing_obj->set('filter_form', 1);

        $this->mod->filterListing();

        $listing_obj->setFilters($_SESSION['filters'][$this->get['module']]);
        $listing_obj->setColumns($this->mod->table_list);

        $this->mod->prepareListing($listing_obj->columns);

        $admin_id = $this->get['id'];
        $offset = $this->get['offset'];
        $paging = $listing_obj->selected_paging;

        $sum_data = $this->mod->getAdminStatCount($admin_id);
        $list_items = $this->mod->getAdminStat($admin_id, $offset * $paging, $paging);
        pae($list_items);

        $listing_obj->setItemsData($sum_data);
        $listing_obj->setItems($list_items);
        $listing_obj->paging($offset);
        $listing_obj->pagingSelect();

        if(empty($list_items)){
                $_count = 0;
        }else{
                $_count = count($list_items);
        }

        benchmark::mark('end_listing', 'Listingo pabaiga');

        return $listing_obj->generate();
	    	
    }
        
	
}

?>