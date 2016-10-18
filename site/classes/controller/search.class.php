<?php

include_once(CLASSDIR_."controller.class.php");
class controller_search extends controller {
	
	private $description_length = 500;
	private $precise_key = false;
	private $highlight_search_result = "<span class='highlight_search_result'>\\0</span>";
	
	function search(){
		parent::__construct();
	}
	
	function index(){
		
		$q = trim($_GET['q']);
		
		if(strlen($q)<3){
			$res = array();
		}else{
			$res = $this->registry->model->inv->search($q, $_GET['offset']);
			$count = $this->registry->model->inv->get_search_count($q);
			$paging = generatePaging($_GET['offset'], $count, $this->registry->model->inv->PAGING);
			TPL::setVar('paging', $paging['loop']);
		}
		
		TPL::setVar('products', $res);
		
		TPL::setVar('no_results', empty($res));
		TPL::setVar('short_key', (strlen($q)<3));
		TPL::setVar('get', $_GET);
		
		TPL::setVar('page_content', TPL::parse(TPLDIR."pages/search.tpl"));
		return $this->registry->controller->pages->frame();		
	}
	
	function advanced(){
		
		$q = trim($_GET['q']);

		if($_GET['a']=='search'){
			$res = $this->registry->model->inv->advanced_search($_GET, $_GET['offset']);
			$count = $this->registry->model->inv->get_advanced_search_count($_GET);
			$paging = generatePaging($_GET['offset'], $count, $this->registry->model->inv->PAGING);
			TPL::setVar('paging', $paging['loop']);
		}else{
			$res = array();
		}
		
		TPL::setVar('products', $res);
		
		TPL::setVar('no_results', empty($res));
		TPL::setVar('get', $_GET);
		
		TPL::setVar('page_content', TPL::parse(TPLDIR."pages/advanced_search.tpl"));
		return $this->registry->controller->pages->frame();		
		
	}
	
	function getResults($key, $table, $cols){
		
	}
	
	/*
	sita reik permest i model
	function getResultsFromModule($key, $module){
		
		$n_res = array();
		$key = addslashes($key);
		
		$arr_key = explode(" ", $key);
		foreach($arr_key as $k=>$v){
			if(strlen($v)>2){
				$_arr_key[] = $v;
			}
		}
		
		$record = $this->registry->modules->create($module);
		$n = count($record->table_fields);
		for($i=0; $i<$n; $i++){
			if($record->table_fields[$i]['elm_type']==FRM_TEXT || $record->table_fields[$i]['elm_type']==FRM_TEXTAREA || $record->table_fields[$i]['elm_type']==FRM_HTML){
				$sql_query_where_arr = array();
				if($this->precise_key!==true){
					foreach($_arr_key as $k1=>$v1){
						$sql_query_where_arr[] = " LOWER(T.{$record->table_fields[$i]['column_name']}) LIKE LOWER('%$v1%') ";
					}
					$arr[]= " (".implode(" AND ", $sql_query_where_arr).") ";
				}else{
					$arr[] = " LOWER(T.{$record->table_fields[$i]['column_name']}) LIKE LOWER('%$v%')";
				}
				if($record->table_fields[$i]['elm_type']==FRM_TEXTAREA || $record->table_fields[$i]['elm_type']==FRM_HTML){
					$arr1[] = " T.{$record->table_fields[$i]['column_name']} ";
				}
			}
		}

		$where_clause = (!empty($arr))?"(".implode(" OR ", $arr).") AND ":"";
		//$description_fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS description, ":"");

		$record->sqlQueryWhere = $where_clause;
		$record->fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS _description_, ":"");
		$res = $record->listSearchItems();
		
		$n = count($res);
		//pae($res);
		for($i=0; $i<$n; $i++){
			
			$description = $res[$i]['_description_'];
			//$description = preg_replace("/<script([^>]*?)>([^(</script>)]*)<\/script>/si", "", $description);
			$description = strip_tags($description);
			$description_lower = mb_strtolower($description, "UTF-8");
			
			if($this->precise_key!==true){
				$max_search_count = 0; $description_value = mb_substr($description, 0, $this->description_length, "UTF-8");;
				foreach($_arr_key as $k=>$v){
					$pos = mb_strpos($description_lower, $v, 0, "UTF-8");
					$start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
					$str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
					$description = mb_substr($description, $start_pos, $str_len, "UTF-8");
					$search_count = 0;
					foreach($_arr_key as $k1=>$v1){
						if(mb_strpos($description, $v1, 0, "UTF-8")) $search_count++;
					}
					if($max_search_count < $search_count){
						$max_search_count = $search_count;
						$description_value = $description;
					}
				}
				
				$description = $description_value;
				
				foreach($_arr_key as $k=>$v){
					$description = eregi_replace("$v", $this->highlight_search_result, $description);
					$res[$i]['title'] = eregi_replace($v, $this->highlight_search_result, $res[$i]['title']);
				}
			}else{
				$pos = mb_strpos($description_lower, $key, 0, "UTF-8");
				$start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
				$str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
				$description = mb_substr($description, $start_pos, $str_len, "UTF-8");
				//$description = $description;
				$description = eregi_replace("$key", $this->highlight_search_result, $description);
				$res[$i]['title'] = eregi_replace($key, $this->highlight_search_result, $res[$i]['title']);
			}
			
			$res[$i]['_description_'] = $description;
			
		}
		return $res;
	}
	*/

}

?>