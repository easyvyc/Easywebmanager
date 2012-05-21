<?php
/*
 * Created on 2007.09.25
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



$CALENDAR['year'] = $_GET['year'];
$CALENDAR['month'] = $_GET['month'];
$CALENDAR['day'] = $_GET['day'];


include_once(CLASSDIR_."easytpl.class.php");
include_once(CLASSDIR_."catalog.class.php");

include(INCDIR."scripts/phrases.php");



include_once(CLASSDIR_."modules/events.class.php");
$events_obj = & new events("events");
$CALENDAR['actions'] = $events_obj->getActionDays($CALENDAR['year'], $CALENDAR['month']);
include_once(CLASSDIR_."pages.class.php");
$pages = & new pages();
$events_page_data = $pages->getModulePageData($configFile->variable['default_page'][$lng], $events_obj->module_info['id']);
$CALENDAR['action_url'] = $events_page_data['page_url'];

include(TPLDIR_."templates/parts/calendar.php");

$tpl_part_calendar->setVar('reserved_url_words', $reserved_url_words);

ob_clean();

include($tpl_part_calendar->cacheFile);

exit;

?>