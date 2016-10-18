<?php

include_once(APP_CLASSDIR."model.class.php");
class model_stat_visitors_path extends model {
	
	// constructor inherit record class
	function __construct(){
		
		parent::__construct("stat_visitors_path");
                $this->module_info['no_record_table'] = 1;
		
	}
		
}

?>