<?php

include_once(CLASSDIR."catalog.class.php");

class orders extends catalog{
	
	function __construct(){
		
		parent::__construct("orders");
		
		$this->pvm = 21;
		
		$this->paging = 30;
		
		$this->currency = $this->registry->modules->get("products", "currency");
    	
		$this->serija_numbers = substr_count($this->module_info['xml_settings']['serija']['value'], "*");
    	$this->serija = ereg_replace("\*", "", $this->module_info['xml_settings']['serija']['value']);
		
	}
	
    function loadItem($id){
    	$data = record::loadItem($id);
    	$data['invoice_number'] = $this->serija.str_repeat("0", $this->serija_numbers-strlen($data['invoice_number'])).$data['invoice_number'];
    	return $data;
    }
    
    function listUserItems($user_id, $offset){
    	
    	if(!is_numeric($offset)) $offset = 0;
    	if(!is_numeric($user_id)) return false;
    	
    	$this->viewAllItems = true;
    	$this->sqlQueryWhere = " T.user_id=$user_id AND ";
    	$this->sqlQueryLimit = " LIMIT ".($this->paging*$offset).", $this->paging ";
    	$this->sqlQueryJoins = " LEFT JOIN ".Config::$val['pr_code']."_saskaitos S ON (S.order_id=R.id) ";
    	$this->fields .= " S.record_id AS sf, ";
    	
    	$this->items_count = $this->getCountSearchItems();
    	
    	$list = $this->listSearchItems();
    	
    	foreach($list as $i=>$val){
    		
    		$arr = array();
    		
    		if($val['title']) $arr[] = $val['title'];
    		if($val['phone']) $arr[] = $val['phone'];
    		if($val['email']) $arr[] = $val['email'];
    		if($val['city']) $arr[] = $val['city'];
    		if($val['address']) $arr[] = $val['address'];
    		if($val['company']) $arr[] = $val['company'];
    		if($val['notes']) $arr[] = $val['notes'];
    		$list[$i]['order_info'] = implode("<br />", $arr);
    		
    		$o_arr = array();
    		$ordered_items = $this->listOrderedItems($val['id']);
    		foreach($ordered_items as $val){
    			$o_arr[] = $val['title'];
    		}
    		$list[$i]['ordered_items'] = implode("<br />", $o_arr);
    		
    	}
    	//pa($list);
    	return $list;
    	
    }
    
    function downloadOrderPdf($order_id){
		
		$order_data = $this->loadItem($order_id);
		
		include_once(CLASSDIR."proforma.class.php");
		$proforma_obj = new proforma();
		
		foreach($this->module_info['xml_settings'] as $key=>$val){
			$invoice_data['rekvizitai'][$key] = $val['value'];
		}
		$invoice_data['order'] = $order_data;
		
		$ordered_items_obj = $this->registry->modules->create("ordered_items");
		$ordered_items_obj->viewAllItems = true;
		$ordered_items_obj->sqlQueryWhere = " T.category_id={$order_id} AND ";
		$invoice_data['ordered_items'] = $ordered_items_obj->listSearchItems();
		
		$proforma_obj->setData($invoice_data);
		$proforma_obj->create();

	}
	
    function downloadOrderSF($saskaitos_id){
		
    	$mod_obj = $this->registry->modules->create("saskaitos");
    	
		$item = $mod_obj->loadItem($saskaitos_id);
		
		$order_data = $this->loadItem($item['order_id']);
		
		if($order_data['user_id']!=$_SESSION['simple_user']['id']) return false;
		
	    if(isset($mod_obj->_table_fields['invoice']['list_values']['dir'])){
			$path = DOCROOT.$mod_obj->_table_fields['invoice']['list_values']['dir'];
		}elseif(isset($mod_obj->_table_fields['invoice']['list_values']['abs_dir'])){
			$path = $mod_obj->_table_fields['invoice']['list_values']['abs_dir'];
		}else{
			$path = UPLOADDIR;
		}
		
		include_once(CLASSDIR."files.class.php");
		$file_obj = new files();
		$file_obj->download($path.$item['invoice']);

	}	
    
