<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();


/*if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action']!='change_order' && $_GET['action']!='delete'){
	if(!in_array($_GET['id'], $admin_obj->modules_rights))
    
        if($_SESSION['admin']['permission']!=1 && in_array($action, $modules->module_fields_for_superadmin)){
        }else{
        	$modules->changeStatus($configFile->variable['sb_module'], $_GET['action'], $_GET['id']);
        }
    	
}*/

if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
    $modules->changeOrder($_GET['firstid'], $_GET['lastid']);
    $tpl->setVar('refresh_tree', 1);
}

if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    if(!in_array($_GET['deleteid'], $admin_obj->modules_rights)){
    	$modules->deleteModule($_GET['deleteid']);
    	$tpl->setVar('refresh_tree', 1);
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
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['title'], 'column_name'=>'title', 'editorship'=>0, 'elm_type'=>FRM_TEXT);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['multilng'], 'column_name'=>'multilng', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['catalog'] , 'column_name'=>'tree', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
//$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['mod_page'], 'column_name'=>'mod_pages', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['cache'], 'column_name'=>'cache', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['no_delete'], 'column_name'=>'forbid_delete', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['no_sort'], 'column_name'=>'forbid_sort', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['no_filter'], 'column_name'=>'forbid_filter', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['no_record_table'], 'column_name'=>'no_record_table', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['rss'], 'column_name'=>'rss', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['search'], 'column_name'=>'search', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['disabled'], 'column_name'=>'disabled', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);


include_once(CLASSDIR."grid.class.php");
$grid_obj = & new grid();
$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");
$grid_obj->setColumns($table_list);


$items = $modules->listAdminModules($_SESSION['admin']['id'], $_SESSION['order'][$_GET['module']]['order_by'], $_SESSION['order'][$_GET['module']]['order_direction']);
$grid_obj->setItems($items);
$grid_obj->setItemsCount(count($items));
$grid_obj->paging_items = count($items);
$grid_obj->paging(0);
$grid_obj->pagingSelect(0);

//include $grid_obj->tpl->parse(); exit;
$tpl_grid = & $grid_obj->tpl;

$tpl_grid->setVar('module.table_name', 'modules');

$grid_obj->grid_data['list_page'] = 'modules';
$grid_obj->grid_data['edit_page'] = 'edit_module';
$grid_obj->grid_data['script'] = 'change_module_item_field';
$grid_obj->grid_data['select_button'] = 0;

$grid_obj->generate();
$tpl->setCodeBlock('items_list_content', 'include $grid_obj->tpl->cacheFile;');


$tpl->setVar('super_admin', $_SESSION['admin']['permission']==1?1:0);

unset($_GET['id']);
include_once(dirname(__FILE__)."/menu.php");
        
?>