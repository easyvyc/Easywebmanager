<?php

include_once(CLASSDIR."model.class.php");
class model_products_fields_options extends model {

    function __construct() {
    	parent::__construct("products_fields_options");
    }
    
    function listOptions($field_id){
        $this->sqlQueryWhere = " T.product_field_value_id = :product_field_value_id ";
        $this->sqlQueryBinds = array('product_field_value_id' => $field_id);
        return $this->listSearchItems();
    }
    
}
?>