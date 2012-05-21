<?php
/*
 * Created on 2006.4.27
 * pages_admin_rights_tree.php
 * Vytautas
 */
 
include_once(CLASSDIR."pages.class.php");

$pages = & new pages();

include_once(CLASSDIR."xmlini.class.php");
$xml = & new xmlIni();
//$xmlNode = new xmlIni();

$item = $pages->load($configFile->variable['default_page'][$_GET['lng']]);

$xml->xmlTree->name = "tree";
$xml->xmlTree->attributes['id'] = "0";

$xml->xmlTree->children[0]->name = "item";

$item['title'] = ereg_replace("&#39;", "'", $item['title']);
$xml->xmlTree->children[0]->attributes['text'] = htmlspecialchars($item['title']);
$xml->xmlTree->children[0]->attributes['id'] = $item['id'];
$xml->xmlTree->children[0]->attributes['active'] = $item['active'];
$xml->xmlTree->children[0]->attributes['open'] = "1";


$main_page_rights = $pages->loadAdminPageRights($_GET['id'], $configFile->variable['default_page'][$_SESSION['site_lng']]);
$main_page_rights_parent_admin = $pages->loadAdminPageRights($_SESSION['admin']['id'], $configFile->variable['default_page'][$_SESSION['site_lng']]);
if(!isset($main_page_rights['rights']) || $main_page_rights['rights']==0)
	$xml->xmlTree->children[0]->attributes['checked'] = 1;

$main_page_rights['readonly'] = ($main_page_rights_parent_admin['rights']==1?1:0);

//$main_page_rights['readonly'] = ($main_page_rights_parent_admin['rights']==1?'disabled':'');


function _xmlTree($xml, $id=0){
	global $pages, $configFile;
	$list = array();
	$xmlNode = null;
	$list = $pages->listAdminRights($configFile->variable['sb_admin_pages_rights'], $_GET['id'], $id);
	$parent = $pages->listAdminRights($configFile->variable['sb_admin_pages_rights'], $_SESSION['admin']['id'], $id);
	$n = count($list);
	$m = count($parent);
	for($i=0; $i<$n; $i++){
		
		$xmlNode[$i]->name = "item";
		
		$list[$i]['title'] = ereg_replace("&#39;", "'", $list[$i]['title']);
		$xmlNode[$i]->attributes['text'] = htmlspecialchars($list[$i]['title']).($_SESSION['admin']['permission']==1?" ({$list[$i]['id']})":"");
		$xmlNode[$i]->attributes['id'] = $list[$i]['id'];
		$xmlNode[$i]->attributes['active'] = $list[$i]['active'];
		
		if($list[$i]['active']!=1){
			$xmlNode[$i]->attributes['im0'] = "disabled.gif";
			$xmlNode[$i]->attributes['im1'] = "disabled.gif";
			$xmlNode[$i]->attributes['im2'] = "disabled.gif";
		}
		
		if(strlen($list[$i]['link_module'])>0){
			$xmlNode[$i]->attributes['module'] = $list[$i]['link_module'];
			$xmlNode[$i]->attributes['title_module'] = $list[$i]['title_module'];
			$xmlNode[$i]->attributes['tree'] = $list[$i]['tree'];
			$xmlNode[$i]->attributes['disabled_module'] = $list[$i]['disabled_module'];
		}

		if($list[$i]['id']==$_GET['id']){
			$xmlNode[$i]->attributes['open'] = "1";
			$xmlNode[$i]->attributes['call'] = "1";
		}
		
		if(!isset($list[$i]['prm']) || $list[$i]['prm']==0)
			$xmlNode[$i]->attributes['checked'] = 1;
		else
			unset($xmlNode[$i]->attributes['checked']);

		for($k=0; $k<$m; $k++){
			if($parent[$k]['id']==$list[$i]['id']){
				$list[$i]['readonly'] = ($parent[$k]['prm']==1?1:0);
				break;
			}
		}
		
		//$xmlNode[$i]->attributes['tooltip'] = "asdsdfdsfsdd";
		
		//$xmlNode[$i]->attributes['readonly'] = $list[$i]['readonly'];
		if(isset($list[$i]['readonly']) && $list[$i]['readonly']==1){
			$xmlNode[$i]->attributes['nocheckbox'] = "1";
			$xmlNode[$i]->attributes['style'] = "color:#777;";
		}else{
			unset($xmlNode[$i]->attributes['nocheckbox']);
			unset($xmlNode[$i]->attributes['style']);
		}
		
//		$xmlNode[$i]->children[0]->name = "userdata";
//		$xmlNode[$i]->children[0]->attributes["name"] = "readonly";
//		$xmlNode[$i]->children[0]->content = isset($list[$i]['readonly'])?$list[$i]['readonly']:0;
		
		$xmlNode_1 = _xmlTree($xmlNode[$i], $list[$i]['id']);
			
		$xml->children[$i] = $xmlNode_1;

	}
	return $xml;
}

$xml->xmlTree->children[0] = _xmlTree($xml->xmlTree->children[0], $configFile->variable['default_page'][$_GET['lng']]);


$xml_source = $xml->objToXml($xml->xmlTree);
 
?>
