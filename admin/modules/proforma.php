<?php 

$orders_obj = $main_object->create("orders");

$order_data = $orders_obj->loadItem($_GET['id']);

include_once(CLASSDIR."proforma.class.php");
$proforma_obj = new proforma();

foreach($orders_obj->module_info['xml_settings'] as $key=>$val){
	$invoice_data['rekvizitai'][$key] = $val['value'];
}
$invoice_data['order'] = $order_data;

$ordered_items_obj = $main_object->create("ordered_items");
$ordered_items_obj->sqlQueryWhere = " T.category_id={$_GET['id']} AND ";
$invoice_data['ordered_items'] = $ordered_items_obj->listSearchItems();


$proforma_obj->setData($invoice_data);
$proforma_obj->create();


?>