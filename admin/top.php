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
$tpl_main = & new easytpl("templates/top.tpl", "templateVariables");

include_once(CLASSDIR."module.class.php");
include_once(CLASSDIR."object.class.php");

$module = new module();
$main_object = new object();


$main_object->call("admins", "registerLastAdminTime");


if(isset($_GET['lng'])){
	$_SESSION['site_lng'] = $_GET['lng'];
	$tpl_main->setVar('content_reload', 1);
}

if(!isset($_SESSION['site_lng'])){
	$_SESSION['site_lng'] = $configFile->variable['default_lng'];
}

$tpl_main->setVar('lng', $_SESSION['site_lng']);

$tpl_main->setVar('admin', $_SESSION['admin']);
$tpl_main->setVar('is_super_admin_prm', $_SESSION['admin']['permission']==1?1:0);

foreach($configFile->variable['default_page'] as $key=>$val){
	$row['lng'] = $key;
	$arr[] = $row;
}

$tpl_main->setVar('config', $configFile->variable);

$modules_list = $module->listModules();
$tpl_main->setLoop('module_list', $modules_list);

$tpl_main->setVar('zend_optimizer', zend_version());

$tpl_main->setVar('admin_interface_language', $_SESSION['admin_interface_language']);
$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$tpl_main->setVar('phrases', $cms_phrases['top']);

include $tpl_main->parse();
ob_end_flush();

?>