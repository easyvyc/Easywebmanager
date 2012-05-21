<?php


include_once(CLASSDIR."trash.class.php");
$trash_obj = & new trash();


$module_data = $trash_obj->getModule($_GET['id']);

include_once(CLASSDIR."module.class.php");
$module = new module();

$_GET['module'] = $module_data['table_name'];

include_once(CLASSDIR."forms.class.php");
$form = new forms();

//$form->tpl_path = MODULESDIR."views/";


$record = $main_object->create($_GET['module']);

/*
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    $trash_obj->delete($_GET['deleteid']);
    redirect("main.php?content={$_GET['content']}");
}


if(isset($_GET['action']) && $_GET['action']=='reset' && isset($_GET['resetid'])){
    $trash_obj->reset($_GET['resetid']);
    redirect("main.php?content={$_GET['content']}");
}
*/


$lng = $_SESSION['site_lng'];

if(isset($_GET['ce'])) $ce = $_GET['ce'];
if(!isset($ce)) $ce = 2;

if(!isset($_GET['id'])) $_GET['id'] = 0;

if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;

$record->data = $record->loadItem($_GET['id'], $_GET['parent_id'], $ce);

$tpl->setVar('parent_id', (isset($_GET['new'])?$_GET['parent_id']:$_GET['id']));

$path = $record->getPath((isset($_GET['new'])?$_GET['parent_id']:$record->data['parent_id']));
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


$n = count($record->table_fields);
for($i=0; $i<$n; $i++){
	if($record->table_fields[$i]['super_user']!=1 || $_SESSION['admin']['permission']==1){
		$tmp_arr = $record->table_fields[$i];
		$tmp_arr['editorship'] = 0;
		$tmp[] = $tmp_arr;
	}
}
$record->table_fields = $tmp;

if(/*$record->data['is_category']!=1 && */$record->module_info['maxlevel']>0){
	$form->addField("parent_id", array('type'=>'tree', 'value'=>$record->data['parent_id'], 'editorship'=>1, 'list_values'=>"module||{$record->module_info['table_name']}::script||module::CheckBoxes||0::DragAndDrop||0::OpenHandler||::ClickHandler||moduleTreeForRecordParentId::ClickImgHandler||moduleTreeForRecordParentId::CheckHandler||::DblClickHandler||::DragHandler||::", 'title'=>'Elemento kategorija', 'require'=>1, 'class_method'=>"object||record::method||checkRecordParentId::admin_error_msg||{$cms_phrases['main']['form']['wrong_parent_id']}"));
}else{
	$form->addField("parent_id", array('type'=>'hidden', 'value'=>$record->data['parent_id']));
}


$n = count($record->table_fields);
for($i=0; $i<$n; $i++){
    if($record->table_fields[$i]['elm_type']!=FRM_SUBMIT) $form->addField($record->table_fields[$i]['column_name'], $record->table_fields[$i]);
}


$m = count($record->table_fields);
for($j=0; $j<$m; $j++){
    $record->table_fields[$j]['value'] = $record->data['isNew']==1?$form->elements[$record->table_fields[$j]['column_name']]['default_value']:$record->data[$record->table_fields[$j]['column_name']];
  	$record->table_fields[$j]['name'] = $record->table_fields[$j]['column_name'];
  	
  	$form->editField($record->table_fields[$j]['column_name'], $record->table_fields[$j]);
}
  //pa($record->data);
  //pa($form->elements);
  //pa($record->table_fields);
  //$form->setData($arr);

if($_SESSION['admin']['permission']==1){
	$tpl->setVar('super_admin', 1);
}else{
	$tpl->setVar('super_admin', 0);
}


if($record->data['isNew']!=1){
	
	$tpl->setVar('record_author_create', $record->loadItemAuthor($record->data['create_by_admin']));
	$tpl->setVar('record_author_modify', $record->loadItemAuthor($record->data['last_modif_by_admin']));
	
}


$record_data = $record->data;

$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');

$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
$form->addField("id", array('type'=>'hidden', 'value'=>$record_data['id']));
$form->addField("isNew", array('type'=>'hidden', 'value'=>$record_data['isNew']));
$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));
$form->addField("is_category", array('type'=>'hidden', 'value'=>$ce));


$form_data = $form->construct_form();

$tpl->setVar('form', $form_data);

$tpl->setVar('data', $record_data);

$tpl->setVar('language', $lng);

$tpl->setVar('is_category', $record_data['is_category']);

$tpl->setVar('new_category', (!isset($_GET['ce'])||$_GET['ce']==1?1:0));
$tpl->setVar('new_item', (isset($_GET['id'])&&$_GET['id']!=0&&$_GET['ce']==1?1:0));

if(!isset($_GET['new'])){
	$list = $record->listItems($_GET['id']);
	$n = count($list);
	for($i=0; $i<$n; $i++){
		if($list[$i]['is_category']==1)
			$list_categories[] = $list[$i];
		else
			$list_products[] = $list[$i];
	}

	$tpl->setLoop('categories', @$list_categories);
	$tpl->setLoop('products', @$list_products);
}
$tpl->setVar('is_sub_categories', (count(@$list_categories)>0?1:0));
$tpl->setVar('is_products', (count(@$list_products)>0?1:0));

$tpl->setVar('lng', $_SESSION['site_lng']);
$tpl->setVar('module_name', $record->module_info['title']);
$tpl->setVar('module', $record->module_info);


$tpl->setVar('filter_page', '');

if($record->module_info['category']==0) $tpl->setVar('tree_reload', 0);

include $tpl->parse();
exit;
?>