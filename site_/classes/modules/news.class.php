<?php

include_once(CLASSDIR."catalog.class.php");
class news extends catalog {
	
	function __construct(){
		parent::__construct("news");
	}
	
	function listItems($id, $offset, $paging){
		
		global $phrases;
		
		if(!isset($offset) || $offset==''){
			$offset = 0;
		}
		
		$this->sqlQueryWhere = " R.parent_id=$id AND ";
		$this->sqlQueryLimit = " LIMIT ".($offset*$paging).", $paging ";
		$this->news_count = $this->getCountSearchItems();
		$news_list = catalog::listSearchItems();
		
		foreach($news_list as $i=>$val){
			$arr = explode("-", $val['news_date']);
			$news_list[$i]['day'] = (int) $arr[2];
			$news_list[$i]['year'] = (int) $arr[0];
			$news_list[$i]['month'] = $phrases['month.'.$arr[1]];
		}
		
		return $news_list;
		
	}
	
	function pagingItems($offset, $paging, $RESULTS_PAGING){
		
		$paging_arr = generatePaging($offset, $this->news_count, $paging, $RESULTS_PAGING);
		return $paging_arr['loop'];
		
	}
	
	
}

?>