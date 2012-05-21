<?php

include_once(CLASSDIR."modules/pages.class.php");
$pages = new pages("pages");



if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
//    $modules->changeOrder($_GET['firstid'], $_GET['lastid']);
//    $tpl->setVar('refresh_tree', 1);
}

if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    $pages->deleteTemplate($_GET['deleteid']);
}

if(isset($_GET['action']) && $_GET['action']=='action_with_selected_items' && !empty($_POST['chk'])){
	foreach($_POST['chk'] as $val){
		$pages->deleteTemplate($val);
	}
}




$_GET['module'] = 'settings';
if(isset($_POST['action']) && $_POST['action']=='paging'){
	$_GET['offset'] = 0;
	$_SESSION['order']['paging'] = $_POST['paging_items'];
}
if(!isset($_SESSION['order']['paging'])){
	$_SESSION['order']['paging'] = DEFAULT_PAGING;
}
if(isset($_GET['by'])){
	$_SESSION['order'][$_GET['module']]['order_by'] = $_GET['by'];
}
if(isset($_GET['order'])){
	$_SESSION['order'][$_GET['module']]['order_direction'] = $_GET['order'];
}
if(!isset($_SESSION['order'][$_GET['module']]['order_by'])){
	$_SESSION['order'][$_GET['module']]['order_by'] = strlen($record->module_info['default_sort'])>0?$record->module_info['default_sort']:"sort_order";
}
if(!isset($_SESSION['order'][$_GET['module']]['order_direction']) || strlen($_SESSION['order'][$_GET['module']]['order_direction'])==0){
	$_SESSION['order'][$_GET['module']]['order_direction'] = (strlen($record->module_info['default_sort_direction'])>0?$record->module_info['default_sort_direction']:"ASC");
}		

$table_list = array();
$table_list[] = array('title'=>$cms_phrases['main']['common']['title_title'], 'column_name'=>'title', 'editorship'=>0, 'elm_type'=>FRM_TEXT);
$table_list[] = array('title'=>$cms_phrases['main']['common']['active_title'], 'column_name'=>'active', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);


if(isset($_POST['action']) && $_POST['action']=='filter'){
	$_GET['offset'] = 0;
	unset($_SESSION['filters']['tpl_list']);
	foreach($table_list as $key=>$val){
		if(strlen($_POST['filteritem___'.$val['column_name']])){
			$_SESSION['filters']['tpl_list'][$val['column_name']] = $_POST['filteritem___'.$val['column_name']];
		}
	}
}

include_once(CLASSDIR."grid.class.php");
$grid_obj = & new grid();
$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
$grid_obj->set_filterParams($_SESSION['filters']['tpl_list']);
$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");
$grid_obj->setColumns($table_list);


$items = $pages->getTemplatesList();
$grid_obj->setItems($items);
$grid_obj->setItemsCount(count($items));
$grid_obj->paging_items = count($items);
$grid_obj->paging(0);
$grid_obj->pagingSelect(0);

//include $grid_obj->tpl->parse(); exit;
$tpl_grid = & $grid_obj->tpl;

$tpl_grid->setVar('module.table_name', '');

$grid_obj->grid_data['list_page'] = 'tpl_list';
$grid_obj->grid_data['edit_page'] = 'template';
$grid_obj->grid_data['script'] = 'change_template_item_field';

$grid_obj->generate();
$tpl->setCodeBlock('items_list_content', 'include $grid_obj->tpl->cacheFile;');


$tpl->setVar('active_1', 'active');

include_once(dirname(__FILE__)."/menu.php");

?>