<?php

include_once(CLASSDIR."basic.class.php");
class fb_app extends basic {
	
	// constructor inherit record class
	function __construct(){
		
		parent::__construct();
		
		$this->loadActions();
		
	}
	
	function loadActions(){
    	include_once(APP_CLASSDIR."actions/actions_fb_app.class.php");
    	$this->actions = new actions_fb_app();
	}

}

?>
