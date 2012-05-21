<?php
/*
 * Created on 2008.02.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$xmlFile = DATADIR.'search.xml';

include_once(CLASSDIR."forms.class.php");
$form = new forms();

include_once(CLASSDIR."xmlini.class.php");
$arr2xml = new xmlIni($xmlFile);

$xml_arr = File::xmlFileToArray($xmlFile);

$form->addField('action', array('title'=>'', 'type'=>'hidden', 'value'=>'save'));
$form->addField('id', array('title'=>'', 'type'=>'hidden', 'value'=>'1'));
$form->addField('stat_day_visitors_paging_value', array('title'=>$cms_phrases['main']['stat']['stat_day_visitors_paging_value'], 'type'=>'text', 'value'=>$xml_arr['stat_day_visitors_paging_value'], 'editorship'=>1, 'require'=>1, 'function'=>"function||valid_number::admin_error_msg||Wrong number"));
$form->addField('hours_unique_visitor', array('title'=>$cms_phrases['main']['stat']['hours_unique_visitor'], 'type'=>'text', 'value'=>$xml_arr['hours_unique_visitor'], 'editorship'=>1, 'require'=>1, 'function'=>"function||valid_number::admin_error_msg||Wrong number"));
$form->addField('months_count_storing_stat', array('title'=>$cms_phrases['main']['stat']['months_count_storing_stat'], 'type'=>'text', 'value'=>$xml_arr['months_count_storing_stat'], 'editorship'=>1, 'require'=>1, 'function'=>"function||valid_number::admin_error_msg||Wrong number"));
$form->addField('days_detail_count_storing_stat', array('title'=>$cms_phrases['main']['stat']['days_detail_count_storing_stat'], 'type'=>'text', 'value'=>$xml_arr['days_detail_count_storing_stat'], 'editorship'=>1, 'require'=>1, 'function'=>"function||valid_number::admin_error_msg||Wrong number"));
$form->addField('max_stat_items', array('title'=>$cms_phrases['main']['stat']['max_stat_items'], 'type'=>'text', 'value'=>$xml_arr['max_stat_items'], 'editorship'=>1, 'require'=>1, 'function'=>"function||valid_number::admin_error_msg||Wrong number"));


//$form->addField('conversion_list', array('title'=>$cms_phrases['main']['stat']['conversion_goals_list'], 'column_name'=>"conversion_list", 'module_id'=>116, 'type'=>FRM_LIST, 'value'=>'1', 'editorship'=>1, 'require'=>0, 'list_values'=>array("source"=>"DB","module"=>"conversion","get_category"=>"category_id","get_column_name"=>"category_column","create_category_parent_id"=>"0")));

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
			redirect("main.php?content={$_GET['content']}&page={$_GET['page']}");
		}
		
	}
}

$tpl->setVar('form', $form->construct_form());

include_once(dirname(__FILE__)."/menu.php"); 

?>