    function listOrderedItems($order_id){
    	$ordered_items_obj = $this->registry->modules->create("ordered_items");
    	$ordered_items_obj->viewAllItems = true;
    	$ordered_items_obj->sqlQueryWhere = " T.category_id=$order_id AND ";
    	return $ordered_items_obj->listSearchItems();
    }
	
	function loadSteps(){
		// TODO: remove global variable
		global $phrases;
		$link[1] = 'cart';
		$link[2] = 'user';
		$link[3] = 'shipping';
		$link[4] = 'pay';
		$link[5] = 'confirm';
		for($i=1; $i<=5; $i++){
			$arr[] = array('num'=>$i, 'link'=>$link[$i], 'title'=>$phrases['order_step_'.$i], 'complited'=>(in_array($link[$i], $_SESSION['steps_complited'])?1:0), 'active'=>($_GET['step']==$link[$i]?1:0));
		}
		return $arr;
	}
	
	function loadCart(){
		$data['is_cart'] = 0;
		foreach($_SESSION['cart'] as $id=>$val){
			$data['sum'] += $val['price']*$val['kiekis'];
			foreach($val['sub'] as $sub_val){
				$data['sum'] += $sub_val['price']*$sub_val['kiekis'];
			}
			$data['is_cart'] += $val['kiekis'];
		}
		$data['sum_no_pvm'] = number_format($data['sum']*100/(100 + $this->pvm), 2, ".", "");
		$data['pvm'] = number_format($data['sum'] - $data['sum_no_pvm'], 2, ".", "");
		$data['sum'] = number_format($data['sum'], 2, ".", "");
		return $data;
	}
	
	function listCartItems(){
		//pae($_SESSION['cart']);
		foreach($_SESSION['cart'] as $id=>$val){
			if(!is_numeric($id)){
				$arr = explode("::", $id);
				$val['id'] = $arr[0];
				$n = count($arr);
				for($i=1; $i<$n; $i++){
					$val['modifications_list'][] = $this->registry->modules->call("select_values", "loadItem", $arr[$i]);
				}
				$val['is_modif'] = 1;
				$val['id_mod_x'] = implode("xxx", $arr);
			}else{
				$val['id'] = $id;
			}

			foreach($val['sub'] as $sub_val){
				$data['sum'] += $sub_val['price']*$sub_val['kiekis'];
			}
			
			$val['id_mod'] = $id;
			$items[] = $val;
		}
		return $items;
	}
	
	function add($item_id, $set_kiekis=0){
		if(!is_numeric($set_kiekis)) $set_kiekis = 0;
		if(is_numeric($_SESSION['cart'][$item_id]['kiekis'])) $kiekis = $_SESSION['cart'][$item_id]['kiekis'];
		if(!is_numeric($item_id)){
			$arr = explode("::", $item_id);
			$id = array_shift($arr);
			if(!is_numeric($id)) return false;
			$options = array();
			foreach($arr as $val){
				$d = explode("x", $val);
				$opt_data = $this->registry->modules->call($d[0], "loadItem", $d[1]);
				$pr_data = $this->registry->modules->call("products", "loadItem", $opt_data['title']);
				$pr_data['kiekis'] = ($opt_data['kiekis']?$opt_data['kiekis']:1)*($set_kiekis!=0?$set_kiekis:1);
				$pr_data['price'] = $pr_data['item_price'];
				$options[] = $pr_data;
			}
		}else{
			$id = $item_id;
		}
		$pr_data = $this->registry->modules->call("products", "loadItem", $id);
		$pr_data['price'] = $pr_data['item_price'];
		$pr_data['sub'] = $options;
		$pr_data['is_sub'] = count($options);
		$_SESSION['cart'][$item_id] = $pr_data;
		$_SESSION['cart'][$item_id]['kiekis'] = ($set_kiekis==0?$kiekis+1:$set_kiekis);
	}
	
	function remove($item_id){
		unset($_SESSION['cart'][$item_id]);
	}
	
