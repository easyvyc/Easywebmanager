<?php
/*
 * Created on 2008.11.14
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;



$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/module.tpl");

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->debug=0;


$record = $pages_obj = $main_object->create("pages");

	
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
}

/*if(strlen($item_data['title'])==0){
	$form->editField("title", array("value"=>$_PAGE_DATA['title'], 'edited'=>1));
}*/
	
$form->formHTML = $record->module_info['area_html'];

$record_data = $item_data;

if(!empty($_POST)){
	
	if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
	    
	    $form->validate($_POST);
	    
	    if($form->error!=1){
		    
		    //$rid = $record->saveItem($_POST);
		    
		    //$item_data['id'] = $rid;
		    
		    $page_data = $_POST;
		    if($_POST['edited_field_title']==1){

			    $page_data['title'] = $_POST['title'];
		    	$page_data['page_title'] = $_POST['title'];

		    }
	    	if($_POST['isNew']==1){
		    	$page_data['mod_id'] = $record->module_info['id'];
		    	$page_data['template'] = 'inner';
		    	$page_data['generate_url'] = 1;
		    	$page_data['generate_keywords'] = 1;
		    	$page_data['generate_description'] = 1;
		    	$page_data['isNew'] = 1;
		    	$page_data['no_create_record'] = 1;
	    	}
		    
	    	$page_data['active'] = $_POST['active'];
	    	$page_data['id'] = $rid;
	    	//$page_data['isNew'] = 0;
	    	$page_data['parent_id'] = $_POST['parent_id'];
	    	$page_data['language'] = $_SESSION['site_lng'];
	    	
		    $pages_obj->saveItem($page_data);
		    //pae($page_data);
		    
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
	$form->formAction = "ajax.php?get={$_GET['content']}/actions&action=module&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['id']}&new=0";
}else{
	$form->formAction = "ajax.php?get={$_GET['content']}/actions&action=module&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['parent_id']}&new=1";	
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

$easy_tpl->setVar('form', $form_data);

$easy_tpl->setVar('data', $item_data);

$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('module', $record->module_info);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
$easy_tpl->setVar('form_name', $form->formName);


?>