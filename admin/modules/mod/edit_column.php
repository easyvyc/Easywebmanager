<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();

include_once(CLASSDIR."forms.class.php");
$form = new forms();

$_GET['column_id'] = $_GET['id'];

if(isset($_GET['column_id']) && $_GET['column_id']!=0){
    $modules->loadColumn($_GET['column_id']);
    $modules->data['isNew'] = 0;
}else{
    $modules->data['isNew'] = 1;
    $modules->data['module_id'] = $_GET['parent_id'];
//    $modules->data['extra_params'] = "prefix=thumb_||size=100x80||quality=80::prefix=||size=500x400||quality=90||watermark=1";
}

$tpl->setVar('data', $modules->data);

$n = count($DB_COLS_TYPES);
for($i=0; $i<$n; $i++){
    $column_types[$i]['value'] = strtolower($DB_COLS_TYPES[$i]);
    $column_types[$i]['title'] = $DB_COLS_TYPES[$i];
}

$n = count($FORM_ELM_TYPES);
for($i=0; $i<$n; $i++){
    if($_SESSION['admin']['permission']==1 || $FORM_ELM_TYPES[$i]['superadmin']!=1){
	    $FORM_ELM_TYPES_[] = $FORM_ELM_TYPES[$i];
	    $types_ = implode("||", array($FORM_ELM_TYPES[$i]['value'], $FORM_ELM_TYPES[$i]['title']));
	    if(strlen($types)==0)
	    	$types = $types_;
	    else
	        $types = implode("::", array($types, $types_));
    }
}

//$CEs[] = array('value'=>'1', 'value'=>'1', 'title'=>'Naudojamas kategorijose', 'selected'=>($modules->data['CE']==1?'selected':''));
//$CEs[] = array('value'=>'0', 'value'=>'0', 'title'=>'Naudojamas elementuose', 'selected'=>($modules->data['CE']==0?'selected':''));

//$CEs = "2||Naudojamas elementuose ir kategorijose::1||Naudojamas tik kategorijose::0||Naudojamas tik elementuose";

$form->addField('action', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>'save'));
$form->addField('id', 			array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$modules->data['id']));
$form->addField('module_id', 	array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$modules->data['module_id']));
$form->addField('isNew', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$modules->data['isNew']));

$form->addField('title_lt', 	array('title'=>$cms_phrases['main']['settings']['columns']['column_title'].' LT', 'require'=>1, 'type'=>'text', 'value'=>$modules->data['title_lt'], 'editorship'=>1));
$form->addField('title_en', 	array('title'=>$cms_phrases['main']['settings']['columns']['column_title'].' EN', 'require'=>1, 'type'=>'text', 'value'=>$modules->data['title_en'], 'editorship'=>1));
$form->addField('column_name', 	array('title'=>$cms_phrases['main']['settings']['columns']['column_name'], 'require'=>1, 'type'=>'text', 'value'=>$modules->data['column_name'], 'editorship'=>1, 'class_method'=>"object=modules::method=checkExistColumnName::admin_error_msg={$cms_phrases['main']['settings']['module']['column_name_exists']}", 'function'=>"function=valid_table_name::admin_error_msg={$cms_phrases['main']['settings']['module']['not_valid_column_name']}"));

if($_SESSION['admin']['permission']==1){
	if(preg_match("/([a-zA-Z0-9]+)\(([0-9a-zA-Z\,\._\-]+)\)/", $modules->data['column_type'], $matches)){
		$modules->data['column_type'] = $matches[1];
		$modules->data['column_type_more'] = $matches[2];
	}
	$form->addField('column_type', 	array('title'=>'DB lauko tipas', 'require'=>1, 'type'=>'select', 'value'=>$modules->data['column_type'], 'list_values'=>$column_types, 'editorship'=>1));
	$form->addField('column_type_more',array('title'=>'DB lauko tipo ilgis/reikšmės', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['column_type_more'], 'editorship'=>1));
}
$form->addField('elm_type',	 	array('title'=>'Laukelio tipas', 'require'=>1, 'type'=>'select', 'value'=>$modules->data['elm_type'], 'list_values'=>$FORM_ELM_TYPES_, 'editorship'=>1, 'onchange'=>'setColumnFields(this);'));

$form->addField('extra_params',	array('title'=>'Papildomi parametrai', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['extra_params'], 'editorship'=>1, 'list_values'=>array('tpl_file'=>'settings/templates/extra_params.tpl')));
$form->addField('default_value',array('title'=>'Default reikšmė', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['default_value'], 'editorship'=>1));
$form->addField('list_values',	array('title'=>'Sąrašo reikšmės', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['list_values'], 'editorship'=>1));
$form->addField('require', 		array('title'=>$cms_phrases['main']['settings']['module']['require'], 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['require'], 'editorship'=>1));
$form->addField('list', 		array('title'=>$cms_phrases['main']['settings']['module']['list'], 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['list'], 'editorship'=>1));
$form->addField('multilng', 	array('title'=>$cms_phrases['main']['settings']['module']['multilng'], 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['multilng'], 'editorship'=>1));

