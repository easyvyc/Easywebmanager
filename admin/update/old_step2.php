<?php
/*
 * Created on 2006.9.15
 * step3.php
 * Vytautas
 */

if(!empty($_POST['update'])){
	
	$key = 1;
	foreach($_POST['update'] as $val){
		//$_SESSION['update'][$key++]['id'] = $val;
		$arr[] = $val;
	}
	
	$param['updates'] = $arr;
	
	$_updateExist = $client->call('sortUpdateList', $param);
	$updateExist = $_updateExist[0];
	
	$_SESSION['update'] = $updateExist['value']['item'];
	
	$next_step = $_GET['step'] + 1;
	$_SESSION['update']['current_update_id'] = 1;
	//pae($_SESSION['update']);
	redirect("update.php?step=$next_step&update_id={$_SESSION['update'][$_SESSION['update']['current_update_id']]['id']}");
	
}else{
	
	$tpl_main->setVar('step3', 1);
	
}
 
?>
