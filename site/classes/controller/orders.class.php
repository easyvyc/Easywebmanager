<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_orders extends controller {
        
        // paypal
        private $paypal_test = true;
        private $paypal_account_email = "vytautas@delfai.lt";
        private $paypal_test_min_sum = false;
        
        private $eur = 3.45;
        
        // mokejimai.lt
        private $web2pay_test = false;
        private $web2pay_project_id = "63566";
        private $web2pay_sign_password = "3f1656d9668dffcf8119e3ecff873558";
	
	function __construct(){
		parent::__construct("orders");
	}
        
        function register_new_order($data){
            
            $order_data = array();
            $currency = $this->registry->controller->currencies->getCurrent();
            $order_data['currency'] = $currency['code'];
            $order_data['order_date'] = date('Y-m-d H:i:s');
            $order_data['order_sum'] = $data['cart']['allsum'];
            
            $order_data['discount_sum'] = $data['cart']['discount_sum'];
            $order_data['discount_code'] = $data['cart']['discount_code'];
            
            $order_data['title'] = $data['user']['title'];
            $order_data['phone'] = $data['user']['phone'];
            $order_data['email'] = $data['user']['email'];
            $order_data['city'] = $data['user']['city'];
            $order_data['address'] = $data['user']['address'];
            if($data['user']['usertype'] == 'company'){
                $order_data['company'] = $data['user']['company'];
                $order_data['company_code'] = $data['user']['company_code'];
                $order_data['company_vat'] = $data['user']['company_vat'];
            }
            $order_data['user_id'] = $this->registry->controller->users->getUserId();
            
            if($data['shipping']['shipping_type'] == 'by_address'){
                $order_data['shipping_type'] = $this->registry->controller->phrases->get('shipping_type_by_address');
                $order_data['address_shipping'] = $data['shipping']['address'];
                $order_data['city_shipping'] = $data['shipping']['city'];
            }else{
                $order_data['shipping_type'] = $this->registry->controller->phrases->get('shipping_type_by_self');
                //$order_data['address_shipping'] = $data['shipping']['place_data']['title'];
            }
            $order_data['info_shipping'] = $data['shipping']['info'];
            $order_data['shipping_price'] = $data['shipping']['price'];
            
            $order_data['payment'] = $data['pay']['pay'];
            
            $payser_arr = explode("::", $data['pay']['payment']);
            if($payser_arr[1]){
                $order_data['paysera_bank'] = $payser_arr[1];
            }
            
            $order_id = $this->mod->insert($order_data);
            
            foreach($data['items'] as $item){
                $product = array();
                $product['category_id'] = $order_id;
                $product['category_column'] = 'ordered_items';
                $product['title'] = $item['title'];
                $product['code'] = $item['code'];
                $product['rel_id'] = $item['id'];
                $product['price'] = $item['price'];
                $product['kiekis'] = $item['kiekis'];
                
                $product['modif'] = '';
                if(!empty($item['id_mod_arr'])){
                    $modif_arr = array();
                    foreach($item['id_mod_arr'] as $modif){
                        $modif_arr[] = $modif['group_title'] . ": " . $modif['title'];
                    }
                    $product['modif'] = implode("\n", $modif_arr);
                    $product['modif_ids'] = $item['id_mod_x_val'];
                }
                    
                $product['active'] = 1;
                $this->registry->model->ordered_items->insert($product);
            }
            
//            $settings = $this->mod->getSettings();
//            
//            $phrases = $this->registry->controller->phrases->loadPhrases();
//            TPL::setVar('phrases', $phrases);
//            TPL::setVar('o_data', $this->mod->loadItem($order_id));
//            TPL::setVar('o_items', $data['items']);
//            
//            TPL::setVar('message', $phrases['order_email_content']);
//            
//            $subject = str_replace("{order_nr}", $order_data['order_number'], $phrases['order_email_subject']);
//            
//            // Pirkejui
//            $this->registry->lib->email->set('settings', array('content_type'=>'text/html', 'charset'=>'UTF-8'));
//            $this->registry->lib->email->send($order_data['address'], $subject, TPL::parse(TPLDIR."cart/email_user.tpl"), $settings['title'], $settings['email']);
//            
//            // Administratoriui
//            $this->registry->lib->email->set('settings', array('content_type'=>'text/html', 'charset'=>'UTF-8'));
//            $this->registry->lib->email->send($settings['email'], $subject, TPL::parse(TPLDIR."cart/email_admin.tpl"), $settings['title'], "no-reply@no-reply.com");
            
            return $order_id;
            
        }
        
        function checkout($order_data){
            
            $order_data = $this->mod->loadItem($order_data);
            
            //$order_data['shipping_price'] = 0;
            $order_data['order_date'] = date('Y-m-d H:i:s');
            
            $html = "";
            
            $pay_data = $this->registry->model->payments->loadItem($order_data['payment']);
            $pay_code = parse___list_values(strip_tags($pay_data['code']));
            
            if($pay_code['type']=='paypal'){

                $paypal_obj = new paypal();
                $paypal_obj->submit = true;

                $paypal_obj->addVar('charset','UTF-8');
                //
                if($this->paypal_test){
                        $paypal_obj->addVar('business', 'vytautas-facilitator@delfai.lt');	/* Payment Test Email */
                }else{
                        $paypal_obj->addVar('business', $this->paypal_account_email);	/* Payment Email */
                }
                if($this->paypal_test_min_sum){
                    $all_sum = 4;
                }else{
                    $all_sum = number_format(($order_data['order_sum'] - $order_data['shipping_price']), 2, ".", "");
                }
                $paypal_obj->addVar('cmd','_xclick');
                $paypal_obj->addVar('amount', $all_sum);
                $paypal_obj->addVar('item_name', '' /*$pr_data['title']*/);
                $paypal_obj->addVar('item_number', '' /*$pr_data['id']*/);
                $paypal_obj->addVar('quantity','1');
                $paypal_obj->addVar('tax','0.00');
                $paypal_obj->addVar('invoice',$order_data['id']);
                $paypal_obj->addVar('shipping',$order_data['shipping_price']);
                $paypal_obj->addVar('currency_code',$order_data['currency']);
                $paypal_obj->addVar('no_shipping','1');
                $paypal_obj->addVar('rm','2');			
                /* Return method must be POST (2) for this class */
                /* Paypal IPN URL - MUST BE URL ENCODED */
                $paypal_obj->addVar('notify_url', Config::$val['site_url'] . "index.php?module=orders&method=paypal_callback&order_id={$order_data['id']}&lng=".$this->language);	

                $paypal_obj->addVar('return', Config::$val['site_url'] . $this->language . "/cart/finish?order_id={$order_data['id']}");

                $paypal_obj->useSandBox($this->paypal_test);

                $html = "<p style=\"text-align:center\"><img src='site/images/loading.gif' alt='loading...' style=\"vertical-align:middle;\" /></p>" . $paypal_obj->showForm();

            }
            
            if($pay_code['type']=='paysera'){

                require_once(CLASSDIR . 'WebToPay.php');

                try {

                    $request = WebToPay::buildRequest(array(
                        'projectid'     => $this->web2pay_project_id,
                        'sign_password' => $this->web2pay_sign_password,
                        'orderid'       => $order_data['id'],
                        'amount'        => $order_data['order_sum'] * 100,
                        'currency'      => $order_data['currency'],
                        'payment'       => $pay_code['bank'],
                        'country'       => 'LT',
                        'accepturl'     => Config::$val['site_url'] . $this->language . "/cart/finish?order_id={$order_data['id']}",
                        'cancelurl'     => Config::$val['site_url'] . $this->language . "/cart/cancel?order_id={$order_data['id']}",
                        'callbackurl'   => Config::$val['site_url'] . "index.php?module=orders&method=paysera_callback&order_id={$order_data['id']}&lng=".$this->language,
                        'test'          => ($this->web2pay_test ? 1 : 0),
                    ));

                    $html = '<form name="paysera" action="' . WebToPay::PAY_URL . '" method="post" style="display:inline;">'."\n";
                    $req = array();
                    foreach($request as $name=>$val){
                        $html .= '<input type="hidden" name="' . $name . '" value="' . htmlspecialchars($val) . '">' . "\n";
                    }
                    $html .= "</form><script type=\"text/javascript\"> document.forms[\"paysera\"].submit(); </script>";
                    $html .= "<p style=\"text-align:center\"><img src='site/images/loading.gif' alt='loading...' style=\"vertical-align:middle;\" /> </p>";
                    
                } catch (WebToPayException $e) {
                    // handle exception
                }                
                
            }
            
            // statistikai uzfiksuojam kad kazka atliko
            $_SESSION['conversion_id'] = 1;
            
            //$this->clearCart();
            return $html;
        }
        
        function send_feedback($order_id){
            
            $settings = $this->mod->getSettings();
            
            $order_data = $this->mod->loadItem($order_id);
            $order_items = $this->mod->listOrderedItems($order_id);
            
            $phrases = $this->registry->controller->phrases->loadPhrases();
            $page_settings = $this->registry->model->pages->getSettings();
            TPL::setVar('phrases', $phrases);
            TPL::setVar('o_data', $order_data);
            TPL::setVar('o_items', $order_items);
            TPL::setVar('config', Config::$val);
            TPL::setVar('settings', $settings);

            $subject = str_replace("{order_number}", $order_data['order_number'], $phrases['order_email_subject']);
            $subject = str_replace("{website}", $page_settings['page_title'], $subject);
            
            // Pirkejui
            $this->registry->lib->email->set('settings', array('content_type'=>'text/html', 'charset'=>'UTF-8'));
            $this->registry->lib->email->send($order_data['email'], $subject, TPL::parse(TPLDIR."cart/email_user.tpl"), $settings['title'], $settings['email']);

            // Administratoriui
            $this->registry->lib->email->set('settings', array('content_type'=>'text/html', 'charset'=>'UTF-8'));
            $this->registry->lib->email->send($settings['email'], $subject, TPL::parse(TPLDIR."cart/email_user.tpl"), $settings['title'], "no-reply@no-reply.com");
            
        }
        
        function paypal_callback(){
            $paypal_obj = new paypal();
            $paypal_obj->useSandBox($this->paypal_test);

            if($paypal_obj->checkPayment($_POST)){
                $this->mod->update(array('payed'=>1), array('record_id'=>$_POST['invoice']));
                $this->send_feedback($_POST['invoice'], $sid);
            }
        }
        
        function paysera_callback(){
            
            require_once(CLASSDIR . 'WebToPay.php');
            
            try {
                $response = WebToPay::checkResponse($_GET, array(
                        // Visu galimu parametru su aprasymais sarasa rasite zemiau.
                        'projectid'     => $this->web2pay_project_id,
                        'sign_password' => $this->web2pay_sign_password,
                ));

                $this->mod->update(array('payed'=>1), array('record_id'=>$response['orderid']));
                
                $this->send_feedback($response['orderid']);
                
                $content = ob_get_contents();
                ob_clean();
                echo 'OK';
                
            }catch (Exception $e) {
                echo get_class($e).': '.$e->getMessage();
                mail("v@adme.lt", Config::$val['pr_url'] . " paysera", get_class($e).': '.$e->getMessage());
            }	

            exit;            
            
        }        
        
		
}

?>
