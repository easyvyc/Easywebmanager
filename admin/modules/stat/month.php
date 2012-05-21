<?php
/*
 * Created on 2007.3.20
 * month.php
 * Vytautas
 */
 
if(!isset($_GET['date'])) $_GET['date'] = date("Y-m")."-01";


if(isset($_GET['date'])){
	$from_date = $_GET['date'];
}else{
	$from_date = date("Y-m")."-01";
}

if(isset($_GET['date'])){
	$arr = explode("-", $_GET['date']);
	$mktime = mktime(0, 0, 0, $arr[1]+1, 1, $arr[0]);
	$to_date = date("Y-m-d", $mktime);
}else{
	$mktime = mktime(date("H"), date("i"), date("s"), date("m")+1, 1, date("Y"));
	$to_date = date("Y-m-d", $mktime);
}

list($start_site_year, $start_site_month, $start_site_day) = explode("-", $configFile->variable['project_start_date']);
for($i=$XML_CONFIG['months_count_storing_stat']-1, $j=0, $arr=array(); $i>=0; $i--){
	$mktime = mktime(date("H"), date("i"), date("s"), date("m")-$i, 1, date("Y"));
	$year = date("Y", $mktime);
	$month = date("n", $mktime);
	if((int)$start_site_year < (int)$year || ((int)$start_site_year == (int)$year && (int)$start_site_month <= (int)$month) ){
		$arr[$j]['title'] = $year." ".$cms_phrases['main']['common']['months'][$month];
		$arr[$j]['date'] = "$year-$month-01";
		$j++;
	}
}
$tpl->setLoop('menu_months', $arr);

$tpl->setVar('from_date', $from_date);
$tpl->setVar('to_date', $to_date);


$sql = "SELECT COUNT(*) AS cnt FROM {$configFile->variable['sb_stat_visitor']} " .
		"WHERE visit_time >= '$from_date' AND visit_time < '$to_date' AND robot!=1 ";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->row(); 

$tpl->setVar('not_empty', $arr['cnt']);

include_once(dirname(__FILE__)."/menu.php");
 
?>
