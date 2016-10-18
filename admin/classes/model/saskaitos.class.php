<?php 

include_once(APP_CLASSDIR."model.class.php");
class model_saskaitos extends model {
	
	function __construct() {
		
    	parent::__construct("saskaitos");
    	
    	$this->serija_numbers = substr_count($this->module_info['xml_settings']['serija']['value'], "*");
    	$this->serija = ereg_replace("\*", "", $this->module_info['xml_settings']['serija']['value']);
    }

	function getLastInvoiceNumber(){
		$sql = "SELECT MAX(invoice_number) AS max_number FROM $this->table WHERE serija='$this->serija'";
		$this->db->exec($sql);
		$row = $this->db->row();
		return $row['max_number'];
	}
	
	function checkOrderInvoice($order_id){
    	$this->sqlQueryWhere = " T.order_id=$order_id AND ";
    	$list = $this->listSearchItems();
		if(empty($list)) return false;
		else return $list[0];
	}
	    
    function generateInvoice($order_id){
    	
    	if($this->checkOrderInvoice($order_id)){
    		return false;
    	}
    	
    	$orders_obj = $this->registry->model->create("orders");
    	
    	$order_data = $orders_obj->loadItem($order_id);
    	
    	$data['isNew'] = 1;
    	$data['id'] = 0;
    	$data['parent_id'] = 0;
    	$data['language'] = $this->language;
    	
    	$data['order_id'] = $order_id;
    	$data['invoice_date'] = date("Y-m-d");
    	$data['sum'] = $order_data['order_sum'];
    	
    	$data['invoice_number'] = $this->getLastInvoiceNumber()+1;
    	$data['serija'] = $this->serija;
    	
    	$data['title'] = $data['serija'].str_repeat("0", $this->serija_numbers-strlen($data['invoice_number'])).$data['invoice_number'];
    	
		include_once(CLASSDIR."proforma.class.php");
		$proforma_obj = new proforma();
		
		$proforma_obj->is_invoice = true;
		    	
		foreach($orders_obj->module_info['xml_settings'] as $key=>$val){
			$invoice_data['rekvizitai'][$key] = $val['value'];
		}
		$order_data['invoice_number'] = $data['title'];
		$invoice_data['order'] = $order_data;
		
		$ordered_items_obj = $this->registry->model->create("ordered_items");
		$ordered_items_obj->sqlQueryWhere = " T.category_id={$_GET['id']} AND ";
		$invoice_data['ordered_items'] = $ordered_items_obj->listSearchItems();

		$proforma_obj->setData($invoice_data);
		$proforma_obj->create(DOCROOT.$this->_table_fields['invoice']['list_values']['dir'].$data['title'].".pdf", 'F');
		$data['invoice'] = $data['title'].".pdf";
    	
    	$id = $this->saveItem($data);
    	
    	return $id;
    	
    }
    
    function send($id, $email, $subject, $text){
    	
    	include_once(CLASSDIR."phpmailer.class.php");
    	$mailer = new PHPMailer();

		$mailer->CharSet = "UTF-8";
		$mailer->ContentType = "text/plain";

		$mailer->Subject = $subject;
		$mailer->Body = $text;
					
		$mailer->From = $_SESSION['admin']['email'];
		$mailer->FromName = $_SESSION['admin']['firstname']." ".$_SESSION['admin']['lastname'];

		$order_data = $this->loadItem($id);
		
		$mailer->AddAttachment(DOCROOT.$this->_table_fields['invoice']['list_values']['dir'].$order_data['invoice'], $order_data['invoice']);
		
		$mailer->AddAddress($email);

		if($mailer->Send()){    	
			$sql = "UPDATE $this->table SET last_send_date=NOW() WHERE record_id=$id";
    		$this->db->exec($sql);
    		return true;
    	}
    	
    }    
    
    function delete($id){
    	$this->deleteFromTrash($id);
    }
    
}

?>