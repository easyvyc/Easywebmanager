<?php

function DB($host, $user, $pass, $name){
	$db = new database($host, $user, $pass, $name);
	if(!$db){
		trigger_error("Mysql error ".mysql_error());
	}
	return $db;
}

?>