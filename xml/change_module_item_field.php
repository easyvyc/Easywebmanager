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



if($_SESSION['admin']['permission']!=1){
	
}

include_once(CLASSDIR."xmlini.class.php");
$xml = new xmlIni();

$_GET['value'] = addslashes(htmlspecialchars(urldecode($_GET['value'])));
$_GET['isNew'] = 0;
$_GET['language'] = $_GET['lng'];

if(!empty($_GET)){
    
    $admin_obj = $main_object->create("admins");
    $admin_obj->modules_rights = $main_object->call("admins", "loadModuleRights", array($_SESSION['admin']['id']));
    
    include_once(CLASSDIR."module.class.php");
    $modules = new module();
    
    if(!isset($_SESSION["admin"]["id"])){
			
			$xml->xmlTree->name = "items";
			$xml->xmlTree->attributes['error'] = "2";
			$xml->xmlTree->children[0]->name = "error";
			$xml->xmlTree->children[0]->content = $cms_phrases['xml']['session_timeout'];
			
	}elseif(($_SESSION['admin']['permission']!=1 && !in_array($_GET['id'], $admin_obj->modules_rights)) || ($_SESSION['admin']['permission']!=1 && in_array($_GET['column'], $modules->module_fields_for_superadmin))){

			$xml->xmlTree->name = "items";
			$xml->xmlTree->attributes['error'] = "1";
			$xml->xmlTree->children[0]->name = "error";
			$xml->xmlTree->children[0]->content = $cms_phrases['xml']['no_permissions'];
		
	}else{
	    
        	$modules->changeStatus($configFile->variable['sb_module'], $_GET['column'], $_GET['id']);
		    
		    $m_data = $modules->getModule($_GET['id']);
		    
		    $xml->xmlTree->name = "items";
			$xml->xmlTree->attributes['error'] = "0";
			
			$xml->xmlTree->children[0]->name = "item";
			$xml->xmlTree->children[0]->attributes['elm_type'] = FRM_CHECKBOX;
			$xml->xmlTree->children[0]->children[0]->name = "title";
			$xml->xmlTree->children[0]->children[0]->content = $m_data[$_GET['column']];
			
	}
}
	

$xml_source = $xml->objToXml($xml->xmlTree);
 
?>
