<?php

include_once(APP_CLASSDIR."model.class.php");
class model_products_fields_options extends model {
	
    function __construct(){
        parent::__construct("products_fields_options");
    }
    
    function loadItemValue($id){
        $data = $this->loadItem($id);
        return $data['title'];
    }
    
    function listOptions($category_id, $selected_values = array()){
        
        $list = $this->loadBy(array('product_field_value_id' => $category_id));
        
        foreach($list as $i => $val){
            if(in_array($val['id'], $selected_values)){
               $list[$i]['selected'] = true;
            }
        }
        
        return $list;
        
    }

}

?>
