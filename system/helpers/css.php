<?php

function generate_css($dir, $css_files){

	global $cache_obj;
	
	if($dir){
		$dir = trim($dir, "/");
		$dir .= "/";
	}
	
	$path = DOCROOT.$dir."css/";
	
	$newest_file_mtime = 0;
	foreach($css_files as $css_file){
		$css_file_path = $path . $css_file . ".css";
		if(mktime($css_file_path) > $newest_file_mtime) $newest_file_mtime = mktime($css_file_path);
	}
	
	$cache_file = CACHEDIR.md5(implode("-", $css_files).$dir).".css";
	
	if(!file_exists($cache_file) || $cache_obj->is_loadCache($cache_file, $newest_file_mtime)){
		require(CLASSDIR.'csspp.php');
		$csspp = new CSSPP();
		foreach($css_files as $css_file){
			$csspp->add($path . $css_file . ".css");
		}
		$output = $csspp->__toString();
		$cache_obj->createCache($cache_file, $output);
	}else{
		$output = $cache_obj->getContent($cache_file);
	}
	
	return $output;
	
}

?>