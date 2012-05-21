<?php


ob_start();

include("inc/config.inc.php");

ini_set('display_errors', 1);
error_reporting(0);


$lng = $_GET['lng'];

if(isset($_GET['module'])){
	include_once(CLASSDIR_."catalog.class.php");
	$catalog_obj = & new catalog($_GET['module']);
	if($catalog_obj->module_info['disabled']!=1){
		if(isset($_GET['lng'])){
			$catalog_obj->language = $_GET['lng'];
		}
		$xml = $catalog_obj->generateSitemap();
	}
}else{
	include_once(CLASSDIR_."modules/pages.class.php");
	$pages = & new pages("pages");
	$xml = $pages->generateSitemap();
}


ob_clean();
header("Content-type: text/xml");
header("Cache-Control: no-store, no-cache");
header("Pragma: no-cache");
header("Expires: 0");

echo $xml;

ob_flush();


?>
