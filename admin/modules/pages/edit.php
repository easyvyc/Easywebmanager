<?php

//error_reporting(E_ALL);
if($_GET['id']==1 || ($_GET['id']==0 && $_GET['new']!=1)){
	redirect("main.php?content={$_GET['content']}&module={$_GET['module']}");
}

include_once(CLASSDIR."forms.class.php");
$form = new forms();
if($VIEW_FORM === true){
	$form->tpl_path = MODULESDIR."views/";
}

$record = $main_object->create($_GET['module']);


if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;


$item_data = $record->loadItem($_GET['id'], $_GET['parent_id']);

if(isset($_GET['duplicate']) && is_numeric($_GET['duplicate'])){
	$new_data = $item_data;
	$item_data = $record->loadItem($_GET['duplicate'], $_GET['parent_id'], $ce);
	foreach($new_data as $key=>$val){
		$item_data[$key] = $val;
	}
}


$EDIT_FORM = true;
include_once(dirname(__FILE__)."/main.php");



$easy_tpl->setVar('parent_id', (isset($_GET['new'])?$_GET['parent_id']:$_GET['id']));

$path = $record->getPath((isset($_GET['new'])?$_GET['parent_id']:$item_data['parent_id']));
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
	$easy_tpl->setVar('filter_module', 1);
}else{
	$path = $record->path;
}
$easy_tpl->setLoop('path', $path);

if(count($record->path) >= $record->module_info['maxlevel'] && $record->data['is_category']==1){
	$denied_save = 1;
	$easy_tpl->setVar('nomorecategories', 1);
}


$n = count($record->table_fields);
for($i=0; $i<$n; $i++){
	if($record->table_fields[$i]['super_user']!=1 || $_SESSION['admin']['permission']==1){
		$tmp[] = $record->table_fields[$i];
	}
}
$record->table_fields = $tmp;

if(/*$record->data['is_category']!=1 && */$record->module_info['maxlevel']>0){

	$arr_parent_id_field['module'] = $record->module_info['table_name'];
	$arr_parent_id_field['script'] = "module_tree";
	$arr_parent_id_field['checkbox'] = "0";
	$arr_parent_id_field['dragndrop'] = "0";
	$arr_parent_id_field['context'] = "0";
	$arr_parent_id_field['click_handler'] = "function (url, id){ this.setActiveItem(id); $('parent_id').value=id; setEdited('parent_id'); return false; }";

	$form->addField("parent_id", array('type'=>'tree', 'value'=>$item_data['parent_id'], 'editorship'=>1, 'list_values'=>$arr_parent_id_field, 'title'=>$cms_phrases['main']['catalog']['item_category'], 'require'=>1, 'class_method'=>"object=record::method=checkRecordParentId::admin_error_msg={$cms_phrases['main']['form']['wrong_parent_id']}"));

}elseif($record->module_info['parent_module']>0){

	$parent_mod = $module->getModule($record->module_info['parent_module']);
	$arr_parent_id_field['module'] = $parent_mod['table_name'];
	$arr_parent_id_field['script'] = "module_tree";
	$arr_parent_id_field['checkbox'] = "0";
	$arr_parent_id_field['dragndrop'] = "0";
	$arr_parent_id_field['context'] = "0";
	$arr_parent_id_field['click_handler'] = "function (url, id){ this.setActiveItem(id); $('parent_id').value=id; setEdited('parent_id'); return false; }";

	$form->addField("parent_id", array('type'=>'tree', 'value'=>$item_data['parent_id'], 'editorship'=>1, 'list_values'=>$arr_parent_id_field, 'title'=>$cms_phrases['main']['catalog']['item_category'], 'require'=>1, 'class_method'=>""));
	
}else{
	$form->addField("parent_id", array('type'=>'hidden', 'value'=>$item_data['parent_id']));
}

$form->addField("inner_module_id", array('type'=>FRM_SELECT, 'value'=>$item_data['inner_module_id'], 'list_values'=>array("source"=>"CALL", "object"=>"module", "method"=>"listModulesPages", "param1"=>$record->module_info['id']), 'title'=>$cms_phrases['main']['catalog']['item_inner_module'], 'require'=>1, 'editorship'=>1));

