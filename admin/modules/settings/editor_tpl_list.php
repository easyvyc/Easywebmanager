<?php
/*
 * Created on 2005.9.21
 *
 * VB
 * editor_tpl_list.php
 */

$xmlFile = FCKDIR.'fcktemplates.xml';

include_once(CLASSDIR."xmlini.class.php");
$arr2xml = new xmlIni($xmlFile);

//pa($arr2xml);

if(isset($_GET['action'])&&$_GET['action']=='delete'){
	$n = count($arr2xml->xmlTree->children);
	for($i=0; $i<$n; $i++){
		if($_GET['id']!=$i+1)
			$list->children[] = $arr2xml->xmlTree->children[$i];
	}
	$arr2xml->xmlTree->children = $list->children;

	$xml = $arr2xml->objToXml($arr2xml->xmlTree);
	$file = fopen($xmlFile, "w");
	fwrite($file, $xml);	
	redirect("main.php?content=settings&page=editor_tpl_list");
}

$n = count($arr2xml->xmlTree->children);
for($i=0; $i<$n; $i++){
	$list[$i]['title'] = $arr2xml->xmlTree->children[$i]->attributes['title'];
	$list[$i]['id'] = $i+1;
}
$tpl->setLoop('items', $list);

$tpl->setVar('empty', empty($list)?1:0);

include_once(dirname(__FILE__)."/menu.php");
 
?>
