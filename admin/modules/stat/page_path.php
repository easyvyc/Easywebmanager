<?php
/*
 * Created on 2009.05.26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(CLASSDIR."stat.class.php");
$stat_obj = & new stat();

$lng = $_SESSION['site_lng'];
if(!isset($_GET['id'])) $_GET['id'] = 0;



$items = $stat_obj->getVisitorPath($_GET['id']);
$tpl->setLoop('path', $items);

$visitor_data = $stat_obj->getVisitor($_GET['id']);
$tpl->setVar('visitor_data', $visitor_data);

if($_SESSION['admin']['permission']==1){
	$tpl->setVar('super_admin', 1);
}else{
	$tpl->setVar('super_admin', 0);
}

$tpl->setVar('language', $lng);

$tpl->setVar('lng', $_SESSION['site_lng']);

include $tpl->parse();
exit;

?>