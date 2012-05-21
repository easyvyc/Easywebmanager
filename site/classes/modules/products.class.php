<?php

include_once(CLASSDIR."catalog.class.php");
class products extends catalog {
	
	function __construct(){
		
		parent::__construct("products");
		
		$this->fields_table = Config::$val['pr_code']."_products_fields";
		$this->modif_table = Config::$val['pr_code']."_products_modif";
		
		$this->paging = $this->module_info['xml_settings']['items_paging']['value'];
		
		$this->currency['title'] = "Lt";
		$this->currency['course'] = 1;
		
		//$this->antkainis = number_format(1+$this->module_info['xml_settings']['antkainis']['value']/100, 2, ".", "");
		
		$this->discount = "0";
		
		if(isset($_SESSION['simple_user']['id'])){
			if(is_numeric($_SESSION['simple_user']['group_id_ids'])){
				$group_data = $this->registry->modules->call("user_groups", "loadItem", array($_SESSION['simple_user']['group_id_ids']));
				if($group_data['discount']>0){
					$this->discount = $group_data['discount'];
				}
			}
		}
		
	}
	
	function loadItem($id){
		
		global $phrases;
		
		$data = catalog::loadItem($id);
		
		$data['is_old_price'] = ($this->discount==0?0:1);
		
		$data['item_price'] = number_format(round($data['price'] * (1+$data['antkainis']/100) * (1-$this->discount/100), 2), 2, ".", "");
		$data['item_old_price'] = number_format(round($data['price'] * (1+$data['antkainis']/100), 2), 2, ".", "");
		
		$page_data = $this->registry->modules->call("pages", "loadItem", array($data['category']));
		
		$data['item_url'] = "{$page_data['page_url']}{$data['product_url']}-{$data['id']}.html";
		
		//$data['delivery_term_text'] = $phrases['no_items']." <b>".$data['delivery_term']."</b> ".$phrases['dienu'];
		
		return $data;
		
	}	
	
	function listSearchItems(){
		$this->fields .= " P.page_url AS page_url, IF('$this->discount'='0' OR '$this->discount'='', 0, 1) AS is_old_price, 
							ROUND(T.price * (1+T.antkainis/100) * (1-$this->discount/100), 2) AS item_price,
							ROUND(T.price * (1+T.antkainis/100), 2) AS item_old_price, 
							CONCAT(P.page_url, T.product_url, '-', R.id, '.html') AS item_url, '{$this->currency['title']}' AS currency, ";
		$this->sqlQueryJoins .= " LEFT JOIN cms_pages P ON (T.category=P.record_id AND P.lng='$this->language') ";
		return catalog::listSearchItems();
	}
	
	function doSearch($offset){
		if(!isset($offset) || !is_numeric($offset)) $offset=0;
		
		if(isset($_GET['price']) && $_GET['price']!=''){
			$arr = explode("-", $_GET['price']);
			if(is_numeric($arr[0]) && $arr[0]>0 && $arr[1]>$arr[0])
				$this->sqlQueryWhere .= " (T.price * (1+T.antkainis/100) * (1-$this->discount/100))>={$arr[0]} AND ";
			if(is_numeric($arr[1]) && $arr[1]>0 && $arr[1]>$arr[0])
				$this->sqlQueryWhere .= " (T.price * (1+T.antkainis/100) * (1-$this->discount/100))<={$arr[1]} AND ";
		}
		if(isset($_GET['q']) && strlen($_GET['q'])>2){
			$_GET['q'] = $this->db->escape($_GET['q']);
			$this->sqlQueryWhere .= " (LOWER(T.title) LIKE LOWER('%{$_GET['q']}%') OR LOWER(T.description) LIKE LOWER('%{$_GET['q']}%') OR LOWER(T.short_description) LIKE LOWER('%{$_GET['q']}%')) AND ";
		}
		
		$this->sqlQueryLimit = " LIMIT ".($offset*$this->module_info['xml_settings']['items_paging']['value']).", {$this->module_info['xml_settings']['items_paging']['value']} ";
		$this->items_count = $this->getCountSearchItems();
		
		return $this->listSearchItems();	
	}
	
