<?php


if(!isset($_GET['id'])) $_GET['id'] = 0;


if(isset($_GET['lng'])) $_SESSION['site_lng'] = $_GET['lng'];
if(isset($_SESSION['site_lng'])) $lng = $_SESSION['site_lng'];

$record = $main_object->create($_GET['module']);  

include_once(CLASSDIR."forms.class.php");
$form_obj = & new forms();   

$path_tpl_name = MODULESDIR.$module_name."/templates/path.tpl";
$tpl_path = & new easytpl($path_tpl_name, "templateVariables");


include_once(dirname(__FILE__)."/main.php");


$item_data = $record->loadItem($_GET['id'], $_GET['parent_id'], $ce);

$tpl->setLoop('mod_actions', $record->getContextMenu($item_data));

$tpl_path->setVar('data', $item_data);
$path = $record->getPath((isset($_GET['new'])?$_GET['parent_id']:$item_data['parent_id']));

if(isset($_SESSION['filter']['category_id']) && $_GET['page']=='filters_list'){
	$n = count($record->path);
	for($i=0, $true=false; $i<$n; $i++){
		if($record->path[$i]['id']==$_SESSION['filter']['category_id']){
			$true = true;
		}
		if($true){
			$path[] = $record->path[$i];
		}
	}
	$tpl_path->setVar('filter_module', 1);
}else{
	$path = $record->path;
}
$tpl_path->setLoop('path', $path);



$level = count( $record->path );
$level += !empty( $_GET['id'] ) ? 1 : 0;
if( $level < ($record->module_info['maxlevel']) ){
	$tpl->setVar( 'nomorefolders', 1 );
}

$tpl->setVar('module', $record->module_info);


if(isset($_GET['tree_reload'])&&$_GET['tree_reload']==1){
	$tpl->setVar('tree_reload', 1);
}
if(isset($_GET['lng'])){
	$tpl->setVar('tree_reload', 1);
}
if($record->module_info['maxlevel']==0){
	$tpl->setVar('tree_reload', 0);
}


$tpl->setVar('upload_url', UPLOADURL);

$tpl->setVar('get', $_GET);



$tpl_path->parse();
$tpl->setCodeBlock('path', 'include $tpl_path->cacheFile;');


$tpl->setVar('parent_id', $_GET['id']);
$tpl->setVar('lng', $lng);
$tpl->setVar('easyweb', $_SESSION['easy']);

$tpl->setVar('filter_page', '');

if($record->module_info['category']==0) $tpl->setVar('tree_reload', 0);

//include_once(dirname(__FILE__)."/menu.php");

if(isset($_POST['action']) && $_POST['action']=='filter'){
	$_GET['offset'] = 0;
	unset($_SESSION['filters'][$record->module_info['table_name']]);
	foreach($record->table_list as $key=>$val){
		if(strlen($_POST['filteritem___'.$val['column_name']])){
			$_SESSION['filters'][$record->module_info['table_name']][$val['column_name']] = $_POST['filteritem___'.$val['column_name']];
		}
	}
}

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
	$_SESSION['order'][$_GET['module']]['order_by'] = strlen($record->module_info['default_sort'])>0?$record->module_info['default_sort']:"R.sort_order";
}
if(!isset($_SESSION['order'][$_GET['module']]['order_direction']) || strlen($_SESSION['order'][$_GET['module']]['order_direction'])==0){
	$_SESSION['order'][$_GET['module']]['order_direction'] = (strlen($record->module_info['default_sort_direction'])>0?$record->module_info['default_sort_direction']:"ASC");
}		

if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    $record->loadItem($_GET['deleteid']);
    $record->delete($_GET['deleteid']);
    $tpl->setVar('tree_reload', 1);
}

if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
    $record->changeOrder($_GET['firstid'], $_GET['lastid']);
    $record->loadItem($_GET['firstid']);
    $tpl->setVar('tree_reload', 1);
}


if(isset($_GET['action']) && $_GET['action']=='action_with_selected_items'){
	
	if($_GET['action_choice']=="delete"){
		foreach($_POST['chk'] as $key=>$val){
			$record->delete($_POST['chk'][$key]);
			$tpl->setVar('tree_reload', 1);
		}
	}
	if($_GET['action_choice']!="delete"){
		foreach($_POST['chk'] as $key=>$val){
			$record->changeFieldStatus($_SESSION['site_lng'], $_GET['action_choice'], $_POST['chk'][$key]);
		}
		
	}

}


include_once(CLASSDIR."grid.class.php");
$grid_obj = & new grid();
$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
$grid_obj->set_filterParams($_SESSION['filters'][$record->module_info['table_name']]);
$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");
$grid_obj->setColumns($record->table_list);

$record->setWhereClause($grid_obj->columns);
$count = $record->listItemsElementsCount($_GET['id']);
$tpl->setVar('items_count', $count);
$list_items = $record->listItemsElements($_GET['id'], $_SESSION['order'][$_GET['module']]['order_by'], $_SESSION['order'][$_GET['module']]['order_direction'], ($_GET['offset']<0?0:$_GET['offset'])*$_SESSION['order']['paging'], $_SESSION['order']['paging']);
$grid_obj->setItems($list_items);
$grid_obj->setItemsCount($count);
$grid_obj->paging_items = $_SESSION['order']['paging'];
$grid_obj->paging($_GET['offset']);
$grid_obj->pagingSelect($IN_ONE_PAGE_LIST);

//include $grid_obj->tpl->parse(); exit;
$tpl_grid = & $grid_obj->tpl;

$grid_obj->grid_data['edit_page'] = 'list';

$grid_obj->generate();
$tpl->setCodeBlock('items_list_content', 'include $grid_obj->tpl->cacheFile;');


//$grid_tpl_name = DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl";
//$tpl_grid = & new easytpl($grid_tpl_name, "templateVariables");
//include_once(dirname(__FILE__)."/grid.php");
//$tpl_grid->parse();
//$tpl->setCodeBlock('items_list_content', 'include $tpl_grid->cacheFile;');


//include_once(dirname(__FILE__)."/inc/screenshot.php");

?>