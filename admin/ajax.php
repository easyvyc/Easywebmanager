<?php
/*
 * Created on 2007.07.13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


ob_start();
session_start();
#session_regenerate_id();
header("Content-Type: text/html; charset=utf-8");
header("Cache-control: private");

//unset($_SESSION['admin']);
include_once ('../inc/config.inc.php');
$time_start = getmicrotime();

//error_reporting(E_ALL);

// If admin session not set, check for post data and restart session or logout
if(!isset($_SESSION["admin"]["id"])){
	if(isset($_POST['action']) && ($_POST['action']=='save' || $_POST['action']=='main_info')){
    	echo "<script type=\"text/javascript\">top.content.showLoginForm();</script>"; exit;
    }else{
    	redirect("login.php");
    }
}

if($_SESSION['admin']['user_agent']!=$_SERVER['HTTP_USER_AGENT'] || $_SESSION['admin']['user_ip']!=$_SERVER['REMOTE_ADDR']){
	unset($_SESSION['admin']);
	redirect("login.php");
}

include_once(CLASSDIR."easytpl.class.php");
$easy_tpl = new easytpl("", "templateVariables");

include_once(CLASSDIR."object.class.php");

$main_object = & new object();

include_once(CLASSDIR."module.class.php");
$module = new module();

if(isset($_GET['module'])){
	$mod_data = $module->loadModuleByTablename($_GET['module']);
}

include_once(LANGUAGESDIR.$_SESSION['admin_interface_language'].".php");

include_once(MODULESDIR.$_GET['get'].".php");


if($easy_tpl->file!="") include $easy_tpl->parse();

ob_end_flush()

?>