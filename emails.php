<?php

ob_start();
session_start();

ini_set('display_errors', true);

header('Content-type: text/html; charset=UTF-8');


require_once('inc/config.inc.php');

include_once(CLASSDIR."object.class.php");

$main_object = new object();

$s_record = $main_object->create("subscribers");
$n_record = $main_object->create("newsletters");


$f = $_GET['v'];
$f = ereg_replace("\+", "{PLIUSAS}", $f);
$f = ereg_replace(" ", "{TARPAS}", $f);
$f = urldecode($f);
$f = ereg_replace("{PLIUSAS}", "+", $f);
$f = ereg_replace("{TARPAS}", " ", $f);


$email = trim(str_crypt($f));
//$email = trim(str_crypt((urldecode($_GET['v']))));

if($_GET['action']=='cancel'){
	$sql = "UPDATE $s_record->table SET active=0 WHERE title='$email'";
	$s_record->db->exec($sql, __FILE__, __LINE__);

	$sql = "INSERT INTO $n_record->table_stats SET email='$email', n_id=0";
	$s_record->db->exec($sql, __FILE__, __LINE__);

	//redirect("http://www.idp.lt");
	echo "<a href=\"".Config::$val['site_url']."\">".Config::$val['site_url']."</a>"; 
	exit;
}


if($_GET['action']=='view'){
	
	$sql = "SELECT * FROM $n_record->table_stats WHERE email='$email' AND n_id={$_GET['n']}";
	$n_record->db->exec($sql, __FILE__, __LINE__);
	$row = $n_record->db->row();
	if(isset($row['view'])){
		$sql = "UPDATE $n_record->table_stats SET view=view+1 WHERE email='$email' AND n_id={$_GET['n']}";
		$n_record->db->exec($sql, __FILE__, __LINE__);
	}else{
		$sql = "INSERT $n_record->table_stats SET view=1, email='$email', n_id={$_GET['n']}";
		$n_record->db->exec($sql, __FILE__, __LINE__);
	}

	$sql = "UPDATE $n_record->table SET view_count=view_count+1 WHERE record_id={$_GET['n']}";
	$n_record->db->exec($sql, __FILE__, __LINE__);		 
	
	redirect(Config::$val['site_url']."images/0.gif");

}



if($_GET['action']=='redirect'){
	
	$sql = "SELECT * FROM $n_record->table_stats WHERE email='$email' AND n_id={$_GET['n']}";
	$n_record->db->exec($sql, __FILE__, __LINE__);
	$row = $n_record->db->row();
	if(isset($row['click'])){
		$sql = "UPDATE $n_record->table_stats SET click=click+1 WHERE email='$email' AND n_id={$_GET['n']}";
		$n_record->db->exec($sql, __FILE__, __LINE__);
	}else{
		$sql = "INSERT $n_record->table_stats SET click=1, email='$email', n_id={$_GET['n']}";
		$n_record->db->exec($sql, __FILE__, __LINE__);
	}

	$sql = "UPDATE $n_record->table SET click_count=click_count+1 WHERE record_id={$_GET['n']}";
	$n_record->db->exec($sql, __FILE__, __LINE__);		 

	$_SESSION['linku_generolas']['email'] = $email;
	redirect($_GET['loc']);

}


?>