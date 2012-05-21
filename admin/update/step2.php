<?php
/*
 * Created on 2006.9.14
 * step3.php
 * Vytautas
 */

$param['update_id'] = $_SESSION['update'][$_SESSION['update']['current_update_id']]['record_id'];

$_updateExist = $client->call('startUpdate', $param);
$updateExist = $_updateExist[0];

if($updateExist['value']!=false){
	$next_step = $_GET['step'] + 1;
	redirect("update.php?step=$next_step&update_id={$param['update_id']}");
}else{
	$tpl_main->setVar('error', $client->getError() . " <br> " . nl2br($updateExist['errorMessage']));
}

?>
