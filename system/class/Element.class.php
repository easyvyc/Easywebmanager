<?php

class Element extends basic {
	
	// 
	private $message;
	
	//
	private $attr;
	
	//
	private $validate_error_css_class = "error";
	
	function __construct($name, $element){
		parent::__construct ();
		foreach($element as $key=>$value){
			$this->set($key, $value);
		}
		$this->set('name', $name);
		
		if(!$element['type']) trigger_error("Form element attribute type must be defined");
		
	}
	
	function set($key, $value){
		if(in_array($key, array('list_values', 'class_method', 'function')) && !is_array($value)){
			$value = $this->parseString2Array($value);
		}
		$this->attr[$key] = $value;
	}
	
	function get($key){
		return $this->attr[$key];
	}
	
	function validate($data){
		$value = $data[$this->get('name')];
		$this->set('value', $value);
		if($this->attr['required']){
			if(!isset($value) || $value==''){
				$this->message = "";
				$this->set('style', $this->validate_error_css_class);
				$this->set('show_error', true);
				return false;
			}
		}
		if(is_array($this->attr['class_method']) && !empty($this->attr['class_method'])){
			if(!$this->registry->modules->{$this->attr['class_method']['module']}->{$this->attr['class_method']['method']}($this->attr, $data)){
				$this->message = $this->attr['class_method']['admin_error_msg'];
				$this->set('style', $this->validate_error_css_class);
				$this->set('show_error', true);
				return false;
			}
		}
		if(is_array($this->attr['function']) && !empty($this->attr['function'])){
			if(!call_user_func($this->attr['function']['function'], $value)){
				$this->message = $this->attr['function']['admin_error_msg'];
				$this->set('style', $this->validate_error_css_class);
				$this->set('show_error', true);
				return false;
			}			
		}
		return true;
	}
	
	function getHTML(){
		TPL::setVar('elm', $this->attr);
		TPL::setVar('style', 'fo');
		return TPL::parse(TPLDIR."forms/".$this->get('type').".tpl")."";
	}
	
	function elm_stateHTML($state = 0){
		return "<input type=\"hidden\" id=\"ELM_state_{$this->attr['name']}\" value=\"$state\">";
	}
	
	function getMessage(){
		return $this->message;
	}
	
}

?>