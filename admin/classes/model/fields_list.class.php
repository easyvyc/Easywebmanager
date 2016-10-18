<?php

include_once(APP_CLASSDIR."model.class.php");
class model_fields_list extends model {
	
	//var $mod_actions = array('module'=>array(), 'edit'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
	
	function __construct(){
		
		parent::__construct("fields_list");
		
		$this->product_fields_tbl = $this->config->variable['pr_code']."_products_fields";
		
	}
	
	function generateData($data){
		$data['column_type'] = "varchar(255)";
		if($data['elm_type']=='textarea'){
			$data['column_type'] = "text";
		}
		$data['column_name'] = $this->generateColumnName($data['id'], $data['title']);
		return $data;
	}
	
	function saveItem($data){
		
		$data = $this->generateData($data);
		
		if($data['isNew']==1){
            $sql = "ALTER TABLE $this->product_fields_tbl ADD `{$data['column_name']}` {$data['column_type']}";
            $this->db->exec($sql, __FILE__, __LINE__);
		}else{
			if($data['column_name']!=''){
				$sql = "SELECT column_name FROM $this->table WHERE record_id={$data['id']}";
	            $this->db->exec($sql, __FILE__, __LINE__);
	            $row = $this->db->row();
	            $sql = "ALTER TABLE $this->product_fields_tbl CHANGE `{$row['column_name']}` `{$data['column_name']}` {$data['column_type']}";
	            $this->db->exec($sql, __FILE__, __LINE__);
			}
		}
		
		return  record::saveItem($data);
		
	}
	
	function delete($id){
        	$data = $this->loadItem($id);
		$sql = "ALTER TABLE $this->product_fields_tbl DROP {$data['column_name']}";
	        $this->db->exec($sql, __FILE__, __LINE__);
		$this->registry->model->call("fields", "deleteField", $id);
		record::deleteFromTrash($id);
	}



	function generateColumnName($id, $title) {
		
		$url = url_slug($title);
		$url = $this->checkUrl($url, $id);

		return $url;
		
	}
	
	function checkUrl($name, $id=0){
		$sql = "SELECT id FROM $this->table WHERE column_name='$name' AND record_id!=$id AND lng='$this->language'";
		$this->db->exec($sql, __FILE__, __LINE__);
		if($this->db->count>0){
			$name .= "_";
			$name = $this->checkUrl($name, $id);
		}
		else
			return $name;
		
		return $name;
	}	
    
}

?>