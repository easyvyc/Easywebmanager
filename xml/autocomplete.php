<?php
/*
 * Created on 2010.09.30
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$lng = $_SESSION['site_lng'];

$list = $main_object->call($_GET['module'], "get_autocomplete_list", array($_GET['column'], strtolower($_GET["q"]), $_GET['limit'], $_GET['left'], $_GET['right']));

ob_clean();
header("Content-type: text/json");
header("Cache-Control: no-store, no-cache");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Type: text/html; charset=utf-8");

echo json_encode($list);
exit;

?>