	function listNewItems(){
		$this->sqlQueryOrder = " ORDER BY R.create_date DESC ";
		$this->sqlQueryLimit = " LIMIT 0, {$this->module_info['xml_settings']['items_paging_block']['value']} ";
		return $this->listSearchItems();
	}

	function listPopItems(){
		$this->sqlQueryWhere = " T.akcija=1 AND ";
		$this->sqlQueryOrder = " ORDER BY R.create_date DESC ";
		$this->sqlQueryLimit = " LIMIT 0, {$this->module_info['xml_settings']['items_paging_block']['value']} ";
		return $this->listSearchItems();
	}
	
	function listPopItems_user($user_id){
		$this->sqlQueryWhere = " T.pardavejas=$user_id AND ";
		$this->sqlQueryOrder = " ORDER BY T.clicks DESC ";
		$this->sqlQueryLimit = " LIMIT 0, 10 ";
		return $this->listSearchItems();
	}
	
	function listMainItems(){
		$this->sqlQueryWhere = " T.akcija=1 AND ";
		$this->sqlQueryLimit = " LIMIT 0, 6 ";
		return $this->listSearchItems();
	}
	
	function listRelatedItems($id){
		$pr_data = $this->loadItem($id);
		$ids_arr = explode("::", $pr_data['recommend']);
		$items = array();
		foreach($ids_arr as $id_val){
			$items[] = $this->loadItem($id_val);
		}
		return $items;	
	}

	function listConfOptions($product_id){
		if(isset($this->config_options[$product_id])) return $this->config_options[$product_id];
		$conf_obj = $this->registry->modules->create("conf_options");
		$conf_obj->sqlQueryWhere = " T.category_id=$product_id AND ";
		$this->config_options[$product_id] = $conf_obj->listSearchItems();
		foreach($this->config_options[$product_id] as $i=>$val){
			$pr_data = $this->loadItem($val['title_ids']);
			$this->config_options[$product_id][$i]['price'] = number_format($pr_data['item_price']*$this->config_options[$product_id][$i]['kiekis'],2,".","");
		}
		return $this->config_options[$product_id];
	}
	
	function getCountConfOptions($product_id){
		return count($this->config_options[$product_id]);
	}

	function listAccessories($product_id){
		if(isset($this->Accessories[$product_id])) return $this->Accessories[$product_id];
		$conf_obj = $this->registry->modules->create("accessories");
		$conf_obj->sqlQueryWhere = " T.category_id=$product_id AND ";
		$this->Accessories[$product_id] = $conf_obj->listSearchItems();
		foreach($this->Accessories[$product_id] as $i=>$val){
			$pr_data = $this->loadItem($val['title_ids']);
			$this->Accessories[$product_id][$i]['price'] = number_format($pr_data['item_price'],2,".","");
		}
		return $this->Accessories[$product_id];
	}
	
	function getCountAccessories($product_id){
		return count($this->Accessories[$product_id]);
	}
		
	function listCategoryItems($id, $offset){
		if(!is_numeric($id)) return false;
		global $id_path;
		if(count($id_path)>2){
			$this->sqlQueryWhere .= " T.category=$id AND ";
		}else{
			$this->sqlQueryWhere .= " R1.parent_id=$id AND ";
			$this->sqlQueryJoins .= " LEFT JOIN cms_record R1 ON (R1.id=T.category) ";
		}
		if(!isset($offset) || !is_numeric($offset)) $offset=0;
		$this->sqlQueryLimit = " LIMIT ".($offset*$this->module_info['xml_settings']['items_paging']['value']).", {$this->module_info['xml_settings']['items_paging']['value']} ";
		$this->items_count = $this->getCountSearchItems();
		return $this->listSearchItems();	
	}
	
	function listUserItems($user_id){
		if(!is_numeric($user_id)) return false;
		$this->sqlQueryWhere = " T.pardavejas=$user_id AND ";
		$this->sqlQueryOrder = " ORDER BY RAND() ";
		$this->sqlQueryLimit = " LIMIT 0, {$this->module_info['xml_settings']['items_paging_main']['value']} ";
		$this->items_count = $this->getCountSearchItems();
		return $this->listSearchItems();
	}
	
