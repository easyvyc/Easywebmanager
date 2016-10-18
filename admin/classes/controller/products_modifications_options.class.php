<?php

include_once(CLASSDIR."controller.class.php");
class controller_products_modifications_options extends controller {

    function __construct() {
    	parent::__construct("products_modifications_options");
    }

    function select_modif_options($elm_obj){
        
        $data = $elm_obj->get('form')->get_data_values();
        $modif_id = $data['title'];
        
        $modif_values = explode("::", $data['modif']);
        
        $list = $this->mod->list_modif_values($modif_id);
        foreach($list as $i => $val){
            $list[$i]['selected'] = ( (in_array($val['id'], $modif_values)) ? true : false);
        }
        TPL::setVar('list', $list);
        
        TPL::setVar('product_modif_options_list', TPL::parse(TPLDIR . 'forms/custom/product_modif_options_list.tpl'));
        
    }
    
    function load_form_list(){
        
        $modif_id = $this->get['modif_id'];
        $list_values = $this->mod->list_modif_values($modif_id);
        TPL::setVar('list', $list_values);
        
        TPL::setVar('elm', $this->registry->model->products_modifications_values->_table_fields['modif']);
        
        $list = TPL::parse(TPLDIR . 'forms/custom/product_modif_options_list.tpl');
        
        $json = array();
        $json['product_modif_list_options_area'] = $list;
        
        return $json;
        
    }
    
}
?>