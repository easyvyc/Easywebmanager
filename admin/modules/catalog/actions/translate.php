<?php
/*
 * Created on 2008.11.14
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if ( !function_exists('json_decode') ){
    function json_decode($content, $assoc=false){
                require_once CLASSDIR.'PEAR/JSON.php';
                if ( $assoc ){
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
                    $json = new Services_JSON;
                }
        return $json->decode($content);
    }
}

function getTranslate($value, $lng_from, $lng_to){
	
	global $configFile;
	
	//echo "http://ajax.googleapis.com/ajax/services/language/translate?q=".$value."&v=1.0&langpair=$lng_from|$lng_to";
	
	if(mb_strlen($value, "UTF-8")>5000) return array('value'=>$value, 'edited'=>0);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/language/translate?q=".urlencode($value)."&v=1.0&langpair=$lng_from|$lng_to");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_REFERER, $configFile->variable['site_url']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($ch);
	curl_close($ch);
	
	$data = json_decode($content);
	
	if($data->responseData->translatedText){
		return array('value'=>$data->responseData->translatedText, 'edited'=>1);
	}	
	else return array('value'=>$value, 'edited'=>0);
	
}


if(!isset($_GET['id'])) $_GET['id'] = 0;
if(!isset($_GET['parent_id'])) $_GET['parent_id'] = 0;


$record = $pages_obj = $main_object->create($_GET['module']);


$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/translate.tpl");

include_once(CLASSDIR."forms.class.php");

$form_translate = new forms();
$form_translate->debug=0;
$form_translate->formName = "translate";

$lang_tr_arr = $record->getItemLangStatus($_GET['id']);

$lang_val = array();
foreach($record->config->variable['default_page'] as $key=>$val){
	
	$lng_from_active = (isset($_GET['lng_from'])?$_GET['lng_from']:$record->config->variable['default_lng']);
	$lng_to_active = (isset($_GET['lng_to'])?$_GET['lng_to']:'');
	$lang_val_from[] = array('title'=>strtoupper($key), 'value'=>$key, 'checked'=>($key==$lng_from_active), 'readonly'=>($lang_tr_arr[$key]['disabled']?0:1));
	$lang_val_to[] = array('title'=>strtoupper($key), 'value'=>$key, 'checked'=>($key==$lng_to_active), 'readonly'=>($lang_tr_arr[$key]['disabled']?1:0));
	
}

$form_translate->addField("lng_from", array('type'=>FRM_RADIO, 'title'=>$cms_phrases['main']['catalog']['language_translate_from'], 'list_values'=>$lang_val_from, 'editorship'=>1, 'require'=>1));
$form_translate->addField("lng_to", array('type'=>FRM_RADIO, 'title'=>$cms_phrases['main']['catalog']['language_translate_to'], 'list_values'=>$lang_val_to, 'editorship'=>1, 'require'=>1));

$form_translate->addField("action", array('type'=>FRM_HIDDEN, 'value'=>'translate'));
$form_translate->addField("translate", array('type'=>FRM_HIDDEN, 'value'=>1));
$form_translate->addField("submit", array('type'=>FRM_BUTTON, 'title'=>$cms_phrases['main']['catalog']['language_translate_submit'], 'onclick'=>"this.form.submit();"));

$form_translate->formAction = "ajax.php?get={$_GET['content']}/actions/translate&content={$_GET['content']}&module={$pages_obj->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['parent_id']}&new=1".($_GET['filters']?"&filters={$_GET['filters']}":"");

if(!empty($_POST)){
	
	if(isset($_POST['action']) && $_POST['action']=='translate' && $denied_save!=1){
	    
	    $form_translate->validate($_POST);
	    
	    if($form_translate->error!=1){
		    
		    if(strlen($_GET['filters'])){
				$_POST[$_SESSION['filter_item'][$_GET['filters']]['get_category']['column_name']] = $_SESSION['filter_item'][$_GET['filters']]['get_category']['value'];
				$_POST[$_SESSION['filter_item'][$_GET['filters']]['get_column_name']['column_name']] = $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value'];
			}
		    
	    }
	    
	}
}


if($form_translate->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
	header("Content-Type: text/html; charset=utf-8");
	if($form_translate->error!=1){
		$easy_tpl->setVar('success', 1);
	}else{
		$form_data = $form_translate->construct_form();
	}
}else{
	$form_data = $form_translate->construct_form();
}

echo "<div style='display:none'>$form_translate->create_in_iframe</div>";
//echo $form_data; exit;

$easy_tpl->setVar('translate_form', $form_data);




$form = new forms();
$form->debug=0;


if($record->module_info['maxlevel']==0 && $_GET['new']==1) $_GET['parent_id'] = 0;
if(($_GET['page']=='filters' || strlen($_GET['filters'])) && $_GET['new']==1) $_GET['parent_id'] = $_SESSION[$_GET['filters']]['filter']['category_id'];


$language_to = $_SESSION['site_lng'];
if($_GET['lng_from'] && $_GET['lng_to']){
	$record->language = $_GET['lng_from'];
	$language_to = $_GET['lng_to'];
}

$item_data = $record->loadItem($_GET['id'], $_GET['parent_id']);

$EDIT_FORM = true;	

/*if($record->module_info['multilng']==1 && count($record->config->variable['default_page'])>1){
	$lang_saved_arr = $record->getItemLangStatus($_GET['id']);
	//pae($lang_saved_arr);
	$lang_val = array();
	foreach($record->config->variable['default_page'] as $key=>$val){
		if($key!=$_SESSION['site_lng']) $lang_val[] = array('title'=>strtoupper($key), 'value'=>$key, 'checked'=>$lang_saved_arr[$key]['checked'], 'readonly'=>$lang_saved_arr[$key]['disabled']);
	}
	$form->addField("language_actions", array('type'=>FRM_CHECKBOX_GROUP, 'title'=>$cms_phrases['main']['catalog']['language_action_with_item'], 'list_values'=>$lang_val));
}*/