	function loadOrderForm_shipping(){

		global $lng, $reserved_url_words, $record;

		$record = $this->registry->modules->create("shippings");
		
		include_once(CLASSDIR_."formaction.class.php");
		$formaction_obj = & new formaction();
		
		$action_data['title'] = "Registracija";
		$action_data['variable'] = "shipping";
		$action_data['target'] = "session";
		$action_data['module'] = $record->module_info['table_name'];
		$action_data['name'] = "shipping";
		$action_data['redirect'] = "$lng/{$reserved_url_words['order']}/{$reserved_url_words['step']}/pay/";
		$action_data['isNew'] = 1;
		$action_data['is_category'] = 0;
		$action_data['id'] = 0;
		$action_data['parent_id'] = 0;
		$action_data['language'] = $lng;
		$action_data['author_id'] = 0;
		
		//pae($_SESSION['order_info']);
		foreach($record->table_fields as $i=>$val){
			if(!empty($_SESSION['shipping'])){
				$record->table_fields[$i]['value'] = $_SESSION['shipping'][$val['column_name']];
			}else{
				$record->table_fields[$i]['value'] = (($val['elm_type']==FRM_SELECT || $val['elm_type']==FRM_CHECKBOX_GROUP || $val['elm_type']==FRM_RADIO)?$_SESSION['order_info'][$val['column_name']]:$_SESSION['order_info'][$val['column_name']]);
			}
		}
		
		$formaction_obj->setAction($action_data);
		$formaction_obj->setFields($record->table_fields);
		
		//$formaction_obj->form->elements['step'] = array('elm_type'=>FRM_HIDDEN, 'name'=>'step', 'value'=>'pay');

		unset($formaction_obj->form->elements['active']);
		unset($formaction_obj->form->elements['submit']);
		
		$_POST['id'] = $_SESSION['simple_user']['id'];
		//pae($_POST);
		$formaction_obj->setData($_POST);
		
		return $formaction_obj->process();			
		
	}
	
	function loadOrderForm_user(){

		global $lng, $reserved_url_words, $record;

		$record = $this->registry->modules->create("users");
		
		include_once(CLASSDIR_."formaction.class.php");
		$formaction_obj = & new formaction();
		
		$action_data['title'] = "Registracija";
		$action_data['variable'] = "order_info";
		$action_data['target'] = "session";
		$action_data['module'] = $this->module_info['table_name'];
		$action_data['name'] = "register";
		$action_data['redirect'] = "$lng/{$reserved_url_words['order']}/{$reserved_url_words['step']}/shipping/";
		$action_data['isNew'] = 1;
		$action_data['is_category'] = 0;
		$action_data['id'] = 0;
		$action_data['parent_id'] = 0;
		$action_data['language'] = $lng;
		$action_data['author_id'] = 0;
		
		//pae($_SESSION['order_info']);
		foreach($this->table_fields as $i=>$val){
			if(!empty($_SESSION['order_info'])){
				$this->table_fields[$i]['value'] = $_SESSION['order_info'][$val['column_name']];
			}else{
				$this->table_fields[$i]['value'] = (($val['elm_type']==FRM_SELECT || $val['elm_type']==FRM_CHECKBOX_GROUP || $val['elm_type']==FRM_RADIO)?$_SESSION['simple_user'][$val['column_name']."_ids"]:$_SESSION['simple_user'][$val['column_name']]);
			}
		}
		
		$formaction_obj->setAction($action_data);
		$formaction_obj->setFields($this->table_fields);
		
		/*
		$formaction_obj->form->editField('saskaita', array('field_extra_params'=>"onclick=\"javascript: if(this.checked) $('#id_company_name,#id_company_code,#id_company_address,#id_company_pvm').show(500); else $('#id_company_name,#id_company_code,#id_company_address,#id_company_pvm').hide(500); \""));
		if($_POST['saskaita']!=1){
			$formaction_obj->form->editField('company_name', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_code', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_address', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_pvm', array('extra_block_style'=>"display:none;"));
			if(isset($_POST['action'])){
				$_POST['company_name'] = strlen($_POST['company_name'])?$_POST['company_name']:"&nbsp;";
				$_POST['company_code'] = strlen($_POST['company_code'])?$_POST['company_code']:"&nbsp;";
				$_POST['company_address'] = strlen($_POST['company_address'])?$_POST['company_address']:"&nbsp;";
				$_POST['company_pvm'] = strlen($_POST['company_pvm'])?$_POST['company_pvm']:"&nbsp;";
			}
		}
		*/
		
		//$formaction_obj->form->elements['step'] = array('elm_type'=>FRM_HIDDEN, 'name'=>'step', 'value'=>'shipping');
		
		unset($formaction_obj->form->elements['invoice_number']);
		unset($formaction_obj->form->elements['payed']);
		unset($formaction_obj->form->elements['postcode']);
		unset($formaction_obj->form->elements['notes']);
		
		unset($formaction_obj->form->elements['order_date']);
		unset($formaction_obj->form->elements['order_sum']);
		unset($formaction_obj->form->elements['ordered_items']);
		unset($formaction_obj->form->elements['sep1']);
		unset($formaction_obj->form->elements['user_id']);
		unset($formaction_obj->form->elements['active']);
		unset($formaction_obj->form->elements['submit']);
		
		$_POST['id'] = $_SESSION['simple_user']['id'];
		//pae($_POST);
		$formaction_obj->setData($_POST);
		
		return $formaction_obj->process();	
		
	}

