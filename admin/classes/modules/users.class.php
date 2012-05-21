<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_users extends modules {
	
	// constructor inherit record class
	function __construct($module){
		parent::__construct($module);
	}
	
	function listUsersGroupedByCity(){
		$cities = $this->registry->modules->call("filters", "listItems", 3803);
		foreach($cities as $i=>$val){
			$this->sqlQueryWhere = " T.city={$val['id']} AND ";
			$cities[$i]['sub'] = $this->listSearchItems();
			if(!empty($cities[$i]['sub'])){
				$list[] = $cities[$i];
			}
		}
		return $list;
	}
	
	function saveItem($data){
		$data['title'] = $data['firstname']." ".$data['lastname'];
		return record::saveItem($data);
	}
	
}

?>
