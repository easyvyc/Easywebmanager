<?php 

include_once(APP_CLASSDIR."modules.class.php");
class modules_orders extends modules {
	
	function __construct() {
    	
    	parent::__construct("orders");
    	
    	//$this->mod_actions = array('edit'=>array(), 'send'=>array('title'=>array('lt'=>'Siųsti', 'en'=>'Send'), 'img'=>'mail'), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array(), 'settings'=>array());
    	$this->serija_numbers = substr_count($this->module_info['xml_settings']['serija']['value'], "*");
    	$this->serija = ereg_replace("\*", "", $this->module_info['xml_settings']['serija']['value']);
    	
    }
    
    function loadItem($id){
    	$data = record::loadItem($id);
    	$data['invoice_number'] = $this->serija.str_repeat("0", $this->serija_numbers-strlen($data['invoice_number'])).$data['invoice_number'];
    	return $data;
    }
    
	function getLastInvoiceNumber(){
		$sql = "SELECT MAX(invoice_number) AS max_number FROM $this->table";
		$this->db->exec($sql);
		$row = $this->db->row();
		return $row['max_number'];
	}
    
    function saveItem($data){
    	
    	$data['invoice_number'] = $this->getLastInvoiceNumber()+1;
    	$id = record::saveItem($data);
    	
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
		
		include_once(CLASSDIR."proforma.class.php");
		$proforma_obj = new proforma();
		
		foreach($this->module_info['xml_settings'] as $key=>$val){
			$invoice_data['rekvizitai'][$key] = $val['value'];
		}
		$invoice_data['order'] = $order_data;
		
		$ordered_items_obj = $this->registry->modules->create("ordered_items");
		$ordered_items_obj->sqlQueryWhere = " T.category_id={$order_data['id']} AND ";
		$invoice_data['ordered_items'] = $ordered_items_obj->listSearchItems();
		
		$proforma_obj->setData($invoice_data);
		
		$mailer->AddStringAttachment($proforma_obj->create('', 'S'), $order_data['invoice_number'].".pdf");
		
		$mailer->AddAddress($email);

		if($mailer->Send()){    	
			$sql = "UPDATE $this->table SET last_send_date=NOW() WHERE record_id=$id";
    		$this->db->exec($sql);
    		return true;
    	}
    	
    }
    
    function getContextMenu($item){
    
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit', 'module', 'proforma','pdf','mail','delete','translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		$act = "getContextMenuContent(\'{$this->config->variable['site_admin_url']}\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'list\',\'{$item['id']}\',\'$key\');";
    		$context[] = array('img'=>(isset($val['img'])?$val['img']:$key), 'name'=>$key, 'title'=>(isset($val['title'][$_SESSION['admin_interface_language']])?$val['title'][$_SESSION['admin_interface_language']]:$this->cmsPhrases['modules']['context_menu'][$key.'_title']), 'action'=>$act, 'main_action'=>$act);
    	}
		
		return $context;
		
    }    

}

?>