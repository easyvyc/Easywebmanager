<?php

include_once(APP_CLASSDIR."model.class.php");
class model_admins extends model {
	
	private $confirm_valid_days_count = 3;
	
	// constructor inherit record class
	function __construct(){
		
		parent::__construct("admins");
                
                $this->module_info['export'] = false;
		//$this->mod_actions = array('edit'=>array(), 'rights'=>array('title'=>array('lt'=>'Privilegijos', 'en'=>'Rights'), 'img'=>'rights'), 'logins'=>array('title'=>array('lt'=>'Prisijungimai', 'en'=>'Logins'), 'img'=>'logins'), 'new'=>array(), /*'export'=>array(), 'pdf'=>array(),*/ 'delete'=>array());
		
	}
	
	function saveItem($data){
		
		if($data['isNew']==1){
			$data['permission'] = $this->admin['permission'] + 1;
		}
		$data['title'] = "{$data['login']} ({$data['firstname']} {$data['lastname']})";

		$admin_id = parent::saveItem($data);
		
		if($data['isNew']==1){

			$this->inheritAdminRecordsRights($admin_id, $this->admin['id']);
			//$this->inheritAdminPagesRights($admin_id, $_SESSION['admin']['id']);
			$this->inheritLanguagesRights($admin_id, $this->admin['id']);
			$this->inheritModulesRights($admin_id, $this->admin['id']);

		}
		
		return $admin_id;
	}
	
	private function inheritModulesRights($child_admin, $parent_admin){

			$arr = $this->loadModuleRights($parent_admin);
			$str = implode("::", $arr);
			$this->db->update($this->table)
					 ->values("mod_rights=:mod_rights")
					 ->where("record_id=:record_id")
					 ->bind('mod_rights', $str)
					 ->bind('record_id', $child_admin)
					 ->query();

	}
	
	private function inheritLanguagesRights($child_admin, $parent_admin){

			//$arr = explode("::", $_SESSION['admin']['lng_rights']);
			$arr = $this->loadLanguageRights($parent_admin);
			foreach(Config::$val['default_page'] as $key => $val){
				if(!in_array($key, $arr)){
					$n_arr[] = $key;
				}
			}
			$str = implode("::", $n_arr);
			$this->saveLanguageRights($child_admin, $str);

	}

	private function inheritAdminRecordsRights($child_admin, $parent_admin){
		
		$arr_ = explode("-", $this->db->version());
		$arr = explode(".", $arr_[0]);
		$version = implode("", $arr);
		
		if($version>40015){
			$sql = "INSERT INTO ".Config::$val['sb_admin_module_rights']." (admin_id, record_id, rights) " .
					"SELECT $child_admin AS admin_id, record_id, rights FROM ".Config::$val['sb_admin_module_rights']." " .
					"WHERE admin_id=$parent_admin";
			$this->db->query($sql);
		}else{
			$arr = $this->db->select(Config::$val['sb_admin_module_rights'])
					 ->fields("record_id, rights")
					 ->where("admin_id=:admin_id")
					 ->bind('admin_id', $parent_admin)
					 ->result_array();
			$n = count($arr);
			for($i=0; $i<$n; $i++){
				$sql = "INSERT INTO ".Config::$val['sb_admin_module_rights']." SET ";
				$this->db->insert(Config::$val['sb_admin_module_rights'])
						 ->values("admin_id=:admin_id, record_id=:record_id, rights=:rights")
						 ->bind('admin_id', $child_admin)
						 ->bind('record_id', $arr[$i]['record_id'])
						 ->bind('rights', $arr[$i]['rights'])
						 ->query();
			}
		}
	}

