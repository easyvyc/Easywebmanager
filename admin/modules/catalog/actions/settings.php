<?php
/*
 * Created on 2009.08.10
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if($_GET['id']==1){
	redirect("main.php?content=catalog&module={$_GET['module']}");
}

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->debug=0;

$record = $pages_obj = $main_object->create($_GET['module']);


$lng = $_SESSION['site_lng'];

if(!isset($_GET['id'])) $_GET['id'] = 0;



$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/settings.tpl");

$form->addField("action", array('type'=>'hidden', 'value'=>"settings"));
foreach($record->module_info['xml_settings'] as $key=>$val){
	$val['title'] = $val['title_'.$_SESSION['admin_interface_language']];
	$val['editorship'] = 1;
	$form->addField($key, $val);
}
$form->addField("submit", array('type'=>FRM_SUBMIT, 'default_value'=>$cms_phrases['main']['form']['submit']));

if(!empty($_POST)){
	
	if(isset($_POST['action']) && $_POST['action']=='settings'){
	    $form_data = $form->validate($_POST);
	    if($form->error!=1){
		    
			foreach($record->module_info['xml_settings'] as $key=>$val){
				$record->module_info['xml_settings'][$key]['value'] = $_POST[$key];
			}		    
		    $xml = File::arrayToXmlString($record->module_info['xml_settings']);
		    $xml = htmlentities("<items>".$xml."</items>", ENT_QUOTES, "UTF-8");
		    $xml = addcslashes($xml, "'");
		    $xml = ereg_replace("&scaron;", "š", $xml);
		    $xml = ereg_replace("&Scaron;", "Š", $xml);
		    $record->module->saveSettings($xml, $record->module_info['id']);
		    //redirect("main.php?content={$_GET['content']}&module={$_GET['module']}&page={$_GET['page']}&id={$_GET['id']}");
		    
		}else{
			$form->error = 1;
			$form->elements['file']['style'] = "error";
		}

	}else{
	    $_POST = $form->elements;
	}
	$lng = $_POST['language'];
}
  

if($item_data['isNew']!=1){
	$form->formAction = "ajax.php?get={$_GET['content']}/actions/settings&content={$_GET['content']}&module={$pages_obj->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['id']}&new=0".($_GET['filters']?"&filters={$_GET['filters']}":"");
}else{
	$form->formAction = "ajax.php?get={$_GET['content']}/actions/settings&content={$_GET['content']}&module={$pages_obj->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['parent_id']}&new=1".($_GET['filters']?"&filters={$_GET['filters']}":"");	
}

if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='settings'){
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
$easy_tpl->setVar('module', $pages_obj->module_info);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
$easy_tpl->setVar('form_name', $form->formName);

?>