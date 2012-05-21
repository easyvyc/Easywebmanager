<?php
/*
 * Created on 2007.3.5
 * lang.php
 * Vytautas
 */


error_reporting(0);

session_start();
if($_SESSION['admin']['permission']!=1 || !isset($_GET['lng']) || !isset($_GET['lng_from'])){
	exit;
}

$user_side = true;
include_once("inc/config.inc.php");

include_once(CLASSDIR."module.class.php");
$mod_obj = module::getInstance();
$list = $mod_obj->listModules();
$n = count($list);

for($i=0; $i<$n; $i++){
	
	if($list[$i]['multilng'] == 1){

		$columns = $mod_obj->listColumns($list[$i]['id']);
		$m = count($columns);
		
		for($j=0, $fld=array(); $j<$m; $j++){
			$fld[] = $columns[$j]['column_name'];
		}
		
		if(!empty($fld))
			$fields = implode(", ", $fld).", ";
		
		echo $sql = "INSERT INTO ".Config::$val['pr_code']."_{$list[$i]['table_name']} ($fields record_id, lng) " .
				" SELECT $fields record_id, '{$_GET['lng']}' FROM ".Config::$val['pr_code']."_{$list[$i]['table_name']} WHERE lng='{$_GET['lng_from']}'";
		echo "<br><br>";
		$database->exec($sql, __FILE__, __LINE__);
		
	}
	
	
}


?>
