<?php

include_once(CLASSDIR."model.class.php");
class model_products_modifications_values extends model {

    function __construct() {
    	parent::__construct("products_modifications_values");
    }
    
    function getListingItems($parent_id){
        $list = parent::getListingItems($parent_id);
        foreach($list as $i => $item){
            $arr = explode("::", $item['modif']);
            $modif_arr = array();
            foreach($arr as $modif){
                $modif_data = $this->registry->model->products_modifications_options->loadItem($modif);
                $modif_arr[] = "<img src='index.php?module=products_modifications_options&method=show_image&column=image&id={$modif_data['id']}&w=30&h=30&t=crop' style='vertical-align:middle'>&nbsp;({$modif_data['code']})&nbsp;{$modif_data['title']}";
            }
            $list[$i]['modif'] = implode("<br />", $modif_arr);
            $list[$i]['modif_ALT'] = "";
            
            //$list[$i]['title'] =
        }
        return $list;
    }
    
}
?>