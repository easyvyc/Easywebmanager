<?php
/*
 * Created on 2006.3.21
 * menu.php
 * Vytautas
 */


$tpl_menu = & new easytpl(MODULESDIR.$module_name."/templates/menu.tpl", "templateVariables");

$number = 1;
if($_GET['page']=='settings'){
	$number = 2;
}

$tpl_menu->setVar('block_'.$number, 1);

$tpl_menu->setVar('is_super_admin', $_SESSION['admin']['permission']==1?1:0);


$menu[] = array('page_url'=>'main.php?content=trash', 'title'=>$cms_phrases['main']['trash']['items_title'], 'active'=>$number==1?1:0);
$menu[] = array('page_url'=>'main.php?content=trash&page=settings', 'title'=>$cms_phrases['main']['trash']['settings'], 'active'=>$number==2?1:0);


$tpl_menu->setLoop('menu', $menu);

$tpl_menu->parse();

$tpl->setCodeBlock('menu', 'include $tpl_menu->cacheFile;');
 
?>
