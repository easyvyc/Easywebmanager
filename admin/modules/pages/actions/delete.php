<?php
/*
 * Created on 2008.11.19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 

$record = $main_object->create($_GET['module']);

$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/delete.tpl");

/*if(){
	
	$easy_tpl->setVar('norights', 1);
	
}*/

if(!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id']==0){
	$easy_tpl->setVar('back2edit', 1);
}


$data = $record->loadItem($_GET['id']);

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['confirm']==1){
	
	$record->delete($_GET['id']);
	$easy_tpl->setVar('done', 1);
	
}elseif(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['reset']==1){

	$record->resetFromTrash($_GET['id']);
	$easy_tpl->setVar('reset', 1);

}elseif(isset($_GET['id']) && is_numeric($_GET['id'])){

	$easy_tpl->setVar('confirm', 1);
	
}

$easy_tpl->setVar('item_data', $data);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
 

?>