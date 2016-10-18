<?php

include_once(CLASSDIR."Registry.class.php");
class basic {
	
	public $db;
	public $config;
	public $registry;
	public $benchmark;
	public $cache_obj;
	
	protected $get = array();
	protected $post = array();
	protected $session = array();
	protected $cookie = array();
	
	// system admin password encrypt function
	protected $password_hash_function = "md5";
	
	
	protected function __construct(){
		
		load_helpers('sys');
		
		if(!isset(Config::$val['DB'])){
			Config::setVal('DB', DB::getInstance(Config::$val['dbdriver'], Config::$val['hostname'], Config::$val['database'], Config::$val['username'], Config::$val['password'], Config::$val['dbport']));
		}
		
		// database object
		$this->db = Config::$val['DB'];
		
		$this->config = Config::$val;
		
		$this->registry = Registry::getInstance();
		
		$this->cache = cache::getInstance();
		
		$this->get = $_GET;
		$this->post = $_POST;
		$this->session = $_SESSION;
		$this->cookie = $_COOKIE;
		
	}
	
}



class license extends basic {

	var $config_file;
	var $config_var;
	var $keyword;
	var $redirect_url;
    
    function __construct() {
    	
    	parent::__construct();
    	$this->keyword = "EASYVYC";
    	$this->redirect_url = "http://www.easywebmanager.com/en/support/wrong-license-key.html";
    	
    }
    
    private function getConfigurationData(){
    	$this->config_var = $GLOBALS['configFile']->variable;
    }
    
    function checkLicense(){
    	
    	$this->getConfigurationData();
    	
    	$res_str = $this->generateLicenseKey($this->config_var['license']);
    	
//    	$arr_ = explode(".", $this->config['pr_url']);
//    	if(count($arr_)==1){
//    		return true;
//    	}
    	$arr = explode("---", $this->config_var['license']);
    	
		//if(!ereg("/$", $_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST'] .= "/";
		if(strtoupper($this->config_var['pr_url']) != strtoupper($_SERVER['HTTP_HOST'])){
    		redirect($this->config_var['site_admin_url']);
    		//$this->wrongLicenseKey();
    	}
    	if(strtoupper($this->config_var['pr_url']) != $arr[1]){
    		$this->wrongLicenseKey();
    	}
    	/*if($this->config_var['project_id'] != (int) $arr[4]){
    		$this->wrongLicenseKey();
    	}*/
    	if(EASYWEBMANAGER_VERSION != $arr[3]){
    		$this->wrongLicenseKey();
    	}
    	
    	if($this->config_var['key'] != $res_str){
    		$this->wrongLicenseKey();
    	}
    	
    }
    
	private function encrypt($string, $key) {
		
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		$result = base64_encode($result);
		return md5($result);
		
	}
	
	private function generateLicenseKey($license){
		
    	$arr = explode("---", $license);
    	foreach($arr as $k=>$v){
    		$res_arr[] = $this->encrypt($v, $this->keyword);
    	}
    	$str = implode("x", $res_arr);
    	$res_str = $this->encrypt($str, $this->keyword);
    	return $res_str;
    	
	}
	
	function wrongLicenseKey(){
		redirect($this->redirect_url."?host={$_SERVER['HTTP_HOST']}&license={$this->config_var['license']}");
	}

}

?>