<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_forms extends controller {
	
	public function __construct() {
		parent::__construct ("forms");
	}
	
	function edit_form(){
		
		$_POST['active'] = 1;
		return $this->mod->saveItem($_POST);
		
	}
			
}

?>