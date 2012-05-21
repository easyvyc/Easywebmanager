<?php

include_once(CLASSDIR."basic.class.php");
class actions extends basic {

	private $mod_actions = array(
							'edit'=>array(), 
							'translate'=>array(), 
							'export'=>array(), 
							'pdf'=>array(), 
							'delete'=>array()
	);
	
    function __construct($module) {
    	
    	parent::__construct();
    	
    	$this->mod = $this->registry->modules->$module;
    	
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
		
    	// Detects settings action
    	if(is_array($this->mod->module_info['xml_settings'])){
    		$this->mod_actions['settings'] = array();
    	}
    	
    	// Detects translate action
    	if($this->mod->module_info['multilng']!=1 || count(Config::$val['default_page'])==1){
    		unset($this->mod_actions['translate']);
    	}

		foreach($this->mod_actions as $key=>$val){
			$this->mod_actions[$key]['img'] = $key;
			$this->mod_actions[$key]['name'] = $key;
			$this->mod_actions[$key]['title'] = $this->phrases['modules']['context_menu'][$key.'_title'];
			$this->mod_actions[$key]['action'] = "javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=$key&id={id}'));";
		}
    	
    }
    
    function listItems($id){
    	
    	return $this->mod_actions;
    }
    
    function _default(){
    	return $this->_list();
    }    
    
    // action methods
    function _edit(){
    	
    }

    function _translate(){
    }

    function _import(){
    }

    function _export(){
    }

    function _pdf(){
    }

    function _delete(){
    }
    
    function _settings(){
    }
    
    function __call($func, $args){
    	trigger_error("Method ".__CLASS__."::$func() not exist.");
    }
    
}
?>