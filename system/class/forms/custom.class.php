<?php

include_once (CLASSDIR.'Element.class.php');
class element_custom extends Element {
	
	function __construct($name, $element, $form_object) {
            parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
            $list_values = $this->get('list_values');
            TPL::setVar('elm', $this->attr);
            TPL::setVar('style', 'fo');
            $c = strip_tags(nl2br(trim($list_values['module'])));
            $m = strip_tags(nl2br(trim($list_values['method'])));
            $html = $this->registry->controller->$c->$m($this).$this->elm_stateHTML($this->get('state'));
            return $html;
            
	}
	
}

?>