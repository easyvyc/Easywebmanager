<?php

class Registry {
	
	private $obj = array();
	
	private static $instance;
	
    private function __construct() {}
    
    static function getInstance(){
    	if(!is_object(self::$instance)){
    		self::$instance = new Registry();
    	}
    	return self::$instance;
    }
    
    function create($scope){

    	if(!is_object($this->$scope)){
    		unset($this->$scope); // 
    		$this->$scope = new Scope($scope);
    	}
    	
    	return $this->$scope;
    	
    }
    
    function __get($scope){
    	return $this->create($scope);
    }
    
}


class Scope {
	
	private $name;
	private $obj;
	
	const classDir = APP_CLASSDIR;
	
	function __construct($name){
		$this->name = $name;
	}
	
	function create($module){
	    
		if(is_numeric($module)){
			// jei paduodamas modulio ID tai is db istraukiamas modulio vardas
    		include_once(CLASSDIR."main_module.class.php");
			$mod = main_module::getInstance()->getModule($module);
    		if($mod['table_name']!=''){
    			$module = $mod['table_name'];
    		}else{
    			trigger_error("Module by id not found ID: $module");
    		}
    	}

		if(is_object($this->obj[$module])) return $this->obj[$module];
    	
		$scope = $this->name;
		
		if(file_exists(self::classDir."$scope/$module.class.php")){
    		
    		include_once(self::classDir."$scope/$module.class.php");
    		$classname = $scope."_".$module;
    		$this->obj[$module] = new $classname();
    		
    	}else{
    		
    		include_once(self::classDir."$scope.class.php");
    		$this->obj[$module] = new $scope($module);
    		
    	}
    	
    	return $this->obj[$module];
    	
    	
	}
	
    function get($module, $property){
    	
    	if(!is_object($this->obj[$module])){
    		$this->create($module);
    	}
    	return $this->obj[$module]->$property;
    	
    }
    
    function set($module, $property, $value){
    	
    	if(!is_object($this->obj[$module])){
    		$this->create($module);
    	}
		$this->obj[$module]->$property = $value;	
    	
    }
    
    function call($module, $method, $params=array()){
    	
    	if(!is_object($this->obj[$module])){
    		$this->create($module);
    	}
    	if(method_exists($this->obj[$module], $method)){
    		
    		$return = call_user_method_array($method, $this->obj[$module], $params);
    		
    	}else{
    		
    		trigger_error("Method $method not exist in module $module scope $this->name");
    		
    	}
    	
    	return $return;
    	
    }	
	
    function __call($name, $args){
    	return $this->call($name, $args);
    }
    
    function __get($name){
    	return $this->create($name);
    }
    
    function destroy($module){
    	unset($this->obj[$module]);
    }	
	
}

?>