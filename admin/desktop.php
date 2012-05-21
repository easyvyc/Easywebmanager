<?php
/*
 * Created on 2008.08.11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


ob_start();
session_start();
#session_regenerate_id();
header("Cache-control: private");
header("Content-Type: text/html; charset=utf-8");

// Config
include_once ('../inc/config.inc.php');
$time_start = getmicrotime();

// Logout, unset admin session
if(isset($_GET['logout'])&&$_GET['logout']==1){
	unset($_SESSION['admin']);
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

$main_object->call("admins", "registerLastAdminTime");
$admin_obj->modules_rights = $main_object->call("admins", "loadModuleRights", array($_SESSION['admin']['id']));;


$tpl_main = & new easytpl("templates/desktop.tpl", "templateVariables");

$tpl_main->setVar('phrases', $cms_phrases['desktop']);


$tpl_main->setVar('onload', $onload_page);
$tpl_main->setVar('admin', $_SESSION['admin']);
$tpl_main->setVar('get', $_GET);
$tpl_main->setVar('lng', $_SESSION['site_lng']);
$tpl_main->setVar('config', $configFile->variable);
$tpl_main->setVar('upload_url', UPLOADURL);
$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$tpl_main->setVar('phrases', $cms_phrases['main']);
$tpl_main->setVar('restart_session', $RESTART_SESSION);

include $tpl_main->parse();

$time_end = getmicrotime();
//echo "<p><b>".($time_end - $time_start)."</b></p>";

ob_end_flush();

?>