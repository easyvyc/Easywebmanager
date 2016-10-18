<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_shipping_places extends controller {
	
    public function __construct() {
        parent::__construct ("shipping_places");
    }

    function google_map_coords_iframe(){
        
        TPL::setVar('default_values', array('googlemaps_centerlat' => 56.93298739609704, 'googlemaps_centerlon' => 24.06005859375, 'googlemaps_zoom' => 6));
        
        if($this->get['id']){
            $data_values = $this->mod->loadItem($this->get['id']);
            TPL::setVar('data_values', $data_values);
        }
        
        TPL::setVar('column_name_lat', 'lat');
        TPL::setVar('column_name_lon', 'lon');
        
        return TPL::parse(TPLDIR . "forms/custom/select_map_iframe.tpl");
        
    }    
		
}

?>