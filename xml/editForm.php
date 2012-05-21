<?php
/*
 * Created on 2010.05.12
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


if(!isset($_SESSION['admin']['permission'])) exit;

$_POST['active'] = 1;
$formid = $main_object->call("forms", "saveItem", array($_POST));
echo $formid;
exit;

?>