<?php

require_once(APP_CLASSDIR.'actions.class.php');
class actions_columns extends actions {
	
	public function __construct() {
		
		parent::__construct("columns");
		//$this->remove("pdf");
		
	}
	
}

?>