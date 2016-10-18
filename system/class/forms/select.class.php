<?php

include_once (CLASSDIR.'Element.class.php');
class element_select extends Element {
	
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
                                if($val)
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

            $is_array = (is_array($this->get('value')) ? true : false);
            
            foreach($list as $i=>$val){
                    if(!isset($list[$i]['value'])) $list[$i]['value'] = $list[$i]['id'];
                    if($is_array){
                        if(in_array($list[$i]['value'], $this->get('value'))) $list[$i]['selected'] = true;
                    }else{
                        if($list[$i]['value']==$this->get('value')) $list[$i]['selected'] = true;
                    }
            }
            TPL::setVar('list', $list);
            return parent::getHTML();
                
	}
	
}

?>