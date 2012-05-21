<?php
/*
 * Created on 2006.9.13
 * update.php
 * Vytautas
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

include_once ('../inc/config.inc.php');

ini_set('max_execution_time', 0);

include_once(CLASSDIR."easytpl.class.php");
$tpl_main = & new easytpl("templates/main.tpl", "templateVariables");
$tpl = & new easytpl("templates/update.tpl", "templateVariables");


require_once(CLASSDIR.'nusoap/lib/nusoap.php'); 
$wsdl=UPDATE_SERVER;
$client=new nusoapclient($wsdl, 'wsdl'); 
//$client->debug=1;

if(!isset($_GET['step'])){
	$_GET['step'] = 1;
}


$param = array(	'date' => date('Y-m-d'),
				'version' => EASYWEBMANAGER_VERSION,
				'domain' => $configFile->variable['pr_url'],
				'license' => $configFile->variable['license'],
				'project_id' => $configFile->variable['project_id']);

include_once("update/step{$_GET['step']}.php");

//pae($client->debug_str);

$tpl->setVar('step'.$_GET['step'], 1);

$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$cms_phrases['main']['update'] = $cms_phrases['update'];
$tpl_main->setVar('phrases', $cms_phrases['main']);

$time_end = getmicrotime();
//echo "<p><b>".($time_end - $time_start)."</b></p>";

$tpl_main->setVar('module.title', $cms_phrases['update']['updates_title']);

$tpl->parse();
$tpl_main->setCodeBlock('inner_content', 'include $tpl->cacheFile;');

include $tpl_main->parse();
//pa($client->debug_str);
ob_end_flush();

?>
