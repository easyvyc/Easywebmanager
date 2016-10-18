<?php

include_once(CLASSDIR."basic.class.php");
include_once(CLASSDIR."record.class.php");
class trash extends basic {

    function __construct() {
    	
    	parent::__construct();
    	
    	$this->language = $_SESSION['admin_interface_language'];
    	
    }
    
    function listCount(){
    	
    	$sql = "SELECT COUNT(R.id) AS cnt FROM {$this->config->variable['sb_record']} R ".
        		" LEFT JOIN {$this->config->variable['sb_module']} M " .
        		" ON (R.module_id=M.id)" .
        		" WHERE $this->where_clause R.trash=1 ";
        		//" GROUP BY R.id ";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	return $row['cnt'];
    	
    }
    
    function listItems($category=0, $order_by='R.sort_order', $order_direction='ASC', $offset=0, $paging=30){
        $sql = "SELECT 1 AS editorship, R.id, R.parent_id, R.is_category, R.create_by_ip, R.create_by_admin, R.create_date, R.last_modif_by_ip, R.last_modif_by_admin, R.last_modif_date, M.table_name, M.title_$this->language AS module_title, M.tree FROM {$this->config->variable['sb_record']} R " .
        		" LEFT JOIN {$this->config->variable['sb_module']} M " .
        		" ON (R.module_id=M.id)" .
        		" WHERE $this->where_clause R.trash=1 " .
        		" ORDER BY $order_by $order_direction " .
        		" LIMIT $offset, $paging ";
        $this->db->exec($sql, __FILE__, __LINE__);
        $arr = $this->db->arr();
        $n = count($arr);
        for($i=0; $i<$n; $i++){
        	$sql = "SELECT title FROM {$this->config->variable['pr_code']}_{$arr[$i]['table_name']} WHERE record_id={$arr[$i]['id']} AND (lng='$this->language' OR lng='') ";
        	$this->db->exec($sql, __FILE__, __LINE__);
        	$row = $this->db->row();
        	$arr[$i]['title'] = $row['title'];
        }
        //pae($arr);
        return $arr;
    }    
    
    function setWhereClause($arr=array()){
    	foreach($arr as $key => $val){
    		//if($key=='title') $this->where_clause .= " T.$key LIKE '%{$val}%' AND ";
    		if($key=='module_title') $this->where_clause .= " M.title_$this->language LIKE '%{$val}%' AND ";
    		if($key=='create_date'){
    			if(strlen($val['from'])) $this->where_clause .= " R.$key>'{$val['from']}' AND ";
    			if(strlen($val['to'])) $this->where_clause .= " R.$key<='{$val['to']}' AND ";
    		} 
    		if($key=='last_modif_date'){
    			if(strlen($val['from'])) $this->where_clause .= " R.$key>'{$val['from']}' AND ";
    			if(strlen($val['to'])) $this->where_clause .= " R.$key<='{$val['to']}' AND ";
    		} 
    	}
    }
    
    function delete($id){
    	
    	$row = $this->getModule($id);
    	
    	if(isset($row['table_name'])){
	    	$record = $this->registry->model->create($row['table_name']);
	    	$record->deleteFromTrash($id);
    	}

    }
    
    function reset($id){

    	$row = $this->getModule($id);
    	
    	if(isset($row['table_name'])){
	    	$record = $this->registry->model->create($row['table_name']);
	    	$record->resetFromTrash($id);
    	}

    }
    
    function deleteOldItems($trash_limit=200){
    	
    	$sql = "SELECT * FROM {$this->config->variable['sb_record']} WHERE trash=1 ORDER BY last_modif_date ASC";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->arr();
    	$count = count($arr);
    	
    	if($trash_limit < $count){
    		$n = $count - $trash_limit;
    		for($i=0; $i<$n; $i++){
    			$this->delete($arr[$i]['id']);
    		}
    	}
    	
    }
    
    function getModule($id){
    	$sql = "SELECT M.* FROM {$this->config->variable['sb_record']} R LEFT JOIN {$this->config->variable['sb_module']} M ON (M.id=R.module_id) WHERE R.id=$id GROUP BY M.id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	return $row;
    }
    
}

?>