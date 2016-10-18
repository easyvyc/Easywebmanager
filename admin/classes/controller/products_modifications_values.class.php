<?php

include_once(CLASSDIR."controller.class.php");
class controller_products_modifications_values extends controller {

    function __construct() {
    	parent::__construct("products_modifications_values");
        
        $this->default_grid_data['filter_form'] = false;
    }

    function checkDataExist($value, $column_name, $data){
        $list = $this->mod->loadBy(array($column_name => $value, 'category_id' => $data['category_id']));
        foreach ($list as $i => $val) {
            if ($data['id'] != $val['id']) {
                return false;
            }
        }
        return true;
    }
    
}
?>