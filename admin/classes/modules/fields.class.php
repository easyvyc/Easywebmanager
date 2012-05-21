<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_fields extends modules {
	
	function __construct(){
		
		parent::__construct("fields");
		
		$this->product_fields_tbl = $this->config->variable['pr_code']."_products_fields";
		
	}
	
	function getFields($category){
	
		$this->registry->modules->call("pages", "getPath", array($category));
		$path = $this->registry->modules->get("pages", "path");
		
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
		$this->sqlQueryJoins = " LEFT JOIN {$this->config->variable['pr_code']}_filters F1 ON (T.elm_type=F1.record_id AND F1.lng='$this->language') ";
		$this->fields = " F1.title AS elm_type, ";
		$fields = $this->listSearchItems();
		
		foreach($fields as $i=>$val){
			if($val['elm_type']==FRM_SELECT || $val['elm_type']==FRM_CHECKBOX_GROUP){
				$fields[$i]['list_values'] = array("source"=>"CALL", "object"=>"select_values", "method"=>"searchItems_list", "param1"=>array('category_id'=>$val['id']));
				/*
				$select_values_obj = $this->registry->modules->create("select_values");
				$select_values_obj->sqlQueryWhere = " R.parent_id=0 AND T.category_id={$val['id']} AND T.category_column='list_values' AND ";
				$list = $select_values_obj->listSearchItems();
				if(is_numeric($list[0]['id']))
					$fields[$i]['list_values'] = array("source"=>"DB", "module"=>"select_values", "parent_id"=>$list[0]['id']);//"source=DB::module=select_values::parent_id={$list[0]['id']}";
				*/
			}
		}
		
		return $fields;
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
		record::deleteFromTrash($id);
	}


	function replaceLetters($str) {

		$str = ereg_replace("&#39;", "'", $str);
		$str = ereg_replace("[\'\<\>\"{`\!\%\(\);\{\}\+\-\*\&\#]", "_", $str);

		$search_arr = array	("#", "ą", "č", "ę", "ė", "į", "š", "ų", "ū", "ž", " ", /* LT */ 
							"й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ", "э", "ж", "д", "л", "о", "р", "п", "а", "в", "ы", "ф", "я", "ч", "с", "м", "и", "т", "ь", "б", "ю", /* Russki */
							"ī", "ņ", "ā", "ē", "ļ", "ģ", /* Latviesu */
							"ä", "ö", "ü", "õ", "å", /* Eesti Swedish Suomi */
							"ç", "ë", "í", "ñ", "é", "è", "á", "à",  
							"ć", "ł", "ń", "ó", "ś", "ź", "ż", /* Poland */
							"ß", /* Deutche unliaut */
							"æ", "ø", "ê", "ò", "â", "ô" /* Norway */
							);
							
		$replace_arr = array("_", "a", "c", "e", "e", "i", "s", "u", "u", "z", "_", 
							"j", "c", "u", "k", "e", "n", "g", "s", "t", "z", "x", "j", "e", "z", "d", "l", "o", "r", "p", "a", "v", "i", "f", "a", "h", "s", "m", "i", "t", "j", "b", "j",
							"i", "n", "a", "e", "l", "g",
							"a", "o", "u", "o", "a", /* Eesti Swedish Suomi */
							"c", "e", "i", "n", "e", "e", "a", "a",  
							"c", "l", "n", "o", "s", "z", "z", /* Poland */
							"s", /* Deutche unliaut */
							"e", "o", "e", "o", "a", "o" /* Norway */
							);

		$str = stripslashes(mb_strtolower($str, "utf-8"));
		$n = mb_strlen($str, "utf-8");
		for ($i = 0; $i < $n; $i ++) {
			$let = mb_substr($str, $i, 1, "utf-8");
			if (in_array($let, $search_arr)) {
				$key = array_search($let, $search_arr);
				$str = mb_substr($str, 0, $i, "utf-8").$replace_arr[$key].mb_substr($str, $i +1, $n - $i, "utf-8");
			}
			elseif (preg_match("/[0-9a-zA-Z_]/", $let) == 0) { //neatitinka
				$str = mb_substr($str, 0, $i, "utf-8").mb_substr($str, $i +1, $n - $i, "utf-8");
				$n --;
			}
		}
		$str = ereg_replace("\.", "", $str);
		$str = ereg_replace(",", "", $str);
		$str = preg_replace("/[\s]+/", "_", $str);
		return $str;
	}

	function generateColumnName($id, $title) {
		
		$url = $this->replaceLetters($title);
		$url = $this->checkColumnName($url, $id);

		return $url;
		
	}
	
	function checkColumnName($name, $id=0){
		$sql = "SELECT id FROM $this->table WHERE column_name='$name' AND record_id!=$id AND lng='$this->language'";
		$this->db->exec($sql, __FILE__, __LINE__);
		if($this->db->count>0){
			$name .= "_";
			$name = $this->checkColumnName($name, $id);
		}
		else
			return $name;
		
		return $name;
	}	
	
	

}

?>