<?php
/*
 * Created on 2006.3.21
 * menu.php
 * Vytautas
 */
 
$tpl_menu = & new easytpl(MODULESDIR.$module_name."/templates/menu.tpl", "templateVariables");

$number = 1;
if($_GET['page']=='template' || $_GET['page']=='tpl_list'){
	$number = 2;
}elseif($_GET['page']=='edit_column' || $_GET['page']=='edit_module' || $_GET['page']=='modules' || $_GET['page']=='column_list'){
	$number = 3;
}elseif($_GET['page']=='editor_tpl_edit' || $_GET['page']=='editor_tpl_list'){
	$number = 4;
}elseif($_GET['page']=='editor_css_edit' || $_GET['page']=='editor_css_list'){
	$number = 5;
}elseif($_GET['page']=='menu_edit_column' || $_GET['page']=='menu_edit_module' || $_GET['page']=='menu_modules' || $_GET['page']=='menu_column_list'){
	$number = 6;
}elseif($_GET['page']=='toggle'){
	$number = 7;
}

$tpl_menu->setVar('block_'.$number, 1);

$tpl_menu->setVar('is_super_admin', $_SESSION['admin']['permission']==1?1:0);


$menu[] = array('page_url'=>'main.php?content=settings', 'title'=>$cms_phrases['main']['settings']['site_setting_title'], 'active'=>$number==1?1:0);
$menu[] = array('page_url'=>'main.php?content=settings&page=toggle', 'title'=>($XML_CONFIG['toggler']!=1?$cms_phrases['main']['settings']['site_enable']:$cms_phrases['main']['settings']['site_disable']), 'active'=>$number==7?1:0);
//$menu[] = array('page_url'=>'main.php?content=settings&page=system', 'title'=>$cms_phrases['main']['settings']['system_title'], 'active'=>$number==7?1:0);
if($_SESSION['admin']['permission']==1){
	$menu[] = array('page_url'=>'main.php?content=settings&page=tpl_list', 'title'=>$cms_phrases['main']['settings']['templates_title'], 'active'=>$number==2?1:0);
}

//$menu[] = array('page_url'=>'main.php?content=settings&page=modules', 'title'=>$cms_phrases['main']['settings']['modules_title'], 'active'=>$number==3?1:0);
$menu[] = array('page_url'=>'main.php?content=settings&page=editor_tpl_list', 'title'=>$cms_phrases['main']['settings']['wysiwyg_tpl_title'], 'active'=>$number==4?1:0);
$menu[] = array('page_url'=>'main.php?content=settings&page=editor_css_list', 'title'=>$cms_phrases['main']['settings']['wysiwyg_style_title'], 'active'=>$number==5?1:0);


$tpl_menu->setLoop('menu', $menu);

$tpl_menu->parse();

$tpl->setCodeBlock('menu', 'include $tpl_menu->cacheFile;');
 
?>
