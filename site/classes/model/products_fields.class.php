<?php

include_once(APP_CLASSDIR."model.class.php");
class model_products_fields extends model {
	
    function __construct(){
        parent::__construct("products_fields");
    }
    
    function loadCategoryFilters($category_id){
        
        $path = $this->registry->model->pages->path($category_id);
        $whr_path_arr = array();
        foreach($path as $path_data){
            $whr_path_arr[] = "T.category_id = {$path_data['id']}";
        }
        $query['where'] = "(" . implode(" OR ", $whr_path_arr) . ")";
        
        return $this->listSearchItems($query);
        
    }

}

?>
