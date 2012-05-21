<?php
/*
 * Created on 2009.07.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

global $templateVariables, $cms_phrases;

$record = $this->main_object->create("admins");

include_once(CLASSDIR."grid.class.php");
$grid_obj = & new grid();
//$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
//$grid_obj->set_filterParams($_SESSION['filters'][$record->module_info['table_name']]);
$grid_obj->setTpl(DOCROOT.$this->config->variable['admin_dir']."templates/grid.tpl", "templateVariables");
$table_fields = array();
$table_fields[] = array('column_name'=>'login_time', 'title'=>$cms_phrases['main']['admins']['login_time'], 'elm_type'=>FRM_DATE, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
$table_fields[] = array('column_name'=>'logout_time', 'title'=>$cms_phrases['main']['admins']['logout_time'], 'elm_type'=>FRM_DATE, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
$table_fields[] = array('column_name'=>'all_time', 'title'=>$cms_phrases['main']['admins']['past_time'], 'elm_type'=>FRM_TEXT, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
$table_fields[] = array('column_name'=>'ipaddress', 'title'=>$cms_phrases['main']['admins']['ipaddress'], 'elm_type'=>FRM_TEXT, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
$grid_obj->setColumns($table_fields);

//$record->setWhereClause($grid_obj->columns);
$count = $record->getAdminStatCount($_GET['id']);
$list_items = $record->getAdminStat($_GET['id'], ($_GET['offset']<0?0:$_GET['offset'])*$_SESSION['order']['paging'], $_SESSION['order']['paging']);

$grid_obj->setItems($list_items);
$grid_obj->setItemsCount($count);
$grid_obj->paging_items = $_SESSION['order']['paging'];
$grid_obj->paging($_GET['offset']);
$grid_obj->pagingSelect($GLOBALS['IN_ONE_PAGE_LIST']);


$grid_obj->grid_data['edit_button'] = 0;
$grid_obj->grid_data['dublicate_button'] = 0;
$grid_obj->grid_data['delete_button'] = 0;
$grid_obj->grid_data['select_button'] = 0;
$grid_obj->grid_data['filter_form'] = 0;
$grid_obj->grid_data['dragndrop'] = 0;


$grid_obj->generate();
include $grid_obj->tpl->cacheFile;

?>