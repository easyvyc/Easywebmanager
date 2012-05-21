<?php

error_reporting(E_ALL);
ob_start();


if (empty($content)) {$content = "pages";}

// Flash uploader can not send cookies
if(isset($_POST['fusid'])){
	session_id($_POST['fusid']);
}

session_start();
$user_side = false;
include("inc/config.inc.php");

$time_start = getmicrotime();

if(isset($_GET['lng'])){
	$lng = $_GET['lng'];
}else{
	$lng = Config::$val['default_lng'];
}

include_once(CLASSDIR."object.class.php");

$main_object = new object();

if(isset($_GET['get'])){
	include(AJAXDIR."{$_GET['get']}.php");
}

$time_end = getmicrotime();

ob_clean();
header("Content-type: text/xml");
header("Cache-Control: no-store, no-cache");
header("Pragma: no-cache");
header("Expires: 0");
//header("Content-Type: text/html; charset=utf-8");

echo $xml_source;

ob_flush();

?>
