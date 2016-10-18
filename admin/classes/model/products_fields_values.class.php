<?php

include_once(CLASSDIR."model.class.php");
class model_products_fields_values extends model {

    function __construct() {
    	parent::__construct("products_fields_values");
    }

    function loadItem($product_id){
        $data = $this->loadByOne(array('record_id' => $product_id), true);

        if(empty($data)) return false;
        
        $product_data = $this->registry->model->products->loadItem($product_id);
        
        $fields = $this->registry->model->products_fields->getCategoryFields($product_data['category']);
        foreach($fields as $name => $value){
            if($value['elm_type'] == FRM_CHECKBOX_GROUP){
                $data[$name] = explode("::", $data[$name]);
            }
        }
        
        return $data;
    }
    
    function saveItem($data){
        $old_data = $this->loadItem($data['id']);
        
        $product_data = $this->registry->model->products->loadItem($data['id']);
        $fields = $this->registry->model->products_fields->getCategoryFields($product_data['category']);
        $product_fields_data = $non_multi_lng_data = array();
        foreach($fields as $name => $value){
            $product_fields_data[$name] = ($value['elm_type'] == FRM_CHECKBOX_GROUP ? implode("::", $data[$name]) : $data[$name]);
            if($value['multilng'] != 1){
                $non_multi_lng_data[$name] = $product_fields_data[$name];
            }
        }
        
        $product_fields_data['id'] = $data['id'];
        if(empty($old_data)){
            $this->insert($product_fields_data);
        }else{
            $this->update($product_fields_data, $old_data['record_id']);
            if(!empty($non_multi_lng_data)){
                $this->update_non_multilng($non_multi_lng_data, $old_data['record_id']);
            }
        }
        
        foreach($fields as $name => $value){
            if($value['list_values']['module'] && $value['list_values']['save_method']){
                $mtdh = strip_tags(nl2br($value['list_values']['save_method']));
                $module = strip_tags(nl2br($value['list_values']['module']));
                $this->registry->model->$module->$mtdh($data['id'], $data[$name]);
            }
        }
        
    }
    
    function insert($data){
        $data['record_id'] = $data['id'];
        unset($data['id']);
        foreach(Config::$val['default_page'] as $lang => $page_id){
            $data['lng'] = $lang;
            $data['lng_saved'] = ($this->language == $data['lng'] ? 1 : 0);
            $this->db->insert($this->table)
                    ->values($data, true)
                    ->query();
        }
    }
    
    function update($data, $id){
        $data['record_id'] = $data['id'];
        $data['lng'] = $this->language;
        $data['lng_saved'] = 1;
        unset($data['id']);
        $this->db->update($this->table)
                ->values($data, true)
                ->where("record_id=:id")
                ->where("lng=:lng")
                ->bind('id', $id)
                ->bind('lng', $this->language)
                ->query();
        // jei kitose kalbose nebuvo save tai saveinti is esamos
        unset($data['lng']);
        unset($data['lng_saved']);
        $this->db->update($this->table)
                ->values($data, true)
                ->where("record_id=:id")
                ->where("lng<>:lng")
                ->where("lng_saved<>1")
                ->bind('id', $id)
                ->bind('lng', $this->language)
                ->query();
    }
    
    function update_non_multilng($data, $id){
        // saveinti vienkalbius(multilng!=1) laukelius kitose kalbose
        $this->db->update($this->table)
                ->values($data, true)
                ->where("record_id=:id")
                ->where("lng<>:lng")
                ->bind('id', $id)
                ->bind('lng', $this->language)
                ->query();
    }
    
    function delete($id){
        $this->db->delete($this->table)
                ->where("record_id = :id")
                ->bind('id', $id)
                ->query();
    }
    
}
?>