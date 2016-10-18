<?php

include_once(APP_CLASSDIR."model.class.php");
class model_stat_visitors_path extends model {

    protected $load_module_info = false;
    
    function __construct(){
        parent::__construct("stat_visitors_path");
        $this->module_info['no_record_table'] = 1;
        $this->table_fields = array();
        $this->table_fields[] = array('column_name' => 'visitor_id');
        $this->table_fields[] = array('column_name' => 'url');
        $this->table_fields[] = array('column_name' => 'visit_time');
        $this->table_fields[] = array('column_name' => 'conversion_id');
    }
    
}

?>
