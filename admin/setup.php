<?php
/*
 * Created on 2008.01.28
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


ob_start();
session_start();
#session_regenerate_id();
header("Cache-control: private");
header("Content-Type: text/html; charset=utf-8");


if(!isset($_SESSION["admin"]["id"])){
	redirect("login.php");
}

if($_SESSION['admin']['user_agent']!=$_SERVER['HTTP_USER_AGENT'] || $_SESSION['admin']['user_ip']!=$_SERVER['REMOTE_ADDR']){
	unset($_SESSION['admin']);
	redirect("login.php");
}

if($_SESSION['admin']['permission']!=1){
	exit;
}

include_once ('../inc/config.inc.php');

ini_set('max_execution_time', 0);

include_once(CLASSDIR."easytpl.class.php");
$tpl_main = & new easytpl("templates/setup.tpl", "templateVariables");


$_GET['page'] = (isset($_GET['page']) && strlen($_GET['page'])>0)?$_GET['page']:"ftp";
$template_name = MODULESDIR."setup/templates/".(isset($_GET['tpl'])?$_GET['tpl']:$_GET['page']).".tpl";
$script_name = MODULESDIR."setup/".$_GET['page'].".php";

$tpl = & new easytpl($template_name, "templateVariables");

require($script_name);

$tpl->parse();
$tpl_main->setCodeBlock('inner_content', 'include $tpl->cacheFile;');


$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$tpl_main->setVar('phrases', $cms_phrases['update']);

$time_end = getmicrotime();
//echo "<p><b>".($time_end - $time_start)."</b></p>";

include $tpl_main->parse();
//pa($client->debug_str);
ob_end_flush();

?>