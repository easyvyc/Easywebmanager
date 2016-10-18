<?php

include_once(APP_CLASSDIR."model.class.php");
class model_users extends model {
	
	// constructor inherit record class
	function __construct(){
		parent::__construct("users");
	}
	
	function listUsersGroupedByCity(){
		$cities = $this->registry->model->call("filters", "listItems", 3803);
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
		//$data['title'] = $data['firstname']." ".$data['lastname'];
		return record::saveItem($data);
	}
	
}

?>
