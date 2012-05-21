<?php

$xmlFile = DATADIR.'search.xml';

include_once(CLASSDIR."forms.class.php");
$form = new forms();

include_once(CLASSDIR."xmlini.class.php");
$arr2xml = new xmlIni($xmlFile);

//include_once(CLASSDIR."xmlfile.class.php");
$xml_arr = File::xmlFileToArray($xmlFile);
//pa($arr);
$form->addField('action', array('title'=>'', 'type'=>'hidden', 'value'=>'save'));
$form->addField('max_trash_items', array('title'=>$cms_phrases['main']['settings']['max_trash_items'], 'type'=>'text', 'value'=>$xml_arr['max_trash_items'], 'editorship'=>1, 'require'=>1, 'function'=>"function||valid_number::admin_error_msg||Wrong number"));


$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] == 'save'){
		
		$form->validate($_POST);
		
		if($form->error != 1){
			foreach($form->elements as $key=>$val){
				$xml_arr[$key] = $_POST[$key];
			}
	
			$xml = $arr2xml->arrayToXml($xml_arr);
			$file = fopen($xmlFile, "w");
			fwrite($file, $xml);
			redirect("main.php?content=trash&page=settings");
		}
		
	}
}

$tpl->setVar('form', $form->construct_form());

$tpl->setVar('module.title', $cms_phrases['top']['trash']);

include_once(dirname(__FILE__)."/menu.php");

?>