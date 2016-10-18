<?php

include_once (CLASSDIR.'forms/select.class.php');
class element_radio extends element_select {
	
	function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
	}
	
}

?>