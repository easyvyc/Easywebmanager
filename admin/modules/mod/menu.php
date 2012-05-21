<?php
/*
 * Created on 2006.3.21
 * menu.php
 * Vytautas
 */
 
$tpl_menu = & new easytpl(MODULESDIR.$module_name."/templates/menu.tpl", "templateVariables");

$tpl_menu->setVar('is_super_admin', $_SESSION['admin']['permission']==1?1:0);


$menu[] = array('page_url'=>"main.php?content=mod&page=modules", 'title'=>$cms_phrases['main']['catalog']['start'], 'active'=>$_GET['page']=='modules'?1:0);
$menu[] = array('page_url'=>"main.php?content=mod&page=import", 'title'=>$cms_phrases['main']['settings']['module']['import'], 'active'=>($_GET['page']=='import')?1:0);

if(isset($_GET['id'])){
	if($_GET['id']>0){
		$menu[] = array('page_url'=>"main.php?content=mod&page=edit&id={$_GET['id']}", 'title'=>$cms_phrases['main']['catalog']['template_edit'], 'active'=>$_GET['page']=='edit'?1:0);
	}
	$menu[] = array('page_url'=>"main.php?content=mod&page=edit_module&id={$_GET['id']}", 'title'=>$cms_phrases['main']['catalog']['mod_edit'], 'active'=>$_GET['page']=='edit_module'?1:0);
	if($_GET['id']>0){
		$menu[] = array('page_url'=>"main.php?content=mod&page=column_list&id={$_GET['id']}", 'title'=>$cms_phrases['main']['catalog']['fields_list'], 'active'=>($_GET['page']=='column_list' || $_GET['page']=='edit_column')?1:0);
		$menu[] = array('page_url'=>"main.php?content=mod&page=export&id={$_GET['id']}", 'title'=>$cms_phrases['main']['settings']['module']['export'], 'active'=>($_GET['page']=='export')?1:0);
		$menu[] = array('page_url'=>"main.php?content=mod&page=settings&id={$_GET['id']}", 'title'=>$cms_phrases['main']['catalog']['mod_settings'], 'active'=>$_GET['page']=='settings'?1:0);
	}
}


$tpl_menu->setLoop('menu', $menu);

$tpl_menu->parse();

$tpl->setCodeBlock('menu', 'include $tpl_menu->cacheFile;');
 
?>
