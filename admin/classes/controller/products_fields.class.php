<?php

include_once(CLASSDIR."controller.class.php");
class controller_products_fields extends controller {

    function __construct() {
    	parent::__construct("products_fields");
    }
    
    function listing($cid){
        $new_item_link = "<div><a class=\"create_product_field_link\" href=\"javascript: void(\$NAV.open_dialog('products_fields_category_id_{$this->get['cid']}', '?module=products_fields&method=create_from_listing&column=category_id&area=&cid={$this->get['cid']}&id=0&no_tree_reload=1', 'New item'));\">" . cms::$phrases['products']['new_additional_field'] . "</a></div>";
        
        $arr = parent::listing($cid);
        $arr['content'] = $new_item_link . $arr['content'];
        
        return $arr;
    }
    
    function editForm($mod, $fields, $data){
        
        // jei ne SELECT RADIO CHECKBOX_GROUP, nerodyti opciju pridejimu laukelio
        if(!in_array($data['elm_type'], array(FRM_SELECT, FRM_RADIO, FRM_CHECKBOX_GROUP))){
            unset($fields['product_field_options']);
        }
        // jei ne custom, nerodyti opcijos list_values
        if($data['elm_type'] != 'custom'){
            unset($fields['list_values']);
        }
        
        return parent::editForm($mod, $fields, $data);
        
    }
    
    function something_after_success_submit($return_val) {
        if (isset($return_val)) {
            switch($this->something_after_success_action){
                default:
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            " \$NAV.get('?module=products&method=filters&column=category_id&cid={$this->get['cid']}'); " .
                            "</script>";
            }
        }
    }
    
    function something_after_success_delete($return_val) {
        if($return_val){
            switch($this->something_after_success_action){
                default:
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            " \$NAV.get('?module=products&method=filters&column=category_id&cid={$this->get['cid']}'); " .
                            "</script>";
            }
        }
    }
    
    
    
}
?>