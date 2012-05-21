<?php
/*
 * Created on 2006.8.1
 * export.php
 * Vytautas
 */


$CSV_COLUMN_SEPARATOR = ",";


if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;


if(isset($_GET['lng'])) $_SESSION['site_lng'] = $_GET['lng'];
if(isset($_SESSION['site_lng'])) $lng = $_SESSION['site_lng'];


$record = $main_object->create($_GET['module']);    


$record->getTableFields(0); // uzkrauna elementu laukus
//pa($record->table_list);
if(isset($_GET['empty']) && $_GET['empty']==1){
	
}else{
	$record->setWhereClause($_SESSION['filters'][$record->module_info['table_name']]);
	$record->shorten_texts = 0;
	$list_products = $record->listItemsElements($_GET['parent_id'], $_SESSION['order'][$record->module_info['table_name']]['order_by'], $_SESSION['order'][$record->module_info['table_name']]['order_direction'], 0, 100000);
	$record->setWhereClause();
}

$fields_arr = array();
foreach($_POST['chk'] as $k=>$v){
	$fields_arr[] = $k;
}

$csv_arr=array();
$csv_arr['column'][] = "ID";
$csv_arr['title'][] = "Identification number";
$n = count($record->table_fields);
$nn = count($fields_arr);
for($i=0; $i<$n; $i++){
	if(in_array($record->table_fields[$i]['column_name'], $fields_arr)){
		$csv_arr['column'][] = "\"{$record->table_fields[$i]['column_name']}\"";
		$csv_arr['title'][] = "\"{$record->table_fields[$i]['title']}\"";
	}
}

$content = "";
$content .= implode($CSV_COLUMN_SEPARATOR, $csv_arr['column']);
$content .= "\r\n";
$content .= implode($CSV_COLUMN_SEPARATOR, $csv_arr['title']);

$count = count($list_products);
for($i=0; $i<$count; $i++){
	$arr=array();
	$arr[] = "\"".$list_products[$i]['id']."\"";
	for($j=0; $j<$n; $j++){
		if(in_array($record->table_fields[$j]['column_name'], $fields_arr)){
			$arr[] = "\"".$list_products[$i][$record->table_fields[$j]['column_name']]."\"";
		}
	}
	$csv_arr['value'][] = implode($CSV_COLUMN_SEPARATOR, $arr);
}

$content .= "\r\n***\r\n";
$content .= implode("\r\n", $csv_arr['value']);

download_data(iconv("UTF-8", "windows-1257", "{$record->module_info['title']}.csv"), $content);

//pae($list_products);



exit;

?>