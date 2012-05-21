<?php
/*
 * Created on 2009.05.07
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$record = $main_object->create($_GET['module']);

$action_str = "_{$_GET['action']}";
$record->actions->$action_str();

?>