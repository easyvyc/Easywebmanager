<?php
/*
 * Created on 2008.03.31
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once(CLASSDIR."module.class.php");
$modules = new module();

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form_config = new forms();

if($_SESSION['admin']['permission']!=1){
	if(in_array($_GET['id'], $admin_obj->modules_rights)){
		redirect("main.php?content={$_GET['content']}");
	}
}

if(isset($_GET['id']) && $_GET['id']!=0){
    $modules->loadModule($_GET['id']);
    $modules->data['isNew'] = 0;
}else{
    $modules->data['isNew'] = 1;
    $modules->data['menu_module'] = $menu_module==1?1:0;
}

$tpl->setVar('data', $modules->data);


$form->addField("html_tpl", 	array('type'=>FRM_HTML, 'value'=>$modules->data['html_tpl'], 'title'=>'', 'list_values'=>array('mode'=>'block', 'toolbar'=>'Form', 'height'=>'300'), 'require'=>0));

$form->addField("submit", 	array('type'=>FRM_SUBMIT, 'value'=>"", 'title'=>'', 'require'=>0));
$form->addField("action", 	array('type'=>FRM_HIDDEN, 'value'=>"save", 'title'=>'', 'require'=>0));


if(!empty($_POST)){
    if($_POST['action']=='save'){
	    $form->validate($_POST);
	    if($form->error!=1){
	    	//$id = $modules->saveModule($_POST);
	    	
	    	$tpl_html = addcslashes($_POST['html_tpl'], "'");
	    	$sql = "UPDATE $modules->table SET html_tpl='$tpl_html' WHERE id={$_GET['id']}";
	    	$database->exec($sql, __FILE__, __LINE__);
	    	
	        redirect("main.php?content=mod&page=edit&id={$_GET['id']}");
	    }
    }
}

$tpl->setVar('form', $form->construct_form('save'));
$form_config->formName = "config";
$tpl->setVar('form_config', $form_config->construct_form('config'));

include_once(dirname(__FILE__)."/menu.php");
        
?>