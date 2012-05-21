<?php

include_once (CLASSDIR.'Element.class.php');

class text extends Element {
	
	public function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
		$this->set('value', htmlspecialchars($this->get("value"), ENT_QUOTES));
		return parent::getHTML();
	}
	
}

?>