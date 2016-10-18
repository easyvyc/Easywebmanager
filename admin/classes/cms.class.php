<?php

include_once (CLASSDIR.'easywebmanager.class.php');
class cms extends easywebmanager {
	
	public static $phrases;
	
	private $output = array();
	
	private static $instance;
	
	public static $DEBUG = false;
	
	function __construct() {
	
                benchmark::mark('cms::__construct', 'cms::__construct');
		
		benchmark::mode(self::$DEBUG);
		
		parent::__construct();
                
                self::set_debug();
		
		ini_set("session.gc_maxlifetime", ADMIN_SESSION_TIMEOUT * 60);
		
		detect_admin_lang();
		
		TPL::setVar('lng', $_SESSION['admin_interface_language']);
		TPL::setVar('lng_'.$_SESSION['admin_interface_language'], 1);
		
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
		TPL::setVar('phrases', self::$phrases);
		
		TPL::setVar('super_admin', ($_SESSION['admin']['permission'])==1?1:0);
		TPL::setVar('admin', $_SESSION['admin']);
		TPL::setVar('upload_url', UPLOADURL);
		TPL::setVar('config', Config::$val);
		TPL::setVar('get', $this->get);
		TPL::setVar('easyweb_version', EASYWEBMANAGER_VERSION);
                
                TPL::setVar('site_lng', $_SESSION['site_lng']);
		
	}
	
	static function getInstance(){
            if(!is_object(self::$instance)){
                    self::$instance = new cms();
            }
            return self::$instance;		
	}
        
        static function set_debug(){
            if(isset($_GET['debug'])) $_SESSION['system_debug'] = true;            
            if($_SESSION['system_debug']){
                self::$DEBUG = true;
                benchmark::mode(self::$DEBUG);
            }
        }
	
	function loadAdminLanguage($lng){ 
		include(LANGUAGESDIR.$lng.".php");
		self::$phrases = $cms_phrases;
	}
	
	function process() {
		
		benchmark::mark('cms::process start', 'cms::process start');

		// Atsijungiam nuo easywebmanager
		if(isset($this->get['logout'])) $this->registry->controller->admins->logout();

		if(!$this->registry->controller->admins->is_loged()){
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
								if(is_array($val)){
									$this->createSection($key, $val['content'], $val['attr']);
								}else{
									$this->createSection($key, $val);
								}
							}
						// Jei tekstine eilute atnaujinama tik content dalis
						}else{
							$this->createSection("content", $_content);
						}
						// Jei adminas pereina prie kito modulio arba keicia kalba reikia perkrauti left bloka
						if($this->get['no_tree_reload'] != 1 && ($this->get['module'] != $_SESSION['current_module'] || $_SESSION['site_lng_changed'])){
							if(in_array($_SESSION['current_module'], array('modules','module_category','module_info')) && in_array($this->get['module'], array('modules','module_category','module_info'))){
								$_SESSION['current_module'] = $this->get['module'];
								$_SESSION['site_lng_changed'] = false;
							}else{
                                                                $tree_content = $this->registry->controller->{$this->get['module']}->tree();
                                                                if($tree_content){
                                                                    $tree_content .= "<script> $('#left').show(); $('#content').css('margin-left', '250px'); </script>";
                                                                }else{
                                                                    $tree_content .= "<script> $('#left').hide(); $('#content').css('margin-left', '0px'); </script>";
                                                                }
								$this->createSection("tree", $tree_content);
								$_SESSION['current_module'] = $this->get['module'];
								$_SESSION['site_lng_changed'] = false;
							}
						}
						if(benchmark::debug()){
							// Nu cia kazkokia analize
							$this->createSection("DEBUG_content", benchmark::result());
						}
						$content = $this->generateOutput();
					}else{
						trigger_error("Method $method not exist in module {$this->get['module']}.");
					}
				}else{
					trigger_error("Module {$this->get['module']} not exist.");
				}				
			}else{
				$method = $this->get['method']; 
				if(method_exists($this->registry->controller->{$this->get['module']}, $method)){
                                        $params = (is_array($this->get['params']) ? $this->get['params'] : array($this->get['params']));
					$content = call_user_func_array(array($this->registry->controller->{$this->get['module']}, $method), $params);
                                        // negerai perduoda funkcijos parametrus 
                                        //$content = $this->registry->controller->{$this->get['module']}->$method($this->get['params']);
				}else{
					$content = $this->start();
				}
				if(benchmark::debug()){
					$content .= "<div id='DEBUG'><div class='rel'><div class='handle'>DEBUG</div><div id='DEBUG_content'>".benchmark::result()."</div></div></div>";
				}
			}
		}
		
		$this->output($content);
		
	}
	
	function start(){
		
		$_SESSION['site_lng_changed'] = true;
		
		// Languages loop
		TPL::setVar('languages', load_admin_languages($this->registry->model->admins->loadLanguageRights($_SESSION['admin']['id'])));
		
		TPL::setVar('cms_lng', $_SESSION['admin_interface_language']);
		
		TPL::setVar('css', generate_css(APP_NAME, array('normalize','index','forms','dialog','listing','tree','jquery.lightbox','jquery-ui')));
		
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
			$this->createSection("_LOGIN_", $buffer);
			if(benchmark::debug()){
				$this->createSection("benchmark", benchmark::result());
			}
			return $this->generateOutput();
		}else{
			TPL::setVar('css', generate_css(APP_NAME, array('normalize','login','forms')));
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
			if(!$this->registry->model->admins->is_loged()){
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
			$this->output['loged'] = $this->registry->controller->admins->is_loged();
			$return = json_encode($this->output);
		}
		return $return;
	}
	
}

?>