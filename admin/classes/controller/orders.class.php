<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_orders extends controller {
	
    public function __construct() {
        parent::__construct ("orders");
    }

    public function products(){
        $order_id = $this->get['id'];
        $_GET['cid'] = $order_id;
        
        $listing = $this->registry->controller->ordered_items->products_listing($order_id);
        
        return $this->actions($order_id) . "<div id='action_area_$order_id' class='action_area'>" . $listing['content'] . "</div>" . $resize_script;
    }
    
    function editForm($mod, $fields, $data){
        unset($fields['ordered_items']);
        return parent::editForm($mod, $fields, $data);
    }
    
    function ordered_item_info(){
        return "sdfsfds";
    }
    
}

?>