<?php

$xmlFile = DATADIR.'search.xml';

include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->debug = 0;

include_once(CLASSDIR."xmlini.class.php");
$arr2xml = new xmlIni($xmlFile);

//include_once(CLASSDIR."xmlfile.class.php");
$xml_arr = File::xmlFileToArray($xmlFile);
//pa($arr);
$form->addField('action', array('title'=>'', 'type'=>'hidden', 'value'=>'save'));
//$form->addField('title', array('title'=>$cms_phrases['main']['settings']['website_title'], 'type'=>'text', 'value'=>$xml_arr['title'][$_SESSION['site_lng']], 'editorship'=>1));

$form->addField('toggler', array('title'=>$cms_phrases['main']['settings']['site_enabled_checkbox'], 'type'=>FRM_CHECKBOX, 'value'=>$xml_arr['toggler'], 'editorship'=>1));
$form->addField('underconstruction', array('title'=>$cms_phrases['main']['settings']['site_underconstruction'], 'type'=>FRM_HTML, 'value'=>$xml_arr['underconstruction'], 'editorship'=>1));

$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] == 'save'){
		$form->validate($_POST);
		$arr = null;
		foreach($form->elements as $key=>$val){
			$arr[$key] = $_POST[$key];
		}

		foreach($arr as $k=>$v){
			$xml_arr[$k] = $arr[$k];
		}
		
		$xml = $arr2xml->arrayToXml($xml_arr);
		$file = fopen($xmlFile, "w");
		fwrite($file, $xml);
		//redirect("main.php?content=settings");
	}
}


if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
	header("Content-Type: text/html; charset=utf-8");
	if($form->error!=1){
		echo "<script type=\"text/javascript\"> top.content.PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&page=toggle&area=tpl&ajax=1&tree_reload=1', 'inner_content'); </script>";
		exit;
	}else{
		$form_data = $form->construct_form();
		echo $form_data;
		exit;
	}
}else{
	$form_data = $form->construct_form();
}

$tpl->setVar('form', $form_data);


include_once(dirname(__FILE__)."/menu.php");

?>