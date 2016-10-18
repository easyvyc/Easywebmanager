<?php

include_once(APP_CLASSDIR."model.class.php");
class model_cars extends model {
	
    function __construct(){
        parent::__construct("cars");
    }
    
    function getMarkes(){
        $this->sqlQueryWhere[] = " R.parent_id=:__category__ ";
        $this->sqlQueryBinds['__category__'] = 0;
        $order_by = $this->module_info['default_sort'];
        $order_direction = $this->module_info['default_sort_direction'];
        $this->sqlQueryOrder[] = " $order_by $order_direction ";
        $list = $this->listSearchItems();
        return $list;
    }
    
    function getModels($mark_id){
        $this->sqlQueryWhere[] = " R.parent_id=:__category__ ";
        $this->sqlQueryBinds['__category__'] = $mark_id;
        $order_by = $this->module_info['default_sort'];
        $order_direction = $this->module_info['default_sort_direction'];
        $this->sqlQueryOrder[] = " $order_by $order_direction ";
        $list = $this->listSearchItems();
        return $list;
    }

    function save_car_modifs($product_id, $data){
        $this->registry->model->cars_products->save($product_id, $data);
    }
    
    function getProductModifs($product_id){
        $modifs = $this->registry->model->cars_products->list_product_modifs($product_id);
        $list = array();
        foreach($modifs as $val){
            $list[] = $this->registry->model->cars_modif->loadItem($val['car_modif_id']);
        }
        return $list;
    }
    
    function getTreeItems($parent_id){
        
        $category = $this->listing_filter_data['parent_id'];
        $order_by = $this->listing_filter_data['order_by'];

        if ($order_by == '')
            $order_by = $this->module_info['default_sort'];
        if ($order_direction == '')
            $order_direction = $this->module_info['default_sort_direction'];

        $arr = preg_split("/\s/", $order_by);
        if(count($arr) > 1){
            $order_by = $this->listing_filter_data['order_by'] = $arr[0];
            $order_direction = $this->listing_filter_data['order_direction'] = $arr[1];
        }
        
        if ($this->module_info['no_record_table'] == 1 && $order_by == 'R.sort_order') {
            $order_by = "";
        }

        if ($this->module_info['no_record_table'] != 1) {
            $this->sqlQueryWhere[] = " R.parent_id=:__category__ ";
            $this->sqlQueryBinds['__category__'] = $category;
        }

        if ($order_by != '')
            $this->sqlQueryOrder[] = " $order_by $order_direction ";
        
        $list = $this->listSearchItems();

        return $list;        
        
    }

}

?>
