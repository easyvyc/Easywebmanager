<?php
/*
 * Created on 2006.9.13
 * step1.php
 * Vytautas
 */

$_updateExist = $client->call('getUpdatesExist', $param);
$updateExist = $_updateExist[0];


$error = $client->getError();

if($updateExist['value']!=false){
	
	$next_step = $_GET['step'] + 1;
	$tpl_main->setVar('update_exist', 1);
	redirect("update.php?step=2");
	
}else{
	$tpl_main->setVar('error', $error . " <br> " . nl2br($updateExist['errorMessage']));
	
}

?>
