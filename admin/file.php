<?php
/*
 * Created on 2009.03.11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


error_reporting(E_ALL);
ini_set("display_errors", true);
ob_start();
session_start();

// Config
include("../inc/config.inc.php");

// only cms admin
if(!isset($_SESSION['admin']['id'])){
	exit;
}

if(isset($_GET['lng'])){
	$lng = $_GET['lng'];
}else{
	$lng = $_SESSION['site_lng'];
}


include_once(CLASSDIR."object.class.php");
$main_object = new object();
$mod_obj = $main_object->create($_GET['module']);

$item = $mod_obj->loadItem($_GET['id']);

if(isset($mod_obj->_table_fields[$_GET['column']]['list_values']['dir'])){
	$path = DOCROOT.$mod_obj->_table_fields[$_GET['column']]['list_values']['dir'];
}elseif(isset($mod_obj->_table_fields[$_GET['column']]['list_values']['abs_dir'])){
	$path = $mod_obj->_table_fields[$_GET['column']]['list_values']['abs_dir'];
}else{
	$path = UPLOADDIR;
}

if(strlen($item[$_GET['column']])==0 || !file_exists($path.$item[$_GET['column']])) die("File not exist: ".$path.$item[$_GET['column']]);

if($mod_obj->_table_fields[$_GET['column']]['elm_type'] == FRM_IMAGE){
	include_once(CLASSDIR."images.class.php");
	$img_obj = & new images();
	$img_obj->process($path.$item[$_GET['column']], '', array('size_width'=>$_GET['w'], 'size_height'=>$_GET['h'], 'resize_type'=>$_GET['t'], 'quality'=>100));
}else{
	include_once(CLASSDIR."files.class.php");
	$file_obj = new files();
	$file_obj->download($path.$item[$_GET['column']]);
}

?>