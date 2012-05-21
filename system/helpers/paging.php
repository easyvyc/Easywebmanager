<?php
function generatePaging($offset, $count, $limit, $RESULTS_PAGING){

	$paging_count = ceil($count/$limit); $tmp_number = 0; $paging_start = 0; $paging_end = $paging_count;
	
	if($paging_count > $RESULTS_PAGING * 2){
		$paging_start = $offset - $RESULTS_PAGING;
		if($paging_start < 0){
			$tmp_number = -1 * $paging_start;
			$paging_arr['paging_end_arrow'] = 1;
		}
		$paging_end = $offset + $RESULTS_PAGING + $tmp_number;
		$tmp_number = 0;
		if($paging_end > $paging_count){
			$tmp_number = $paging_end - $paging_count;
		}
		$paging_start = $offset - $RESULTS_PAGING - $tmp_number;
		
		if(($offset - $RESULTS_PAGING)>0){
			$paging_arr['paging_start_arrow'] = 1;
		}
		if(($offset + $RESULTS_PAGING)<$paging_count){
			$paging_arr['paging_end_arrow'] = 1;
		}
	}

	$paging_arr['paging_end_arrow_value'] = $offset+1;
	$paging_arr['paging_start_arrow_value'] = $offset-1;
	
	for($i=0, $arr=array(), $paging=array(); $i<$paging_count && floor(($count-1)/$limit)>0; $i++){
		$arr['value'] = "$i";
		$arr['title'] = ($i * $limit + 1)."..".($i + 1)*$limit;
		$arr['active'] = $offset==$i?1:0;
		if($i>=$paging_start && $i<=$paging_end){
			$paging[] = $arr;	
		}
	}
	$paging_arr['is_paging'] = count($paging)>1?1:0;
	$paging_arr['loop'] = $paging;
	
	return $paging_arr;

}
?>