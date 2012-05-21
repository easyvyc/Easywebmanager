<?php
/*
 * Created on 2008.09.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->formName = 'IMPORT';
$form->debug = 0;

$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/import.tpl");

$lng = $_SESSION['site_lng'];
if(!isset($_GET['id'])) $_GET['id'] = 0;
if(isset($_GET['import'])) $easy_tpl->setVar('success', 1);


$record = $main_object->create($_GET['module']);
if($record->module_info['maxlevel']==0) $_GET['id'] = 0;

$form->addField("parent_id", array('type'=>'hidden', 'value'=>$_GET['id']));

$form->formAction = "ajax.php?get={$_GET['content']}/actions/import&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}";

if(!isset($_GET['file'])){
	
	$form->addField("action", array('type'=>'hidden', 'value'=>"import"));
	$form->addField("csv_separator", array('type'=>FRM_TEXT, 'value'=>",", "title"=>$cms_phrases['main']['catalog']['csv_separator'], "require"=>1, "editorship"=>1));
	$form->addField("csv_separator_title", array('type'=>FRM_TEXT, 'value'=>"***", "title"=>$cms_phrases['main']['catalog']['csv_separator_title'], "require"=>1, "editorship"=>1));
	$form->addField("file_encoding", array('type'=>FRM_TEXT, 'value'=>"windows-1257", "title"=>$cms_phrases['main']['catalog']['csv_file_encoding'], "require"=>1, "editorship"=>1));
	$form->addField("file", array('type'=>FRM_FILE, "title"=>$cms_phrases['main']['catalog']['csv_file'], "require"=>1, "editorship"=>1));

}else{
	
	$form->addField("action", array('type'=>'hidden', 'value'=>"data"));
	
	$form->addField("file", array('type'=>'hidden', 'value'=>$_GET['file']));
	$form->addField("separator", array('type'=>'hidden', 'value'=>$_GET['separator']));
	$form->addField("encoding", array('type'=>'hidden', 'value'=>$_GET['encoding']));
	$form->addField("sep_title", array('type'=>'hidden', 'value'=>$_GET['sep_title']));
	
	$form->create_in_iframe = 1;
	$csv_data = csv_to_arr(UPLOADDIR.$_GET['file'], $_GET['separator'], $_GET['encoding'], $_GET['sep_title']);
	//pae($csv_data);
	foreach($csv_data['cols'] as $key=>$val){
		$csv_data['cols'][$key]['short'] = (strlen($val['title'])>17?mb_substr($val['title'], 0, 14, "UTF-8")."...":$val['title']);
	}
	$easy_tpl->setLoop('columns', $csv_data['cols']);
	$n = count($csv_data['data']);
	for($i=0; $i<$n && $i<30; $i++){
		$csv_data_[] = $csv_data['data'][$i];
	}
	$easy_tpl->setLoop('items', $csv_data_);
	$easy_tpl->setVar('show_import_data', 1);
	$easy_tpl->setVar('all_items_count', $n);
	
	$form->iframe_load_action = "<script type=\"text/javascript\"> if(parent.document.getElementById('formContent_$form->formName')) parent.document.getElementById('formContent_$form->formName').innerHTML = document.getElementById('import_data_area').innerHTML + document.getElementById('formContent_$form->formName').innerHTML; </script>";
	
}

$form->addField("submit", array('type'=>FRM_SUBMIT, 'title'=>$cms_phrases['main']['catalog']['upload_csv_file']));

if(!empty($_POST)){
	
	if(isset($_POST['action']) && $_POST['action']=='import'){
	    
	    $form->validate($_POST);
	    
	    if($form->error!=1){
		    
			//unlink(UPLOADDIR."csv/".$form->elements['file']['value']);
			if(file_exists(UPLOADDIR.$form->elements['file']['value'])){
//			    $csv_data = csv_to_arr(UPLOADDIR."csv/".$_GET['file'], $_GET['separator']);
//			    
//			    if(){
//			    	
//			    }
				redirect("ajax.php?get={$_GET['content']}/actions/import&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&file=".urlencode($form->elements['file']['value'])."&separator={$form->elements['csv_separator']['value']}&encoding={$form->elements['file_encoding']['value']}&sep_title={$form->elements['csv_separator_title']['value']}");
			}else{
				$form->create_in_iframe = 1;
				$form->error = 1;
				$form->elements['file']['style'] = "error";
			}

	    }else{
	    	$_POST = $form->elements;
	    }
	}
	if(isset($_POST['action']) && $_POST['action']=='data'){

		$csv_data = csv_to_arr(UPLOADDIR.$_POST['file'], $_POST['separator'], $_POST['encoding'], $_POST['sep_title']);
		$record->insertListItems($csv_data['data'], $_GET['id']);
		unlink(UPLOADDIR.$_GET['file']);
		
		redirect("ajax.php?get={$_GET['content']}/actions/import&content={$_GET['content']}&module={$record->module_info['table_name']}&id={$_GET['id']}&import=success");
		
	}
	$lng = $_POST['language'];
}
  
echo "<div style='display:none;'>".$form->create_in_iframe."</div>";
//pa($form->elements);
$form_data = $form->construct_form();
$easy_tpl->setVar('form', $form_data);
$easy_tpl->setVar('form_name', $form->formName);


$easy_tpl->setVar('lng', $_SESSION['site_lng']);
$easy_tpl->setVar('module_name', $record->module_info['title']);


$easy_tpl->setVar('phrases', $cms_phrases);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('module', $record->module_info);


?>