	function checkEmail($email){
		$n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }		
        return $this->db->select("$this->table T")
        				->fields("$fields R.id AS id, R.parent_id, T.lng_rights, T.mod_rights")
        				->joins("LEFT JOIN {$this->tables['record']} R ON (R.id=T.record_id)")
        				->where("T.email=:email AND T.active=1")
        				->bind('email', $email)
        				->row_array();
	}
	
	function setConfirmData($id){
		$confirm_data['date'] = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")+$this->confirm_valid_days_count,date("Y")));
		$confirm_data['code'] = md5($confirm_data['date'].$id);
		$this->db->update($this->table)
				 ->values("confirm_code=:confirm_code, confirm_date=:confirm_date")
				 ->where("record_id=:id")
				 ->bind('id', $id)
				 ->bind('confirm_code', $confirm_data['code'])
				 ->bind('confirm_date', $confirm_data['date'])
				 ->query();
		return $confirm_data;
	}
	
	function sendRemindConfirm($data){
		
		include_once(CLASSDIR."phpmailer.class.php");
		$mailer = new PHPMailer();
		
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = "Easywebmanager - ".cms::$phrases['login']['password_remind'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		
		$confirm_data = $this->setConfirmData($data['id']);
		
		$msg = cms::$phrases['login']['confirm_email_text'];
		$msg = str_replace("{link}", Config::$val['site_admin_url']."?remind=1&id={$data['id']}&code={$confirm_data['code']}", $msg);
		$msg = str_replace("{confirm_days}", (string)$this->confirm_valid_days_count, $msg);
		$msg = str_replace("{confirm_date}", $confirm_data['date'], $msg);
		
		$message .= $msg;
		
		$mailer->Body = $message;
		
		$mailer->AddAddress($data['email']);
		$mailer->From = "support@easywebmanager.com";
		$mailer->FromName = "Easywebmanager";
		$mailer->Send();		
	}
	
	function checkConfirmation($id, $code){
		$n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }		
        return $this->db->select("$this->table T")
        				->fields("$fields R.id AS id, R.parent_id, T.lng_rights, T.mod_rights")
        				->joins("LEFT JOIN {$this->tables['record']} R ON (R.id=T.record_id)")
        				->where("T.record_id=:record_id AND confirm_code=:confirm_code AND confirm_date>NOW() AND T.active=1")
        				->bind('record_id', $id)
        				->bind('confirm_code', $code)
        				->row_array();
	}
	
	function sendLoginData($id){
		
		$admin_data = $this->loadItem($id);
		
		$newpass = $this->generatePassword($id);
		
		include_once(CLASSDIR."phpmailer.class.php");
		$mailer = new PHPMailer();
		
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = "Easywebmanager - ".cms::$phrases['login']['password_remind'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		
		$msg = cms::$phrases['login']['password_email_text'];
		$msg = str_replace("{link}", Config::$val['site_admin_url'], $msg);
		$msg = str_replace("{loginname}", $admin_data['login'], $msg);
		$msg = str_replace("{password}", $newpass, $msg);
		
		$message .= $msg;
		
		$mailer->Body = $message;
		
		$mailer->AddAddress($admin_data['email']);
		$mailer->From = "support@easywebmanager.com";
		$mailer->FromName = "Easywebmanager";
		$mailer->Send();

		$this->setConfirmData($id);
	}
	
	function generatePassword($id){
		load_helpers('password');
		$newpass = generatePassword(7);
		$this->db->update($this->table)
				 ->values("pass=:newpass")
				 ->where("record_id=:id")
				 ->bind('newpass', md5($newpass))
				 ->bind('id', $id)
				 ->query();
		return $newpass;
	}
	
	function checkLogin($data){
		$n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }
       	$row = $this->db->select("$this->table T")
       					->fields("$fields R.id AS id, R.parent_id, T.lng_rights, T.mod_rights")
       					->joins("LEFT JOIN {$this->tables['record']} R ON (R.id=T.record_id)")
       					->where("T.login=:login AND T.pass=:password AND T.active=1")
       					->bind('login', $data['login'])
       					->bind('password', call_user_func($this->password_hash_function, $data['pass']))
       					->row_array();
       	return $row;
	}
	
	function checkLoginData($value, $column, $data=array()){
		
		$where = $binds = array();
		$where[] = "login=:login";
		$binds['login'] = trim($value);
		
		if($data['id']!=0){
			$where[] = "record_id!=:record_id";
			$binds['record_id'] = $data['id'];
		}

		$arr = $this->db->select($this->table)
						->fields("id")
						->where($where)
						->bind($binds)
						->row_array();
		
		return (empty($arr)?true:false);
		
	}
	
	function registerAdminLogin(){
		$row = $this->db->select(Config::$val['sb_admin_stat'])
						->fields("id")
						->where("admin_id=:admin_id AND session=:session")
						->bind('admin_id', $_SESSION['admin']['id'])
						->bind('session', session_id())
						->row_array();
		if(!empty($row)){
			$this->db->update(Config::$val['sb_admin_stat'])
					 ->values("logout_time=NOW()")
					 ->where("admin_id=:admin_id AND session=:session")
					 ->bind('admin_id', $_SESSION['admin']['id'])
					 ->bind('session', session_id())
					 ->query();
		}else{
			$sql = "INSERT INTO ".Config::$val['sb_admin_stat']." SET admin_id={$_SESSION['admin']['id']}, login_time=NOW(), logout_time=NOW(), ipaddress='".$_SERVER['REMOTE_ADDR']."', session='".session_id()."'";
			$this->db->insert(Config::$val['sb_admin_stat'])
					 ->values("admin_id=:admin_id, login_time=NOW(), logout_time=NOW(), ipaddress=:ipaddress, session=:session")
					 ->bind('admin_id', $_SESSION['admin']['id'])
					 ->bind('ipaddress', $_SERVER['REMOTE_ADDR'])
					 ->bind('session', session_id())
					 ->query();
		}
		$_SESSION['FIRST_SESSION_ID'] = session_id();
		$this->deleteAdminsLoginStats(ADMIN_LOGIN_STATS);
	}
	
	function registerLastAdminTime(){
		if(RESTART_SESSION == 1) return;
		$this->db->update(Config::$val['sb_admin_stat'])
				 ->values("logout_time=NOW()")
				 ->where("admin_id=:admin_id AND session=:session")
				 ->bind('admin_id', $_SESSION['admin']['id'])
				 ->bind('session', $_SESSION['FIRST_SESSION_ID'])
				 ->query();
	}
	
	function getAdminStatCount($id){
		$row = $this->db->select(Config::$val['sb_admin_stat'])
						->fields("COUNT(*) AS cnt")
						->where("admin_id=:admin_id")
						->bind('admin_id', $id)
						->order("login_time DESC")
						->row_array();
		return $row['cnt'];
	}
	
	function getAdminStat($id, $offset, $paging){
		return $this->db->select(Config::$val['sb_admin_stat'])
						->fields("id, login_time, logout_time, ipaddress, SEC_TO_TIME(UNIX_TIMESTAMP(logout_time)-UNIX_TIMESTAMP(login_time)) AS all_time")
						->where("admin_id=:admin_id")
						->bind('admin_id', $id)
						->order("login_time DESC")
						->limit($offset, $paging)
						->result_array();
	}
	
	function deleteAdminsLoginStats($days){
		$this->db->delete(Config::$val['sb_admin_stat'])
				 ->where("TO_DAYS(login_time) < (TO_DAYS(NOW())- :days )")
				 ->bind('days', $days)
				 ->query();
	}
	
	function loadLanguageRights($admin_id){
		$row = $this->db->select($this->table)
						->fields("lng_rights")
						->where("record_id=:record_id")
						->bind('record_id', $admin_id)
						->row_array();
		$arr = explode("::", $row['lng_rights']);
		return $arr;
	}
	
	function saveLanguageRights($admin_id, $rights){
		$arr = explode("::", $rights);
		foreach(Config::$val['default_page'] as $key => $val){
			if(!in_array($key, $arr)){
				$n_arr[] = $key;
			}
		}
		$str = implode("::", $n_arr);
		$this->db->update($this->table)
				 ->values("lng_rights=:lng_rights")
				 ->where("record_id=:record_id")
				 ->bind('record_id', $admin_id)
				 ->bind('lng_rights', $str)
				 ->query();
	}

	
	function loadModuleRights($admin_id){
		$row = $this->db->select($this->table)
						->fields("mod_rights")
						->where("record_id=:record_id")
						->bind('record_id', $admin_id)
						->row_array();
		$arr = explode("::", $row['mod_rights']);
		return $arr;
	}
	
	function saveModuleRights($admin_id, $rights){
		//$arr = explode("::", $rights);
		$list = $this->module->listModules();
		
		$current_admin_rights = $this->loadModuleRights($admin_id);
		$super_admin_rights = $this->loadModuleRights($_SESSION['admin']['id']);
		
		foreach($list as $key => $val){
			if(in_array($val['id'], $super_admin_rights)){
				if(in_array($val['id'], $current_admin_rights)){
					$n_arr[] = $val['id'];
				}
			}else{
				if(!in_array($val['id'], $rights)){
					$n_arr[] = $val['id'];
				}
			}
		}
		$str = implode("::", $n_arr);
		$this->db->update($this->table)
				 ->values("mod_rights=:mod_rights")
				 ->where("record_id=:record_id")
				 ->bind('mod_rights', $str)
				 ->bind('record_id', $admin_id)
				 ->query();
	}
	
	function saveModuleCategoriesRights($admin_id, $access_denied_record_arr){
		
		$arr = $this->db->select(Config::$val['sb_admin_module_rights'])
						->where("admin_id=:admin_id")
						->bind('admin_id', $_SESSION['admin']['id'])
						->result_array();
		
		$this->db->delete(Config::$val['sb_admin_module_rights'])
				 ->where("admin_id=:admin_id")
				 ->bind('admin_id', $admin_id)
				 ->query();
		
		foreach($access_denied_record_arr as $key => $val){
			$this->db->insert(Config::$val['sb_admin_module_rights'])
					 ->values("admin_id=:admin_id, record_id=:record_id, rights=1")
					 ->bind('admin_id', $admin_id)
					 ->bind('record_id', $val)
					 ->query();
		}
		
	}
	
	function delete($id){
		
		// Adinistrator cannot delete himself
		if($id==$_SESSION['admin']['id']) return false;
		
		// same level or lower level admin cannot delete higher level or same level admin
		$admin_data = $this->loadItem($id);
		if($admin_data['permission']<=$_SESSION['admin']['permission']) return false;
		
		// remove from database
		$this->deleteFromTrash($id);
		
		// remove admin rights records from database
		$this->db->delete(Config::$val['sb_admin_module_rights'])
				 ->where("admin_id=:id")
				 ->bind('id', $id)
				 ->query();
		
		// remove admin login stat
		$this->db->delete(Config::$val['sb_admin_stat'])
				 ->where("admin_id=:id")
				 ->bind('id', $id)
				 ->query();
				
		return 0;
		
	}

	// TODO: sqlQueryWhere situos reik tvarkyt
	function getCountSearchItems(){
		
		$this->sqlQueryWhere[] = " R.id!={$_SESSION['admin']['id']} ";
		return record::getCountSearchItems();
		
	}	
	function listSearchItems(){
		
		$this->sqlQueryWhere[] = " R.id!={$_SESSION['admin']['id']} ";
		$list = record::listSearchItems();
		foreach($list as $i=>$val){
			if($val['permission']<=$_SESSION['admin']['permission']){
				$list[$i]['editorship'] = 0;
			}
		}
		return $list;
		
	}
	
}

?>