	function getShippingInfo(){
		
		$sh_obj = $this->registry->modules->create("shippings");
		
		$list = array();
		
		$city_data = $this->registry->modules->call("filters", "loadItem", $_SESSION['shipping']['city']);
		$list[] = array('title'=>$sh_obj->_table_fields['city']['title'], 'value'=>$city_data['title']);
		$list[] = array('title'=>$sh_obj->_table_fields['address']['title'], 'value'=>$_SESSION['shipping']['address']);
		$list[] = array('title'=>$sh_obj->_table_fields['postcode']['title'], 'value'=>$_SESSION['shipping']['postcode']);
		$list[] = array('title'=>$sh_obj->_table_fields['description']['title'], 'value'=>$_SESSION['shipping']['description']);
		
		return $list;
		
	}	
	
	function getUserInfo(){
		
		$list = array();
		
		foreach($this->table_fields as $i=>$val){
			if($val['column_name']=='city'){
				$city_data = $this->registry->modules->call("filters", "loadItem", $_SESSION['order_info'][$val['column_name']]);
				$val['value'] = $city_data['title'];
			}else{
				$val['value'] = $_SESSION['order_info'][$val['column_name']];
			}
			if($val['column_name']=='title' || $val['column_name']=='phone' || $val['column_name']=='email' || 
				$val['column_name']=='city' || $val['column_name']=='address' || $val['column_name']=='company'
				 || $val['column_name']=='company_code' || $val['column_name']=='pvm_code' || $val['column_name']=='company_address'){
				$list[] = $val;
			}
			
		}
		//pae($list);
		return $list;
		
	}
	
	function setPay(){
		
		if(isset($_POST['payment'])){
			$_SESSION['order_payment'] = $_POST['payment'];
			if(!in_array('pay', $_SESSION['steps_complited'])) $_SESSION['steps_complited'][] = 'pay';
			redirect(Config::$val['site_url'].$this->language."/order/step/confirm/");
		}	
		
	}	
	
	function getPayInfo(){
		
		return $this->registry->modules->call("payments", "loadItem", $_SESSION['order_payment']);
		
	}
	
	function getLastInvoiceNumber(){
		$sql = "SELECT MAX(invoice_number) AS max_number FROM $this->table";
		$this->db->exec($sql);
		$row = $this->db->row();
		return $row['max_number'];
	}
	
