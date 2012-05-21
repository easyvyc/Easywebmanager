<?php
/*
 * Created on 2007.12.04
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$CSV_COLUMN_SEPARATOR = ",";

if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;


if(isset($_GET['lng'])) $_SESSION['site_lng'] = $_GET['lng'];
if(isset($_SESSION['site_lng'])) $lng = $_SESSION['site_lng'];

$record = $main_object->create($_GET['module']);   


$lng = $_SESSION['site_lng'];

if(!isset($_GET['id'])) $_GET['id'] = 0;


$tpl->setVar('parent_id', (isset($_GET['new'])?$_GET['parent_id']:$_GET['id']));


include_once(dirname(__FILE__)."/main.php");

$path_tpl_name = MODULESDIR.$module_name."/templates/path.tpl";
$tpl_path = & new easytpl($path_tpl_name, "templateVariables");


$path = $record->getPath($_GET['id']);
if(isset($_SESSION['filter']['category_id']) && $_GET['page']=='filters_edit'){
	$n = count($record->path);
	for($i=0, $true=false; $i<$n; $i++){
		if($record->path[$i]['id']==$_SESSION['filter']['category_id']){
			$true = true;
		}
		if($true){
			$path[] = $record->path[$i];
		}
	}
	$tpl->setVar('filter_module', 1);
}else{
	$path = $record->path;
}
$tpl->setLoop('path', $path);
$tpl_path->setLoop('path', $path);
$data['title'] = '';
$data['isNew'] = 0;
$tpl_path->setVar('data', $data);


$record->getTableFields(0); // uzkrauna elementu laukus


foreach($record->table_fields as $key=>$val){
	if($val['list_values']['source']=='DB' && $val['elm_type']!=FRM_LIST){
		$val['is_list_values'] = 1;
		$val['list_values_module'] = $val['list_values']['module'];
		$val['list_values_parent_id'] = $val['list_values']['parent_id'];
	}
	if(!in_array($val['elm_type'], $FORM_TYPES_NON_EXPORT)) $fields[] = $val;
}
$tpl->setLoop('table_fields', $fields);


$tpl->setVar('lng', $_SESSION['site_lng']);
$tpl->setVar('module_name', $record->module_info['title']);
$tpl->setVar('module', $record->module_info);

$tpl->setVar('filter_page', '');

$tpl_path->parse();
$tpl->setCodeBlock('path', 'include $tpl_path->cacheFile;');

include_once(dirname(__FILE__)."/menu.php");

?>