<?php
/*
 * Created on 2009.03.11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


error_reporting(0);
ob_start();
session_start();

// Set variable to user side
$user_side = true;

// Config
include("inc/config.inc.php");

$TIME_START = getmicrotime();


$arr = explode(".", $_GET['image']);
$extension = $arr[(count($arr)-1)];

include_once(CLASSDIR_."images.class.php");
$img_obj = & new images();


if(in_array(strtolower($extension), $valid_images)){
	$img_obj->process(DOCROOT.urldecode($_GET['image']), '', array('size_width'=>$_GET['w'], 'size_height'=>$_GET['h'], 'resize_type'=>$_GET['t'], 'quality'=>100));
}else{
	redirect($main_configFile->variable['site_admin_url']."images/extension_icons/$extension.gif");
}


?>