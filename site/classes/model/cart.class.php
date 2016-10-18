<?php

include_once(APP_CLASSDIR."model.class.php");
class model_cart extends model {
	
    private $session_name = '__cart_items_';
    private $session_name_user = '__cart_user_info_';
    private $session_name_pay = '__cart_pay_info_';
    private $session_name_shipping = '__cart_shipping_info_';
    private $session_name_discount = '__cart_discount_';
    
    private $shipping_price_by_address = 3;
    
    private $vat = 21;
    
    function __construct(){
        parent::__construct("cart");
    }
    
    function set_key($product_id, $modif){
        if($modif){
            $keys = array_merge(array($product_id), (array)$modif);
            $session_key = implode("::", $keys);
        }else{
            $session_key = $product_id;
        }
        return $session_key;
    }
    
    function set_user($data){
        $_SESSION[$this->session_name_user] = $data;
    }
    
    function get_user(){
        if($_SESSION[$this->session_name_user]){
            $data = $_SESSION[$this->session_name_user];
        }elseif($_SESSION['logged_user']){
            $data = $_SESSION['logged_user'];
        }
        if($data['usertype'] == 'company') $data['usertype_company'] = true;
        else $data['usertype_private'] = true;
        return $data;
    }

    function set_pay($data){
        $_SESSION[$this->session_name_pay] = $data;
    }
    
    function get_pay(){
        $data = $_SESSION[$this->session_name_pay];
        $pmnt_arr = explode("::", $data['payment']);
        $pmnt = array_shift($pmnt_arr);
        if(is_numeric($pmnt)){
            $data['pay_data'] = $this->registry->model->payments->loadItem($pmnt);
        }
        return $data;
    }
    
    function set_shipping($data){
        $_SESSION[$this->session_name_shipping] = $data;
    }
    
    function get_shipping(){
        if(isset($_SESSION[$this->session_name_shipping])){
            $data = $_SESSION[$this->session_name_shipping];
        }else{
            $user_data = $this->get_user();
            $data['shipping_type'] = "by_address";
            $data['shipping_type_by_address'] = true;
            $data['city'] = $user_data['city'];
            $data['address'] = $user_data['address'];
        }
        $data['shipping_type_' . $data['shipping_type']] = true;
        $data['shipping_price_by_self'] = 0.00;
        $cart_data = $this->load_cart();
        $data['shipping_price_by_address'] = number_format($this->shipping_price_by_address, 2, ".", "");//$this->get_shipping_price($cart_data['svoris']);
        
        if($data['shipping_type']=='by_self') $data['price'] = $data['shipping_price_by_self'];
        else $data['price'] = $data['shipping_price_by_address'];
        $data['price_eur'] = eur($data['price']);
        
        if($data['place']){
            $data['place_data'] = $this->registry->model->shipping_places->loadItem($data['place']);
        }
        
        return $data;
    }

    function setDiscount($data){
        $_SESSION[$this->session_name_discount] = $data;
    }
    
    function getDiscount(){
        return $_SESSION[$this->session_name_discount];
    }
    
    function removeDiscount(){
        unset($_SESSION[$this->session_name_discount]);
    }
    
    function check_discount_min_sum($discount_data = array()){
        
        if(empty($discount_data)){
            $discount_data = $this->getDiscount();
        }
        
        $cart_data = $this->load_cart();
        if($cart_data['_SUMA_'] <= $discount_data['discount']){
            return false;
        }
        $discount_code_settings = $this->registry->model->discount_codes->getSettings();
        if($cart_data['_SUMA_'] < $discount_code_settings['min_cart_sum']){
            return false;
        }
        return true;
    }
    
    function get_shipping_price($svoris){
//        $shipping_price = $this->registry->model->shipping_price_table->loadByOne(array(
//                                                                                        'weight_from' => array('column' => 'weight_from', 'op' => '<', 'val' => $svoris), 
//                                                                                        'weight_to' => array('column' => 'weight_to', 'op' => '>=', 'val' => $svoris)
//                                                                                     ));
//        return $shipping_price['price'];
        
        return $this->shipping_price_by_address;
        
    }
    