$form->addField("parent_id", array('type'=>'hidden', 'value'=>($item_data['isNew']==0?$item_data['parent_id']:$_GET['parent_id'])));


$n = count($record->table_fields);
for($i=0; $i<$n; $i++){
   $form->addField($record->table_fields[$i]['column_name'], $record->table_fields[$i]);
}


$m = count($record->table_fields);
for($j=0; $j<$m; $j++){
    $record->table_fields[$j]['value'] = ($item_data['isNew']==1 && !isset($_GET['duplicate']))?$form->elements[$record->table_fields[$j]['column_name']]['default_value']:$item_data[$record->table_fields[$j]['column_name']];
    
    if($record->table_fields[$j]['multilng']==1 && isset($_GET['lng_from']) && isset($_GET['lng_to'])){
    	if(in_array($record->table_fields[$j]['elm_type'], array(FRM_TEXT, FRM_TEXTAREA, FRM_HTML))){
    		$arr = array();
    		$arr = getTranslate($record->table_fields[$j]['value'], $_GET['lng_from'], $_GET['lng_to']);
    		$record->table_fields[$j]['value'] = $arr['value'];
    		$record->table_fields[$j]['edited'] = $arr['edited'];
    	}
    }
    
  	$record->table_fields[$j]['name'] = $record->table_fields[$j]['column_name'];
  	
  	$form->editField($record->table_fields[$j]['column_name'], $record->table_fields[$j]);
}

//pae($record->table_fields);

/*
if($item_data['isNew']!=1){
	$easy_tpl->setVar('record_author_create', $record->loadItemAuthor($item_data['create_by_admin']));
	$easy_tpl->setVar('record_author_modify', $record->loadItemAuthor($item_data['last_modif_by_admin']));
}
*/

/*if(strlen($item_data['title'])==0){
	$form->editField("title", array("value"=>$_PAGE_DATA['title'], 'edited'=>1));
}*/
	
$form->formHTML = $record->module_info['area_html'];

$record_data = $item_data;

if(!empty($_POST)){
	
	if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
	    
	    $form->validate($_POST);
	    
	    if($form->error!=1){
		    
		    if(strlen($_GET['filters'])){
			    //pa($_GET);
			    //pae($_SESSION['filter_item'])
				$_POST[$_SESSION['filter_item'][$_GET['filters']]['get_category']['column_name']] = $_SESSION['filter_item'][$_GET['filters']]['get_category']['value'];
				$_POST[$_SESSION['filter_item'][$_GET['filters']]['get_column_name']['column_name']] = $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value'];
			}
		    
		    $record->language = $language_to;
		    
		    $rid = $record->saveItem($_POST);
		    
		    $item_data['id'] = $rid;
		    
		    $easy_tpl->setVar('success', 1);
		    
	    }else{
	    	$_POST = $form->elements;
	    }
	    
	}
	$lng = $_POST['language'];
}
  

$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');


$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
$form->addField("id", array('type'=>'hidden', 'value'=>$record_data['id']));
$form->addField("isNew", array('type'=>'hidden', 'value'=>$record_data['isNew']));
$form->addField("language", array('type'=>'hidden', 'value'=>$language_to));
$form->addField("is_category", array('type'=>'hidden', 'value'=>$ce));

$form->formAction = "ajax.php?get={$_GET['content']}/actions/translate&content={$_GET['content']}&module={$pages_obj->module_info['table_name']}&id={$_GET['id']}&parent_id={$_GET['id']}&new=0&lng_from={$_GET['lng_from']}&lng_to={$_GET['lng_to']}".($_GET['filters']?"&filters={$_GET['filters']}":"");

if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
	header("Content-Type: text/html; charset=utf-8");
	if($form->error!=1){
		$easy_tpl->setVar('success', 1);
	}else{
		$form_data = $form->construct_form();
	}
}else{
	$form_data = $form->construct_form();
}

echo "<div style='display:none'>$form->create_in_iframe</div>";
//echo $form_data; exit;

$easy_tpl->setVar('form', $form_data);
	

$easy_tpl->setVar('data', $item_data);

$easy_tpl->setVar('config', $configFile->variable);
$easy_tpl->setVar('get', $_GET);
$easy_tpl->setVar('post', $_POST);
$easy_tpl->setVar('module', $pages_obj->module_info);
$easy_tpl->setVar('phrases', $cms_phrases['main']);
$easy_tpl->setVar('form_name', $form->formName);


?>
