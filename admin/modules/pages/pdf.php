<?php
/*
 * Created on 2007.09.26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$FORM_TYPES_NON_EXPORT = array(FRM_SUBMIT, FRM_BUTTON, FRM_LIST, FRM_TREE, FRM_SEPARATOR);



if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;


if(isset($_GET['lng'])) $_SESSION['site_lng'] = $_GET['lng'];
if(isset($_SESSION['site_lng'])) $lng = $_SESSION['site_lng'];

$record = $main_object->create($_GET['module']);    


if(is_numeric($_GET['id']) && $_GET['id']!=0){
	
	$path = $record->getPath($_GET['id']);
	$n = count($record->path);
	for($i=0, $path_str = ""; $i<$n; $i++){
		$path_str .= ($i!=0?" -> ":"")."{$record->path[$i]['title']}";
	}
	
	$item_data = $record->loadItem($_GET['id']);
	$list_products[] = $item_data;
	
}elseif(is_numeric($_GET['parent_id'])){

	$path = $record->getPath($_GET['parent_id']);
	$n = count($record->path);
	for($i=0, $path_str = ""; $i<$n; $i++){
		$path_str .= ($i!=0?" -> ":"")."{$record->path[$i]['title']}";
	}
	
	$record->getTableFields(0); // uzkrauna elementu laukus
	//pa($record->table_list);
	$record->setWhereClause($_SESSION['filters'][$record->module_info['table_name']]);
	$record->shorten_texts = 0;
	$record->table_list = $record->table_fields;
	$list_products = $record->listItemsElements($_GET['parent_id'], $_SESSION['order'][$record->module_info['table_name']]['order_by'], $_SESSION['order'][$record->module_info['table_name']]['order_direction'], 0, 100000);
	$record->setWhereClause();
	
}

$tblflds = array();
foreach($_POST['chk'] as $k=>$v){
	foreach($record->table_fields as $k1=>$v2){
		if($k==$v2['column_name']){
			$tblflds[] = $v2;
		}
	}
}

include_once(CLASSDIR."pdf.class.php");

$pdf_obj = & new pdf();
$pdf_obj->setData($list_products);
$pdf_obj->setFields($tblflds);
$pdf_obj->setTitle($configFile->variable['pr_url']."\n\n".$record->module_info['title']."\n\n".$path_str);
$pdf_obj->createDocument();


exit;

include_once(dirname(__FILE__)."/menu.php");



?>