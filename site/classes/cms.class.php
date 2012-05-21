<?php

include_once (CLASSDIR.'easywebmanager.class.php');
class cms extends easywebmanager {
	
	private $output = array();
	
	private static $instance;
	
	protected function __construct() {
		
		parent::__construct();
		
		ini_set("session.gc_maxlifetime", ADMIN_SESSION_TIMEOUT * 60);
		
		detect_admin_lang();
		
		TPL::setVar('upload_url', 'files/upload/');
		TPL::setVar('config', Config::$val);
		TPL::setVar('get', $this->get);
		
	}
	
	static function getInstance(){
    	if(!is_object(self::$instance)){
    		self::$instance = new cms();
    	}
    	return self::$instance;		
	}	
	
	function process() {
		
		$content = $this->start().$this->benchmark->result();
		
		$this->output($content);
		
	}
	
	function start(){
		
		TPL::setVar('css', generate_css('fb', array('normalize','index','forms')));

		include(TPL::parse(TPLDIR."index.tpl"));
		$buffer = $this->ob_get_contents();
		$this->ob_start();
		return $buffer;
		
	}

	
}

?>