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

function pas($arr, $s=0){
	$str = "";
	if($s==1){
		if($_SESSION['admin']['permission']==1){
			$str .= "<pre>";
			$str .= print_r($arr, true);
			$str .= "</pre>";
		}
	}else{
		$str .= "<pre>";
		$str .= print_r($arr, true);
		$str .= "</pre>";
	}
	return $str;
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