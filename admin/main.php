<?php

ob_start();
session_start();
#session_regenerate_id();
header("Cache-control: private");
header("Content-Type: text/html; charset=utf-8");

// Config
include_once ('../inc/config.inc.php');
$time_start = getmicrotime();
//error_reporting(E_ALL);
// Logout, unset admin session
if(isset($_GET['logout'])&&$_GET['logout']==1){
	unset($_SESSION['admin']);
	unset($_SESSION['site_lng']);
}

// If admin session not set, check for post data and restart session or logout
if(!isset($_SESSION["admin"]["id"])){
	if(isset($_POST['action']) && ($_POST['action']=='save' || $_POST['action']=='main_info')){
    	$RESTART_SESSION = 1;
    }else{
    	redirect("login.php");
    }
}

if($_SESSION['admin']['user_agent']!=$_SERVER['HTTP_USER_AGENT'] || $_SESSION['admin']['user_ip']!=$_SERVER['REMOTE_ADDR']){
	unset($_SESSION['admin']);
	redirect("login.php");
}

if(!in_array($_GET['content'], array('settings', 'stat', 'update', 'trash', 'mod', 'filemanager', 'search')) && strlen($_GET['module'])==0){
	redirect("main.php?content=stat");
}


$lng = $_SESSION['site_lng'];
// If open window for filters, set temporary current language
if(isset($_GET['filter_lang'])){
	$TMP_VARS['site_lng'] = $_SESSION['site_lng'];
	$_SESSION['site_lng'] = $_GET['filter_lang'];
}

$onload_page = "";

include_once(CLASSDIR."easytpl.class.php");
include_once(CLASSDIR."module.class.php");
include_once(CLASSDIR."object.class.php");

$module = new module();
$main_object = new object();

$main_object->call("admins", "registerLastAdminTime");
//$admin_obj->modules_rights = $main_object->call("admins", "loadModuleRights", array($_SESSION['admin']['id']));

$tpl_main = & new easytpl("templates/main.tpl", "templateVariables");


$module_name = $_GET['content'];

if(isset($_GET['lng'])){
	$tpl_main->setVar('refresh_tree', 1);
	$_SESSION['site_lng'] = $_GET['lng'];
} 


// Load cms languages for current admin
foreach($main_configFile->variable['default_page'] as $key=>$val){
	$row['lng'] = $key;
	$arr[] = $row;
}
$lng_rights = $main_object->call("admins", "loadLanguageRights", array($_SESSION['admin']['id']));
for($i=0; $i<count($arr); $i++){
	$arr[$i]['first'] = $i==0?'first':'';
	$arr[$i]['active'] = $_SESSION['site_lng']==$arr[$i]['lng']?'active':'';
	if(!in_array($arr[$i]['lng'], $lng_rights)){
		$n_arr[] = $arr[$i];
	}	
}
$tpl_main->setLoop('languages', $n_arr);


if(!isset($_GET['page'])){
	$_GET['page'] = "list";
} 

$tpl_main->setVar('phrases', $cms_phrases['main']);

// Including and parsing module 
$template_name = MODULESDIR.$module_name."/templates/".(isset($_GET['tpl'])?$_GET['tpl']:$_GET['page']).".tpl";
$script_name = MODULESDIR.$module_name."/".$_GET['page'].".php";
$tpl = & new easytpl($template_name, "templateVariables");
require($script_name);
//pae($_GET);
if(isset($_GET['ajax']) && $_GET['ajax']==1 && isset($_GET['area'])){
	$area = $_GET['area'];
	include $$area->parse();
	exit;
}
$tpl->parse();
$tpl_main->setCodeBlock('inner_content', 'include $tpl->cacheFile;');


// If module is from standart easywebmanager module list, check admin rights
if(is_object($main_object->obj[$_GET['module']])){
	// Check admin permission to module and module category
	if(is_numeric($_GET['id'])/* && $_GET['id']!=0*/){
		if($main_object->obj[$_GET['module']]->loadAdminRights($_SESSION['admin']['id'], $_GET['id'])==0) 
			$tpl_main->setVar('no_permission_block', 1);
	}
	// Check admin permission to module and module parent category, when creating new item	
	if($_GET['isNew']==1 && isset($_GET['parent_id']) && is_numeric($_GET['parent_id']) && $_GET['parent_id']!=0){
		if($main_object->obj[$_GET['module']]->loadAdminRights($_SESSION['admin']['id'], $_GET['parent_id'])==0)
			$tpl_main->setVar('no_permission_block', 1);
	}
	//
	/*if(is_numeric($_GET['id']) && $_GET['id']==0){
		if($main_object->obj[$_GET['module']]->loadAdminRights($_SESSION['admin']['id'], 0)==0) 
			$tpl_main->setVar('no_permission_block', 1);
	}*/
}
/*// Check admin rights for module
if(isset($_GET['module'])){
	$mod_data = $module->loadModuleByTablename($_GET['module']);
	if(in_array($mod_data['id'], $admin_obj->modules_rights) && is_numeric($mod_data['id'])){
		$tpl_main->setVar('no_permission_block', 1);
	}
}*/

// If module is not in standart easywebmanager modules list
if($module_name=='settings'){
	if($_GET['page']=='trash' || $_GET['page']=='trash_item')
		$tpl_main->setVar('module.title', $cms_phrases['top']['trash_alt']);
	else
		$tpl_main->setVar('module.title', $cms_phrases['top']['settings_alt']);
}
if($module_name=='stat'){
	$tpl_main->setVar('module.title', $cms_phrases['top']['stat_alt']);
	$tpl_main->setVar('show_video_help', "http://manual.easywebmanager.com/files/video/stat.flv");
}
if($module_name=='update'){
	$tpl_main->setVar('module.title', $cms_phrases['top']['update_alt']);
}


$tpl_main->setVar('onload', $onload_page);
$tpl_main->setVar('admin', $_SESSION['admin']);
$tpl_main->setVar('get', $_GET);
$tpl_main->setVar('lng', $_SESSION['site_lng']);
$tpl_main->setVar('config', $configFile->variable);
$tpl_main->setVar('upload_url', UPLOADURL);
$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$tpl_main->setVar('phrases', $cms_phrases['main']);
$tpl_main->setVar('restart_session', $RESTART_SESSION);

$arr = explode("&", $_SERVER['QUERY_STRING']);
foreach($arr as $key=>$val){
	$arr1 = explode("=", $val);
	if($arr1[0]!='filter_lang')
		$QUERY_STRING_ARR[] = $val;
}
$tpl_main->setVar('QUERY_STRING', implode("&", $QUERY_STRING_ARR));

// If form fields not valide, set is_edited_element value to true for confirm dialog window when admin close or navigate out form that form
if(is_object($form)){
	if($form->error == 1){
		$tpl_main->setVar('is_edited_element', 1);
	}
}

if(isset($_GET['filter_lang'])){
	$_SESSION['site_lng'] = $TMP_VARS['site_lng'];
}

include $tpl_main->parse();

$time_end = getmicrotime();
//echo "<p><b>".($time_end - $time_start)."</b></p>";

ob_end_flush();

?>