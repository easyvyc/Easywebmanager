<?php
/*
 * Created on 2010.05.13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

function format_json_str($str){
	$str = str_replace("\n", "<br />", $str);
	$str = str_replace("\r", "", $str);
	$str = str_replace("\"", "&quote;", $str);
	return $str;
}

$parr = explode("::", $_GET['params']);
$data = $main_object->call($_GET['module'], $_GET['method'], $parr);
foreach($data as $key=>$val){
	$arr[] = "\"$key\":\"".format_json_str($val)."\"";
}
echo "{ ".implode(",", $arr)." }";
exit;

?>