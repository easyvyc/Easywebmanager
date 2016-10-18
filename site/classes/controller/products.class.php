<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_products extends controller {
	
	public static $phrases;
	
	function __construct(){
		parent::__construct("products");
		self::$phrases = $this->registry->controller->phrases->loadPhrases();
                TPL::setVar('phrases', self::$phrases);
                TPL::setVar('logged_user', $_SESSION['logged_user']);
                TPL::setVar('currency', array('title'=>'Lt', 'kursas'=>1));
	}
        
        function first_image(){
            $img = $this->registry->model->products_images->loadByOne(array('product_id' => $this->get['id']));
            return $this->registry->controller->products_images->show_image_func($img['record_id'], $this->get['column'], $this->get['w'], $this->get['h'], $this->get['t']);
        }
        
        function check_modifications($product_id, $modif = array()){
            $modif_values = $this->registry->model->products_modifications_values->listProductModifications($product_id);
            $ok = true;
            foreach($modif_values as $modif_val){
                $arr = explode("::", $modif_val['modif']);
                if(!isset($modif[$modif_val['id']]) || !in_array($modif[$modif_val['id']], $arr)) $ok = false;
            }
            return $ok;
        }
        
        function load(){
            $data = $this->mod->loadItem($_GET['item_id']);
            TPL::setVar('product', $data);
            $arr = array('title' => self::$phrases['product_open_dialog_title'], 'content' => TPL::parse(TPLDIR."products/product.tpl"));
            return json_encode($arr);
        }
        
        function add2cart(){
            
            //$_SESSION['cart'] = array('item_id'=>$_GET['item_id'], 'kiekis'=>$_GET['kiekis']);
            $this->registry->controller->orders->add2cart($_GET['item_id'], $_GET['kiekis']);
            
            if($_SESSION['logged_user']['id']){
                return $this->checkout();
            }else{
                $arr = array('title' => self::$phrases['product_open_dialog_title'], 'content' => TPL::parse(TPLDIR."products/pasirinkimas.tpl"), 'width' => 900);
            }
            
            return json_encode($arr);
        }
        
        function checkout(){
            if($_POST['action'] == 'checkout'){
                $html = $this->registry->controller->orders->checkout($_POST);
                $arr = array('title' => self::$phrases['payment_loading_title'], 'content' => $html);
                return json_encode($arr);
            }
            TPL::setVar('payments', $this->registry->model->payments->listSearchItems());
            $arr = array('title' => self::$phrases['checkout_dialog_title'], 'content' => TPL::parse(TPLDIR."products/checkout.tpl"));
            return json_encode($arr);
        }
        
        function product_request(){
            $product = $this->mod->loadItem($_GET['pid']);
            TPL::setVar('product', $product);
            $arr = array('title' => self::$phrases['product_email'], 'content' => TPL::parse(TPLDIR."products/product_request.tpl"));
            return json_encode($arr);
        }
        
        function purchase(){
            $arr = array('title' => self::$phrases['buy_dialog_title'], 'content' => TPL::parse(TPLDIR."products/purchase.tpl"));
            return json_encode($arr);
        }
        
		
}

?>