    function add($product_id, $quantity, $modif){
        $session_key = $this->set_key($product_id, $modif);
        $_SESSION[$this->session_name][$session_key] = $quantity;
    }

    function remove($product_id, $modif){
        $session_key = $this->set_key($product_id, $modif);
        unset($_SESSION[$this->session_name][$session_key]);
    }
    
    function load_cart(){
        $list = $this->list_items();
        $sum = 0; $kiekis = 0; $svoris = 0;
        foreach($list as $val){
            $sum += $val['price_sum'];
            $kiekis += $val['kiekis'];
            $svoris += $val['weight'];
        }
        $cart_data['kiekis'] = $kiekis;
        $cart_data['svoris'] = $svoris;
        $cart_data['shipping_price'] = ($_SESSION[$this->session_name_shipping]['shipping_type'] == 'by_address' && $kiekis > 0 ? $this->get_shipping_price($svoris) : 0.00);
        
        $cart_data['_SUMA_'] = $sum;
        
        $discount_data = $this->getDiscount();
        if(!empty($discount_data)){
            $cart_data['discount_sum'] = number_format((empty($discount_data) ? 0 : $discount_data['discount']), 2, ".", "");
            $cart_data['discount_is'] = true;
            $cart_data['discount_code'] = $discount_data['title'];
            $sum -= $cart_data['discount_sum'];
        }
        
        $cart_data['allsum_no_shipping'] = number_format($sum, 2, ".", "");
        $cart_data['allsum'] = number_format($cart_data['allsum_no_shipping'] + $cart_data['shipping_price'], 2, ".", "");
        $cart_data['allsum_no_pvm'] = number_format($cart_data['allsum'] / 1.21, 2, ".", "");
        $cart_data['pvm'] = number_format($cart_data['allsum'] - $cart_data['allsum_no_pvm'], 2, ".", "");

        $cart_data['list_items'] = $list;
        
        return $cart_data;
    }
    
    function list_items(){
        $cart_items = array();
        if(!empty($_SESSION[$this->session_name])){
            foreach($_SESSION[$this->session_name] as $key => $quantity){
                $keys = explode("::", $key);
                $modifs = $keys;
                $product_id = array_shift($modifs);
                $cart_item = $this->registry->model->products->loadItem_main($product_id);
                $modif_arr = array();
                foreach($modifs as $modif_id){
                    $modif_data = $this->registry->model->products_modifications_options->loadItem($modif_id);
                    $modif_group_data = $this->registry->model->products_modifications->loadItem($modif_data['category_id']);
                    $modif_data['group_title'] = $modif_group_data['title_visible'];
                    $modif_arr[] = $modif_data;
                }
                $cart_item['id_mod_arr'] = $modif_arr;
                $cart_item['id_mod_x'] = implode("_", $keys);
                $cart_item['id_mod_x_val'] = $key;
                $cart_item['modifs'] = implode("::", $modifs);
                $cart_item['kiekis'] = $quantity;
                $cart_item['weight'] = $quantity * $cart_item['weight'];
                $cart_item['price_sum'] = number_format($quantity * $cart_item['price'], 2, ".", "");
                $cart_items[] = $cart_item;
            }
        }
        return $cart_items;
    }
    
    function clear_cart(){
        unset($_SESSION[$this->session_name]);
        unset($_SESSION[$this->session_name_pay]);
        unset($_SESSION[$this->session_name_discount]);
    }
    
    function steps($active){
        
        $phrases = $this->registry->controller->phrases->loadPhrases();
        
        $link[1] = 'index';
        $link[2] = 'user_info';
        $link[3] = 'shipping_info';
        $link[4] = 'confirm';
        for($i=1; $i<=4; $i++){
                $arr[] = array('num'=>$i, 'link'=>$link[$i], 'title'=>$phrases['order_step_'.$link[$i]], 'complited'=>(in_array($link[$i], $_SESSION['steps_complited'])?1:0), 'active'=>($active==$link[$i]?1:0));
        }
        return $arr;
    }
    
}

?>
