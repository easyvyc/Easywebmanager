<?php
/*
 * Created on 2006.5.2
 * module_admin_rights_tree.php
 * Vytautas
 */

if(!isset($_SESSION['admin']['permission'])) exit;


$lng = $_GET['lng'];

$record_obj = $main_object->create($_GET['module']);

$record_obj->getTableFields(1);

include_once(CLASSDIR."xmlini.class.php");
$xml = & new xmlIni();
//$xmlNode = new xmlIni();

//$item = $pages->load($configFile->variable['default_page'][$_GET['lng']]);

$xml->xmlTree->name = "tree";
$xml->xmlTree->attributes['id'] = "0";

$xml->xmlTree->children[0]->name = "item";

$record_obj->module_info['title'] = ereg_replace("&#39;", "'", $record_obj->module_info['title']);
$xml->xmlTree->children[0]->attributes['text'] = htmlspecialchars($record_obj->module_info['title']);
$xml->xmlTree->children[0]->attributes['id'] = 1;
$xml->xmlTree->children[0]->attributes['active'] = 1;
$xml->xmlTree->children[0]->attributes['checked'] = 1;
$xml->xmlTree->children[0]->attributes['open'] = "1";


$main_page_rights['readonly'] = ($main_page_rights_parent_admin['rights']==1?1:0);


function _xmlTree($xml, $id=0){
	global $record_obj, $configFile;
	$list = array();
	$xmlNode = null;
	$list = $record_obj->listAdminRights($configFile->variable['sb_admin_module_rights'], $_GET['id'], $record_obj->module_info['id'], $id);
	$parent = $record_obj->listAdminRights($configFile->variable['sb_admin_module_rights'], $_SESSION['admin']['id'], $record_obj->module_info['id'], $id);
	$n = count($list);
	$m = count($parent);
	for($i=0; $i<$n; $i++){
		
		$xmlNode[$i]->name = "item";
		
		$list[$i]['title'] = ereg_replace("&#39;", "'", $list[$i]['title']);
		$xmlNode[$i]->attributes['text'] = htmlspecialchars($list[$i]['title'])." ({$list[$i]['id']})";
		$xmlNode[$i]->attributes['id'] = $list[$i]['id'];
		$xmlNode[$i]->attributes['active'] = $list[$i]['active'];
		
		if($list[$i]['active']!=1){
			$xmlNode[$i]->attributes['im0'] = "disabled.gif";
			$xmlNode[$i]->attributes['im1'] = "disabled.gif";
			$xmlNode[$i]->attributes['im2'] = "disabled.gif";
		}
		
		if($list[$i]['id']==$_GET['id']){
			$xmlNode[$i]->attributes['open'] = "1";
			$xmlNode[$i]->attributes['call'] = "1";
		}
		
		if(!isset($list[$i]['prm']) || $list[$i]['prm']==0){
			$xmlNode[$i]->attributes['checked'] = 1;
		}else
			unset($xmlNode[$i]->attributes['checked']);
			

		for($k=0; $k<$m; $k++){
			if($parent[$k]['id']==$list[$i]['id']){
				$list[$i]['readonly'] = ($parent[$k]['prm']==1?1:0);
				break;
			}
		}
		//$xmlNode[$i]->attributes['readonly'] = $list[$i]['readonly'];
		
		$xmlNode[$i]->children[0]->name = "userdata";
		$xmlNode[$i]->children[0]->attributes["name"] = "readonly";
		$xmlNode[$i]->children[0]->content = isset($list[$i]['readonly'])?$list[$i]['readonly']:0;

		if(isset($list[$i]['readonly']) && $list[$i]['readonly']==1){
			$xmlNode[$i]->attributes['nocheckbox'] = "1";
			$xmlNode[$i]->attributes['style'] = "color:#777;";
		}else{
			unset($xmlNode[$i]->attributes['nocheckbox']);
			unset($xmlNode[$i]->attributes['style']);
		}

		
		$xmlNode_1 = _xmlTree($xmlNode[$i], $list[$i]['id']);
			
		$xml->children[$i] = $xmlNode_1;

	}
	return $xml;
}

$xml->xmlTree->children[0] = _xmlTree($xml->xmlTree->children[0]);

//pae($xml->xmlTree);

$xml_source = $xml->objToXml($xml->xmlTree); 
 
?>
