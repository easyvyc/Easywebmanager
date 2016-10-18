<?php 

include_once(APP_CLASSDIR."model.class.php");
class model_ordered_items extends model {
	
    function __construct() {
    	parent::__construct("ordered_items");
    }
    
    function saveItem($data){
    	$id = parent::saveItem($data);
    	
        $o_item_data = $this->loadItem($id);
        $this->registry->model->orders->recalculate_order_sum($o_item_data['category_id']);
        
    	return $id;
    }

}

?>