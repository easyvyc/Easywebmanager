<?php
/*
 * Created on 2006.3.21
 * menu.php
 * Vytautas
 */
 
$tpl_menu = & new easytpl(MODULESDIR.$module_name."/templates/menu.tpl", "templateVariables");

$tpl_menu->setVar('is_super_admin', $_SESSION['admin']['permission']==1?1:0);

$level = count( $record->path ) + ($_GET['page']=='list'?1:0);// (($EDIT_FORM===true && $item_data['is_category']==1)?1:0);

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']!=0){
	$record->loadItem($_GET['id']);	
}


$menu[] = array(
			'page_url'=>"main.php?content={$_GET['content']}&module={$record->module_info['table_name']}", 
			'title'=>$cms_phrases['main']['pages']['start'],
			'ico'=>'home',			
			'ajax'=>0,  
			'active'=>(($_GET['id']==0 && $_GET['new']!=1 && $_GET['page']=='list')?1:0)
			);


$url = ($_GET['parent_id']?"&parent_id={$_GET['parent_id']}":"").($_GET['new']?"&new={$_GET['new']}":"").($_GET['ce']?"&ce={$_GET['ce']}":"")."&ajax=1&area=inner_content";
if(($_GET['id']==0 && $_GET['new']==1) || $_GET['id']!=0){
	$menu[] = array(
				'page_url'=>"javascript: void(PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=edit&id={$_GET['id']}".$url."&area=tpl', 'inner_content'));", 
				'title'=>(($_GET['id']==0)?$cms_phrases['main']['catalog']['new_element']:$cms_phrases['modules']['context_menu']['edit']),
				'ajax'=>1,
				'ico'=>($item_data['lng_saved']==1?'edit':'not_saved'), 
				'active'=>($_GET['page']=='edit'?1:0)
				);
}

if($level <= $record->module_info['maxlevel'] && $record->module_info['maxlevel'] > 0 && $_GET['id']!=0){
	$menu[] = array(
				'page_url'=>"javascript: void(PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=list&id=".$_GET['id']."&ajax=1&area=tpl', 'inner_content'));", 
				'title'=>"{$cms_phrases['main']['pages']['elements_list']} ({$templateVariables->vars['not_empty_categories']})",
				'ajax'=>1,
				'ico'=>'inner', 
				'active'=>($_GET['page']=='list')?1:0
				);
}

/*if($_GET['id']!=0){
	$menu[] = array(
				'page_url'=>"javascript: void(PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=meta&id=".$_GET['id']."&ajax=1&area=tpl', 'inner_content'));", 
				'title'=>$cms_phrases['main']['pages']['meta_tags'],
				'ajax'=>1, 
				'ico'=>'meta',
				'active'=>($_GET['page']=='meta')?1:0
				);
}*/


// When page have module and is not new
if($item_data['mod_id'] && $item_data['isNew']!=1){
	
	$module->loadModule($item_data['mod_id']);
	$menu[] = array(
				'page_url'=>"javascript: void(PageClass.getPageContent('{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=module&id={$_GET['id']}&parent_id={$_GET['id']}".$url."&area=tpl', 'inner_content'));", 
				'title'=>$module->data['title'],
				'ico'=>'mod',
				'active'=>(($_GET['page']=='module' || $_GET['page']=='module_edit')?1:0)
				);
}

if(strlen($record->module_info['additional_settings'])>0){
	$menu[] = array(
					'page_url'=>"main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=settings&id={$_GET['id']}".$url, 
					'title'=>$cms_phrases['main']['catalog']['settings'],
					'ico'=>'settings', 
					'active'=>$_GET['page']=='settings'?1:0
					);	
}

//$menu[] = array('page_url'=>"main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=info&id=".(($EDIT_FORM===true)?$item_data['parent_id']:$templateVariables->vars['parent_id']), 'title'=>"{$cms_phrases['main']['catalog']['info_tab_title']}", 'active'=>($_GET['page']=='info')?1:0);

$tpl_menu->setLoop('menu', $menu);

$tpl_menu->parse();
$tpl->setCodeBlock('main_menu', 'include $tpl_menu->cacheFile;');

?>