if($_SESSION['admin']['permission']==1){

	$form->addField('editable', 	array('title'=>$cms_phrases['main']['settings']['module']['editable'], 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['editable'], 'editorship'=>1));
	//$form->addField('htmlspecialchars',array('title'=>'Htmlspecialchars filtras', 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['htmlspecialchars'], 'editorship'=>1));
	$form->addField('super_user', 	array('title'=>$cms_phrases['main']['settings']['module']['superadmin'], 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['superuser'], 'editorship'=>1));
	
	$form->addField('function',		array('title'=>'Funkcija tikrinimui', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['function'], 'editorship'=>1));
	$form->addField('class_method', array('title'=>'Klasės metodas tikrinimui', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['class_method'], 'editorship'=>1));
	//$form->addField('error_message',array('title'=>'Klaidos pranešimas', 'require'=>0, 'type'=>'text', 'value'=>$modules->data['error_message'], 'editorship'=>1));

	//$form->addField('CE', 			array('title'=>'Naudojamas(elemtuose ar kategorijose)', 'require'=>1, 'type'=>'checkbox_group', 'value'=>$modules->data['CE'], 'list_values'=>$CEs, 'editorship'=>1));

	//$form->addField('no_standart_tpl',array('title'=>'Naudoti savitą šabloną', 'require'=>0, 'type'=>'checkbox', 'value'=>$modules->data['no_standart_tpl'], 'editorship'=>1, 'default_value'=>1));
	//$form->addField('field_html', 	array('title'=>'Laukelio HTML', 'require'=>0, 'type'=>'html', 'value'=>$modules->data['field_html'], 'editorship'=>1, 'htmlspecialchars'=>1, 'list_values'=>array('mode'=>'block', 'toolbar'=>'Form', 'height'=>'250')));
	
}


$form->addField('description', 	array('title'=>'Aprašymas', 'require'=>0, 'type'=>'textarea', 'value'=>$modules->data['description'], 'editorship'=>1));

$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if($_SESSION['admin']['permission']==1){
	//$form->editField('elm_type', array('onchange'=>"getDefaultFieldTemplate(this, this.form.elements['no_standart_tpl'], this.form.elements['field_html']);"));
	//$form->editField('no_standart_tpl', array('extra_params'=>"onclick=\"javascript: getDefaultFieldTemplate(this.form.elements['elm_type_tmp'], this, this.form.elements['field_html']);\""));
}


if(!empty($_POST)){
    $form->validate($_POST);
    if($form->error!=1){
    	if($_SESSION['admin']['permission']!=1){
    		switch($_POST['elm_type']){
    			case FRM_TEXT:
    			case FRM_IMAGE:
    			case FRM_FILE:
    				$_POST['column_type'] = 'varchar';
					$_POST['column_type_more'] = '255';
    			break;
    			case FRM_TEXTAREA: 
    			case FRM_HTML:
    				$_POST['column_type'] = 'text';
					$_POST['column_type_more'] = '';
    			break;
    			case FRM_DATE: 
    				$_POST['column_type'] = 'date';
					$_POST['column_type_more'] = '';
    			break;
    			case FRM_SELECT: 
    			case FRM_RADIO:
    			case FRM_CHECKBOX_GROUP:
    				$_POST['column_type'] = 'int';
					$_POST['column_type_more'] = '11';
    			break;
    			case FRM_CHECKBOX:
    				$_POST['column_type'] = 'tinyint';
					$_POST['column_type_more'] = '1';
    			break;
    			case FRM_SUBMIT:
    				$_POST['column_type'] = 'tinyint';
					$_POST['column_type_more'] = '1';
    			break;
    		}
    	}
    	
    	foreach($form->elements as $key=>$val){
    		if($val['elm_type']==FRM_CHECKBOX && !isset($_POST[$key])){
    			$_POST[$key] = 0;
    		}
    	}
    	
    	if(strlen($_POST['column_type_more'])) $_POST['column_type'] = $_POST['column_type']."({$_POST['column_type_more']})";
    	
    	$id = $modules->saveColumn($_POST);
		redirect("main.php?content={$_GET['content']}&page=edit_column&id={$modules->data['module_id']}&column_id=$id");
    }
     
    
}

$tpl->setVar('form', $form->construct_form());

$tpl->setVar('module_id', $modules->data['module_id']);

$modules->loadModule($modules->data['module_id']);
$tpl->setVar('module_data', $modules->data);

if($_SESSION['admin']['permission']==1){
	$tpl->setVar('superadmin', 1);
}


$_GET['id'] = $modules->data['id'];
include_once(dirname(__FILE__)."/menu.php");
        
?>