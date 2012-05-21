<?php
/*
 * Created on 2006.4.24
 * change_catalog_item_field.php
 * Vytautas
 */

if(!isset($_SESSION["admin"]["id"])){
	//exit;
	redirect("login.php");
}
 
include_once(CLASSDIR."forms.class.php");
$form = new forms();


$record = $main_object->create($_GET['module']);


include_once(CLASSDIR."xmlini.class.php");
$xml = new xmlIni();

$n = count($record->table_fields);
for($i=0; $i<$n; $i++){
	if($record->table_fields[$i]['column_name']==$_GET['column']){
		$column = $record->table_fields[$i];
	}
}
unset($record->table_fields);
$record->table_fields[] = $column;

$_GET[$column['column_name']] = addslashes(htmlspecialchars(urldecode($_GET['value'])));
if($column['elm_type']==FRM_TEXT){
	$_GET[$column['column_name']] = ereg_replace("\n", " ", $_GET[$column['column_name']]);
	$_GET[$column['column_name']] = ereg_replace("\r", " ", $_GET[$column['column_name']]);
}
$_GET['isNew'] = 0;
$_GET['language'] = $_GET['lng'];

if($column['elm_type']==FRM_IMAGE){
	$column['image_extra'] = $record->getValueParamsImages($column['extra_params']);
	foreach($column['image_extra'] as $image_extra_key => $image_extra_val){
		$_GET['resize_width_'.$column['column_name'].'_'.$image_extra_val['prefix']] = $image_extra_val['size_width'];
		$_GET['resize_height_'.$column['column_name'].'_'.$image_extra_val['prefix']] = $image_extra_val['size_height'];
	}
}

if(!empty($_GET)){
    
    if(!isset($_SESSION["admin"]["id"])){
			
			$xml->xmlTree->name = "items";
			$xml->xmlTree->attributes['error'] = "2";
			$xml->xmlTree->children[0]->name = "error";
			$xml->xmlTree->children[0]->content = $cms_phrases['xml']['session_timeout'];
			
	}else{
	    
	    $form->addField($column['column_name'], $record->table_fields[0]);
	    
	    $form->validate($_GET);
	    if($form->error!=1){
		    
		    $rid = $record->saveItem($_GET);
		    $xml->xmlTree->name = "items";
			$xml->xmlTree->attributes['error'] = "0";
			
			$item_data = $record->loadItem($rid);
			
			$xml->xmlTree->children[0]->name = "item";
			$xml->xmlTree->children[0]->attributes['elm_type'] = $column['type'];
			$xml->xmlTree->children[0]->children[0]->name = "title";
			$xml->xmlTree->children[0]->children[0]->content = $item_data[$_GET['column'].((in_array($column['type'], array(FRM_SELECT, FRM_CHECKBOX_GROUP, FRM_RADIO))&&$column['list_values']['source']=='DB')?'_list':'')];
			
	    }else{
			
			$xml->xmlTree->name = "items";
			$xml->xmlTree->attributes['error'] = "1";
			$xml->xmlTree->children[0]->name = "error";
			$xml->xmlTree->children[0]->content = $form->elements[$column['column_name']]['error_message'];//"Neteisingai įvesti duomenys.";
			
	    }
	}
}


$xml_source = $xml->objToXml($xml->xmlTree);
 
?>
