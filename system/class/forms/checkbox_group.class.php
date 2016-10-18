<?php

include_once (CLASSDIR.'Element.class.php');
class element_checkbox_group extends Element {
	
	function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
		
		$list_values = $this->get('list_values');
		
		if(is_array($list_values)){
			$mode = 'array'; // default
			if(isset($list_values['parent_id'])) $mode = 'list';
			if(isset($list_values['method'])) $mode = 'call';
                        if(isset($list_values['source']) && strtolower($list_values['source'])=='values') $mode = 'values';
		}
		
		switch($mode){
			case 'array':
				$list = $list_values;
			break;
			case 'values':
                                $list_ = explode(";", trim($list_values['values'], ";"));
                                $list = array();
                                foreach($list_ as $val){
                                    $list[] = array('value'=>$val, 'title'=>$val);
                                }
			break;
			case 'list':
				$list = $this->registry->model->{$list_values['module']}->listItems($list_values['parent_id']);
			break;
			case 'call':
				$list = $this->registry->model->{$list_values['module']}->{$list_values['method']}($list_values['parent_id']);
			break;
		}
		
		$extra = $this->get('field_extra_params');
		foreach($list as $i=>$val){
			if(!isset($list[$i]['value'])) $list[$i]['value'] = $list[$i]['id'];
			if(in_array($list[$i]['value'], (array)$this->get('value'))) $list[$i]['selected'] = true;
			if($extra) $list[$i]['field_extra_params'] = preg_replace("/{value}/", $list[$i]['value'], $extra);
		}

		TPL::setVar('list', $list);
		return parent::getHTML();
	}
	
}

?>