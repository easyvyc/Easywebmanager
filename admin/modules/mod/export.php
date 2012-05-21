<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->debug=0;
//$form_config = new forms();

if($_SESSION['admin']['permission']!=1){
	if(in_array($_GET['id'], $admin_obj->modules_rights)){
		redirect("main.php?content=settings");
	}
}

if(isset($_GET['id']) && $_GET['id']!=0){
    $modules->loadModule($_GET['id']);
}

$tpl->setVar('data', $modules->data);

$form->addField("action", 	array('type'=>FRM_HIDDEN, 'value'=>"save"));
$form->addField("submit", 	array('type'=>FRM_SUBMIT, 'value'=>"", 'title'=>$cms_phrases['main']['settings']['module']['export'], 'require'=>0));



if(!empty($_POST)){
    if($_POST['action']=='save'){
	    $form->validate($_POST);
	    if($form->error!=1){
			$modules->data['module_columns'] = $modules->listColumns($_GET['id']);
			//pae($modules->data);
			download_data("{$modules->data['table_name']}_structure.backup.e", var_export(serialize($modules->data), true));
		}
    }
}

$tpl->setVar('form', $form->construct_form('save'));

include_once(dirname(__FILE__)."/menu.php");
        
?>