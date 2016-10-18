<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_cart extends controller {
	
    protected $settings = array();
	
    function __construct(){
        parent::__construct("cart");
        
        if($this->get['ajax']){
            TPL::setVar('currency', $this->registry->controller->currencies->getCurrent());
            TPL::setVar('phrases', $this->registry->controller->phrases->loadPhrases());
            TPL::setVar('lng', $this->language);
            TPL::setVar('lng_' . $this->language, true);
            TPL::setVar('get', $_GET);
        }
        
        TPL::setVar('get', $_GET);
        
    }
    
    function frame(){

        cms::getInstance()->add_css('cart');
        TPL::setVar('css', generate_css('site', cms::getInstance()->load_css()));
        
        $buffer = TPL::parse(TPLDIR."index.tpl");
        cms::ob_start();
        return $buffer;
    }
    
    function user_info(){
        
        cms::getInstance()->load_view_variables();
        
        if($_POST['action'] == 'user'){
            $this->mod->set_user($_POST);
            redirect(Config::$val['site_url'] . $this->language . "/cart/shipping_info");
        }
        
        TPL::setVar('cart_user', $this->mod->get_user());
        TPL::setVar('cart_data', $this->mod->load_cart());
        
        //TPL::setVar('cities', $this->registry->model->cities->listSearchItems());
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_user.tpl"));
        
        return $this->frame();
        
    }

    function shipping_info(){
        
        cms::getInstance()->load_view_variables();
        
        TPL::setVar('steps', $this->mod->steps('shipping_info'));
        TPL::setVar('steps_html', TPL::parse(TPLDIR."cart/steps.tpl"));
        
        if($_POST['action'] == 'shipping'){
            $this->mod->set_shipping($_POST);
            redirect(Config::$val['site_url'] . $this->language . "/cart/confirm");
        }
        
        //TPL::setVar('shipping_places', $this->registry->model->shipping_places->listSearchItems());
        TPL::setVar('cart_shipping', $this->mod->get_shipping());
        
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_shipping.tpl"));
        
        return $this->frame();
        
    }
    
    
    function pay_info(){
        
        cms::getInstance()->load_view_variables();
        
        if($_POST['action'] == 'pay'){
            $this->mod->set_pay($_POST);
            redirect(Config::$val['site_url'] . $this->language . "/cart/confirm");
        }
        
        TPL::setVar('payments', $this->registry->model->payments->listSearchItems());
        
        TPL::setVar('cart_pay', $this->mod->get_pay());
        
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_pay.tpl"));
        
        return $this->frame();
        
    }

    function confirm(){
        
        cms::getInstance()->load_view_variables();
        
        TPL::setVar('steps', $this->mod->steps('confirm'));
        TPL::setVar('steps_html', TPL::parse(TPLDIR."cart/steps.tpl"));
        
        if($_POST['action'] == 'confirm'){
            
            $data = array();
            $this->mod->set_pay($_POST);
            
            $data['pay'] = $this->mod->get_pay();
            $data['user'] = $this->mod->get_user();
            $data['shipping'] = $this->mod->get_shipping();
            $data['cart'] = $this->mod->load_cart();
            $data['items'] = $data['cart']['list_items'];
            
            $order_id = $this->registry->controller->orders->register_new_order($data);
            
            $html = $this->registry->controller->orders->checkout($order_id);
            
            $this->mod->clear_cart();
            
            if($html){
                TPL::setVar('message', $html);
                TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_message.tpl"));
                return $this->frame();
            }else{
                $this->registry->controller->orders->send_feedback($order_id);
                redirect(Config::$val['site_url'] . $this->language . "/cart/finish/?t=" . $order_id);
            }
            
        }
        
        TPL::setVar('payments', $this->registry->model->payments->listSearchItems());
        
        TPL::setVar('cart_shipping', $this->mod->get_shipping());
        TPL::setVar('cart_user', $this->mod->get_user());
        TPL::setVar('cart_data', $this->mod->load_cart());
        TPL::setVar('cart_items', $this->mod->list_items());
        
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_confirm.tpl"));
        
        return $this->frame();
        
    }

    function cancel(){
        cms::getInstance()->load_view_variables();
        
        if(is_numeric($this->get['order_id'])){
            $order_data = $this->registry->model->orders->loadItem($this->get['order_id']);
            $this->registry->model->orders->removeItem($this->get['order_id']);
        }
        
        TPL::setVar('message', '<p style="margin:50px;text-align:center;">' . $this->registry->controller->phrases->get('checkout_canceled') . '</p>');
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_message.tpl"));
        return $this->frame();
    }
    
    function finish(){
        cms::getInstance()->load_view_variables();
        
        if(is_numeric($this->get['t'])){
            $order_data = $this->registry->model->orders->loadItem($this->get['t']);
        }
        
        TPL::setVar('cart_finish_message_' . $order_data['payment'], 1);
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_finish.tpl"));
        return $this->frame();
    }
    
    function index(){
        
        cms::getInstance()->load_view_variables();
        
        TPL::setVar('steps', $this->mod->steps('index'));
        TPL::setVar('steps_html', TPL::parse(TPLDIR."cart/steps.tpl"));
        
        $cart_data = $this->mod->load_cart();
        TPL::setVar('cart_data', $cart_data);
        TPL::setVar('cart_items', $cart_data['list_items']);
        TPL::setVar('page_content', TPL::parse(TPLDIR."cart/cart_checkout.tpl"));
        
        return $this->frame();
    }
    
    function cart_checkout(){
        
        $product_id = $this->get['id'];
        $quantity = $this->get['q']; 
        $modif = $this->get['modif'];
        
        if($this->get['a'] == 'plus' || $this->get['a'] == 'minus'){
            $this->mod->add($product_id, $quantity, $modif);
        }
        if($this->get['a'] == 'remove' || $this->get['a'] && $quantity == 0){
            $this->mod->remove($product_id, $modif);
        }
        
        if(!$this->mod->check_discount_min_sum()){
            $this->mod->removeDiscount();
        }

        $json['cart_content'] = $this->load_view();
        $json['checkout_cart_content'] = TPL::parse(TPLDIR."cart/cart_checkout.tpl");
        
        return json_encode($json);
        
    }

    function add(){
        $product_id = $this->get['id'];
        $quantity = $this->get['q']; 
        parse_str(urldecode($this->get['modif']), $modif);
        
        if($this->registry->controller->products->check_modifications($product_id, $modif['modif'])){
            $this->mod->add($product_id, $quantity, $modif['modif']);
            TPL::setVar('added', true);
        }else{
            $product_data = $this->registry->model->products->loadItem($product_id);
            TPL::setVar('product_data', $product_data);
            $modif_values = $this->registry->model->products_modifications_values->listProductModifications($product_id);
            TPL::setVar('modif_values', $modif_values);
            TPL::setVar('modif_data', $modif['modif']);
        }
        
        $return['cart_content'] = $this->load_view();
        return json_encode($return);
    }
    
    function remove(){
        $product_id = $this->get['id'];
        $modif = $this->get['modif'];
        $this->mod->remove($product_id, $modif);
        $return['cart_content'] = $this->load_view();
        return json_encode($return);
    }
    
    function discount(){
        
        $json = array();
        
        $code = $this->post['code'];

        $discount_data = $this->registry->model->discount_codes->loadByOne(array('title' => $code));
        
        if(empty($discount_data)){
            $json['error'] = true;
            $json['msg'] = $this->registry->controller->phrases->get("discount_code_wrong");
            return json_encode($json);
        }
        if(!$this->mod->check_discount_min_sum($discount_data)){
            $json['error'] = true;
            $json['msg'] = $this->registry->controller->phrases->get("discount_code_min_cart_sum");
            return json_encode($json);
        }
        
        $this->mod->setDiscount($discount_data);

        $json['cart_content'] = $this->load_view();
        $json['checkout_cart_content'] = TPL::parse(TPLDIR."cart/cart_checkout.tpl");
        
        return json_encode($json);
        
    }
    
    function load_view(){

        $mainpage_data = $this->registry->model->pages->loadItem(Config::$val['default_page'][$this->language]);
        TPL::setVar('main_page', $mainpage_data);
        
        TPL::setVar('currency', $this->registry->controller->currencies->getCurrent());
        
        TPL::setVar('steps', $this->mod->steps('index'));
        TPL::setVar('steps_html', TPL::parse(TPLDIR."cart/steps.tpl"));
        
        $cart_data = $this->mod->load_cart();
        TPL::setVar('cart_data', $cart_data);
        TPL::setVar('cart_items', $cart_data['list_items']);
        
        return TPL::parse(TPLDIR."cart/cart.tpl");
    }
	
}

?>
