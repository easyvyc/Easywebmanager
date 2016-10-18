<?php

include_once(CLASSDIR."controller.class.php");
class controller_products_fields_values extends controller {

    function __construct() {
    	parent::__construct("products_fields_values");
    }

    function edit(){
        
        $product_id = $this->get['id'];
        
        $data = $this->registry->model->products->loadItem($product_id);
        
        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=edit&id={$this->get['id']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1&json=1', $('#{$mod['id']}')));";

        $mod['hiddens']['id'] = $product_id;
        $mod['hiddens']['isNew'] = 0;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = 0;
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->registry->model->products_fields->getCategoryFields($data['category']);
        $fields_values_data = $this->mod->loadItem($product_id);
        $form_content = $this->editForm($mod, $fields, $fields_values_data);
        
        if($this->get['json']){
            return array('_WINDOW_content_' . $mod['table_name']  => "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        }        
    }
    
}
?>