<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();

include_once(CLASSDIR."forms.class.php");
$form = new forms();
//$form_config = new forms();

if($_SESSION['admin']['permission']!=1){
	if(in_array($_GET['id'], $admin_obj->modules_rights)){
		redirect("main.php?content=settings");
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

$form->addField('action', 	array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>"save"));
$form->addField('id', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$modules->data['id']));
$form->addField('isNew', 	array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$modules->data['isNew']));

$form->addField('title_lt', 	array('title'=>$cms_phrases['main']['settings']['module']['title_lt'], 'require'=>1, 'type'=>'text', 	'value'=>$modules->data['title_lt'], 'editorship'=>1	));
$form->addField('title_en', 	array('title'=>$cms_phrases['main']['settings']['module']['title_en'], 'require'=>1, 'type'=>'text', 	'value'=>$modules->data['title_en'], 'editorship'=>1	));
$form->addField('table_name', 	array('title'=>$cms_phrases['main']['settings']['module']['table_name'],'require'=>1, 'type'=>'text', 	'value'=>$modules->data['table_name'], 'editorship'=>1, 'class_method'=>"object=modules::method=checkExistTableName::admin_error_msg={$cms_phrases['main']['settings']['module']['table_name_exists']}", 'function'=>"function=valid_table_name::admin_error_msg={$cms_phrases['main']['settings']['module']['not_valid_table_name']}"	));

if($modules->data['isNew'] != 1){
	if($_SESSION['admin']['permission']==1){
		$form->addField('no_standart_tpl',array('title'=>$cms_phrases['main']['settings']['module']['no_standart_tpl'], 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['no_standart_tpl'], 'editorship'=>1, 'default_value'=>1));
		$form->addField('area_html', 	array('title'=>$cms_phrases['main']['settings']['module']['area_html'], 'require'=>0, 'type'=>'html', 'value'=>$modules->data['area_html'], 'editorship'=>1, 'htmlspecialchars'=>1, 'list_values'=>array('mode'=>'block', 'toolbar'=>'Default', 'height'=>'350')));
		$form->editField('no_standart_tpl', array('onclick'=>"getDefaultModuleTemplate(this, this.form.elements['field_html'], {$modules->data['id']});"));
	}
}

if($_SESSION['admin']['permission']==1){
	//$form->addField('parent_module',array('title'=>$cms_phrases['main']['settings']['module']['parent_module'],'require'=>0, 'type'=>FRM_CHECKBOX_GROUP, 'value'=>$modules->data['parent_module'], 'editorship'=>1, "list_values"=>array('source'=>'CALL', 'object'=>'modules', 'method'=>'listModules')));
	$form->addField('additional_submit_action',array('title'=>$cms_phrases['main']['settings']['module']['additional_submit_action'],'require'=>0, 'type'=>'text', 		'value'=>$modules->data['additional_submit_action'], 'editorship'=>1, "extra_params"=>"style='width:650px;'"));
	$form->addField('multilng', 	array('title'=>$cms_phrases['main']['settings']['module']['multilng'],	'require'=>0, 'type'=>'checkbox', 	'value'=>$modules->data['multilng'], 'editorship'=>1	));
	$form->addField('category', 	array('title'=>$cms_phrases['main']['settings']['module']['category'],  'require'=>0, 'type'=>'checkbox', 	'value'=>$modules->data['category'], 'editorship'=>1	));
	$form->addField('tree', 		array('title'=>$cms_phrases['main']['settings']['module']['tree'], 		'require'=>0, 'type'=>'checkbox', 	'value'=>$modules->data['tree'], 'editorship'=>1		));
	$form->addField('mod_pages', 	array('title'=>$cms_phrases['main']['settings']['module']['mod_pages'], 'require'=>0, 'type'=>'select', 	'value'=>$modules->data['mod_pages'], 'editorship'=>1, 'list_values'=>array('source'=>'CALL', 'object'=>'module', 'method'=>'listModules')));
}

$list_values[0]['value'] = "R.sort_order";
$list_values[0]['title'] = $cms_phrases['main']['common']['sort_title'];
$columns = $module->listColumns($_GET['id']);

$n = count($columns);
for($i=0, $j=1; $i<$n; $i++){
	if($columns[$i]['list']==1){
		$list_values[$j]['value'] = "T.{$columns[$i]['column_name']}";
		$list_values[$j]['title'] = "{$columns[$i]['title']}";
		$j++;
	}
	$arr['value'] = "{$columns[$i]['column_name']}";
	$arr['title'] = "{$columns[$i]['title']} ({$columns[$i]['column_name']})";
	$email_list_values[] = $arr;
}
//$form->addField('mail', 			array('title'=>'El. paštas siuntimui', 'require'=>0, 'type'=>'select', 	'value'=>$modules->data['mail'], 'editorship'=>1, 'list_values'=>$email_list_values));
$form->addField('default_sort', 	array('title'=>$cms_phrases['main']['settings']['module']['default_sort'], 'require'=>1, 'type'=>'select', 	'value'=>$modules->data['default_sort'], 'editorship'=>1, 'list_values'=>$list_values));

unset($list_values);
$list_values[0]['value'] = "ASC";
$list_values[0]['title'] = "Ascending";
$list_values[1]['value'] = "DESC";
$list_values[1]['title'] = "Descending";
$form->addField('default_sort_direction',array('title'=>$cms_phrases['main']['settings']['module']['default_sort_direction'], 'require'=>1, 'type'=>'select', 	'value'=>$modules->data['default_sort_direction'], 'editorship'=>1, 'list_values'=>$list_values));

if($_SESSION['admin']['permission']==1){
	$form->addField('maxlevel',	array( 'title' => $cms_phrases['main']['settings']['module']['maxlevel'], 'type' => 'text', 'require' => 1, 'value' => $modules->data['maxlevel'], 'editorship'=>1 ) );
	$form->addField('additional_settings',	array('title' => $cms_phrases['main']['settings']['module']['additional_settings'], 'type' => 'textarea', 'require' => 0, 'value' => $modules->data['additional_settings'], 'editorship'=>1 ) );
}

$form->addField('description', 	array('title'=>$cms_phrases['main']['settings']['module']['description'], 			'require'=>0, 'type'=>'textarea', 	'value'=>$modules->data['description'], 'editorship'=>1	));

$form->addField("submit", 	array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));



if(!empty($_POST)){
    if($_POST['action']=='save'){
	    $form->validate($_POST);
	    if($form->error!=1){
	    	$id = $modules->saveModule($_POST);
	        //redirect("main.php?content={$_GET['content']}&page=edit_module&id=$id&tree_reload=1");
	    }
	    //echo $form->construct_form('save'); exit;
    }
}

$tpl->setVar('form', $form->construct_form('save'));
//$form_config->formName = "config";
//$tpl->setVar('form_config', $form_config->construct_form('config'));

include_once(dirname(__FILE__)."/menu.php");
        
?>
