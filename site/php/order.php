<?php
/*
 * Created on 2009.09.28
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


if(!isset($_GET['step'])){
	redirect(Config::$val['site_url']."$lng/order/step/cart/");
}

if(isset($_POST['step']) && $_POST['step']!=$_GET['step']){
	if(!in_array($_GET['step'], $_SESSION['steps_complited'])) $_SESSION['steps_complited'][] = $_GET['step'];
	redirect(Config::$val['site_url']."$lng/order/step/{$_POST['step']}/");
}

if($_GET['step']=='shipping'){
	if(!in_array('user', $_SESSION['steps_complited'])) $_SESSION['steps_complited'][] = 'user';
}
if($_GET['step']=='pay'){
	if(!in_array('shipping', $_SESSION['steps_complited'])) $_SESSION['steps_complited'][] = 'shipping';
}


$tpl_inner->setFile(TPLDIR_."order/{$_GET['step']}.tpl");

if($_GET['ajax']==1){
	include $tpl->parse();
	exit;
}

?>