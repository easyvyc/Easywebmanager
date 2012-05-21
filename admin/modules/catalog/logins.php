<?php
/*
 * Created on 2009.07.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$record = $main_object->create($_GET['module']);
$record->actions->_logins();

?>