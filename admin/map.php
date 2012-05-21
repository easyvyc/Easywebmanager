<?php
/*
 * Created on 2005.9.29
 *
 * VB
 * index.php
 */
 
ob_start();
session_start();
#session_regenerate_id();
header("Cache-control: private");
header("Content-Type: text/html; charset=utf-8");

$install = true;
include_once ('../inc/config.inc.php');

if($_SESSION['admin']['user_agent']!=$_SERVER['HTTP_USER_AGENT'] || $_SESSION['admin']['user_ip']!=$_SERVER['REMOTE_ADDR']){
	unset($_SESSION['admin']);
	redirect("login.php");
}

include_once("install/map.php");
 
?>
