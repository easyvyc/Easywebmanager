<?php
/*
 * Created on 2008.08.29
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$FORM_TYPES_NON_EXPORT = array(FRM_SUBMIT, FRM_BUTTON, FRM_LIST, FRM_TREE, FRM_SEPARATOR);

$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/pdf.tpl");

$record = $main_object->create($_GET['module']);

if($record->module_info['maxlevel']==0) $_GET['id'] = 0;

global $FORM_TYPES_NON_EXPORT;
foreach($record->table_fields as $k=>$v){
	if(!in_array($v['elm_type'], $FORM_TYPES_NON_EXPORT)) $tblflds[] = $v;
}
$easy_tpl->setLoop('fields', $tblflds);


$easy_tpl->setVar('phrases', $cms_phrases);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('module', $record->module_info);

?>