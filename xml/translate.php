<?php
/*
 * Created on 2009.06.30
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$_SESSION['site_lng'] = $lng;


$lng_from = 'lt';

if($_GET['action']=='google'){
	
	$data = $main_object->call($_GET['module'], "loadItem", $_GET['id']);
	
	$site_url = $configFile->variable['site_url']."xml.php?get=translate&action=tr&module={$_GET['module']}&column={$_GET['column']}&id={$_GET['id']}&lng=$lng_from";
	$site_url = urlencode($site_url);
	$google_url = "http://209.85.129.132/translate_c?hl=en&ie=UTF-8&oe=UTF-8&langpair=$lng_from|{$_GET['lng']}&sl=en&tl=lt&u=$site_url%3Fgtrans%3Dtrue&rurl=translate.google.com&usg=ALkJrhhT23xl_caEGj-8Ys7e_UAogIJzOQ";
	
	$s = curl_init();

	curl_setopt($s,CURLOPT_URL,$google_url);
	curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
	 
    curl_setopt($s,CURLOPT_HEADER,0);

	curl_setopt($s,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; GTB6; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)");
	curl_setopt($s,CURLOPT_REFERER,$this->_referer);
	 
	$content = curl_exec($s);
	//$this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);  
	curl_close($s); 

	//$content = preg_replace('/<a href="(.*?)u=(.*?)">/', '<a href="$2">', $content);
	//$content = str_replace(str_replace('%7C', '&#037;7C', htmlentities($uri)), '', $content);
	
	echo $content;
	
}

if($_GET['action']=='tr'){
	$data = $main_object->call($_GET['module'], "loadItem", $_GET['id']);
	echo $data[$_GET['column']];
}


"<script src=\"http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/translatemypage.xml&up_source_language=en&w=160&h=60&title=&border=&output=js\"></script>";

exit;

?>