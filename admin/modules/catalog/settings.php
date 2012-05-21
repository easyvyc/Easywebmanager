<?php
/*
 * Created on 2007.09.21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



if($_GET['id']==1){
	redirect("main.php?content=catalog&module={$_GET['module']}");
}

include_once(CLASSDIR."forms.class.php");
$form = new forms();


$record = $main_object->create($_GET['module']);


$lng = $_SESSION['site_lng'];

if(!isset($_GET['id'])) $_GET['id'] = 0;


$tpl->setVar('parent_id', (isset($_GET['new'])?$_GET['parent_id']:$_GET['id']));


include_once(dirname(__FILE__)."/main.php");


$path_tpl_name = MODULESDIR.$module_name."/templates/path.tpl";
$tpl_path = & new easytpl($path_tpl_name, "templateVariables");


$path = $record->getPath($_GET['id']);
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
$tpl_path->setLoop('path', $path);
$data['title'] = '';
$data['isNew'] = 0;
$tpl_path->setVar('data', $data);


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
		    redirect("main.php?content={$_GET['content']}&module={$_GET['module']}&page={$_GET['page']}&id={$_GET['id']}");
		    
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

$tpl_path->parse();
$tpl->setCodeBlock('path', 'include $tpl_path->cacheFile;');

include_once(dirname(__FILE__)."/menu.php");


?>