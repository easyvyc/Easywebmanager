<?php

include_once (CLASSDIR.'easywebmanager.class.php');
class cms extends easywebmanager {
	
	const DEFAULT_CONTROLLER = "pages";
	const DEFAULT_METHOD = "index";
	
	public static $language;
        public static $global_var = array();
        public static $_EDIT_MODE;
	
	private $output = array();
	
	private $router;
        
        private $css_files = array();
	
	private static $instance;
	
	protected function __construct() {
		
		parent::__construct();
		
		benchmark::mode(false);
		
		$this->router = new router();
		
		if(function_exists("detect_language")){
			self::$language = detect_language();
		}
		
		TPL::setVar('upload_url', 'files/upload/');
		TPL::setVar('config', Config::$val);
		TPL::setVar('get', $this->get);
		TPL::setVar('lng', self::$language);
                TPL::setVar('logged_user', $_SESSION['logged_user']);
		
		self::$_EDIT_MODE = (isset($_SESSION['admin']['id']) && $_GET['edit'] == 1);
		
                TPL::setVar('EDIT_MODE', self::$_EDIT_MODE);
                
                TPL::setVar('load_site_js', (!self::$_EDIT_MODE && $_GET['ajax'] != 1 ? true : false));
		//$old_error_handler = set_error_handler(array($this->registry->controller->pages, 'error'));
		
	}
        
        function add_css($css){
            if(!in_array($css, $this->css_files)) $this->css_files[] = $css;
        }
        
        function load_css(){
            return $this->css_files;
        }
        
        function load_view_variables(){
            
            $mainpage_data = $this->registry->model->pages->loadItem(Config::$val['default_page'][self::$language]);
            TPL::setVar('main_page', $mainpage_data);
            $search_data = $this->registry->model->pages->loadByTemplate('search');
            TPL::setVar('search_page', $search_data);
            $sitemap_data = $this->registry->model->pages->loadByTemplate('sitemap');
            TPL::setVar('sitemap_page', $sitemap_data);
            $checkout_data = $this->registry->model->pages->loadByTemplate('checkout');
            TPL::setVar('checkout_page', $checkout_data);
//            $events_data = $this->registry->model->pages->loadByTemplate('events');
//            TPL::setVar('events_page', $events_data);
            
            
            TPL::setVar('phrases', $this->registry->controller->phrases->loadPhrases());
            TPL::setVar('site_blocks', $this->registry->model->site_blocks->loadBlocks());
            TPL::setVar('lng', self::$language);
            TPL::setVar('lng_' . self::$language, true);
            TPL::setVar('get', $_GET);
            
            //TPL::setVar('shortcuts', $this->registry->model->keyboard_shortcuts->listSearchItems());
            
            $main_blocks = $this->registry->model->blocks->getBlocks(0);
            TPL::setVar('main_blocks', $main_blocks);

            $current_path_ids = array();
            $path = self::$global_var['current_path'];
            foreach($path as $item){
                if($item['id']){
                    $current_path_ids[] = $item['id'];
                }
            }
            
            TPL::setVar('bmenu', $this->registry->model->pages->getMenu(Config::$val['default_page'][self::$language], $current_path_ids));
            //TPL::setVar('user_menu', $this->registry->model->pages->getMenu(Config::$val['user_page'][self::$language], $current_path_ids));
            TPL::setVar('menu', $this->registry->model->pages->getMenu(Config::$val['product_page'][self::$language], $current_path_ids));

            TPL::setVar('currency', $this->registry->controller->currencies->getCurrent());

            TPL::setVar('javascript', $javascript);

            $this->add_css('base');
            $this->add_css('style');
            $this->add_css('products');
            $this->add_css('prettyPhoto');
            
            $this->add_css('tablet');
            $this->add_css('mobile');
            
            TPL::setVar('page_settings', $this->registry->model->pages->getSettings());
            TPL::setVar('languages', $this->registry->model->languages->get_list());
            TPL::setVar('current_language', $this->registry->model->languages->get_current());

            TPL::setVar('cart_content', $this->registry->controller->cart->load_view());
                
        }
	
	static function getInstance(){
            if(!is_object(self::$instance)){
                    self::$instance = new cms();
            }
            return self::$instance;		
	}	
	
	function process() {
		
		// Default controller
		$controller = self::DEFAULT_CONTROLLER; 
		// Default controller method
		$method = self::DEFAULT_METHOD;
		
		$params = array();
		
		$_GET['path'] = $this->router->website_path_info($_GET['path']);
		
		if(isset($_GET['module'])){
			$controller = $_GET['module'];
			if(isset($_GET['method'])){
				$method = $_GET['method'];
			}
		}elseif($cntr = $this->router->detect_url_controller($_GET['path'])){
                    	if(is_array($cntr)){
				$controller = $cntr['c'];
				$method = $cntr['m'];
			}else{
				$controller = $cntr;
			}
		}else{
			$controller = "pages";
			$page_data = $this->registry->model->pages->loadByUrl($_GET['path'], self::$_EDIT_MODE);
			$this->registry->controller->pages->set_current_page($page_data);
                        
			if(!empty($page_data)){
				$method = $page_data['template'];
				$params['page_id'] = $page_data['id'];
			}else{
				$method = "page_not_found";
				$params['msg'] = "<h1>Page not found.</h1>";
			}
		}
		
		// patikrint ar exist surastas controller ir jo methodas
		if(!method_exists($this->registry->controller->$controller, $method)){
			$content = $this->registry->controller->pages->page_not_found("<h1>Page not found.</h1>");
		}else{
			$content = call_user_func_array(array($this->registry->controller->$controller, $method), $params);
		}
		
		// tvs admino redagavimo rezimas
                if(self::$_EDIT_MODE){
                    	$content .= "<script src=\"admin/lib/ckeditor/ckeditor.js\"></script>";
//			$content .= "<script src=\"admin/lib/ckeditor/lang/_languages.js\"></script>";
//			$content .= "<script src=\"admin/lib/ckeditor/default.js\"></script>";
			$content .= "<script src=\"site/js/admin.js\"></script>";
			$content .= "<style> .cke { z-index:10000; } *[contenteditable=\"true\"]:hover, .cke_focus { box-shadow:0 0 5px #666; } .hide { display:block; } .contenteditable { min-height:30px; min-width:100px; } </style>";
		}else{
			//if($_GET['ajax'] != 1) $content .= "<script src=\"site/js/site.js\"></script>";
                        $this->registry->controller->stat_visitors->process();
		}
		
		//$content.= $this->db->debug();

                $content .= benchmark::result();
                
		$this->output($content);
                exit;
		
	}
	
}

?>