<?php
/*
 * Created on 2006.3.21
 * menu.php
 * Vytautas
 */
 
$tpl_menu = & new easytpl(MODULESDIR.$module_name."/templates/menu.tpl", "templateVariables");




//$menu[] = array('title'=>$cms_phrases['main']['stat']['menu_title_day'], 'page_url'=>'main.php?content=stat&page=day', 'active'=>($number==1?1:0));
//$menu[] = array('title'=>$cms_phrases['main']['stat']['menu_title_month'], 'page_url'=>'main.php?content=stat&page=month', 'active'=>($number==2?1:0));
$menu[] = array('title'=>$cms_phrases['main']['stat']['menu_title_all'], 'page_url'=>'main.php?content=stat&page=custom', 'active'=>($_GET['page']=='custom'?1:0));
$menu[] = array('title'=>$cms_phrases['main']['stat']['menu_title_detail'], 'page_url'=>'main.php?content=stat&page=detail', 'active'=>($_GET['page']=='detail'?1:0));
$menu[] = array('title'=>$cms_phrases['main']['stat']['menu_title_conversion'], 'page_url'=>'main.php?content=stat&page=conversion', 'active'=>($_GET['page']=='conversion'?1:0));
$menu[] = array('title'=>$cms_phrases['main']['stat']['settings'], 'page_url'=>'main.php?content=stat&page=settings', 'active'=>($_GET['page']=='settings'?1:0));

$tpl_menu->setLoop('menu', $menu);


$tpl_menu->setVar('is_super_admin', $_SESSION['admin']['permission']==1?1:0);

$tpl_menu->parse();

$tpl->setCodeBlock('menu', 'include $tpl_menu->cacheFile;');
 
?>
