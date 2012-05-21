<?php
function detect_language(){
	if(defined('LANG')){
		return LANG;
	}elseif(isset($_GET['lng'])){
		return $_GET['lng'];
	}else{
		return Config::$val['default_lng'];
	}
}

function load_languages($lngs){
	foreach($lngs as $key => $val){
		if($val==1){
			$arr['title'] = strtoupper($key);
			$arr['value'] = strtolower($key);
			$arr['active'] = (detect_language()==$key?1:0);
			$languages[] = $arr;
		}
	}
	return $languages;
}

// Load cms languages for current admin
function load_admin_languages($lng_rights){
	if(isset($_GET['lng'])) $_SESSION['site_lng'] = $_GET['lng'];
	foreach(Config::$val['default_page'] as $key=>$val){
		$row['lng'] = $key;
		$arr[] = $row;
	}
	for($i=0; $i<count($arr); $i++){
		$arr[$i]['active'] = $_SESSION['site_lng']==$arr[$i]['lng']?1:0;
		if(!in_array($arr[$i]['lng'], $lng_rights)){
			$n_arr[] = $arr[$i];
		}	
	}
	return $n_arr;
}

function detect_admin_lang(){
	if(isset($_GET['lang'])){
		$_SESSION['admin_interface_language'] = $_GET['lang'];
	}
	if(!isset($_SESSION['admin_interface_language'])){
		$_SESSION['admin_interface_language'] = 'lt';
	}
}

?>