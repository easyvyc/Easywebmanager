<?php
/*
 * Created on 2006.2.21
 * change_parent_id_modules.php
 * Vytautas
 */

if(!isset($_SESSION['admin']['permission'])) exit;

if(isset($_GET['module'])){
	
	$lng = $_GET['lng'];

	$record = $main_object->create($_GET['module']);
	
	if(isset($_GET['id'])&&is_numeric($_GET['id'])&&isset($_GET['parent_id'])&&is_numeric($_GET['parent_id'])){
		if($_GET['parent_id']==1) $_GET['parent_id'] = 0;
		$record->changeParentId($_GET['id'], $_GET['parent_id']);
	}
}
$xml_source = "<x></x>"; 

?>
