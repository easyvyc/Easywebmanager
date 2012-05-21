<?php

if(isset($_GET['app'])){
	define('APP_NAME', $_GET['app']);
}else{
	define('APP_NAME', 'site');
}

// Config
include("inc/config.inc.php");

load_helpers('debug', 'error_handler', 'languages', 'DB');

include_once(APP_CLASSDIR."cms.class.php");
$CMS = cms::getInstance();

// Main object
include_once(CLASSDIR."main_object.class.php");
$main_object = main_object::getInstance();

// detect current language
$lng = detect_language();


echo @$main_object->call($_GET['module'], $_GET['method'], array($_GET['params']));

echo benchmark::getInstance()->result();

ob_flush();

?>