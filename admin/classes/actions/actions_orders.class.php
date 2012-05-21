<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_orders extends actions {

    function __construct() {
    	
    	parent::__construct();
    	
    	$this->mod_actions = array('edit'=>array(), 'new'=>array(), 'pdf'=>array('title'=>array('lt'=>'Sąskaitos', 'en'=>'Invoices')), /*'import'=>array(), 'export'=>array(), 'pdf'=>array(),*/ 'delete'=>array());
    	    	
    }

    function _mail(){
    	
    	
    }
    
    function _pdf(){
    	
    	global $easy_tpl, $cms_phrases, $module;
    	
    	$easy_tpl->setFile(MODULESDIR."extras/invoices.tpl");
    	
    	$orders_obj = $this->registry->modules->create("orders");
    	$order_data = $orders_obj->loadItem($_GET['id']);
    	
    	$saskaitos_obj = $this->registry->modules->create("saskaitos");
    	
    	if(!$invoice_data = $saskaitos_obj->checkOrderInvoice($order_data['id'])){
    		$order_data['is_invoice'] = 0;
    		if($_GET['generate']==1){
    			$order_data['is_invoice'] = $saskaitos_obj->generateInvoice($order_data['id']);
    		}
    	}else{
    		$order_data['is_invoice'] = $invoice_data['id'];
    	}
    	
    	if(is_numeric($order_data['is_invoice']) && $order_data['is_invoice']!=0){
    		$invoice_data = $saskaitos_obj->loadItem($order_data['is_invoice']);
    		if($invoice_data['last_send_date']=='0000-00-00 00:00:00') $invoice_data['last_send_date'] = '';
    		$easy_tpl->setVar('invoice_data', $invoice_data);
    	}
    	
    	if(isset($_POST['action']) && $_POST['action']=='proforma_send'){
    		$orders_obj->send($order_data['id'], $_POST['email'], $_POST['subject'], $_POST['text']);
    	}

    	if(isset($_POST['action']) && $_POST['action']=='invoice_send'){
    		$saskaitos_obj->send($invoice_data['id'], $_POST['email'], $_POST['subject'], $_POST['text']);
    	}
    	
    	$easy_tpl->setVar('config', $this->config->variable);
    	$easy_tpl->setVar('get', $_GET);
    	
    	if($order_data['last_send_date']=='0000-00-00 00:00:00') $order_data['last_send_date'] = '';
    	$easy_tpl->setVar('order_data', $order_data);
    	$easy_tpl->setVar('phrases', $cms_phrases['main']['orders']);

    }
     
}

?>