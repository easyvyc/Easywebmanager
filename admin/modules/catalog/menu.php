<?php
/*
 * Created on 2006.3.21
 * menu.php
 * Vytautas
 */
 
$tpl_menu = & new easytpl(MODULESDIR.$module_name."/templates/menu.tpl", "templateVariables");

$tpl_menu->setVar('is_super_admin', $_SESSION['admin']['permission']==1?1:0);

if(is_numeric($record->module_info['mod_pages']) && $record->module_info['mod_pages']!=0){
	$modules_list = $record->module->listModulesPages($record->module_info['mod_pages']);
}

$menu = array();
foreach($modules_list as $val){
	$menu[] = array(
			'page_url'=>"main.php?content={$_GET['content']}&module={$val['table_name']}", 
			'title'=>$val['title'],
			'ajax'=>0,  
			'active'=>(($_GET['module']==$val['table_name'])?1:0)
			);	
}

$tpl_menu->setLoop('menu', $menu);

$tpl->setVar('main_menu_block', (count($menu)>1?1:0));

$tpl_menu->parse();
$tpl->setCodeBlock('main_menu', 'include $tpl_menu->cacheFile;');

?>