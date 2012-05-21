<?php
/*
 * Created on 2010.09.20
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(false){
	exit;
}

$data = $main_object->call($_GET['module'], "loadItem", array($_GET['id']));

$_GET['w'] = 100;
$_GET['h'] = 35;
$_GET['t'] = 0;
$_GET['image'] = ereg_replace(DOCROOT_, "", UPLOADDIR).$data[$_GET['column']];

//include(DOCROOT_."thumb.php");

redirect("{$configFile->variable['site_url']}thumb.php?w=100&h=35&t=0&image=".ereg_replace(DOCROOT_, "", UPLOADDIR).$data[$_GET['column']]);


?>