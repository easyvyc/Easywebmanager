<?php
/*
 * Created on 2007.07.13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$tpl_inner = & new easytpl(TPLDIR_."templates/others/rss.tpl", "templateVariables");

$tpl_inner->setVar('data', $data);


include_once(CLASSDIR."module.class.php");
$module_obj = module::getInstance();

$list = $module_obj->listModules();

foreach($list as $key=>$val){
	if($val['rss']==1){
		$rss_modules[] = $val;
	}
}

$tpl_inner->setLoop('modules', $rss_modules);

$tpl_inner->parse();
$tpl->setCodeBlock('page_content', 'include $tpl_inner->cacheFile;');

?>