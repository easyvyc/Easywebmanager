<?php

include_once (CLASSDIR.'Element.class.php');
class element_autocomplete extends Element {
	
	function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
		
		$list_values = $this->get('list_values');
		
                if($list_values['multiple'] == 1){

                    if(!is_array($this->get('value'))){
                        $value = explode("::", $this->get('value'));
                    }else{
                        $value = $this->get('value');
                    }

                    $value_list = array();
                    if(!is_array($value)){
                        $value_list[] = $value;
                    }else{
                        $value_list = $value;
                    }

                    $list = array();
                    foreach($value_list as $id){
                        if(is_numeric($id)){
                            $data = $this->registry->model->{$list_values['module']}->loadItem($id);
                            if($list_values['list_title']){
                                $data['label'] = $list_values['list_title'];
                                foreach($this->registry->model->{$list_values['module']}->table_fields as $table_field){
                                    $data['label'] = str_replace("{" . $table_field['column_name'] . "}", $data[$table_field['column_name']], $data['label']);
                                }
                            }else{
                                $data['label'] = $data['title'];
                            }
                            $list[] = $data;
                        }
                    }
                    
                    TPL::setVar('list', $list);
                    
                }else{
                    
                    $item_data = $this->registry->model->{$list_values['module']}->loadItem($this->get('value'));
                    if($list_values['list_title']){
                        $item_data['label'] = $list_values['list_title'];
                        foreach($this->registry->model->{$list_values['module']}->table_fields as $table_field){
                            $item_data['label'] = str_replace("{" . $table_field['column_name'] . "}", $item_data[$table_field['column_name']], $item_data['label']);
                        }
                    }else{
                        $item_data['label'] = $item_data['title'];
                    }
                    
                    TPL::setVar('auto_complete_data', $item_data);
                }

		
		return parent::getHTML();
	}
	
}

?>