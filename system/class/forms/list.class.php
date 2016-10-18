<?php

include_once (CLASSDIR.'Element.class.php');
class element_list extends Element {
	
	function __construct($name, $element, $form_object) {
            parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
            $data_values = $this->get("form")->get_data_values();
            TPL::setVar('frm_list_CID', ($data_values['id'] ? $data_values['id'] : 'TEMP'));
            return parent::getHTML();
	}
        
        
	
}

?>