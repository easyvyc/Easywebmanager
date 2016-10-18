<?php

include_once(CLASSDIR."model.class.php");
class model_products_modifications_options extends model {

    function __construct() {
    	parent::__construct("products_modifications_options");
    }

    function list_modif_values($modif_id){
        return $this->loadBy(array('category_id' => $modif_id));
    }
    
}
?>