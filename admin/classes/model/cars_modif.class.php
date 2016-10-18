<?php

include_once(APP_CLASSDIR."model.class.php");
class model_cars_modif extends model {
	
    function __construct(){
        parent::__construct("cars_modif");
    }
    
    function getItems($model_id){
        $this->sqlQueryWhere[] = " T.car_modif_id=:__model_id__ ";
        $this->sqlQueryBinds['__model_id__'] = $model_id;
        $order_by = $this->module_info['default_sort'];
        $order_direction = $this->module_info['default_sort_direction'];
        $this->sqlQueryOrder[] = " $order_by $order_direction ";
        $list = $this->listSearchItems();
        return $list;
    }

}

?>