	function confirmOrder(){
		
		if(!isset($_POST['action']) || $_POST['action']!='confirm'){
			return false;
		}
		
		$cart_data = $this->loadCart();
		

		$data['isNew'] = 1;
		$data['id'] = 0;
		$data['parent_id'] = 0;
		$data['language'] = $this->language;
		
		$data['order_date'] = date("Y-m-d H:i:s");
		$data['order_sum'] = $cart_data['sum'];
		$data['order_sum_no_pvm'] = $cart_data['sum_no_pvm'];
		$data['order_sum_pvm'] = $cart_data['pvm'];
		$data['title'] = $_SESSION['order_info']['title'];
		$data['phone'] = $_SESSION['order_info']['phone'];
		$data['email'] = $_SESSION['order_info']['email'];
		$data['company'] = $_SESSION['order_info']['company'];
		$data['company_code'] = $_SESSION['order_info']['company_code'];
		$data['pvm_code'] = $_SESSION['order_info']['pvm_code'];
		$data['company_address'] = $_SESSION['order_info']['company_address'];
		
		$data['city'] = $_SESSION['shipping']['city'];
		$data['address'] = $_SESSION['shipping']['address'];
		$data['postcode'] = $_SESSION['shipping']['postcode'];
		$data['notes'] = $_SESSION['shipping']['description'];
		
		$data['pvm_dydis'] = $this->pvm;
		
		$data['invoice_number'] = $this->getLastInvoiceNumber()+1;
		
		$data['user_id'] = $_SESSION['simple_user']['id'];
		$data['active'] = 0;
		
		$id = $this->saveItem($data);
		
		$ordered_items_obj = $this->registry->modules->create("ordered_items");

		$cart_items = $this->listCartItems();
		foreach($cart_items as $val){
			$pr_data = array();
			$pr_data['title'] = $val['id'];
			$pr_data['price'] = $val['price'];
			$pr_data['kiekis'] = $val['kiekis'];
			$pr_data['modif'] = serialize($val['modifications_list']);
			$pr_data['category_id'] = $id;
			$pr_data['category_column'] = "ordered_items";
			$ordered_items_obj->insert($pr_data);
			foreach($val['sub'] as $sub_val){
				$pr_data = array();
				$pr_data['title'] = $sub_val['id'];
				$pr_data['price'] = $sub_val['price'];
				$pr_data['kiekis'] = $sub_val['kiekis'];
				$pr_data['modif'] = serialize($sub_val['modifications_list']);
				$pr_data['rel_id'] = $val['id'];
				$pr_data['category_id'] = $id;
				$pr_data['category_column'] = "ordered_items";
				$ordered_items_obj->insert($pr_data);
			}
		}
		
		$this->clearCart();
		
		$_SESSION['steps_complited'][] = 'confirm';
		
		$this->send($id, $data['email']);
		
		redirect(Config::$val['site_url'].$this->language."/order/step/end/");
		
		return $id;
	}
	
	function send($order_id, $email){
		
		global $phrases;
		
    	include_once(CLASSDIR."phpmailer.class.php");
    	$mailer = new PHPMailer();

		$mailer->CharSet = "UTF-8";
		$mailer->ContentType = "text/plain";

		$mailer->Subject = $phrases['order_email_subject'];
		$mailer->Body = ereg_replace("<br />", "", $phrases['order_email_body']);
					
		$order_data = $this->loadItem($order_id);
		
		include_once(CLASSDIR."proforma.class.php");
		$proforma_obj = new proforma();
		
		foreach($this->module_info['xml_settings'] as $key=>$val){
			$invoice_data['rekvizitai'][$key] = $val['value'];
		}
		$invoice_data['order'] = $order_data;

		$mailer->From = $invoice_data['rekvizitai']['email'];
		$mailer->FromName = $invoice_data['rekvizitai']['company'];
		
		$ordered_items_obj = $this->registry->modules->create("ordered_items");
		$ordered_items_obj->viewAllItems = true;
		$ordered_items_obj->sqlQueryWhere = " T.category_id={$order_data['id']} AND ";
		$invoice_data['ordered_items'] = $ordered_items_obj->listSearchItems();
		
		$proforma_obj->setData($invoice_data);
		
		$mailer->AddStringAttachment($proforma_obj->create('', 'S'), $order_data['invoice_number'].".pdf");
		
		$mailer->AddAddress($email);

		if($mailer->Send()){    	
			$sql = "UPDATE $this->table SET last_send_date=NOW() WHERE record_id=$order_id";
    		$this->db->exec($sql);
    		return true;
    	}
		
	}
	
	function clearCart(){
		unset($_SESSION['cart']);
	}
	
	function endOrder($order_id){
		global $phrases;
		unset($_SESSION['steps_complited']);
		return $phrases['order_grynais_success'];
	}
		
}

?>