<?php
/*
 * Created on 2006.1.28
 * module_tree.php
 * Vytautas
 */


include_once(CLASSDIR."tpl.class.php");

if(!isset($_SESSION['admin']['permission'])) exit;

include_once(CLASSDIR."module.class.php");
$modules = new module();

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

$tpl_file = MODULESDIR."tree/templates/tree.tpl";

for($i=0; $i<$n; $i++){
	
	$list[$i]['display'] = 1;
	$list[$i]['submenu'] = '';
	
	$list[$i]['ico'] = 'blank';
//	if(!empty($sub)){
//		$list[$i]['sub'] = 1;
//		if($list[$i]['display']==1)
//			$list[$i]['ico'] = 'minus';
//		else
//			$list[$i]['ico'] = 'plus';
//	} 
	
	$list[$i]['img'] = 'leaf';
//	if($list[$i]['prm'] == 1){
//		$list[$i]['img'] = 'leaf_secure';
//	}
	if($list[$i]['disabled']==1){

		if($list[$i]['prm'] == 1){
			$list[$i]['img'] = 'secure_disabled';
		}else{
			$list[$i]['img'] = 'disabled';
		}

	}
	
	$list[$i]['a'] = ($_GET['id']==$list[$i]['id']?1:0);
	
	$CONTENT = "mod";
	$list[$i]['img_action'] = "main.php?content=$CONTENT&page=column_list&id={$list[$i]['id']}";	
	$list[$i]['action'] = "top.content.location=\'{$configFile->variable['site_admin_url']}main.php?content=$CONTENT&page=edit_module&id={$list[$i]['id']}\';";
	
	/*$context = array();
	
	$context[] = array('img'=>'edit', 'title'=>$cms_phrases['modules']['context_menu']['edit'], 'action'=>"main.php?content=$CONTENT&page=edit_module&id={$list[$i]['id']}");
	//$context[] = array('img'=>'preview', 'title'=>$cms_phrases['modules']['context_menu']['view'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id={$list[$i]['id']}");
	$context[] = array('img'=>'inner', 'title'=>$cms_phrases['modules']['context_menu']['view_inner'], 'action'=>"main.php?content=$CONTENT&page=column_list&id={$list[$i]['id']}");
	$context[] = array('img'=>'new_element', 'title'=>$cms_phrases['modules']['context_menu']['create_inner'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id=0&isNew=1&parent_id={$list[$i]['id']}");
//	$context[] = array('img'=>'tree', 'title'=>$cms_phrases['modules']['context_menu']['create_inner_category'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id={$list[$i]['id']}");
//	$context[] = array('img'=>'tree', 'title'=>$cms_phrases['modules']['context_menu']['create_inner_element'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id={$list[$i]['id']}");
	
//	if($record->module_info['table_name']=='pages'){
//		$context[] = array('img'=>'seo', 'title'=>$cms_phrases['main']['pages']['meta_tags'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=meta&id={$list[$i]['id']}");
//	}
	
	$context[] = array('img'=>'duplicate', 'title'=>$cms_phrases['main']['common']['duplicate_title'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id=0&parent_id={$list[$i]['parent_id']}&new=1&duplicate={$list[$i]['id']}");

	if($list[$i]['disabled']!=1)
		$context[] = array('img'=>'status_0', 'title'=>$cms_phrases['modules']['context_menu']['hide'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id={$list[$i]['id']}");
	else
		$context[] = array('img'=>'status_1', 'title'=>$cms_phrases['modules']['context_menu']['show'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id={$list[$i]['id']}");

	$context[] = array('img'=>'delete', 'title'=>$cms_phrases['modules']['context_menu']['delete'], 'action'=>"javascript: if(confirm('{$cms_phrases['modules']['context_menu']['delete_confirm']}')) top.content.location='{$configFile->variable['admin_site_url']}main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=list&action=delete&deleteid={$list[$i]['id']}&id={$list[$i]['parent_id']}';");
	
	$list[$i]['context'] = $context;*/
	
	if(!empty($list[$i]['context'])){
		$list[$i]['context_menu'] = 1;
	}
	
	
}
	

$tpl = & new template($tpl_file);

$tpl->setVar('data', array('id'=>0, 'display'=>'block'));
$tpl->setLoop('items', $list);

$tpl->setVar('config', $configFile->variable);
$tpl->setVar('mod', array('table_name'=>'catalog', 'id'=>0));
$tpl->setVar('lng', $_SESSION['site_lng']);
$tpl->setVar('get', $_GET);

echo $tpl->parse();
 
?>