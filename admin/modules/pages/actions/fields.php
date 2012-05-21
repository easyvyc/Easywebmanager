<?php
/*
 * Created on 2009.03.20
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/fields.tpl");

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->formName = 'EDIT';
$form->debug = 0;

$record = $main_object->create($_GET['module']);

$EDIT_FORM = true;


$form->addField("id", array('type'=>'hidden', 'value'=>$_GET['id']));
$form->addField('fields', $record->_table_fields['fields']);
$form->addField('modification', $record->_table_fields['modification']);


$easy_tpl->setVar('form', $form->construct_form());

$easy_tpl->setVar('data', $item_data);

$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('module', $record->module_info);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
$easy_tpl->setVar('form_name', $form->formName);

?>