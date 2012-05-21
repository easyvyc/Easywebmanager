<?php
/*
 * Created on 2006.9.14
 * step2.php
 * Vytautas
 */

$_updateExist = $client->call('getUpdatesList', $param);
$updateExist = $_updateExist[0];
//pae($updateExist);
if($updateExist['value']!=false){
	
	$next_step = $_GET['step'] + 1;
	if(isset($updateExist['value']['item']['id'])){
		$arr = $updateExist['value']['item'];
		unset($updateExist['value']['item']);
		$updateExist['value']['item'][] = $arr;
	}
	foreach($updateExist['value']['item'] as $key=>$val){
		$updateExist['value']['item'][$key]['description'] = nl2br($val['description']);
	}


	//$tpl_main->setLoop('updates_list', $updateExist['value']['item']);
	
	$count = count($updateExist['value']['item']);
	
	$table_list = array();
	$table_list[] = array('title'=>$cms_phrases['update']['updates_title_title'], 'column_name'=>'title', 'elm_type'=>FRM_TEXT, 'no_sort'=>1);
	$table_list[] = array('title'=>$cms_phrases['update']['updates_description_title'], 'column_name'=>'description', 'elm_type'=>FRM_TEXT, 'no_sort'=>1);
	
	include_once(CLASSDIR."grid.class.php");
	$grid_obj = & new grid();
	$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");
	$grid_obj->setColumns($table_list);
	
	$tpl->setVar('items_count', $count);
	$grid_obj->setItems($updateExist['value']['item']);
	$grid_obj->setItemsCount($count);
	$grid_obj->paging_items = 100;
	$grid_obj->paging(0);
	$grid_obj->pagingSelect(100);
	
	$tpl_grid = & $grid_obj->tpl;
	
	$grid_obj->grid_data['edit_page'] = 'list';
	$grid_obj->grid_data['edit_button'] = 0;
	$grid_obj->grid_data['dublicate_button'] = 0;
	$grid_obj->grid_data['delete_button'] = 0;
	$grid_obj->grid_data['select_button'] = 0;
	
	$grid_obj->grid_data['filter_form'] = 0;
	$grid_obj->grid_data['dragndrop'] = 0;
	$grid_obj->grid_data['no_paging'] = 1;
	
	
	$grid_obj->generate();
	$tpl->setCodeBlock('items_list_content', 'include $grid_obj->tpl->cacheFile;');	

	$_SESSION['update'] = $updateExist['value']['item'];
	$_SESSION['update']['current_update_id'] = 0;
	
}else{
	
	$tpl->setVar('empty', 1);
	$tpl->setVar('error', $client->getError() . " <br> " . nl2br($updateExist['errorMessage']));
	
}
 
?>
