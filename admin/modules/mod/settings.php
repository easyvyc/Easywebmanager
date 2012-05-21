<?php
/*
 * Created on 2007.09.21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



include_once(CLASSDIR."forms.class.php");
$form = new forms();


$mod_info = $module->getModule($_GET['id']);


$record = $main_object->create($mod_info['table_name']);

$lng = $_SESSION['site_lng'];


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
		    redirect("main.php?content={$_GET['content']}&page={$_GET['page']}&id={$_GET['id']}");
		    
		}else{
			$form->error = 1;
			$form->elements['file']['style'] = "error";
		}

	}else{
	    $_POST = $form->elements;
	}
	$lng = $_POST['language'];
}
  

$form_data = $form->construct_form();
$tpl->setVar('form', $form_data);

$tpl->setVar('lng', $_SESSION['site_lng']);
$tpl->setVar('module_name', $record->module_info['title']);
$tpl->setVar('module', $record->module_info);

$tpl->setVar('filter_page', '');


include_once(dirname(__FILE__)."/menu.php");


?>