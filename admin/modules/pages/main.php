<?php
/*
 * Created on 2007.09.20
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


if(!is_numeric($_GET['id'])) $_GET['id'] = 0;
$all_count = $record->listItemsElementsCount($_GET['id']);


//$tpl->setVar('not_empty_categories', $all_count);
//$tpl->setVar('not_empty_elements', $all_count);


?>