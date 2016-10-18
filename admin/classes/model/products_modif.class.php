<?php

include_once(CLASSDIR."basic.class.php");
class model_products_modif extends basic {

    function __construct() {
    	parent::__construct();
    	$this->table = $this->config->variable['pr_code']."_products_modif";
    	$this->language = $_SESSION['site_lng'];
    	
    	$this->table_fields = $this->registry->model->call("modifications", "listSearchItems");
    }
    
    function loadItem($id){
    	$sql = "SELECT * FROM $this->table WHERE record_id=$id AND lng='$this->language'";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	if(empty($row)){
    		$row['isNew'] = 1;
    	}
    	return $row;
    }
    
    function saveItem($data){
    	
    	$fields = array();
    	foreach($this->table_fields as $i=>$val){
    		$fields[] = " {$val['column_name']}='".$data[$val['column_name']]."' ";
    	}
    	if($data['isNew']==1){
    		$sql = "INSERT INTO $this->table SET ".implode(",", $fields)." , lng='$this->language', record_id={$data['id']}";
    		$this->db->exec($sql, __FILE__, __LINE__);
    	}else{
    		$sql = "UPDATE $this->table SET ".implode(",", $fields)." WHERE record_id={$data['id']} AND lng='$this->language'";
    		$this->db->exec($sql, __FILE__, __LINE__);
    	}
    	
    }
    
    function delete($id){
    	$sql = "DELETE FROM $this->table WHERE record_id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    }
    
}
?>