	function get_searchItems($offset){
		$this->sqlQueryOrder = " ORDER BY R.create_date DESC ";
		if(strlen($_GET['q'])){
			$_GET['q'] = addcslashes($_GET['q'], "'\\");
			$this->sqlQueryWhere .= " (LOWER(T.title) LIKE LOWER('%{$_GET['q']}%') OR LOWER(T.short_description) LIKE LOWER('%{$_GET['q']}%') OR LOWER(T.description) LIKE LOWER('%{$_GET['q']}%')) AND ";
		}
		if(is_numeric($_GET['c']) && $_GET['c']!=0){
			$this->sqlQueryWhere .= " (T.category={$_GET['c']} OR R1.parent_id={$_GET['c']}) AND ";
			$this->sqlQueryJoins .= " LEFT JOIN cms_record R1 ON (R1.id=T.category) ";
		}
		if(is_numeric($_GET['price_from'])){
			$this->sqlQueryWhere .= " T.price>={$_GET['price_from']} AND ";
		}
		if(is_numeric($_GET['price_to'])){
			$this->sqlQueryWhere .= " T.price<={$_GET['price_to']} AND ";
		}
		$this->sqlQueryLimit = " LIMIT ".($offset*$this->module_info['xml_settings']['items_paging']['value']).", {$this->module_info['xml_settings']['items_paging_main']['value']} ";
		$this->items_count = $this->getCountSearchItems();
		return $this->listSearchItems();
	}
	
	function showItem($id){
		//$this->addClick($id);
		$data = $this->loadItem($id);
		$data['currency'] = $this->currency['title'];
		return $data;
	}
	
	function addClick($id){
		if(!in_array($id, $_SESSION['clicks'])){
			$_SESSION['clicks'][] = $id;
			$sql = "UPDATE $this->table SET clicks=IF(clicks IS NULL, 1, clicks+1) WHERE record_id=$id";
			$this->db->exec($sql, __FILE__, __LINE__);
		}
	}
	
	function getFieldsData($id){
		
		global $phrases;
		
		$data = $this->loadItem($id);

		$fields = $this->registry->modules->call("fields", "getFields", $data['category']);
		
		$sql = "SELECT * FROM $this->fields_table WHERE record_id=$id AND lng='$this->language'";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		
		$fields_ = array();
		foreach($fields as $i=>$val){
			if($val['elm_type']==FRM_SELECT || $val['elm_type']==FRM_CHECKBOX_GROUP){
				$ids_arr = explode("::", $row[$val['column_name']]);
				$val_arr = array();
				foreach($ids_arr as $id_val){
					if(is_numeric($id_val)){
						$select_values_data = $this->registry->modules->call("select_values", "loadItem", $id_val);
						$val_arr[] = $select_values_data['title'];
					}
				}
				$fields[$i]['value'] = implode(", ", $val_arr);
			}elseif($val['elm_type']==FRM_CHECKBOX){
				$fields[$i]['value'] = ($row[$val['column_name']]==1?$phrases['yes']:$phrases['no']);
			}else{
				$fields[$i]['value'] = $row[$val['column_name']];
			}
			if(strlen($fields[$i]['value'])){
				$fields_[] = $fields[$i];
			}
		}
		
		return $fields_;
		
	}
	
	function getModifData($id){
		
		$data = $this->loadItem($id);
		
		$fields = $this->registry->modules->call("modifications", "getFields", $data['category']);
		
		$sql = "SELECT * FROM $this->modif_table WHERE record_id=$id AND lng='$this->language'";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		
		foreach($fields as $i=>$val){
			$arr = explode("::", $row[$val['column_name']]);
			$select_arr = array();
			foreach($arr as $val){
				if(is_numeric($val) && $val!=0) $select_arr[] = $this->registry->modules->call("select_values", "loadItem", $val);
			}
			$fields[$i]['select_values'] = $select_arr;
		}
		
		if(!empty($fields)) $this->item_have_modif[$id] = 1;
		
		return $fields;
		
	}
	
	function isModif($id){
		return $this->item_have_modif[$id];
	}
	
}

?>