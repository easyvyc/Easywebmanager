<?php

include_once(APP_CLASSDIR."model.class.php");
class model_cars_products extends model {
	
    function __construct(){
        parent::__construct("cars_products");
    }
    
    function list_product_modifs($product_id){
        return $this->db->select($this->table)
                ->where("product_id = :product_id")
                ->bind('product_id', $product_id)
                ->result_array();
    }
    
    function save($product_id, $modifs){
        $all_product_modifs = $this->list_product_modifs($product_id);
        foreach($all_product_modifs as $modif_val){
            if(!in_array($modif_val['car_modif_id'], $modifs)){
                $this->remove($product_id, $modif_val['car_modif_id']);
            }
        }
        foreach($modifs as $modif_id){
            $row = $this->check($product_id, $modif_id);
            if(empty($row)){
                $this->insert($product_id, $modif_id);
            }
        }
    }
    
    function check($product_id, $modif_id){
        return $this->db->select($this->table)
                ->where("product_id = :product_id")
                ->where("car_modif_id = :car_modif_id")
                ->bind('product_id', $product_id)
                ->bind('car_modif_id', $modif_id)
                ->row_array();
    }
    
    function insert($product_id, $modif_id){
        $this->db->insert($this->table)
                ->values('product_id = :product_id, car_modif_id = :car_modif_id')
                ->bind('product_id', $product_id)
                ->bind('car_modif_id', $modif_id)
                ->query();
        
    }
    
    function remove($product_id, $modif_id){
        return $this->db->delete($this->table)
                ->where("product_id = :product_id")
                ->where("car_modif_id = :car_modif_id")
                ->bind('product_id', $product_id)
                ->bind('car_modif_id', $modif_id)
                ->query();
    }
    
}

?>
