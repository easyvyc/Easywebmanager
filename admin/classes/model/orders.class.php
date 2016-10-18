<?php 

include_once(APP_CLASSDIR."model.class.php");
class model_orders extends model {
	
    function __construct() {
    	parent::__construct("orders");
    }
    
    function getLastInvoiceNumber(){
            $sql = "SELECT MAX(order_number) AS max_number FROM $this->table";
            $this->db->exec($sql);
            $row = $this->db->row();
            return $row['max_number'];
    }
    
    function recalculate_order_sum($order_id){
        $old_data = $this->loadItem($order_id);
        $o_items = $this->registry->model->ordered_items->loadBy(array('category_id' => $order_id));
        $recalc_price = 0;
        foreach($o_items as $o_item_val){
            $recalc_price += $o_item_val['kiekis'] * $o_item_val['price'];
        }
        $recalc_price += $old_data['shipping_price'];
        $this->updateField($order_id, 'order_sum', $recalc_price);
    }
    
}

?>