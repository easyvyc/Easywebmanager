<?php

include_once (CLASSDIR.'Element.class.php');

class element_password extends Element {
	
	public function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
		if(isset($element['password_hash_function'])){
			// set custom password encrypt function
			$this->password_hash_function = $element['password_hash_function'];
		}
	}
	
	function validate($data){
		if(trim($data[$this->get('name') . "_1"]) == trim($data[$this->get('name') . "_2"])){
			$data[$this->get('name')] = trim($data[$this->get('name') . "_1"]);
			if(strlen($data[$this->get('name')]) > 0){
				$this->get('form')->set_data_value($this->get('name'), call_user_func($this->password_hash_function, $data[$this->get('name')]));
			}elseif($data['isNew'] == 1){
				return $this->error();
			}
			parent::validate($data);
			return true;
		}else{
			return $this->error();
		}
	}
	
	function error(){
		$this->set('style', $this->validate_error_css_class);
		$this->set('show_error', true);
		$this->set('error_message', cms::$phrases['main']['admins']['wrong_password']);
		return false;
	}
	
}

?>