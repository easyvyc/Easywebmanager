<?php
/*
 * Created on 2009.03.20
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/block.tpl");

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->formName = 'EDIT';
$form->debug = 0;

$record = $main_object->create($_GET['module']);

// Reikia del teisiu, nes modulis blocks realiai yra disablintas ir useris negali tureti prie jo teisiu, todel reikia tikrinti pages userio teises 
$_SESSION['filter_item']['list_values']['get_category']['value'] = $_GET['page_id'];


$record->sqlQueryWhere = " T.page_id={$_GET['page_id']} AND T.block_name='{$_GET['area']}' AND ";
$list = $record->listSearchItems();

if(empty($list[0])){
	$item_data['isNew'] = 1;
	$item_data['id'] = 0;
	$item_data['language'] = $_SESSION['site_lng'];
	$item_data['parent_id'] = 0;
	$item_data['block_name'] = $_GET['block_name'];
	$item_data['page_id'] = $_GET['page_id'];
}else{
	$item_data = $list[0];
	$_POST['isNew'] = 0;
	$_POST['id'] = $item_data['id'];
}

//pa($item_data);

$EDIT_FORM = true;



$form->addField("parent_id", array('type'=>'hidden', 'value'=>$item_data['parent_id']));


if($record->module_info['multilng']==1 && count($record->config->variable['default_page'])>1){
	$lang_saved_arr = $record->getItemLangStatus($item_data['id']);
	//pae($lang_saved_arr);
	foreach($record->config->variable['default_page'] as $key=>$val){
		if($key!=$_SESSION['site_lng']) $lang_val[] = array('title'=>strtoupper($key), 'value'=>$key, 'checked'=>$lang_saved_arr[$key]['checked'], 'readonly'=>$lang_saved_arr[$key]['disabled']);
	}
	$form->addField("language_actions", array('type'=>FRM_CHECKBOX_GROUP, 'title'=>$cms_phrases['main']['catalog']['language_action_with_item'], 'list_values'=>$lang_val, 'editorship'=>1));
}

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

$form->editField('page_id', array('value'=>$_GET['page_id']));
$form->editField('block_name', array('value'=>$_GET['area']));

/*if($item_data['isNew']!=1){
	$easy_tpl->setVar('record_author_create', $record->loadItemAuthor($item_data['create_by_admin']));
	$easy_tpl->setVar('record_author_modify', $record->loadItemAuthor($item_data['last_modif_by_admin']));
}else{
		
}*/

	
$form->formHTML = $record->module_info['area_html'];



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
$form->addField("id", array('type'=>'hidden', 'value'=>$item_data['id']));
$form->addField("isNew", array('type'=>'hidden', 'value'=>$item_data['isNew']));
$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));


if($item_data['isNew']!=1){
	$form->formAction = "ajax.php?get={$_GET['content']}/actions/block&content={$_GET['content']}&module={$record->module_info['table_name']}&page_id={$_GET['page_id']}&area={$_GET['area']}";
}else{
	$form->formAction = "ajax.php?get={$_GET['content']}/actions/block&content={$_GET['content']}&module={$record->module_info['table_name']}&page_id={$_GET['page_id']}&area={$_GET['area']}";	
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


?>