<?php

include_once(CLASSDIR."module.class.php");
include_once(CLASSDIR."basic.class.php");
class _main extends basic {

    function __construct() {
		parent::__construct();	
		$this->module = module::getInstance();
    }
    
    function listRss(){
    	
    	$sql = "SELECT * FROM {$this->module->table} WHERE rss=1";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->arr();
    	return $arr;
    	
    }
    
    function loadItem($id){
    	if(!is_numeric($id)) return false;
    	$sql = "SELECT * FROM ".Config::$val['pr_code']."_record WHERE id=$id";
    	$this->db->exec($sql);
    	$row = $this->db->row();
    	if(!empty($row)){
	    	$sql = "SELECT * FROM {$this->module->table} WHERE id={$row['module_id']}";
			$this->db->exec($sql, __FILE__, __LINE__);
			$mod_row = $this->db->row();
			$data = $this->registry->modules->call($mod_row['table_name'], "loadItem", array($id));
    		$data['_MODULE_'] = $mod_row['table_name'];
    		return $data;
    	}
    }    
    
}
?>
