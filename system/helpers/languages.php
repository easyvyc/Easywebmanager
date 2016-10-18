<?php
function detect_language(){
	if(isset($_GET['lng'])){
		$lng = $_GET['lng'];
	}elseif(defined('LANG')){
		$lng = LANG;
	}elseif($_SESSION['website_language']){
		$lng = $_SESSION['website_language'];
	}else{
		$lng = Config::$val['default_lng'];
	}
        
        if(!Config::$val['default_page'][$lng]){
            $lng = Config::$val['default_lng'];
        }
        
        $_SESSION['website_language'] = $lng;
        
        return $lng;
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
	if(isset($_GET['lng'])){ 
		$_SESSION['site_lng_changed'] = ($_SESSION['site_lng'] != $_GET['lng']);
		$_SESSION['site_lng'] = $_GET['lng'];
	}else{
		if(!isset($_SESSION['site_lng'])){
			$_SESSION['site_lng_changed'] = true;
		}
	}
	if(isset($_GET['lang'])){
		$_SESSION['admin_interface_language'] = $_GET['lang'];
	}
	if(!isset($_SESSION['admin_interface_language'])){
		$_SESSION['admin_interface_language'] = Config::$val['default_admin_interface_lng'];
	}
}

?>