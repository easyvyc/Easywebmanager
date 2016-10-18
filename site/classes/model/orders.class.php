<?php

include_once(APP_CLASSDIR."model.class.php");
class model_orders extends model {
	
    function __construct(){
        parent::__construct("orders");
    }
    
    function loadItem($order_id){
        $data = parent::loadItem($order_id);
        $data['payment_type_bank'] = ($data['payment'] == 15183 ? true : false);
        return $data;
    }
    
    function listOrderedItems($order_id){
        $list = $this->registry->model->ordered_items->loadBy(array('category_id' => $order_id));
        foreach($list as $i => $val){
            $product_data = $this->registry->model->products->loadItem($val['rel_id']);
            $list[$i]['page_url'] = $product_data['page_url'];
            $list[$i]['item_url'] = $product_data['item_url'];
        }
        return $list;
    }

    function insert($data){
        $data['order_number'] = $this->get_next_order_number();
        $data['active'] = 1;
        return parent::insert($data);
    }
    
    function get_next_order_number(){
        $row = $this->db->select($this->table)
                        ->fields("MAX(order_number) AS max_number")
                        ->row_array();   		
        $next = $row['max_number'] + 1;
        return $next;
    }
    
}

?>
