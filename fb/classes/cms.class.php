<?php

include_once (CLASSDIR.'easywebmanager.class.php');
class cms extends easywebmanager {
	
	private $output = array();
	
	private static $instance;
	
	function __construct() {
		
		benchmark::mark('cms::__construct', 'cms::__construct');
		
		parent::__construct();
		
		ini_set("session.gc_maxlifetime", ADMIN_SESSION_TIMEOUT * 60);
		
		detect_admin_lang();
		
		TPL::setVar('lng', $_SESSION['admin_interface_language']);
		TPL::setVar('lng_'.$_SESSION['admin_interface_language'], 1);
		
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
		TPL::setVar('phrases', $this->phrases);
		
		TPL::setVar('super_admin', ($_SESSION['admin']['permission'])==1?1:0);
		TPL::setVar('admin', $_SESSION['admin']);
		TPL::setVar('upload_url', UPLOADURL);
		TPL::setVar('config', Config::$val);
		TPL::setVar('get', $this->get);
		TPL::setVar('easyweb_version', EASYWEBMANAGER_VERSION);
		
	}
	
	static function getInstance(){
    	if(!is_object(self::$instance)){
    		self::$instance = new cms();
    	}
    	return self::$instance;		
	}	
	
	function process() {
		
		benchmark::mark('cms::process start', 'cms::process start');
		
		// Atsijungiam nuo easywebmanager
		if(isset($this->get['logout'])) $this->registry->modules->admins->logout();
		
		if(!$this->registry->modules->admins->is_loged()){
			$content = $this->login();
		}else{
			if($this->get['ajax']==1){
				if(isset($this->get['module'])){
					if($this->get['method']=='') $this->get['method'] = '_default';
					$method = $this->get['method']; 
					if(method_exists($this->registry->controller->{$this->get['module']}, $method)){
						benchmark::mark('cms::process en', 'cms::process end');
						$_content = $this->registry->controller->{$this->get['module']}->$method();
						// Jei masyvas sukuriamas json masyvas leidziantis atnaujinti kelias html sritis $key nurodo dom id $val turinys
						if(is_array($_content)){
							foreach($_content as $key=>$val){
								$this->createSection($key, $val);
							}
						// Jei tekstine eilute atnaujinama tik conten dalis
						}else{
							$this->createSection("content", $_content);
						}
						// Jei adminas pereina prie kito modulio reikia perkrauti left bloka
						if($this->get['method'] != $_SESSION['current_module']){
							$this->createSection("tree", $this->registry->controller->{$this->get['module']}->tree());
						}
						// Nu cia kazkokia analize
						$bench = benchmark::result();
						if($bench){
							$this->createSection("benchmark", $bench);
						}
						$content = $this->generateOutput();
					}else{
						trigger_error("Method $method not exist in module {$this->get['module']}.");
					}
				}else{
					trigger_error("Module {$this->get['module']} not exist.");
				}				
			}else{
				if(isset($this->get['module'])){
					$method = $this->get['method'];
					if(method_exists($this->registry->controller->{$this->get['module']}, $method)){
						benchmark::mark('cms::process en', 'cms::process end');
						$content = $this->registry->controller->{$this->get['module']}->$method();
					}
				}else{
					// index page
					$content = $this->start()."<div id='benchmark'>".benchmark::result()."</div>";
				}
			}
		}
		
		$this->output($content);
		
	}
	
	function start(){
		
		// Languages loop
		TPL::setVar('languages', load_admin_languages($this->registry->modules->admins->loadLanguageRights($_SESSION['admin']['id'])));
		
		TPL::setVar('css', generate_css('fb', array('normalize','index','forms','dialog','listing','app')));
		
		return TPL::parse(TPLDIR."index.tpl");
		
	}
	
	function login(){
		if($this->get['ajax']==1){
			
			// Jei bandoma jungtis prie tvs 
			if($this->get['action']=='login'){
				if($this->get['method']=='login'){
					return $this->registry->controller->admins->login();
				}
				// slaptazodzio priminimas
				if($this->get['method']=='remind'){
					return $this->registry->controller->admins->remind();
				}
			}
			
			$buffer = TPL::parse(TPLDIR."blocks/login.tpl");
			$this->createSection("_WINDOW_content", $buffer);
			$bench = benchmark::result();
			if($bench){
				$this->createSection("benchmark", $bench);
			}
			return $this->generateOutput();
		}else{
			TPL::setVar('css', generate_css('admin', array('normalize','login','forms')));
			TPL::setVar('login_form_content', TPL::parse(TPLDIR."blocks/login.tpl"));
			return TPL::parse(TPLDIR."login.tpl");
		}
	}
	
	function createSection($name, $content, $attr=array()){
		$this->output['section'][] = array('id'=>$name, 'content'=>$content, 'attr'=>$attr);
	}
	
	function generateOutput($type="json"){
		if($type=='xml'){
			/*
			ko gero trinti nafik
			$dom = new DOMDocument();
			$root = $dom->createElement('data');
			$root = $dom->appendChild($root);
			if(!$this->registry->modules->admins->is_loged()){
				$child = $dom->createElement('loged');
				$is_loged = $dom->createTextNode(0);
				$child->appendChild($is_loged);
				$root = $root->appendChild($child);
				$child = $dom->createElement('section');
				$html_content = $dom->createCDATASection($data['content']);
				$child->appendChild($html_content);
				$child->setAttribute('id', $name);
				$return = $dom->saveXML();
			}else{
				$child = $dom->createElement('loged');
				$is_loged = $dom->createTextNode(1);
				$child->appendChild($is_loged);
				$root->appendChild($child);
				foreach($this->output as $name=>$data){
					unset($child);
					$child = $dom->createElement('section');
					$html_content = $dom->createCDATASection($data['content']);
					$child->appendChild($html_content);
					$child->setAttribute('id', $name);
					foreach($data['attr'] as $attr_name=>$attr_value){
						$child->setAttribute($attr_name, $attr_value);
					}
					$root->appendChild($child);
				}
				$return = $dom->saveXML();
				
			}
			*/
		}
		if($type=='json'){
			$this->output['loged'] = $this->registry->modules->admins->is_loged();
			$return = json_encode($this->output);
		}
		return $return;
	}
	
}

?>