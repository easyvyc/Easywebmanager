<?php

require_once(APP_CLASSDIR.'actions.class.php');
class actions_modules extends actions {
	
	public function __construct() {
		
		parent::__construct("modules");
		$this->remove("pdf");
		$this->add("columns", array(
								'img'=>'modif',
								'name'=>'columns',
								'title'=>'Laukeliai',
								'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'columns', '{id}'));"
		));		
		$this->add("new_column", array(
								'img'=>'new',
								'name'=>'new_column',
								'title'=>'Naujas laukelis',
								'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'new_column', '{id}'));"
		));
//		$this->add("template", array(
//								'img'=>'settings',
//								'name'=>'template',
//								'title'=>'Šablonas',
//								'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'template', '{id}'));"
//		));
		
	}
	
}

?>