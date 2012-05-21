<?php
/*
 * Created on 2009.10.06
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(is_numeric($_GET['id'])){
	$product_data = $main_object->call("products", "showItem", $_GET['id']);
	$tpl_inner->setVar('item_data', $product_data);
	$data['page_title'] .= " - ".$product_data['title'];
	$data['description'] = $product_data['short_description'];
	$data['keywords'] = $product_data['title'];
}


?>