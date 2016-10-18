<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_ordered_items extends controller {
	
    public function __construct() {
        parent::__construct ("ordered_items");
    }

//    public function listing($order_id){
//        $this->mod->get['id'] = $this->get['cid'];
//        return array('action_area_' . $this->get['cid'] => parent::listing());
//    }
    
    public function products_listing($order_id){
        $this->get['cid'] = $_GET['cid'] = $order_id;
        $this->get['column'] = $_GET['column'] = 'category_id';
        $this->mod->listing_filter_data['parent_id'] = 0;
        $this->mod->get['id'] = 0;
        return parent::listing(0);
    }
    
    public function tree(){
        return $this->registry->controller->orders->tree();
    }
    
    function edit(){
        
        $id = $this->get['id'];
        //return $this->actions($id)."<div id='action_area_$id' class='action_area'>".$this->editItemForm($id)."</div>";

        $data = $this->mod->loadItem($id);
        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=edit&id=$id&cid={$this->get['cid']}&area=_WINDOW_content_ordered_item_$id&no_tree_reload=1&json=1', $('#{$mod['id']}')));";
        //$mod['redirect'] = "admin.php?module={$mod['table_name']}&method=edit&id=$id&ajax=1&form_success=1";

        $mod['hiddens']['id'] = $id;
        $mod['hiddens']['isNew'] = ($id ? 0 : 1);
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = ($parent_id ? $parent_id : $data['parent_id']);
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->mod->_table_fields;
        if ($mod['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields = $this->add_edit_form_save_languages($id);
            // cia jeigu custom form template reikia pridet kalbu checkboxus
            if ($mod['form_tpl'])
                $mod['form_tpl'] = "{tpl.language_actions}" . $mod['form_tpl'];
        }

        $form_content = $this->editForm($mod, $fields, $data);        
        
        if($_POST){
            return array("_WINDOW_content_ordered_item_$id" => "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        }
        
    }
    
    function something_after_success_submit($return_val) {
        if (isset($return_val)) {
            switch($this->something_after_success_action){
                case 'edit_from_listing':
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .formElementsField, #_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .submit_block').hide(); " .
                            "\$NAV.get('?module={$this->get['module']}&method=listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1');" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}_{$this->get['column']}_{$this->get['cid']}'); }, 2000); " .
                            "</script>";
                    break;
                case 'create_from_listing':
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']} .formElementsField, #_WINDOW_content_{$this->get['module']} .submit_block').hide(); " .
                            "\$NAV.get('?module={$this->get['module']}&method=listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1');" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}'); }, 2000); " .
                            "</script>";
                    break;
                default:
                    $o_item = $this->mod->loadItem($return_val);
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            " \$NAV.select_context_action('orders', 'products', '{$o_item['category_id']}'); " .
                            "</script>";
            }
        }
    }    
    
    function delete(){
        $id = $this->get['id'];
        if($_POST){
            return array('_WINDOW_content_ordered_item_' . $id  => "<div id='action_area_$id' class='action_area'>" . parent::delete(false) . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . parent::delete(false) . "</div>";
        }        
        return ;
    }
    
    function something_after_success_delete($return_val) {
        if($return_val){
            switch($this->something_after_success_action){
                case 'delete_from_listing':
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .formElementsField, #_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .submit_block').hide(); " .
                            "\$NAV.get('?module={$this->get['module']}&method=listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1');" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}_{$this->get['column']}_{$this->get['cid']}'); }, 2000); " .
                            "</script>";
                    break;
                default:
                    return "<script> \$NAV.is_not_saved = false; \$NAV.select_context_action('orders', 'products', '{$this->get['cid']}'); </script>";
            }
        }
    }    
}

?>