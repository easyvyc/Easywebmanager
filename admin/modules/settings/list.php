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

$arr = array();
foreach($configFile->variable['default_page'] as $key => $val){
	$arr['id'] = $val;
	$arr['title'] = strtoupper($key);
	$arr['value'] = $key;
	$arr['checked'] = $xml_arr['languages'][$key];
	$lang_arr[] = $arr;
	if($xml_arr['languages'][$key]==1)
		$lang_arr_values[] = $arr['id'];
}

$form->addField('languages', array('title'=>$cms_phrases['main']['settings']['website_languages'], 'type'=>'checkbox_group', 'value'=>$lang_arr_values, 'list_values'=>$lang_arr, 'editorship'=>1));


$form->addField('website_title', array('title'=>$cms_phrases['main']['settings']['website_title'], 'type'=>'text', 'value'=>$xml_arr['website_title'], 'editorship'=>1));

$form->addField('google', array('title'=>$cms_phrases['main']['settings']['google_analytics'], 'type'=>'textarea', 'value'=>$xml_arr['google'], 'editorship'=>1, 'html'=>1));

$form->addField('keywords', array('title'=>$cms_phrases['main']['settings']['page_keywords_title'], 'type'=>'textarea', 'value'=>$xml_arr['keywords'], 'editorship'=>1));


$form->addField('lng_in_url', array('title'=>$cms_phrases['main']['settings']['lng_in_url'], 'type'=>FRM_CHECKBOX, 'value'=>$xml_arr['lng_in_url'], 'editorship'=>1));

/*$arr['value'] = 1;
$arr['title'] = $cms_phrases['main']['settings']['diferent_title_foreach_page'];
$string_values[] = $arr;
$arr['value'] = 2;
$arr['title'] = $cms_phrases['main']['settings']['combined_website_title'];
$string_values[] = $arr;
$arr['value'] = 3;
$arr['title'] = $cms_phrases['main']['settings']['one_title_foreach_page'];
$string_values[] = $arr;
*/
//$form->addField('combo_title', array('title'=>$cms_phrases['main']['settings']['website_title_type'], 'type'=>'select', 'value'=>$xml_arr['combo_title'], 'list_values'=>$string_values, 'selected'=>$arr['combo_title'], 'editorship'=>1));

$form->addField('website_email', array('title'=>$cms_phrases['main']['settings']['website_email_title'], 'type'=>'text', 'value'=>$xml_arr['website_email'], 'editorship'=>1));
$form->addField('google_map_code', array('title'=>"<a href='http://code.google.com/apis/maps/signup.html' target='_blank'>".$cms_phrases['main']['settings']['google_map_code']." <img src='images/search.gif' class='vam' alt='' /></a>", 'type'=>'text', 'value'=>$xml_arr['google_map_code'], 'editorship'=>1));
$form->addField('googlemaps_centerlat', array('title'=>$cms_phrases['main']['settings']['GoogleMaps_CenterLat'], 'type'=>'text', 'value'=>$xml_arr['googlemaps_centerlat'], 'editorship'=>1));
$form->addField('googlemaps_centerlon', array('title'=>$cms_phrases['main']['settings']['GoogleMaps_CenterLon'], 'type'=>'text', 'value'=>$xml_arr['googlemaps_centerlon'], 'editorship'=>1));
$form->addField('googlemaps_zoom', array('title'=>$cms_phrases['main']['settings']['GoogleMaps_Zoom'], 'type'=>'text', 'value'=>$xml_arr['googlemaps_zoom'], 'editorship'=>1));

//$form->addField('show_friendly_url', array('title'=>$cms_phrases['main']['settings']['show_friendly_url'], 'type'=>'checkbox', 'value'=>$xml_arr['show_friendly_url']=='1'?'1':'', 'editorship'=>1));
//$form->addField('generate_url', array('title'=>$cms_phrases['main']['settings']['generate_url'], 'type'=>'checkbox', 'value'=>$xml_arr['generate_url']=='1'?'1':'', 'editorship'=>1));



$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] == 'save'){
		$form->validate($_POST);
		$arr = null;
		foreach($form->elements as $key=>$val){
			$arr[$key] = $_POST[$key];
		}
		//pa($xml_arr);
		$arr['title'] = $xml_arr['title'];
		$arr['title'][$_SESSION['site_lng']] = $_POST['title'];

		$arr['page_keywords'] = $xml_arr['page_keywords'];
		$arr['page_keywords'][$_SESSION['site_lng']] = $_POST['page_keywords'];
		
		$languages_tmp = explode("::", $_POST['languages']);
		unset($arr['languages']);
		foreach($configFile->variable['default_page'] as $key => $val){
			$arr['languages'][$key] = (in_array($key, $languages_tmp)?1:0);
		}
		
		foreach($arr as $k=>$v){
			$xml_arr[$k] = $arr[$k];
		}
		
		$xml_arr['lng_in_url'] = ($_POST['lng_in_url']==1?1:0);
		
		$xml = $arr2xml->arrayToXml($xml_arr);
		$file = fopen($xmlFile, "w");
		fwrite($file, $xml);
		//redirect("main.php?content=settings");
	}
}


if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
	header("Content-Type: text/html; charset=utf-8");
	if($form->error!=1){
		echo "<script type=\"text/javascript\"> top.content.PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&area=tpl&ajax=1&tree_reload=1', 'inner_content'); </script>";
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