<?php
/*
 * Created on 2009.03.16
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

//error_reporting(E_ALL);
include_once(CLASSDIR."search.class.php");
$search = new search();


$key = trim($_GET['q']);
$key = addslashes($key);


if(strlen($key)>2){
	
	
	include_once(CLASSDIR."module.class.php");
	$module_obj = & new module();
	
	$list = $module_obj->listModules();
	
	$n = count($list);
	for($i=0, $not_empty=false, $search_results=array(); $i<$n; $i++){
		if($list[$i]['search']==1){
			$list[$i]['main_module'] = $list[$i]['table_name'];
			$list[$i]['action'] = 'edit';
			if($list[$i]['mod_pages']!=0){
				$main_mod = $module_obj->getModule($list[$i]['mod_pages']);
				$list[$i]['main_module'] = $main_mod['table_name'];
				$list[$i]['tree'] = $main_mod['tree'];
			}
			$results_news = $search->getResultsFromModule($key, $list[$i]['table_name']);
			//$tpl->setVar($list[$i]['table_name'].'_url', $url_data['page_url']);
			if(!empty($results_news)){
				$arr_mod = $list[$i];
				$arr_mod['mod_list_items'] = $results_news;
				$search_results[] = $arr_mod;
				$not_empty = true;
			}
		}
	}
	$tpl->setLoop('search_results', $search_results);
	
	if(empty($results_page) && !$not_empty){
		$tpl->setVar('no_results', 1);
	}

}else{

	$tpl->setVar('short_key', 1);

}

$tpl->setVar('module', array('title'=>$cms_phrases['top']['search']));
$tpl->setVar('post', $_POST);
$tpl->setVar('get', $_GET);

?>