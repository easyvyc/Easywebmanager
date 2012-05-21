<?php

include_once (CLASSDIR.'Element.class.php');
class select extends Element {
	
	function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
		$attr = $this->get('list_values');
		if(!isset($attr['method'])){
			$list = $this->registry->modules->{$attr['module']}->listItems($attr['parent_id']);
		}else{
			$list = $this->registry->modules->{$attr['module']}->{$attr['method']}($attr['parent_id']);
		}
		foreach($list as $i=>$val){
			if(!isset($list[$i]['value'])) $list[$i]['value'] = $list[$i]['id'];
			if($list[$i]['value']==$this->get('value')) $list[$i]['selected'] = true;
		}
		TPL::setVar('list', $list);
		return parent::getHTML();
	}
	
}

?>