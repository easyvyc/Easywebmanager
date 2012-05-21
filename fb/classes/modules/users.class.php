<?php

include_once(APP_CLASSDIR."catalog.class.php");
class users extends catalog {
	
	// constructor inherit record class
	function __construct($module){
		parent::__construct($module);
	}
	
	function listUsersGroupedByCity(){
		$cities = $this->main_object->call("filters", "listItems", 3803);
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
