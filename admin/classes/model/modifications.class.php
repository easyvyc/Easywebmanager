<?php

include_once(APP_CLASSDIR."model.class.php");
class model_modifications extends model {
	
	//var $mod_actions = array('module'=>array(), 'edit'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
	
	function __construct($module){
		
		parent::__construct($module);
		
		$this->product_fields_tbl = $this->config->variable['pr_code']."_products_modif";
		
	}
	
	function getFields($category){
	
		$this->registry->model->call("pages", "getPath", array($category));
		$path = $this->registry->model->get("pages", "path");
		
		$fields = $fields_arr = array();
		foreach($path as $i=>$val){
			$fields_arr = array_merge($fields_arr, $this->_getFields($val['id']));
		}
		$ids = array();
		foreach($fields_arr as $i=>$val){
			if(!in_array($val['column_name'], $ids)){
				$ids[] = $val['column_name'];
				$fields[] = $val;
			}
		}
		return $fields;
	}	
	
	function _getFields($category){
		$this->sqlQueryWhere = " T.category_id=$category AND ";
		$fields = $this->listSearchItems();
		foreach($fields as $i=>$val){
			$fields[$i]['elm_type'] = FRM_CHECKBOX_GROUP;
			$fields[$i]['list_values'] = array("source"=>"CALL", "object"=>"select_values", "method"=>"searchItems_list", "param1"=>array('category_id'=>$val['id']));
		}
		return $fields;
	}	

	function generateData($data){
		$data['column_type'] = "varchar(255)";
		$data['elm_type'] = '';
		$data['column_name'] = $this->generateColumnName($data['id'], $data['title']);
		return $data;
	}
	
	function saveItem($data){
		
		$data = $this->generateData($data);
		
		if($data['isNew']==1){
            $sql = "ALTER TABLE $this->product_fields_tbl ADD `{$data['column_name']}` {$data['column_type']}";
            $this->db->exec($sql, __FILE__, __LINE__);
		}else{
            $sql = "SELECT column_name FROM $this->table WHERE record_id={$data['id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $row = $this->db->row();
            $sql = "ALTER TABLE $this->product_fields_tbl CHANGE `{$row['column_name']}` `{$data['column_name']}` {$data['column_type']}";
            $this->db->exec($sql, __FILE__, __LINE__);
		}
		
		return  record::saveItem($data);
		
	}
	
	function delete($id){
        $data = $this->loadItem($id);
		$sql = "ALTER TABLE $this->product_fields_tbl DROP {$data['column_name']}";
	    $this->db->exec($sql, __FILE__, __LINE__);
		$this->registry->model->call("modif", "deleteField", $id);
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