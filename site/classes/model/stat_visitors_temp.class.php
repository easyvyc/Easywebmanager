<?php

include_once(APP_CLASSDIR."model.class.php");
class model_stat_visitors_temp extends model {

    protected $load_module_info = false;
    private $hours_unique_visitor = 5;
    
    function __construct(){
        parent::__construct("stat_visitors_temp");
        $this->module_info['no_record_table'] = 1;
        $this->table_fields = array();
        $this->table_fields[] = array('column_name' => 'session_id');
        $this->table_fields[] = array('column_name' => 'user_agent');
        $this->table_fields[] = array('column_name' => 'ipaddress');
        $this->table_fields[] = array('column_name' => 'visit_time');
    }
    
    function check($visitor){
        $cond['user_agent'] = $visitor['user_agent'];
        $cond['ipaddress'] = $visitor['ipaddress'];
        $result = $this->loadBy($cond, true);
        if(empty($result) ? false : true);
    }
    
    function clear(){
        $unique_user_mktime = mktime(date("H")-$this->hours_unique_visitor,date("i"),date("s"),date("m"),date("d"),date("Y"));
        $dt = date("Y-m-d H:i:s", $unique_user_mktime);
        $this->db->delete($this->table)
                 ->where(array("visit_time < '$dt'"))
                 ->query();
    }
    
}

?>
