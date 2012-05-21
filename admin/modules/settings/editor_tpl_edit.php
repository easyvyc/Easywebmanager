<?php
/*
 * Created on 2005.9.21
 *
 * VB
 * editor_tpl_edit.php
 */

$xmlFile = FCKDIR.'fcktemplates.xml';

include_once(CLASSDIR."xmlini.class.php");
$arr2xml = new xmlIni($xmlFile);

include_once(CLASSDIR."forms.class.php");
$form = new forms();

$form->imgDir = FCKDIR."editor/dialog/fck_template/images/";
$form->imgUrl = $configFile->variable['site_url'].$configFile->variable['admin_dir']."fcked/editor/dialog/fck_template/images/";
$form->img->path = FCKDIR."editor/dialog/fck_template/images/";

$xmlNodeEdit = $arr2xml->xmlTree->children[($_GET['id']-1)];

if(isset($_GET['id']) && $_GET['id']!=0){
    $data['isNew'] = 0;
}else{
    $data['isNew'] = 1;
}
$data['id'] = $_GET['id'];

$form->addField('action', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>"save"));
$form->addField('id', 			array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$data['id']));
$form->addField('isNew', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$data['isNew']));

$form->addField('title', 		array('title'=>$cms_phrases['main']['settings']['template_name'], 'require'=>1, 'type'=>'text', 'value'=>trim($xmlNodeEdit->attributes['title']), 'editorship'=>1));
$form->addField('image', 		array('title'=>$cms_phrases['main']['settings']['template_image'], 'require'=>1, 'type'=>'image', 'value'=>$xmlNodeEdit->attributes['image'], 'editorship'=>1, 'extra_params'=>'prefix||size=100x100||quality=90'));
$form->addField('description', 	array('title'=>$cms_phrases['main']['settings']['template_description'], 'require'=>0, 'type'=>'textarea', 'value'=>trim($xmlNodeEdit->children[0]->content), 'editorship'=>1));
$form->addField('template', 	array('title'=>$cms_phrases['main']['settings']['template_html'], 'require'=>0, 'type'=>'html', 'value'=>trim($xmlNodeEdit->children[1]->content), 'editorship'=>1));

$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if(isset($_POST['action'])&&$_POST['action']=='save'){
	
	$form->validate($_POST);
	if($form->error!=1){
		$xmlNodeEdit->attributes['title'] = $_POST['title'];
		$xmlNodeEdit->attributes['image'] = $_POST['image'];
		$xmlNodeEdit->children[0]->content = $_POST['description'];
		$xmlNodeEdit->children[1]->content = $_POST['template'];
		//pae($xmlNodeEdit); 
		if($_POST['isNew']==1){
			$xmlNodeEdit->name = "Template";
			$xmlNodeEdit->children[0]->name = "Description";
			$xmlNodeEdit->children[1]->name = "Html";
			$arr2xml->xmlTree->children[] = $xmlNodeEdit;
		}else{
			$arr2xml->xmlTree->children[($_POST['id']-1)] = $xmlNodeEdit;
		}
		
		//pae($arr2xml->xmlTree);
		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
		$file = fopen($xmlFile, "w");
		fwrite($file, $xml);
		fclose($file);	
		redirect("main.php?content=settings&page=editor_tpl_list");
	}
}

$tpl->setVar('form', $form->construct_form('save'));

include_once(dirname(__FILE__)."/menu.php");
 
?>
