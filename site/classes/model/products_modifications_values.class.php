<?php

include_once(APP_CLASSDIR."model.class.php");
class model_products_modifications_values extends model {
	
    function __construct(){
        parent::__construct("products_modifications_values");
    }

    function listProductModifications($product_id){
        $list = $this->loadBy(array('category_id' => $product_id));
        foreach($list as $i => $val){
            $arr = explode("::", $val['modif']);
            $modif_arr = array();
            foreach($arr as $modif_id){
                $modif_arr[] = $this->registry->model->products_modifications_options->loadItem($modif_id);
            }
            $list[$i]['modif_arr'] = $modif_arr;
            $m_data = $this->registry->model->products_modifications->loadItem($val['title']);
            $list[$i]['title'] = $m_data['title_visible'];
        }
        return $list;
    }

}

?>
