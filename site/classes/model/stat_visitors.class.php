<?php

include_once(APP_CLASSDIR."model.class.php");
class model_stat_visitors extends model {

    protected $load_module_info = false;
    
    function __construct(){
        parent::__construct("stat_visitors");
        $this->module_info['no_record_table'] = 1;
        $this->table_fields = array();
        $this->table_fields[] = array('column_name' => 'ipaddress');
        $this->table_fields[] = array('column_name' => 'browser');
        $this->table_fields[] = array('column_name' => 'browser_version');
        $this->table_fields[] = array('column_name' => 'os');
        $this->table_fields[] = array('column_name' => 'device');
        $this->table_fields[] = array('column_name' => 'referer');
        $this->table_fields[] = array('column_name' => 'referer_domain');
        $this->table_fields[] = array('column_name' => 'keyword');
        $this->table_fields[] = array('column_name' => 'country');
        $this->table_fields[] = array('column_name' => 'country_code');
        $this->table_fields[] = array('column_name' => 'city');
        $this->table_fields[] = array('column_name' => 'region');
        $this->table_fields[] = array('column_name' => 'latitude');
        $this->table_fields[] = array('column_name' => 'longitude');
        $this->table_fields[] = array('column_name' => 'user_agent');
        $this->table_fields[] = array('column_name' => 'visit_time');
        $this->table_fields[] = array('column_name' => 'session_id');
        $this->table_fields[] = array('column_name' => 'robot');
        $this->table_fields[] = array('column_name' => 'page_count');
        $this->table_fields[] = array('column_name' => 'back_id');
        $this->table_fields[] = array('column_name' => 'conversion_id');
    }
    
    function add_page($visitor){
        $upd['page_count'] = $visitor['page_count'];
        if($visitor['conversion_id']){
            $upd['conversion_id'] = $visitor['conversion_id'];
        } 
        $this->update($upd, array('id'=>$visitor['visitor_id']));
    }
    
}

?>
