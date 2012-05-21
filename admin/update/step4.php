<?php
/*
 * Created on 2006.9.14
 * step6.php
 * Vytautas
 */

$param['update_id'] = $_SESSION['update'][$_SESSION['update']['current_update_id']]['record_id'];

$_updateExist = $client->call('endUpdate', $param);
$updateExist = $_updateExist[0];

if($updateExist['value']!=false){
	$next_step = $_GET['step'] + 1;
	$_SESSION['update']['current_update_id'] = $current_index = $_SESSION['update']['current_update_id'] + 1;
	//pae($_SESSION['update']);
	if(isset($_SESSION['update'][$current_index]['id'])){
		redirect("update.php?step=2");
	}else{
		unset($_SESSION['update']);
		
		include_once(dirname(__FILE__)."/final_step.php");
		
		$tpl->setVar('update_complete', 1);
	}
}else{
	unset($_SESSION['update']);
	$tpl_main->setVar('error', $client->getError() . " <br> " . nl2br($updateExist['errorMessage']));
}

?>
