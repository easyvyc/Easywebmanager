<?php
function pa($arr, $s=0){
	if($s==1){
		if($_SESSION['admin']['permission']==1){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
	}else{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}

function pae($arr, $s=0){
	if($s==1){
		if($_SESSION['admin']['permission']==1){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
	}else{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	exit;
}
?>