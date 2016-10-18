<?php

include_once(APP_CLASSDIR."model.class.php");
class model_products extends model {
	
	function __construct() {
    	
    	parent::__construct("products");
    	
    	//$this->mod_actions = array('edit'=>array(), 'send'=>array('title'=>array('lt'=>'Siųsti', 'en'=>'Send'), 'img'=>'mail'), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array(), 'settings'=>array());
    	
    }
    
//    function saveItem($data){
//    	if(isset($data['title']) && strlen($data['title'])){
//	    	include_once(CLASSDIR."modules/pages.class.php");
//	    	$data['product_url'] = url_slug($data['title']);
//    	}
//    	$id = record::saveItem($data);
//    	return $id;
//    }
    
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
    
    /**
     * 
     */
    function getListingSum($cid = 0) {
        if ($cid) {
            $this->getCategoriesTreeIds($cid);
            $index = 0; $tree_arr = array();
            foreach($this->CategoriesTreeIds[$cid] as $tree_id){
                $tree_arr[] = " T.category=:___ctg___$index ";
                $this->sqlQueryBinds["___ctg___$index"] = $tree_id;
                $index++;
            }
            $tree_arr[] = " T.category=:___ctg___$index ";
            $this->sqlQueryBinds["___ctg___$index"] = $cid;
            if(!empty($tree_arr))
                $this->sqlQueryWhere[] = " (" . implode(" OR ", $tree_arr) . ") ";
        }
        return $this->getCountSearchItems();
    }
    
    function getListingItems($cid = 0) {
        if ($cid) {
            $this->getCategoriesTreeIds($cid);
            $index = 0; $tree_arr = array();
            foreach($this->CategoriesTreeIds[$cid] as $tree_id){
                $tree_arr[] = " T.category=:___ctg___$index ";
                $this->sqlQueryBinds["___ctg___$index"] = $tree_id;
                $index++;
            }
            $tree_arr[] = " T.category=:___ctg___$index ";
            $this->sqlQueryBinds["___ctg___$index"] = $cid;
            if(!empty($tree_arr))
                $this->sqlQueryWhere[] = " (" . implode(" OR ", $tree_arr) . ") ";
        }
        
        $order_by = $this->listing_filter_data['order_by'];
        $order_direction = $this->listing_filter_data['order_direction'];
        $offset = $this->listing_filter_data['offset'];
        $paging = $this->listing_filter_data['paging'];

        if ($order_by == '')
            $order_by = $this->module_info['default_sort'];
        if ($order_direction == '')
            $order_direction = $this->module_info['default_sort_direction'];

        if ($this->module_info['no_record_table'] == 1 && $order_by == 'R.sort_order') {
            $order_by = "";
        }

        $this->sqlQueryLimit = array('start' => $offset, 'paging' => $paging);
        if ($order_by != '')
            $this->sqlQueryOrder[] = " $order_by $order_direction ";
        
        return $this->listSearchItems();
    }
    
    function getCategoriesTreeIds($cid){
        if(!empty($this->CategoriesTreeIds[$cid])) return $this->CategoriesTreeIds[$cid];
        $this->CategoriesTreeIds[$cid] = array();
        $this->registry->model->pages->listing_filter_data['parent_id'] = $cid;
        $list = $this->registry->model->pages->getListingItems();
        foreach($list as $page_item){
            $this->CategoriesTreeIds[$cid][] = $page_item['id'];
            $tree_ids = $this->getCategoriesTreeIds($page_item['id']);
            $this->CategoriesTreeIds[$cid] = array_merge($this->CategoriesTreeIds[$cid], $tree_ids);
        }
        return $this->CategoriesTreeIds[$cid];
    }
    
    function delete($id){
    	record::deleteFromTrash($id);
        // 
    	$this->registry->model->products_fields_values->delete($id);
        // delete images
        $list = $this->registry->model->products_images->loadBy(array('product_id' => $id), true);
        foreach($list as $img){
            $this->registry->model->products_images->delete($img['id']);
        }
    	//$this->registry->model->call("storage", "deleteProduct", $id);
    }
    
    function changeKiekis($id, $kiekis){
    	$sql = "UPDATE $this->table SET kiekis=$kiekis WHERE record_id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    }
    
}

?>