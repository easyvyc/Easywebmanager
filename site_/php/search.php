<?php

/*
include_once(CLASSDIR_."search.class.php");
$search = new search();

if($_GET['q']==$phrases['search_default_value']) $_GET['q'] = '';

$key = trim(urldecode($_GET['q']));
$key = addslashes($key);

if(strlen($key)>2){
	
	include_once(CLASSDIR."module.class.php");
	$module_obj = module::getInstance();
	
	$list = $module_obj->listModules();
	$n = count($list);
	for($i=0, $not_empty=false, $search_results=array(), $id_array=array(), $mod_index=0; $i<$n; $i++){
		if($list[$i]['search']==1){
			$results_news = $search->getResultsFromModule($key, $list[$i]['table_name']);
			$results_news_ = array();
			if(!empty($results_news)){
				$tikrinimas = false;
				$item_index = 0;
				foreach($results_news as $j=>$val){
					if(in_array($val['id'], $id_array)){
						$tikrinimas = true;
						//pa($val);
						if(mb_strlen($id_array_[$val['id']]['description'], "UTF-8")<mb_strlen($val['description'], "UTF-8")){
							$search_results[$id_array_[$val['id']]['mod_index']]['mod'][$id_array_[$val['id']]['item_index']]['description'] = $val['description'];
						}
					}else{
						$id_array[] = $val['id'];
						$id_array_[$val['id']] = $val;
						$id_array_[$val['id']]['mod_index'] = $mod_index;
						$id_array_[$val['id']]['item_index'] = $item_index;
					}
					if($tikrinimas===false){
						$results_news_[$item_index++] = $val;
					}
				}
				if(!empty($results_news_)){
					$search_results[$mod_index++] = array('mod'=>$results_news_);
					$not_empty = true;
				}
			}
		}
	}
	//pae($search_results);
	$tpl_inner->setLoop('search_results', $search_results);
	
	if(empty($results_page) && !$not_empty){
		$tpl_inner->setVar('no_results', 1);
	}

}else{

	$tpl_inner->setVar('short_key', 1);

}

$tpl_inner->setVar('search_phrase', $key);
*/

parse_str($_SERVER['QUERY_STRING'], $get);
unset($get['offset']);
$tpl_inner->setVar('query_url', http_build_query($get)."&");

?>