<?php

include_once(APP_CLASSDIR."model.class.php");
class model_products_fields_values extends model {
	
    function __construct(){
        parent::__construct("products_fields_values");
    }
    
    function loadItem($id){
        
        $product = $this->registry->model->products->loadItem($id);
        $filters = $this->registry->model->products_fields->loadCategoryFilters($product['category']);
        $filters_data = $this->load($id);
        
        $filters_values = array();
        foreach($filters as $i => $val){
            if($filters_data['column_' . $val['id']]){
                if(in_array($val['elm_type'], array(FRM_SELECT, FRM_RADIO, FRM_CHECKBOX_GROUP))){
                    $tmp_arr = explode("::", $filters_data['column_' . $val['id']]);
                    $select_values = array();
                    foreach($tmp_arr as $tmp_val){
                        $tmp_data = $this->registry->model->products_fields_options->loadItem($tmp_val);
                        $select_values[] = $tmp_data['title'];
                    }
                    $filters_values[] = array('title' => $val['title'], 'value' => implode(", ", $select_values));
                }else{
                    $filters_values[] = array('title' => $val['title'], 'value' => $filters_data['column_' . $val['id']]);
                }
            }
        }
        
        return $filters_values;
        
    }
    
    function loadMinMax($field_id, $category_id){
        
        if(!$this->registry->model->products->categories_tree_temp[$category_id]){
            $this->registry->model->products->categories_tree_temp[$category_id] = $this->registry->model->pages->loadTree($category_id);
        }
        
        $query_where = "";
        $where_path_arr = array();
        $where_path_arr[] = "P.category = $category_id";
        foreach($this->registry->model->products->categories_tree_temp[$category_id] as $path_data){
            $where_path_arr[] = "P.category = {$path_data['id']}";
        }
        $query_where = " (" . implode(" OR ", $where_path_arr) . ") ";
        
        $field_name = "column_" . $field_id;
        $arr = $this->db->select($this->table . " T")
                        ->fields("MAX($field_name) AS max_val, MIN($field_name) AS min_val")
                        ->joins("LEFT JOIN cms_products P ON (P.record_id = T.record_id AND P.lng=:lng)")
                        ->where(" T.$field_name IS NOT NULL ")
                        ->where($query_where)
                        ->where('T.lng = :lng')
                        ->bind('lng', $this->language)
                        ->row_array();
        return $arr;
        
    }
    
    function load($id){
        $data = $this->db->select($this->table)
                ->where('record_id = :id')
                ->where('lng = :lng')
                ->bind('id', $id)
                ->bind('lng', $this->language)
                ->row_array();
        return $data;
    }
    
    function getOptionsValues($field_id, $category_id, $field_type){
        
        if(!$this->registry->model->products->categories_tree_temp[$category_id]){
            $this->registry->model->products->categories_tree_temp[$category_id] = $this->registry->model->pages->loadTree($category_id);
        }
        
        $query_where = "";
        $where_path_arr = array();
        $where_path_arr[] = "P.category = $category_id";
        foreach($this->registry->model->products->categories_tree_temp[$category_id] as $path_data){
            $where_path_arr[] = "P.category = {$path_data['id']}";
        }
        $query_where = " (" . implode(" OR ", $where_path_arr) . ") ";
        
        $field_name = "column_" . $field_id;
        
        $selected_str = "0";
        $binds = array();
        if($_GET['filter'][$field_id] && $field_type == 'select'){
            $selected_str = "IF(T.$field_name = :use_filter_bind_$field_id, 1, 0)";
            $binds['use_filter_bind_' . $field_id] = $_GET['filter'][$field_id];
        }
        if(!empty($_GET['filter'][$field_id]) && $field_type == 'checkbox'){
            $fltr_val_arr = array();
            foreach($_GET['filter'][$field_id] as $indx => $fltr_val){
                if($fltr_val){
                    $bnd = 'use_filter_bind_' . $field_id . '_' . $indx;
                    $fltr_val_arr[] = ":" . $bnd;
                    $binds[$bnd] = $fltr_val;
                }
            }
            $selected_str = "IF(T.$field_name IN (" . implode(",", $fltr_val_arr) . "), 1, 0)";
        }
        
        $arr = $this->db->select($this->table . " T")
                        ->fields("T.$field_name AS title, T.$field_name AS id, $selected_str AS selected")
                        ->joins("LEFT JOIN cms_products P ON (P.record_id = T.record_id AND P.lng=:lng)")
                        ->where(" T.$field_name IS NOT NULL ")
                        ->where($query_where)
                        ->where('T.lng = :lng')
                        ->bind($binds)
                        ->bind('lng', $this->language)
                        ->group("T.$field_name")
                        ->result_array();
        return $arr;
        
    }

}

?>
