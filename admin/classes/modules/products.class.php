<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_products extends modules {
	
	function __construct() {
    	
    	parent::__construct("products");
    	
    	//$this->mod_actions = array('edit'=>array(), 'send'=>array('title'=>array('lt'=>'Siųsti', 'en'=>'Send'), 'img'=>'mail'), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array(), 'settings'=>array());
    	
    }
    
    function saveItem($data){
    	if(isset($data['title']) && strlen($data['title'])){
	    	include_once(CLASSDIR."modules/pages.class.php");
	    	$data['product_url'] = pages::replaceLetters($data['title']);
    	}
    	$id = record::saveItem($data);
    	return $id;
    }
    
    function getContextMenu($item){
    
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit', 'module', 'modif','recommend','storage','delete','translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		$act = "getContextMenuContent(\'{$this->config->variable['site_admin_url']}\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'list\',\'{$item['id']}\',\'$key\');";
    		$context[] = array('img'=>(isset($val['img'])?$val['img']:$key), 'name'=>$key, 'title'=>(isset($val['title'][$_SESSION['admin_interface_language']])?$val['title'][$_SESSION['admin_interface_language']]:$this->cmsPhrases['modules']['context_menu'][$key.'_title']), 'action'=>$act, 'main_action'=>$act);
    	}
		
		return $context;
		
    }
    
    function deleteFromTrash($id){
    	record::deleteFromTrash($id);
    	$this->registry->modules->call("products_fields", "delete", $id);
    	$this->registry->modules->call("storage", "deleteProduct", $id);
    }
    
    function changeKiekis($id, $kiekis){
    	$sql = "UPDATE $this->table SET kiekis=$kiekis WHERE record_id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    }
    
}

?>