<?php
/*
 * Created on 2010.09.21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

ob_start();
session_start();

// Set variable to user side
$user_side = true;
ini_set('display_errors', true);

// Config
include("inc/config.inc.php");

error_reporting(E_ALL);

$TIME_START = getmicrotime();

$cs_cache_file = CACHEDIR."data/{$_GET['f']}.dat";

$arr = array();
if($_GET['f']=='js'){
	$arr[] = array('file'=>"js/jquery.min.js", 'compress'=>0);
	$arr[] = array('file'=>"js/jquery-ui.js", 'compress'=>0);
	$arr[] = array('file'=>"js/jquery.lightbox.js", 'compress'=>0);
	$arr[] = array('file'=>"js/jquery.timer.js", 'compress'=>1);
	$arr[] = array('file'=>"js/scripts.js", 'compress'=>1);
	
	$arr[] = array('file'=>"js/DD_roundies_0.0.2a-min.js", 'compress'=>1);
	$arr[] = array('file'=>"js/jquery.multiple-bgs.js", 'compress'=>0);
//	$arr[] = array('file'=>"js/cufon-yui.js", 'compress'=>0);
//	$arr[] = array('file'=>"js/cufon-replace.js", 'compress'=>0);
//	$arr[] = array('file'=>"js/fonts/Museo_Sans_100_250-Museo_Sans_500_400.font.js", 'compress'=>0);
}
if($_GET['f']=='css'){
	$arr[] = array('file'=>"css/normalize.min.css", 'compress'=>0);
	$arr[] = array('file'=>"css/style.css", 'compress'=>1);
	$arr[] = array('file'=>"css/jquery.lightbox.css", 'compress'=>1);
	$arr[] = array('file'=>"css/main.css", 'compress'=>1);
	$arr[] = array('file'=>"css/calendar.css", 'compress'=>1);
//	$arr[] = array('file'=>"css/pr.css", 'compress'=>1);
}


function strip_white_space_css($str){
	$str = preg_replace("/\r/", "\n", $str);
	$str = preg_replace("/\s+/", " ", $str);
	$str = preg_replace("/\/\*(.*?)\*\//", "", $str);
//	$str = preg_replace("/\}/", " } ", $str);
//	$str = preg_replace("/\n$/", "", $str);
//	$str = preg_replace("/ \{ /", " {", $str);
//	$str = preg_replace("/; \}/", "}", $str);
	return $str;
}

function strip_white_space_js($str){
	//$str = preg_replace("/\r/", "\n", $str);
	$str = preg_replace("/\/\/(.*?)\n/", "\n", $str);
	$str = preg_replace("/\s+/", " ", $str);
	$str = preg_replace("/\n\/\*(.*?)\*\/\n/", "\n", $str);
//	$str = preg_replace("/\}/", " } ", $str);
//	$str = preg_replace("/\n$/", "", $str);
//	$str = preg_replace("/ \{ /", " {", $str);
//	$str = preg_replace("/; \}/", "}", $str);
	return $str;
}


$create_new = false;
clearstatcache();
$c_m_time = filemtime($cs_cache_file);
foreach($arr as $key=>$val){
	if($c_m_time < filemtime(DOCROOT.$val['file'])){
		$create_new = true;
		break;
	}
}

if($create_new){
	$str = "";
	foreach($arr as $key=>$val){
		if($val['compress']==1){
			$fn_name = "strip_white_space_".$_GET['f'];
			$str .= $fn_name(file_get_contents(DOCROOT.$val['file']));
		}else
			$str .= file_get_contents(DOCROOT.$val['file']);
			
		$str .= ";\n";
	}
	file_put_contents($cs_cache_file, $str);
}

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
    ob_start("ob_gzhandler");
else
    ob_start();

if($_GET['f']=='js'){
	header ("content-type: text/javascript; charset: UTF-8");
}
if($_GET['f']=='css'){
	header ("content-type: text/css; charset: UTF-8");
}
header ("cache-control: must-revalidate");
header ("expires: " . gmdate ("D, d M Y H:i:s", time() + 60 * 60 * 24) . " GMT");

echo file_get_contents($cs_cache_file);

?>