$n = count($record->table_fields);
for($i=0; $i<$n; $i++){
    $form->addField($record->table_fields[$i]['column_name'], $record->table_fields[$i]);
}


$m = count($record->table_fields);
for($j=0; $j<$m; $j++){
    $record->table_fields[$j]['value'] = ($item_data['isNew']==1 && !isset($_GET['duplicate']))?$form->elements[$record->table_fields[$j]['column_name']]['default_value']:$item_data[$record->table_fields[$j]['column_name']];
  	$record->table_fields[$j]['name'] = $record->table_fields[$j]['column_name'];
  	
  	$form->editField($record->table_fields[$j]['column_name'], $record->table_fields[$j]);
}

if($_SESSION['admin']['permission']==1){
	$easy_tpl->setVar('super_admin', 1);
}else{
	$easy_tpl->setVar('super_admin', 0);
}

if($item_data['isNew']!=1){
	
	$easy_tpl->setVar('record_author_create', $record->loadItemAuthor($item_data['create_by_admin']));
	$easy_tpl->setVar('record_author_modify', $record->loadItemAuthor($item_data['last_modif_by_admin']));
	
}else{
	
	$form->editField("page_redirect", array('value'=>0));
	
}

$form->formHTML = $record->module_info['area_html'];

$record_data = $item_data;

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
	    //pae($_POST);
	    
	    $form->validate($_POST);
	    
	    if($form->error!=1){
		    
		    if($FILTER_PAGE==1){
		    	$_POST[$_SESSION['filter_item']['get_category']['column_name']] = $_SESSION['filter_item']['get_category']['value'];
		    	$_POST[$_SESSION['filter_item']['get_column_name']['column_name']] = $_SESSION['filter_item']['get_column_name']['value'];
		    }
		    
		    $rid = $record->saveItem($_POST);
		    //$easy_tpl_main->setVar('tree_reload', 1);
	    	//redirect("main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page={$_GET['page']}&id=$rid&tree_reload=1");

	    }else{
	    	$_POST = $form->elements;
	    }
	    
	}
	$lng = $_POST['language'];
}
  


$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');



$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
$form->addField("id", array('type'=>'hidden', 'value'=>$record_data['id']));
$form->addField("isNew", array('type'=>'hidden', 'value'=>$record_data['isNew']));
$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));
$form->addField("is_category", array('type'=>'hidden', 'value'=>$ce));

if($record_data['is_category']!=1 && $record->module_info['no_standart_tpl']==1) $form->formHTML = $record->module_info['area_html'];

//if(isset($_GET['tree_reload'])) $form->create_in_iframe = 1;


if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
	header("Content-Type: text/html; charset=utf-8");
	if($form->error!=1){
		echo "<script type=\"text/javascript\"> top.content.PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page={$_GET['page']}&id=$rid&area=tpl&ajax=1&tree_reload=1', 'inner_content'); </script>";
		exit;
	}else{
		$form_data = $form->construct_form();
		echo $form_data;
		exit;
	}
}else{
	$form_data = $form->construct_form();
}


$easy_tpl->setVar('form', $form_data);

$easy_tpl->setVar('data', $record_data);

$easy_tpl->setVar('language', $lng);


$easy_tpl->setVar('lng', $_SESSION['site_lng']);
$easy_tpl->setVar('module_name', $record->module_info['title']);
$easy_tpl->setVar('module', $record->module_info);

if(isset($_GET['tree_reload'])&&$_GET['tree_reload']==1){
	$easy_tpl->setVar('tree_reload', 1);
}
if(isset($_GET['lng'])){
	$easy_tpl->setVar('tree_reload', 1);
}
if($record->module_info['maxlevel']==0){
	$easy_tpl->setVar('tree_reload', 0);
}

$easy_tpl->setVar('filter_page', '');

if($record->module_info['category']==0) $easy_tpl->setVar('tree_reload', 0);

//pae($_GET);
//include_once(dirname(__FILE__)."/menu.php");


$easy_tpl->setVar('get', $_GET);



//include_once(dirname(__FILE__)."/inc/screenshot.php");

?>