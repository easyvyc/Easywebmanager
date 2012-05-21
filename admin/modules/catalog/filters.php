<?php
/*
 * Created on 2009.06.23
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


//$_GET['module'] = $_GET['filter_module'];
//pae($_GET);
if(isset($_GET['parent_module']) && isset($_GET['parent_column'])){
	
	$_GET['filters'] = $_GET['parent_column'];
	
	$parent_record_obj = $main_object->create($_GET['parent_module']);
	$parent_record_obj->getTableFields(0);
	
	$_SESSION['filter_item'][$_GET['parent_column']]['get_category']['column_name'] = $parent_record_obj->_table_fields[$_GET['parent_column']]['list_values']['get_category'];
	$_SESSION['filter_item'][$_GET['parent_column']]['get_category']['value'] = $_GET['parent_record_id'];
	
	//$_SESSION['filter_item'][$_GET['parent_column']]['get_column_name']['column_name'] = $parent_record_obj->_table_fields[$_GET['parent_column']]['list_values']['get_category'];
	$_SESSION['filter_item'][$_GET['parent_column']]['get_column_name']['value'] = $_GET['parent_column'];
	
}

if(isset($_GET['filter_category_id'])){
	$_SESSION[$_GET['filters']]['filter']['category_id'] = $_GET['filter_category_id'];
}else{
	$_SESSION[$_GET['filters']]['filter']['category_id'] = 0;
}


$tpl->setFile(MODULESDIR.$module_name."/templates/list.tpl");

//pae($_SESSION['filter_item'][$_GET['parent_column']]);

$tpl->setVar('filter_arr', $_SESSION['filter_item'][$_GET['filters']]);
$tpl->setVar('filter_page', 'filters_');
$tpl->setVar('filter_module', 1);
//$_GET['filters'] = $_GET['parent_column'];

include_once(MODULESDIR.$module_name."/list.php"); 




$tpl_main->setVar('filter_module', 1);

?>