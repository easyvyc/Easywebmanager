<?php
/*
 * Created on 2008.03.31
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


if(!isset($_SESSION['admin']['permission'])) exit;


include_once(CLASSDIR."module.class.php");
$modules = new module();

include_once(CLASSDIR."xmlini.class.php");
$xml = new xmlIni();

//$item = $record->load($configFile->variable['default_page'][$_GET['lng']]);

$xml->xmlTree->name = "tree";
$xml->xmlTree->attributes['id'] = "0";


$items = $modules->listModules();
if($_SESSION['admin']['permission']!=1){
	$n = count($items);
	for($i=0; $i<$n; $i++){
		if($items[$i]['admin_catalog']==1 && !in_array($items[$i]['id'], $admin_obj->modules_rights))
			$list[] = $items[$i];
	}
}else{
	$list = $items;
}

$n = count($list);

for($i=0; $i<$n; $i++){
	
	$xmlNode->name = "item";
	
	$list[$i]['title'] = ereg_replace("&#39;", "'", $list[$i]['title']);
	$xmlNode->attributes['text'] = htmlspecialchars($list[$i]['title'])." ({$list[$i]['id']})";
	$xmlNode->attributes['id'] = $list[$i]['id'];
	$xmlNode->attributes['active'] = $list[$i]['active'];
	if($list[$i]['id']==$_GET['id']){
	 	$xmlNode->attributes['open'] = 1;
	 	$xmlNode->attributes['call'] = 1;
	}else{
		unset($xmlNode->attributes['open']);
		unset($xmlNode->attributes['call']);			
	}

	/*unset($xmlNode->attributes['im0']);
	unset($xmlNode->attributes['im1']);
	unset($xmlNode->attributes['im2']);

	if($list[$i]['prm'] == 1){
		$xmlNode->attributes['im0'] = "leaf_secure.gif";
		$xmlNode->attributes['im1'] = "leaf_secure.gif";
		$xmlNode->attributes['im2'] = "leaf_secure.gif";
	}

	if($list[$i]['active']!=1){

		if($list[$i]['prm'] == 1){
			$xmlNode->attributes['im0'] = "secure_disabled.gif";
			$xmlNode->attributes['im1'] = "secure_disabled.gif";
			$xmlNode->attributes['im2'] = "secure_disabled.gif";
		}else{
			$xmlNode->attributes['im0'] = "disabled.gif";
			$xmlNode->attributes['im1'] = "disabled.gif";
			$xmlNode->attributes['im2'] = "disabled.gif";
		}

	}else{
	}*/

	//$xmlNode_ = _xmlTree($xmlNode, $list[$i]['id']);
	
	$xml->xmlTree->children[$i] = $xmlNode;
	
	unset($xmlNode);
	
}

//$xml->xmlTree = _xmlTree($xml->xmlTree);

//pae($xml->xmlTree);

$xml_source = $xml->objToXml($xml->xmlTree);
?>