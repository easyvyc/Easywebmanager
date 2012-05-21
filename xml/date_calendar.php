<?php
/*
 * Created on 2009.04.21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$CALENDAR['year'] = $_GET['year'];
$CALENDAR['month'] = $_GET['month'];
$CALENDAR['day'] = $_GET['day'];


include_once(CLASSDIR_."easytpl.class.php");

$tpl_part_calendar = & new easytpl(MODULESDIR."extras/parts/calendar.tpl", "templateVariables");

$tpl_part_calendar->setVar('ajax', isset($_GET['get'])&&$_GET['get']=='calendar'?1:0);

$c_mktime = mktime(0,0,0,$CALENDAR['month'], $CALENDAR['day'], $CALENDAR['year']);
$CALENDAR['year'] = (int) date("Y", $c_mktime);
$CALENDAR['month'] = (int) date("m", $c_mktime);
$CALENDAR['day'] = (int) date("d", $c_mktime);

$current_date['title'] = $CALENDAR['year']." ".$phrases['calendar.month.'.(((int) $CALENDAR['month'])-1)];
$current_date['year'] = $CALENDAR['year'];
$current_date['previous_year'] = $CALENDAR['year'] - 1;
$current_date['next_year'] = $CALENDAR['year'] + 1;
$current_date['month'] = (int) $CALENDAR['month'];
$current_date['previous_month'] = (int) $CALENDAR['month'] - 1;
$current_date['next_month'] = (int) $CALENDAR['month'] + 1;
$current_date['day'] = $CALENDAR['day'];

$current_date['actions'] = $CALENDAR['actions'];

$tpl_part_calendar->setVar('current_date', $current_date);

$tpl_part_calendar->setVar('now', array('year'=>date("Y"), 'month'=>(int) date("m"), 'day'=>date("d")));

for($i=0; $i<7; $i++){
	$weekdays[$i]['title'] = $phrases['weekdays.'.$i];
	$weekdays[$i]['name'] = mb_substr($phrases['weekdays.'.$i], 0, 3, "UTF-8");
}
$tpl_part_calendar->setLoop('weekdays', $weekdays);

$mktime = mktime(0,0,0, $current_date['month'], 1, $current_date['year']);
$number_of_days = date("t", $mktime); $day = 1;
while($day <= $number_of_days){
	
	$first_week_day = date("w", $mktime);
	$first_week_day = ($first_week_day==0?6:$first_week_day-1);
	for($i = 0, $week = array(); $i < 7; $i++){
		if($i >= $first_week_day && $day <= $number_of_days){
			$week[$i]['description'] = $CALENDAR['year']." ".$phrases['calendar.month.'.(((int) $CALENDAR['month'])-1)].", ".$day;
			if(in_array($day, $current_date['actions'])){
				$week[$i]['action'] = 1;
			}
			$week[$i]['value'] = $day++;
			$mktime = mktime(0,0,0, $current_date['month'], $day, $current_date['year']);
		}else{
			$week[$i]['value'] = '&nbsp;';
		}
	}
	$weeks[] = array('days'=>$week);
}
//pae($weeks);
$tpl_part_calendar->setLoop('weeks', $weeks);

$tpl_part_calendar->setVar('phrases', $phrases);

$tpl_part_calendar->setVar('config', $configFile->variable);

$tpl_part_calendar->parse();


ob_clean();

include($tpl_part_calendar->cacheFile);

exit;

?>