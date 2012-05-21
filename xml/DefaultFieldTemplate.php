<?php
/*
 * Created on Dec 15, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(!isset($_GET['tpl'])) exit;

if(isset($_GET['userside']) && $_GET['userside']==1){
	$filename = TPLDIR."templates/forms/".$_GET['tpl'].".tpl";
}else{
	$filename = MODULESDIR."forms/".$_GET['tpl'].".tpl";
}

$h = fopen($filename, "r");
$str = fread($h, filesize($filename));
fclose($h);
echo $str;

exit;

?>