<?php

include_once(CLASSDIR."basic.class.php");
class model_storage extends basic {

    function __construct() {
    	parent::__construct();
    	$this->table = $this->config->variable['pr_code']."_storage";
    	$this->table_reserved = $this->config->variable['pr_code']."_storage_reserved";
    	$this->language = $_SESSION['site_lng'];
    }
    
    function load($item_id, $modifications){
    	$sql = "SELECT * FROM $this->table WHERE item_id=$item_id AND kombinacija='$modifications'";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	return $this->db->row();
    }
    
    function insert($item_id, $modifications){
    	$sql = "INSERT INTO $this->table SET item_id=$item_id, kombinacija='$modifications', kiekis=0";
    	$this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function loadItem($item_id, $modifications){
		$row = $this->load($item_id, $modifications);
		if(empty($row['kiekis'])) return 0;
    	else return $row['kiekis'];
    }
    
    function change($item_id, $modifications, $count, $action){
    	$row = $this->load($item_id, $modifications);
    	if(empty($row)){
    		$this->insert($item_id, $modifications);
    	}
    	// kad nebutu neigiamo kiekio
    	if($count > $row['kiekis'] && $action=="-") return false;
    	
    	$sql = "UPDATE $this->table SET kiekis=kiekis $action $count WHERE item_id=$item_id AND kombinacija='$modifications'";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	
    	$this->registry->model->call("products", "changeKiekis", array($item_id, $this->getStorageItemModifications($item_id)));
    	
    	return true;
    }
    
    function getStorageItemModifications($id){
    	$sql = "SELECT SUM(kiekis) AS kiekis_all FROM $this->table WHERE item_id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	return $row['kiekis_all'];
    }
    
    function deleteProduct($item_id){
    	$sql = "DELETE FROM $this->table WHERE item_id=$item_id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function reserveItem($item_id, $item_komb, $kiekis, $order_id){
		$sql = "UPDATE $this->table SET kiekis=kiekis - $kiekis WHERE item_id=$item_id AND kombinacija='$item_komb' ";
		$this->db->exec($sql, __FILE__, __LINE__);
		$sql = "INSERT INTO $this->table_reserved SET kiekis=$kiekis, item_id=$item_id, kombinacija='$item_komb', order_id=$order_id ";
		$this->db->exec($sql, __FILE__, __LINE__);
	}
	
	function backItem($item_id, $item_komb, $order_id){

		$sql = "SELECT * FROM $this->table_reserved WHERE item_id=$item_id AND kombinacija='$item_komb' AND order_id=$order_id ";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();

		$sql = "DELETE FROM $this->table_reserved WHERE item_id=$item_id AND kombinacija='$item_komb' AND order_id=$order_id ";
		$this->db->exec($sql, __FILE__, __LINE__);

		$sql = "UPDATE $this->table SET kiekis=kiekis + $kiekis WHERE item_id=$item_id AND kombinacija='$item_komb' ";
		$this->db->exec($sql, __FILE__, __LINE__);
		
	}
	
	function sellItem(){
		
	}
	
	
    
}
?>