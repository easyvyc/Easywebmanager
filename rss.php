<?php
/*
 * Created on 2007.6.6
 * rss.php
 * Vytautas
 */


ob_start();

include("inc/config.inc.php");

ini_set('display_errors', 1);
error_reporting(0);


$xmlFile = 'files/data/search.xml';
$search_engines = File::xmlFileToArray($xmlFile);


if(isset($_GET['module'])){
	include_once(CLASSDIR_."object.class.php");
	$main_object = new object();
	$catalog_obj = $main_object->create($_GET['module']);
	if($catalog_obj->module_info['rss']==1){
		if(isset($_GET['lng'])){
			$catalog_obj->language = $_GET['lng'];
			$lng = $_GET['lng'];
		}else{
			$lng = Config::$val['default_lng'];
		}
		
		$xml = $catalog_obj->generateRSS();
	}else{
		echo "No RSS"; exit;
	}
}else{
	exit;
}

include("inc/visitor.inc.php");

ob_clean();
header("Content-type: text/xml; charset=utf-8");
header("Cache-Control: no-store, no-cache");
header("Pragma: no-cache");
header("Expires: 0");
//header("Content-Type: text/html; charset=utf-8");

echo $xml;

ob_flush();


?>
