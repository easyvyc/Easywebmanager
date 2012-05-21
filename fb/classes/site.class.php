<?php

include_once (CLASSDIR.'easywebmanager.class.php');
class site extends easywebmanager {
	
	private $output = array();
	
	private static $instance;
	
	protected function __construct() {
		
		parent::__construct();
		
		TPL::setVar('upload_url', 'files/upload/');
		TPL::setVar('config', Config::$val);
		TPL::setVar('get', $this->get);

	}
	
	static function getInstance(){
    	if(!is_object(self::$instance)){
    		self::$instance = new site();
    	}
    	return self::$instance;		
	}	
	
	function process() {
		
		$content = $this->start().$this->benchmark->result();
		return $content;
	}
	
	function start(){
		
		$app_data = json_decode(file_get_contents(DATADIR."fb_app.js"));
		
		$banner_top = "<img src=\"".UPLOADURL."_APP_TOP_BANNER/".$app_data->_APP_TOP_BANNER->url."\" >";
		if($app_data->_APP_TOP_BANNER->link){
			$banner_top = "<a href=\"{$app_data->_APP_TOP_BANNER->link}\" target=\"_blank\">".$banner_top."</a>";
		}
		TPL::setVar("banner_top", $banner_top);

		$banner_top = "<img src=\"".UPLOADURL."_APP_LOGO/".$app_data->_APP_LOGO->url."\" >";
		if($app_data->_APP_LOGO->link){
			$banner_top = "<a href=\"{$app_data->_APP_LOGO->link}\">".$banner_top."</a>";
		}
		TPL::setVar("logo", $banner_top);
		
		$banner_top = "<img src=\"".UPLOADURL."_APP_BOT_BANNER/".$app_data->_APP_BOT_BANNER->url."\" >";
		if($app_data->_APP_BOT_BANNER->link){
			$banner_top = "<a href=\"{$app_data->_APP_BOT_BANNER->link}\" target=\"_blank\">".$banner_top."</a>";
		}
		TPL::setVar("banner_bottom", $banner_top);

		$banner_top = "<img src=\"".UPLOADURL."_APP_LEFT_BLOCK/".$app_data->_APP_LEFT_BLOCK->url."\" >";
		if($app_data->_APP_LEFT_BLOCK->link){
			$banner_top = "<a href=\"{$app_data->_APP_LEFT_BLOCK->link}\">".$banner_top."</a>";
		}
		TPL::setVar("left_block", $banner_top);

		$banner_top = "<img src=\"".UPLOADURL."_APP_RIGHT_BLOCK/".$app_data->_APP_RIGHT_BLOCK->url."\" >";
		if($app_data->_APP_RIGHT_BLOCK->link){
			$banner_top = "<a href=\"{$app_data->_APP_RIGHT_BLOCK->link}\">".$banner_top."</a>";
		}
		TPL::setVar("right_block", $banner_top);		
		
		$app_menu = json_decode(file_get_contents(DATADIR."fb_menu.js"));
		 
		foreach($app_menu as $i=>$val){
			$menu .= "<a href=\"index.php?p=$i\">{$val->title}</a>";
		}
		TPL::setVar("menu", $menu);
		
    	include TPL::parse(TPLDIR."app.tpl");
		$buffer = $this->ob_get_contents();
		$this->ob_start();
		
		TPL::setVar('content', $buffer);
		
		TPL::setVar('css', generate_css('fb', array('fb_app')));
		include TPL::parse(TPLDIR."main_app.tpl");
		$buffer = $this->ob_get_contents();
		$this->ob_start();
		
		return $buffer;
		
	}
	
}

?>