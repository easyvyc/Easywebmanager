<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_admins extends modules {
	
	private $confirm_valid_days_count = 3;
	
	// constructor inherit record class
	function __construct(){
		
		parent::__construct("admins");
		$this->mod_actions = array('edit'=>array(), 'rights'=>array('title'=>array('lt'=>'Privilegijos', 'en'=>'Rights'), 'img'=>'rights'), 'logins'=>array('title'=>array('lt'=>'Prisijungimai', 'en'=>'Logins'), 'img'=>'logins'), 'new'=>array(), /*'export'=>array(), 'pdf'=>array(),*/ 'delete'=>array());
		
	}
	
	function saveItem($data){
		
		if($data['isNew']==1){
			$data['permission'] = $this->admin['permission'] + 1;
		}
		$data['title'] = "{$data['login']} ({$data['firstname']} {$data['lastname']})";
		$admin_id = record::saveItem($data);
		
		if($data['isNew']==1){

			$this->inheritAdminRecordsRights($admin_id, $this->admin['id']);
			//$this->inheritAdminPagesRights($admin_id, $_SESSION['admin']['id']);
			$this->inheritLanguagesRights($admin_id, $this->admin['id']);
			$this->inheritModulesRights($admin_id, $this->admin['id']);

		}
		
		return $admin_id;
	}
	
	private function inheritModulesRights($child_admin, $parent_admin){

			//$arr = explode("::", $_SESSION['admin']['lng_rights']);
			$arr = $this->loadModuleRights($parent_admin);
			$str = implode("::", $arr);
			$sql = "UPDATE $this->table SET mod_rights='$str' WHERE record_id=$child_admin";
			$this->db->query($sql);

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
		
		$arr_ = explode("-", $this->db->version);
		$arr = explode(".", $arr_[0]);
		$version = implode("", $arr);
		
		if($version>40015){
			$sql = "INSERT INTO ".Config::$val['sb_admin_module_rights']." (admin_id, record_id, rights) " .
					"SELECT $child_admin AS admin_id, record_id, rights FROM ".Config::$val['sb_admin_module_rights']." " .
					"WHERE admin_id=$parent_admin";
			$this->db->query($sql);
		}else{
			$sql = "SELECT record_id, rights FROM ".Config::$val['sb_admin_module_rights']." WHERE admin_id=$parent_admin";
			$this->db->exec($sql, __FILE__, __LINE__);
			$arr = $this->db->arr();
			$n = count($arr);
			for($i=0; $i<$n; $i++){
				$sql = "INSERT INTO ".Config::$val['sb_admin_module_rights']." SET admin_id=$child_admin, record_id={$arr[$i]['record_id']}, rights='{$arr[$i]['rights']}'";
				$this->db->query($sql);
			}
		}
	}

	function checkEmail($email){
		$email = $this->db->escape_str($email);
		$n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }		
        $sql = "SELECT $fields R.id AS id, R.parent_id, T.lng_rights, T.mod_rights " .
        		" FROM $this->table T" .
        		" LEFT JOIN {$this->tables['record']} R " .
        		" ON (R.id=T.record_id)" .
        		" WHERE T.email='$email' AND T.active=1 ";
        return $this->db->query($sql)->row_array();
	}
	
	function setConfirmData($id){
		$confirm_data['date'] = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")+$this->confirm_valid_days_count,date("Y")));
		$confirm_data['code'] = md5($confirm_data['date'].$id);
		$sql = "UPDATE $this->table SET confirm_code='{$confirm_data['code']}', confirm_date='{$confirm_data['date']}' WHERE record_id=$id";
		$this->db->query($sql);
		return $confirm_data;
	}
	
	function sendRemindConfirm($data){
		
		include_once(CLASSDIR."phpmailer.class.php");
		$mailer = new PHPMailer();
		
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = "Easywebmanager - ".$this->phrases['login']['password_remind'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		
		$confirm_data = $this->setConfirmData($data['id']);
		
		$msg = $this->phrases['login']['confirm_email_text'];
		$msg = ereg_replace("{link}", Config::$val['site_admin_url']."?remind=1&id={$data['id']}&code={$confirm_data['code']}", $msg);
		$msg = ereg_replace("{confirm_days}", (string)$this->confirm_valid_days_count, $msg);
		$msg = ereg_replace("{confirm_date}", $confirm_data['date'], $msg);
		
		$message .= $msg;
		
		$mailer->Body = $message;
		
		$mailer->AddAddress($data['email']);
		$mailer->From = "support@easywebmanager.com";
		$mailer->FromName = "Easywebmanager";
		$mailer->Send();		
	}
	
	function checkConfirmation($id, $code){
		$id = $this->db->escape_str($id);
		$code = $this->db->escape_str($code);
		$n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }		
        $sql = "SELECT $fields R.id AS id, R.parent_id, T.lng_rights, T.mod_rights " .
        		" FROM $this->table T" .
        		" LEFT JOIN {$this->tables['record']} R " .
        		" ON (R.id=T.record_id)" .
        		" WHERE T.record_id='$id' AND confirm_code='$code' AND confirm_date>NOW() AND T.active=1 ";
        
        return $this->db->query($sql)->row_array();
	}
	
	function sendLoginData($id){
		
		$admin_data = $this->loadItem($id);
		
		$newpass = $this->generatePassword($id);
		
		include_once(CLASSDIR."phpmailer.class.php");
		$mailer = new PHPMailer();
		
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = "Easywebmanager - ".$this->phrases['login']['password_remind'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		
		$msg = $this->phrases['login']['password_email_text'];
		$msg = ereg_replace("{link}", Config::$val['site_admin_url'], $msg);
		$msg = ereg_replace("{loginname}", $admin_data['login'], $msg);
		$msg = ereg_replace("{password}", $newpass, $msg);
		
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
		$sql = "UPDATE $this->table SET pass=MD5('$newpass') WHERE record_id=$id";
		$this->db->query($sql)->exec($sql);
		return $newpass;
	}
	
	function checkLogin($data){
		$data['login'] = $this->db->escape_str($data['login']);
		$data['pass'] = $this->db->escape_str($data['pass']);
		$n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }		
        $sql = "SELECT $fields R.id AS id, R.parent_id, T.lng_rights, T.mod_rights " .
        		" FROM $this->table T" .
        		" LEFT JOIN {$this->tables['record']} R " .
        		" ON (R.id=T.record_id)" .
        		" WHERE T.login='{$data['login']}' AND T.pass=MD5('{$data['pass']}') AND T.active=1 ";
       	$row = $this->db->query($sql)->row_array();
       	return $row;
	}
	
	function checkLoginData($login_data, $data=array()){
		//pa($data);
		$login = trim($login_data['value']);
		if(strlen($data['id'])>0) $not_id = "AND record_id!={$data['id']}";
		$sql = "SELECT id " .
				"FROM $this->table " .
				"WHERE login='$login' ".$not_id;
		$arr = $this->db->query($sql)->row_array();
		
		if(empty($arr) && strlen($login)>3)
			return 0;
		else
			return 1;		
	}
	
	function registerAdminLogin(){
		$sql = "SELECT id FROM ".Config::$val['sb_admin_stat']." WHERE admin_id={$_SESSION['admin']['id']} AND session='".session_id()."'";
		$row = $this->db->query($sql)->row_array();
		if(!empty($row)){
			$sql = "UPDATE ".Config::$val['sb_admin_stat']." SET logout_time=NOW() WHERE admin_id={$_SESSION['admin']['id']} AND session='".session_id()."'";
			$this->db->query($sql);
		}else{
			$sql = "INSERT INTO ".Config::$val['sb_admin_stat']." SET admin_id={$_SESSION['admin']['id']}, login_time=NOW(), logout_time=NOW(), ipaddress='".$_SERVER['REMOTE_ADDR']."', session='".session_id()."'";
			$this->db->query($sql);
		}
		$_SESSION['FIRST_SESSION_ID'] = session_id();
		$this->deleteAdminsLoginStats(ADMIN_LOGIN_STATS);
	}
	
	function registerLastAdminTime(){
		if(RESTART_SESSION == 1) return;
		$sql = "UPDATE ".Config::$val['sb_admin_stat']." SET logout_time=NOW() WHERE admin_id={$_SESSION['admin']['id']} AND session='".$_SESSION['FIRST_SESSION_ID']."'";
		$this->db->query($sql);
	}
	
	function getAdminStatCount($id){
		$sql = "SELECT COUNT(*) AS cnt " .
				"FROM ".Config::$val['sb_admin_stat']." " .
				"WHERE admin_id=$id ORDER BY login_time DESC ";
		$row = $this->db->query($sql)->row_array();
		return $row['cnt'];
	}
	
	function getAdminStat($id, $offset, $paging){
		$sql = "SELECT id, login_time, logout_time, ipaddress, SEC_TO_TIME(UNIX_TIMESTAMP(logout_time)-UNIX_TIMESTAMP(login_time)) AS all_time " .
				"FROM ".Config::$val['sb_admin_stat']." " .
				"WHERE admin_id=$id ORDER BY login_time DESC " .
				"LIMIT $offset, $paging ";
		return $this->db->query($sql)->result_array();
	}
	
	function deleteAdminsLoginStats($days){
		$sql = "DELETE FROM ".Config::$val['sb_admin_stat']." " .
				" WHERE TO_DAYS(login_time) < (TO_DAYS(NOW())-$days) ";
		$this->db->query($sql);
	}
	
	function loadLanguageRights($admin_id){
		$sql = "SELECT lng_rights FROM $this->table WHERE record_id=$admin_id";
		$row = $this->db->query($sql)->row_array();
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
		$sql = "UPDATE $this->table SET lng_rights='$str' WHERE record_id=$admin_id";
		$this->db->query($sql);
	}

	
	function loadModuleRights($admin_id){
		$sql = "SELECT mod_rights FROM $this->table WHERE record_id=$admin_id";
		$row = $this->db->query($sql)->row_array();
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
		$sql = "UPDATE $this->table SET mod_rights='$str' WHERE record_id=$admin_id";
		$this->db->query($sql);
	}
	
	function saveModuleCategoriesRights($admin_id, $access_denied_record_arr){
		
		$sql = "SELECT * FROM ".Config::$val['sb_admin_module_rights']." WHERE admin_id={$_SESSION['admin']['id']}";
		$arr = $this->db->query($sql)->result_array();
		
		$sql = "DELETE FROM ".Config::$val['sb_admin_module_rights']." WHERE admin_id=$admin_id";
		$this->db->query($sql);
		
		foreach($access_denied_record_arr as $key => $val){
			$sql = "INSERT INTO ".Config::$val['sb_admin_module_rights']." SET admin_id=$admin_id, record_id=$val, rights=1";
			$this->db->query($sql);
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
		$sql = "DELETE FROM ".Config::$val['sb_admin_module_rights']." WHERE admin_id=$id";
		$this->db->query($sql);
		
		// remove admin login stat
		$sql = "DELETE FROM ".Config::$val['sb_admin_stat']." WHERE admin_id=$id ";
		$this->db->query($sql);
		
		return 0;
		
	}

	function getCountSearchItems(){
		
		$this->sqlQueryWhere = " R.id!={$_SESSION['admin']['id']} AND ";
		return record::getCountSearchItems();
		
	}	
	function listSearchItems(){
		
		$this->sqlQueryWhere = " R.id!={$_SESSION['admin']['id']} AND ";
		$list = record::listSearchItems();
		foreach($list as $i=>$val){
			if($val['permission']<=$_SESSION['admin']['permission']){
				$list[$i]['editorship'] = 0;
			}
		}
		return $list;
		
	}

    function getContextMenu($item){
    
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit','module','delete', 'rights', 'logins');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		if($item['permission']<$_SESSION['admin']['permission'] && in_array($key, $z_arr)) continue;
    		if($item['permission']==$_SESSION['admin']['permission'] && $item['id']!=$_SESSION['admin']['id'] && in_array($key, $z_arr)) continue;
    		if($item['permission']==$_SESSION['admin']['permission'] && $item['id']==$_SESSION['admin']['id'] && in_array($key, array('delete','rights'))) continue;
    		$act = "getContextMenuContent(\'".Config::$val['site_admin_url']."\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'list\',\'{$item['id']}\',\'$key\');";
    		$context[] = array('img'=>(isset($val['img'])?$val['img']:$key), 'name'=>$key, 'title'=>(isset($val['title'][$_SESSION['admin_interface_language']])?$val['title'][$_SESSION['admin_interface_language']]:$this->cmsPhrases['modules']['context_menu'][$key.'_title']), 'action'=>$act, 'main_action'=>$act);
    	}
		
		return $context;
		
    }
	
}

?>