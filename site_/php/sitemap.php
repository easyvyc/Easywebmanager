<?php
/*
 * Created on 2005.12.15
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 
$tree = $main_object->call("pages", "loadTree", array(Config::$val['default_page'][$lng]));
$tpl_inner->setLoop('tree_list', $tree);

?>
