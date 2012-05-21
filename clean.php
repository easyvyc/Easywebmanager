<?php
/*
 * Created on 2009.07.19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

ob_start();
session_start();

// Set variable to user side
$user_side = true;
ini_set('display_errors', true);

header('Content-type: text/html; charset=UTF-8');

// Config
include("inc/config.inc.php");

$sql = "SELECT * FROM cms_record";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->arr();

$counter = 0;
foreach($arr as $val){
	
	$sql = "SELECT * FROM cms_module WHERE id={$val['module_id']}";
	$database->exec($sql, __FILE__, __LINE__);
	$row = $database->row();
	
	if($row['no_record_table']!=1){
		if(strlen($row['table_name'])>0){
			$sql = "SELECT * FROM cms_{$row['table_name']} WHERE record_id={$val['id']}";
			$database->exec($sql, __FILE__, __LINE__);
			$row = $database->row();
			if(empty($row)){
				$sql = "DELETE FROM cms_record WHERE id={$val['id']}";
				$database->exec($sql, __FILE__, __LINE__);
				$counter++;
			}
		}else{
			if(empty($row)){
				$sql = "DELETE FROM cms_record WHERE id={$val['id']}";
				$database->exec($sql, __FILE__, __LINE__);
				$counter++;
			}
		}
	}
	
	
}
echo "Sutvarkyta $counter irasu";

?>