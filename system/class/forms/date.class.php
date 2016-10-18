<?php

include_once (CLASSDIR.'Element.class.php');

class element_date extends Element {
	
    public function __construct($name, $element, $form_object) {
        parent::__construct ($name, $element, $form_object);
    }

    function validate($data){
        $nm = $this->get('name');
        $data[$nm] = $data[$nm . '_date'];
        if($this->attr['list_values']['time'] == 1){
            $data[$nm] .= $data[$nm . '_hour'] . ":" . $data[$nm . '_min'] . ":00";
        }
        $this->get('form')->set_data_value($nm, $data[$nm]);
        return parent::validate($data);
    }
    
    function getHTML(){
        if($this->attr['list_values']['multiple'] && !$this->attr['list_values']['tpl_file']){
            $this->attr['list_values']['tpl_file'] = 'forms/date_multiple.tpl';
        }
        if($this->attr['list_values']['multiple']){
            $dates_arr = preg_split("/,\s/", $this->get('value'));
            TPL::setVar('date_values', $dates_arr);
        }
        return parent::getHTML();
    }
    
}

?>