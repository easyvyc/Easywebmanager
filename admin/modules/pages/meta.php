<?php
/*
 * Created on 2008.03.06
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */




$_GET['ce'] = 0;



include_once(CLASSDIR."forms.class.php");
$form = new forms();
if($VIEW_FORM === true){
	$form->tpl_path = MODULESDIR."views/";
}

$record = $main_object->create($_GET['module']);
$record->getTableFields(1);

$form->img->watermark_file = UPLOADDIR.$record->module_info['xml_settings']['watermark']['value'];


$ce = $_GET['ce'];

$item_data = $record->loadItem($_GET['id'], $_GET['parent_id'], $ce);

$meta_obj = $main_object->create("metatags");

$record_data = $main_object->call("metatags", "loadItem", array($_GET['id'], $_GET['parent_id'], $ce));
//$record_data = $main_object->get("metatags", "data");
$record_data['title'] = $item_data['title'];

$table_fields = $main_object->get("metatags", "table_fields");
$n = count($table_fields);
for($i=0; $i<$n; $i++){
	if($table_fields[$i]['super_user']!=1 || $_SESSION['admin']['permission']==1){
		$tmp[] = $table_fields[$i];
	}
}
$table_fields = $tmp;

$form->addField("parent_id", array('type'=>'hidden', 'value'=>$item_data['parent_id']));


$n = count($table_fields);
for($i=0; $i<$n; $i++){
    $form->addField($table_fields[$i]['column_name'], $table_fields[$i]);
}


$m = count($table_fields);
for($j=0; $j<$m; $j++){
    $table_fields[$j]['value'] = ($item_data['isNew']==1 && !isset($_GET['duplicate']))?$form->elements[$table_fields[$j]['column_name']]['default_value']:$record_data[$table_fields[$j]['column_name']];
  	$table_fields[$j]['name'] = $table_fields[$j]['column_name'];
  	
  	$form->editField($table_fields[$j]['column_name'], $table_fields[$j]);
}


if($meta_obj->module_info['area_html'] && $meta_obj->module_info['no_standart_tpl']==1)
	$form->formHTML = $meta_obj->module_info['area_html'];

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
	    $form->validate($_POST);
	    if($form->error!=1){
		    
		    $rid = $main_object->call("metatags", "saveItem", array($_POST));
		    
		    /*
		    if($_POST['is_category']>0)
		    	redirect("main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=meta&id=$rid&tree_reload=1");
		    else
		    	redirect("main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=meta&id=$rid");
		    */
		    
	    }else{
	    	$_POST = $form->elements;
	    }
	}
	$lng = $_POST['language'];
}
  
//$record_data = $item_data;

$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');

$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
$form->addField("id", array('type'=>'hidden', 'value'=>$record_data['id']));
$form->addField("isNew", array('type'=>'hidden', 'value'=>$record_data['isNew']));
$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));
$form->addField("is_category", array('type'=>'hidden', 'value'=>$ce));

//if($record_data['is_category']!=1 && $record->module_info['no_standart_tpl']==1) $form->formHTML = $record->module_info['area_html'];

$form->formAction = "main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=meta&id={$_GET['id']}&ajax=1&area=tpl";
echo "<div style='display:none'>$form->create_in_iframe</div>";
$form_data = $form->construct_form();


if(isset($_GET['ajax']) && $_GET['ajax']==1){
	echo $form_data;
	//include $tpl->parse();
	exit;
}


?>