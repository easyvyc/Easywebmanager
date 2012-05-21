<?php
/*
 * Created on 2007.3.20
 * custom.php
 * Vytautas
 */

if(!isset($_GET['from_date'])) $_GET['from_date'] = $configFile->variable['project_start_date'];

if(!isset($_GET['to_date'])) $_GET['to_date'] = date("Y-m-d");

include_once(dirname(__FILE__)."/menu.php"); 

$tpl->setVar('not_empty', 1);

$tpl->setVar('from_date', $_GET['from_date']);
$tpl->setVar('to_date', $_GET['to_date']);

?>