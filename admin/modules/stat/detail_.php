<?php
/*
 * Created on 2007.07.13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */




if(isset($_GET['date'])){
	$arr = explode("-", $_GET['date']);
	$mktime = mktime(23, 59, 59, $arr[1], $arr[2], $arr[0]);
	$to_date = date("Y-m-d H:i:s", $mktime);
}else{
	$mktime = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
	$to_date = date("Y-m-d H:i:s", $mktime);
}

if(!isset($_GET['date_to'])){
	$_GET['date_to'] = $to_date;
}else{
	$_GET['date_to'] = $_GET['date_to']." 23:59:59";
}



include_once(CLASSDIR."stat.class.php");
$stat_obj = & new stat();

$search_stat = array();
if(isset($_GET['ipaddress'])){
	$search_stat['ipaddress'] = $_GET['ipaddress'];
}
if(isset($_GET['referer_domain'])){
	$search_stat['referer_domain'] = $_GET['referer_domain'];
}
$tpl_detail->setVar('filters_data', $search_stat);

//pa($_GET);
$count = $stat_obj->getDayVisitorsCount($_GET['date'], $_GET['date_to'], $search_stat);
$list = $stat_obj->getDayVisitors($_GET['date'], $_GET['offset'], $_GET['date_to'], $search_stat);
$tpl->setLoop('items', $list);
$tpl->setVar('phrases', $cms_phrases['main']);

$tpl->setVar('empty', empty($list)?1:0);
for($i=0; $i<ceil($count/STAT_DAY_VISITORS_PAGING_VALUE); $i++){
	$paging[$i]['number'] = $i;
	$paging[$i]['active'] = $i==$_GET['offset']?1:0;
}
$tpl->setLoop('paging', $paging);

$tpl->setVar('day_stat_count', $count);
$_GET['date_to'] = substr($_GET['date_to'],0, 10);
$tpl->setVar('get', $_GET);



?>