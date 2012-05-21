<?php

include_once(CLASSDIR."catalog.class.php");
class fields extends catalog {
	
	function __construct($module){
		
		parent::__construct($module);
		
	}
	
	function getFields($category){
		$this->sqlQueryWhere = " T.category_id=$category AND ";
		$this->sqlQueryJoins = " LEFT JOIN ".Config::$val['pr_code']."_filters F1 ON (T.elm_type=F1.record_id AND F1.lng='$this->language') ";
		$this->fields = " F1.title AS elm_type, ";
		$fields = $this->listSearchItems();
		
		return $fields;
	}	

	function getFields_($category){
		$fields = $this->getFields($category);
		foreach($fields as $i=>$val){
			if($val['elm_type']==FRM_SELECT){
				$select_values_obj = $this->registry->modules->create("select_values");
				$select_values_obj->sqlQueryWhere = " R.parent_id=0 AND T.category_id={$val['title_ids']} AND T.category_column='list_values' AND ";
				$list = $select_values_obj->listSearchItems();
				if(is_numeric($list[0]['id']))
					$fields[$i]['list_values'] = array("source"=>"DB", "module"=>"select_values", "parent_id"=>$list[0]['id']);//"source=DB::module=select_values::parent_id={$list[0]['id']}";
			}
		}
		return $fields;
	}
	
}

?>