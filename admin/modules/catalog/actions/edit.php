<?php
/*
 * Created on 2008.09.05
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once(MODULESDIR."catalog/actions/module.php");

/*
$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/edit.tpl");

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->formName = 'EDIT';

$record = $main_object->create($_GET['module']);


if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;


$item_data = $record->loadItem($_GET['id'], $_GET['parent_id']);


$EDIT_FORM = true;



$form->addField("parent_id", array('type'=>'hidden', 'value'=>$item_data['parent_id']));


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
	    
	    $form->validate($_POST);
	    
	    if($form->error!=1){
		    
		    $rid = $record->saveItem($_POST);

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

//if($record_data['is_category']!=1 && $record->module_info['no_standart_tpl']==1) $form->formHTML = $record->module_info['area_html'];

if($item_data['isNew']!=1){
	$form->formAction = "ajax.php?get={$_GET['content']}/actions/edit&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['id']}&new=0";
}else{
	$form->formAction = "ajax.php?get={$_GET['content']}/actions/edit&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['parent_id']}&new=1";	
}


if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
	header("Content-Type: text/html; charset=utf-8");
	if($form->error!=1){
		$easy_tpl->setVar('success', 1);
	}else{
		$form_data = $form->construct_form();
	}
}else{
	$form_data = $form->construct_form();
}

echo "<div style='display:none'>$form->create_in_iframe</div>";
//echo $form_data; exit;

$easy_tpl->setVar('form', $form_data);

$easy_tpl->setVar('data', $item_data);

$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('module', $record->module_info);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
$easy_tpl->setVar('form_name', $form->formName);
*/


?>