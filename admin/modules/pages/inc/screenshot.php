<?php
/*
 * Created on 2008.04.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$record_data = $this->main_object->call("pages", "loadItem", array($_GET['id']));
//$record_data = $main_object->get("pages", "data");

$template = $this->main_object->call("pages", "getTemplate", array($record_data['template']));
$template['map'] = $template['tmpl_image_map'];
$template['map'] = str_replace("%page%", $record_data['id'], $template['map']);
$tpl_module_name = ""; $target = "_self"; $content = "";
if($record_data['module_id'] > 0){
	
	$GLOBALS['module']->loadModule($record_data['module_id']);
	$tpl_module_name = $GLOBALS['module']->data['table_name'];

	$target = "_self";
	$content = "catalog";
	$script = "main";
	
}
$template['map'] = str_replace("%module%", $tpl_module_name, $template['map']);
//$template['map'] = str_replace("%script%", $script, $template['map']);
$template['map'] = str_replace("%content%", $content, $template['map']);

//$template['map'] = str_replace("%target%", $target, $template['map']);
//$id_path[0]['id'] = ($data['parent_id']==0?$data['id']:$id_path[0]['id']);

$this->main_object->call("pages", "getPath", array($_GET['id']));
$id_path = $this->main_object->get("pages", "path");

$template['map'] = str_replace("%path%0%", $id_path[0]['id'], $template['map']);
$template['map'] = str_replace("%path%1%", $id_path[1]['id'], $template['map']);
$template['map'] = str_replace("%path%2%", $id_path[2]['id'], $template['map']);
$template['map'] = str_replace("%path%3%", $id_path[3]['id'], $template['map']);
$template['map'] = str_replace("%path%4%", $id_path[4]['id'], $template['map']);


$record_data['template'] = $template;
$record_data['icourl'] = ICOTPLURL;
$record_data['isNew'] = $record_data['isNew'];

$record_data['title'] = ((mb_strlen($record_data['title'])>35)?mb_substr($record_data['title'], 0, 30, "UTF-8")."...":$record_data['title']);
$this->tpl[$v['column_name']]->setVar('elm', $record_data);



?>