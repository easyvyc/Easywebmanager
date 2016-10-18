<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_products extends controller {
	
	function __construct(){
		parent::__construct("products");
	}
	
	// index page
	function index(){
		
	}
	
	function c_list(){
		TPL::setVar('category', $this->registry->model->inv->loadCategory($_GET['id']));
		TPL::setVar('products', $this->registry->model->inv->listItems($_GET['id']));
		$count = $this->registry->model->inv->getAllCount($_GET['id']);
		$paging = generatePaging($_GET['offset'], $count, $this->registry->model->inv->PAGING);
		TPL::setVar('paging', $paging['loop']);
		TPL::setVar('page_content', TPL::parse(TPLDIR."pages/products.tpl"));
		return $this->registry->controller->pages->frame();		
	}

	function info(){
		
		$product = $this->registry->model->inv->loadItem($_GET['id']);
		
		TPL::setVar('product', $product);
		TPL::setVar('category', $this->registry->model->inv->loadCategory($product['category']));
		
		TPL::setVar('product_number_in_list', $this->registry->model->inv->getItemNumber($product['category'], $product['sort_order']));
		TPL::setVar('products_count', $this->registry->model->inv->getAllCount($product['category']));
		
		TPL::setVar('next', $this->registry->model->inv->getNext($product['sort_order'], $product['category']));
		TPL::setVar('prev', $this->registry->model->inv->getPrev($product['sort_order'], $product['category']));
		
		TPL::setVar('encoded_product_url', urlencode($this->config['site_url'].$this->language."/products/info/".$product['url']."-".$product['id'].".html"));//{config.site_url}{lng}/products/info/{product.url}-{product.id}.html
		
		TPL::setVar('page_content', TPL::parse(TPLDIR."pages/product.tpl"));
		return $this->registry->controller->pages->frame();
		
	}
	
}

?>
