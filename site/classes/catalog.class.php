<?php

include_once(CLASSDIR."record.class.php");
class catalog extends record {

	var $sqlQueryWhere="";
	var $sqlQueryOrder="";
	var $viewAllItems = 0;

    function __construct($module) {
    	
    	global $lng, $cache_obj;
    	
    	parent::__construct($module);
    	
    	$this->language = $lng;
    	
    	if(is_object($cache_obj))
    		$this->cache = $cache_obj;
    	else{
    		$this->module_info['cache'] = 0;
    	}

    }
    
    function saveItem($data){
    	$this->admin['id'] = 1;
    	$id = record::saveItem($data);
    	foreach($this->table_fields as $i=>$val){
    		if($val['elm_type']==FRM_LIST){
    			if($val['list_values']['source'] == 'DB') {
    				$list_obj = $this->registry->modules->create($val['list_values']['module']);
    				foreach($data[$val['column_name']] as $list_data){
    					$list_data[$val['list_values']['get_category']] = $id;
    					$list_data[$val['list_values']['get_column_name']] = $val['column_name'];
    					$list_data['active'] = 1;
    					$list_obj->insert($list_data);
    				}
    			}
    		}
    	}
    	return $id;
    }
    
    function insert($data){
    	$data['isNew'] = 1;
    	$data['id'] = 0;
    	$data['parent_id'] = 0;
    	$data['language'] = $this->language;
    	return $this->saveItem($data);
    }  
    
    function listAllItems($parent_id=0, $is_category=0){
    	
    	$this->viewAllItems = 1; 
    	$this->sqlQueryWhere = " R.is_category=$is_category AND R.parent_id=$parent_id AND ";
    	if(strlen($this->module_info['default_sort'])>0)
    		$this->sqlQueryOrder = " ORDER BY {$this->module_info['default_sort']} {$this->module_info['default_sort_direction']} ";
    	$list = $this->listSearchItems();
    	$this->viewAllItems = 0;
    	return $list;
    	
    }
    
    function listItems($parent_id=0, $is_category=0){
    	
		if($this->module_info['cache']==1){
			$create_cache = false;
			$cache_file = CACHEDIR."data/cache_{$this->module_info['table_name']}.$this->language.$parent_id.$is_category.php";
			$cached_function = "getCacheData_{$this->module_info['table_name']}_".$this->language."_".$parent_id."_".$is_category."";
			if($this->cache->is_loadCache($cache_file, $this->module_info['last_modify_time'])){
				include_once($cache_file);
				return $cached_function();
			}
			$create_cache = true;
    	}
		
    	$this->sqlQueryWhere = " R.parent_id=$parent_id AND ";
    	
    	$list = $this->listSearchItems();
    	
    	
    	if($this->module_info['cache']==1 && $create_cache===true){
    		$this->cache->setFilename($cache_file);
    		$this->cache->setFunctionname($cached_function);
    		$this->cache->generateCache($list);
    	}
    	
    	return $list;
    	
    }
    
	function loadItem($id){
		
        $item_data = record::loadItem($id);

		foreach($this->table_fields as $key=>$val){
			if($val['elm_type']==FRM_TEXTAREA){
				$item_data[$val['column_name']] = nl2br($item_data[$val['column_name']]);
			}
		}
		
		return $item_data;
		
	}

    function updateField($column, $value, $id){
    	$sql = "UPDATE $this->table SET $column='$value' WHERE record_id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    }
    
    
//    function generateSitemap(){
//    	
//    	$lng = isset($this->language)?$this->language:Config::$val['default_lng'];
//    	include_once(CLASSDIR."xmlini.class.php");
//		$arr2xml = new xmlIni();
//		$tree = $this->listSearchItems();
//		
//		$n = count($tree);
//		$arr2xml->xmlTree->name = "urlset";
//		$arr2xml->xmlTree->attributes = array("xmlns"=>"http://www.google.com/schemas/sitemap/0.84");
//		for($i=0; $i<$n; $i++){
//			$arr->name = "url";
//			
//			$arr->children[0]->name = "loc";
//			$arr->children[0]->content = Config::$val['site_url'].$lng."/".$GLOBALS['reserved_url_words']['search']."/".urlencode($tree[$i]['title']);
//			
//			$arr->children[1]->name = "lastmod";
//			$arr->children[1]->content = substr($tree[$i]['last_modif_date'], 0, 10)."T".substr($tree[$i]['last_modif_date'], 11)."+00:00";//"2005-02-19T02:10:08+00:00";
//			
//			$arr2xml->xmlTree->children[] = $arr;
//		}
//		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
//		return $xml;
//		 	    	
//    }
    
//    function generateRSS(){
//		
//		global $search_engines;
//		
//    		$lng = isset($this->language)?$this->language:Config::$val['default_lng'];
//	    	include_once(CLASSDIR."xmlini.class.php");
//		$arr2xml = new xmlIni();
//		
//		foreach($this->table_fields as $key=>$val){
//			if($val['elm_type']==FRM_TEXTAREA || $val['elm_type']==FRM_HTML){
//				$_a[] = " T.{$val['column_name']} ";
//			}
//		}
//		$this->fields = (count($_a)?" CONCAT(".implode(",", $_a).") AS description, ":"");
//		$tree = $this->listSearchItems();
//		
//		$arr2xml->xmlTree->name = "rss";
//		$arr2xml->xmlTree->attributes["version"] = "2.0";
//		
//		$arr2xml->xmlTree->children[0]->name = "channel";
//		
//		$arr[0]->name = "title";
//		$arr[0]->content = Config::$val['pr_url'];
//
//		$arr[1]->name = "link";
//		$arr[1]->content = Config::$val['site_url'];
//
//		$arr[2]->name = "generator";
//		$arr[2]->content = "easywebmanager ".EASYWEBMANAGER_VERSION;
//		
//		$n = count($tree);
//		for($i=0, $j=3; $i<$n; $i++, $j++){
//
//			$arr[$j]->name = "item";
//
//			$arr[$j]->children[0]->name = "title";
//			$arr[$j]->children[0]->content = $tree[$i]['title'];
//
//			$arr[$j]->children[1]->name = "link";
//			$arr[$j]->children[1]->content = $this->language.$tree[$i]['page_url'];
//
//			$arr[$j]->children[2]->name = "description";
//			$arr[$j]->children[2]->content = mb_substr(strip_tags($tree[$i]['description']), 0, 500, "UTF-8");
//
//			$arr[$j]->children[3]->name = "pubDate";
//			$arr[$j]->children[3]->content = $tree[$i]['last_modif_date'];
//
//		}
//		$arr2xml->xmlTree->children[0]->children = $arr;
//		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
//				
//		return $xml;
//    	
//    }
    
	function pagingItems($offset, $RESULTS_PAGING){
		$paging_arr = generatePaging($offset, $this->items_count, $this->paging, $RESULTS_PAGING);
		$this->is_paging = $paging_arr['is_paging'];
		return $paging_arr['loop'];
	}
	
	function is_pagingItems(){
		return $this->is_paging;
	}
    
}
?>
