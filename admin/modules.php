<?php

ob_start();
session_start();
#session_regenerate_id();
header("Cache-control: private");
header("Content-Type: text/html; charset=utf-8");

include_once ('../inc/config.inc.php');

if(!isset($_SESSION["admin"]["id"])){
	redirect("login.php");
}

if($_SESSION['admin']['user_agent']!=$_SERVER['HTTP_USER_AGENT'] || $_SESSION['admin']['user_ip']!=$_SERVER['REMOTE_ADDR']){
	unset($_SESSION['admin']);
	redirect("login.php");
}

include_once(CLASSDIR."easytpl.class.php");
include_once(CLASSDIR."module.class.php");
include_once(CLASSDIR."object.class.php");

$module = new module();

$main_object = new object();

$tpl_main = & new easytpl("templates/modules.tpl", "templateVariables");

$main_object->call("admins", "registerLastAdminTime");
$admin_obj->modules_rights = $main_object->call("admins", "loadModuleRights", array($_SESSION['admin']['id']));


//if(@$_SESSION['easy']['content'] != @$_GET['content'] || isset($_GET['module'])) 	$redirect_main_frame = true;
//else																				$redirect_main_frame = false;


if(!isset($_SESSION['site_lng'])) $_SESSION['site_lng'] = $configFile->variable['default_lng'];

foreach($configFile->variable['default_page'] as $key=>$val){
	$row['title'] = strtoupper($key);
	$row['value'] = $key;
	$languages[] = $row;
	if($_SESSION['site_lng']==$key){
		$main_page_id = $val;
	}
}


$tpl_main->setVar('site_url', $configFile->variable['pr_url']);


$modules_list = $module->listModules();
for($i=0; $i<count($modules_list); $i++){
	
	if($modules_list[$i]['table_name'] == @$_SESSION['easy']['module'])
		$modules_list[$i]['active'] = 1;
	else
		$modules_list[$i]['active'] = 0;

	$modules_list[$i]['is_categories'] = ($modules_list[$i]['maxlevel']>0 && $modules_list[$i]['category']==1 ?1:0);

	if(!in_array($modules_list[$i]['id'], $main_object->obj['admins']->modules_rights) && $modules_list[$i]['disabled']!=1){
		$modules_list_all[] = $modules_list[$i];		
	}
	
}
$tpl_main->setLoop('mod_list_tree', $modules_list_all);

$tpl_main->setVar('is_modules', (count($modules_list)>0?1:0));

// If super admin
$tpl_main->setVar('is_admin_prm', ($_SESSION['admin']['permission'])==1?1:0);


if(isset($_GET['content'])&&$redirect_main_frame){
	$tpl_main->setVar('main_reload', 1);
}

$tpl_main->setVar('lng', $_SESSION['site_lng']);
$tpl_main->setVar('config', $configFile->variable);

$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$tpl_main->setVar('phrases', $cms_phrases['modules']);

include $tpl_main->parse();
ob_end_flush();

?>