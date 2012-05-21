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

$dienied_admin_langs = $main_object->call("admins", "loadLanguageRights", array($_SESSION['admin']['id']));

$data = $record->loadItem($_GET['id']);

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['reset']==1){
	$record->resetFromTrash($_GET['id']);
	$easy_tpl->setVar('reset', 1);
}elseif(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['confirm']==1){
	$easy_tpl->setVar('success', 1);
}elseif(isset($_GET['id']) && is_numeric($_GET['id'])){

	include_once(CLASSDIR."forms.class.php");
	$form = new forms();
	$form->debug=0;

	$form->addField("delete_all", array('type'=>FRM_CHECKBOX, 'title'=>$cms_phrases['main']['catalog']['language_delete_all'], 'value'=>1, 'checked'=>1, 'editorship'=>1, 'onclick'=>" var i=1; if(this.checked==true) while(document.getElementById('id_language_actions_'+i)) document.getElementById('id_language_actions_'+i++).checked=true;"));
	if($record->module_info['multilng']==1 && count($record->config->variable['default_page'])>1){
		$lang_saved_arr = $record->getItemLangStatus($_GET['id']);
		//pae($lang_saved_arr);
		foreach($record->config->variable['default_page'] as $key=>$val){
			/*if(!($lang_saved_arr[$key]['checked']==0 && $lang_saved_arr[$key]['disabled']==0))*/
			if(!in_array($key, $dienied_admin_langs)) 
				$lang_val[] = array('title'=>strtoupper($key), 'value'=>$key, 'checked'=>1);
		}
		$form->addField("language_actions", array('type'=>FRM_CHECKBOX_GROUP, 'title'=>$cms_phrases['main']['catalog']['language_delete_item'], 'list_values'=>$lang_val, 'onclick'=>"if(this.checked!=true) document.getElementById('id_delete_all').checked=false;", 'editorship'=>1));
	}

	if(!empty($_POST)){
		if(isset($_POST['action']) && $_POST['action']=='confirm'){
		    $form->validate($_POST);
		    if($form->error!=1){
				if($_POST['delete_all']==1 && empty($dienied_admin_langs)){
					$easy_tpl->setVar('reset_access', $record->delete($_GET['id']));
				}else{
					$record->deleteLang($_GET['id'], explode("::", $_POST['language_actions']));
				}
				$easy_tpl->setVar('done', 1);
		    }else{
		    	$_POST = $form->elements;
		    }
		}
	}
	
	$form->addField("action", array('type'=>FRM_HIDDEN, 'value'=>'confirm'));
	$form->addField("submit", array('type'=>FRM_BUTTON, 'title'=>$cms_phrases['main']['catalog']['confirm_delete_yes'], 'onclick'=>" top.content.edited_element=false; this.form.submit();"));

	$form->formAction = "ajax.php?get={$_GET['content']}/actions/delete&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&".($_GET['filters']?"&filters={$_GET['filters']}":"");
	
	if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='confirm'){
		header("Content-Type: text/html; charset=utf-8");
		if($form->error!=1){
		}else{
			$form_data = $form->construct_form();
		}
	}else{
		$form_data = $form->construct_form();
	}
	
	echo "<div style='display:none'>$form->create_in_iframe</div>";
	//echo $form_data; exit;
	
	$easy_tpl->setVar('form', $form_data);

	$easy_tpl->setVar('confirm', 1);
	
}

$easy_tpl->setVar('item_data', $data);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
$easy_tpl->setVar('module', $record->module_info);
 

?>