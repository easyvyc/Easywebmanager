<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_pages extends controller {
	
	public static $phrases;
	
	// current page data assoc array
	private $current_page = array();
	
	// path to current page increment array
	private $current_path = array();
	
        //private $css_files = array();
        
	function __construct(){
		
		parent::__construct("pages");
		
		self::$phrases = $this->registry->controller->phrases->loadPhrases();
		
                $page_data = $this->mod->loadByUrl($_GET['path']);
                $_SESSION['last_visited_page'] = $page_data;
                
                if($page_data['redirect'] && !cms::$_EDIT_MODE){
                    if(strpos($page_data['redirect'], 'http') === 0){
                        redirect($page_data['redirect']);
                    }else{
                        redirect(Config::$val['site_url'] . $page_data['redirect']);
                    }
                }
                
                $this->set_current_page($page_data);
                TPL::setVar('path', $this->current_path);
                cms::$global_var['current_path'] = $this->current_path;
                
                $current_path_ids = array();
                foreach($this->current_path as $item){
                    $current_path_ids[] = $item['id'];
                }
                
                cms::getInstance()->load_view_variables();
                
	}
        
	function frame(){
            
            TPL::setVar('css', generate_css('site', cms::getInstance()->load_css()));

            TPL::setVar('page_data', $this->current_page);
            
            $buffer = TPL::parse(TPLDIR."index.tpl");
            cms::ob_start();
            return $buffer;
	} 
        
	
	/**
	 * index page
	 */
	function index(){
		return $this->main();
	}
	
	function set_current_page($page_data){
		$this->current_page = $page_data;
		$this->current_path = $this->mod->path($page_data['id']);
	}
	
	function inner(){
            
                if($this->current_path[1]['id']){
                    $current_path_ids = array();
                    $path = $this->current_path;
                    foreach($path as $item){
                        $current_path_ids[] = $item['id'];
                    }
                    TPL::setVar('inner_menu', $this->mod->getMenu($this->current_path[1]['id'], $current_path_ids));
                    TPL::setVar('inner_menu_content', TPL::parse(TPLDIR . "inner_menu.tpl"));
                }
            
                TPL::setVar('page_data', $this->current_page);
		TPL::setVar('page_content', TPL::parse(TPLDIR."pages/inner.tpl"));
		return $this->frame();
	}
        
        function popup(){
                $_GET['ajax'] = 1;
                TPL::setVar('page_data', $this->current_page);
                if(cms::$_EDIT_MODE){
                    TPL::setVar('page_content', TPL::parse(TPLDIR."pages/popup.tpl"));
                    return $this->frame();            
                }else{
                    return json_encode(array('title'=>$this->current_page['header_title'], 'content'=>TPL::parse(TPLDIR."pages/popup.tpl")));
                }
        }

	function search(){
            if(strlen($_GET['q']) > 2){
                $search_list = $this->registry->model->record_lang->getSearchResults($_GET['q'], $_GET['offset']);
                $res_count = $this->registry->model->record_lang->getSearchResults_count($_GET['q']);
                $paging = generatePaging($_GET['offset'], $res_count, $this->registry->model->record_lang->get_paging());
                TPL::setVar('paging', $paging);
            }else{
                TPL::setVar('short_key', true);
            }
            TPL::setVar('page_data', $this->current_page);
            TPL::setVar('no_results', empty($search_list));
            TPL::setVar('search_results', $search_list);
            TPL::setVar('page_content', TPL::parse(TPLDIR."pages/search.tpl"));
            return $this->frame();
	}
        
	function sitemap(){
            $tree_list = $this->mod->loadTree(0);
            TPL::setVar('tree_list', $tree_list);
            TPL::setVar('page_data', $this->current_page);
            TPL::setVar('page_content', TPL::parse(TPLDIR."pages/sitemap.tpl"));
            return $this->frame();
	}
	
	function main(){
            
            cms::getInstance()->add_css('start');
            
//            $list = $this->registry->model->products->loadBy(array('show_in_main'=>1));
//            TPL::setVar('products', $list);
            
            TPL::setVar('flash', $this->registry->model->main_images->listSearchItems());
            
            TPL::setVar('main_link1', $this->mod->getMenu(14290));
            TPL::setVar('main_link2', $this->mod->getMenu(14631));
            TPL::setVar('main_link3', $this->mod->getMenu(15109));

            TPL::setVar('main_link1_page', $this->mod->loadItem(14290));
            TPL::setVar('main_link2_page', $this->mod->loadItem(14631));
            TPL::setVar('main_link3_page', $this->mod->loadItem(15109));
            
            TPL::setVar('start_page', 1);
            TPL::setVar('page_data', $this->current_page);
            TPL::setVar('page_content', TPL::parse(TPLDIR."pages/start.tpl"));
            return $this->frame();
	}
        
        function salonai(){
            
            //cms::getInstance()->add_css('salonai');
            
            $contacts = $this->registry->model->salonai->listSearchItems();
            foreach($contacts as $i => $cnt){
                $contacts[$i]['short_description'] = nl2br($contacts[$i]['short_description']);
                $contacts[$i]['short_description'] = preg_replace("/\n/", "", $contacts[$i]['short_description']);
                $contacts[$i]['short_description'] = preg_replace("/\r/", "", $contacts[$i]['short_description']);
            }
            TPL::setVar('contacts', $contacts);
            
            TPL::setVar('page_data', $this->current_page);
            TPL::setVar('page_content', TPL::parse(TPLDIR."pages/salonai.tpl"));
            return $this->frame();
            
        }
        
        function akcijos(){
            
            cms::getInstance()->add_css('products');
            TPL::setVar('page_data', $this->current_page);
            
            if($this->current_path[1]['id']){
                $current_path_ids = array();
                $path = $this->current_path;
                foreach($path as $item){
                    $current_path_ids[] = $item['id'];
                }
                TPL::setVar('inner_menu', $this->mod->getMenu($this->current_path[1]['id'], $current_path_ids));
                TPL::setVar('inner_menu_content', TPL::parse(TPLDIR . "inner_menu.tpl"));
            }
            
            if(is_numeric($_GET['_ID_'])){

                $product = $this->registry->model->products->loadItem($_GET['_ID_']);
                TPL::setVar('product_data', $product);
                
                $modif_values = $this->registry->model->products_modifications_values->listProductModifications($_GET['_ID_']);
                TPL::setVar('modif_values', $modif_values);

                $filters_values = $this->registry->model->products_fields_values->loadItem($_GET['_ID_']);
                TPL::setVar('filters_values', $filters_values);
                
                foreach($product['materials_arr'] as $i => $val){
                    $material_info = $this->registry->model->products_materials->loadItem($val['record_id']);
                    $product['materials_arr'][$i]['desc'] = $material_info['description'];
                }
                TPL::setVar('product_materials', $product['materials_arr']);
                $product_images = $this->registry->model->products_images->loadBy(array('product_id' => $_GET['_ID_']));
                TPL::setVar('product_images', $product_images);

                $this->current_page['page_title'] .= " - " . $product['title'];
                $this->current_page['description'] = $product['short_description'];
                
                if($product['image']){
                    $this->current_page['og_image'] = Config::$val['site_url'] . "index.php?module=products_images&method=show_image&column=image&id={$product['image_id']}&w=300&h=300&t=auto";
                }
                
                $keywords = array();
                foreach($this->current_path as $val){
                    $keywords[] = $val['title'];
                }
                $keywords[] = $product['title'];
                $this->current_page['keywords'] = implode(", ", $keywords);
                
                TPL::setVar('page_content', TPL::parse(TPLDIR . "products/item.tpl"));
                
            }else{
            
                $sort = array();
                if($this->get['sort_by']){
                    if($this->get['sort_dir']){
                        $_SESSION['products_sort']['by'] = $this->get['sort_by'];
                        $_SESSION['products_sort']['dir'] = $this->get['sort_dir'];
                    }else{
                        unset($_SESSION['products_sort']);
                    }
                }
                if(!empty($_SESSION['products_sort'])){
                    $sort = $_SESSION['products_sort'];
                }

                $products = $this->registry->model->products->listAkcijosItems($sort, $_GET['offset']);
                TPL::setVar('products', $products);

                $pr_obj_module_info = $this->registry->model->products->getProp('module_info');
                $paging = generatePaging($_GET['offset'], $this->registry->model->products->count, $pr_obj_module_info['xml_settings']['items_paging']['value'], 5);

                TPL::setVar('paging', $paging['loop']);
                TPL::setVar('is_paging', $paging);

                TPL::setVar('page_content', TPL::parse(TPLDIR . "products/list.tpl"));

            }
                
            return $this->frame();
            
        }
        
	function products(){
            
            cms::getInstance()->add_css('products');
            TPL::setVar('page_data', $this->current_page);
            
            if(is_numeric($_GET['_ID_'])){

                $product = $this->registry->model->products->loadItem($_GET['_ID_']);
                TPL::setVar('product_data', $product);
                
                $modif_values = $this->registry->model->products_modifications_values->listProductModifications($_GET['_ID_']);
                TPL::setVar('modif_values', $modif_values);

                $filters_values = $this->registry->model->products_fields_values->loadItem($_GET['_ID_']);
                TPL::setVar('filters_values', $filters_values);
                
                foreach($product['materials_arr'] as $i => $val){
                    $material_info = $this->registry->model->products_materials->loadItem($val['record_id']);
                    $product['materials_arr'][$i]['desc'] = $material_info['description'];
                }
                TPL::setVar('product_materials', $product['materials_arr']);
                $product_images = $this->registry->model->products_images->loadBy(array('product_id' => $_GET['_ID_']));
                TPL::setVar('product_images', $product_images);

                $this->current_page['page_title'] .= " - " . $product['title'];
                $this->current_page['description'] = $product['short_description'];
                
                if($product['image']){
                    $this->current_page['og_image'] = Config::$val['site_url'] . "index.php?module=products_images&method=show_image&column=image&id={$product['image_id']}&w=300&h=300&t=auto";
                }
                
                $keywords = array();
                foreach($this->current_path as $val){
                    $keywords[] = $val['title'];
                }
                $keywords[] = $product['title'];
                $this->current_page['keywords'] = implode(", ", $keywords);
                
                $product_request_site_block = $this->registry->model->site_blocks->loadByOne(array('title' => 'product_request'));
                TPL::setVar('product_request_site_block', $product_request_site_block['block_content']);
                
                $content_tpl = TPLDIR . "products/item.tpl";
                
            }else{
                
                $sort = array();
                if($this->get['sort_by']){
                    if($this->get['sort_dir']){
                        $_SESSION['products_sort']['by'] = $this->get['sort_by'];
                        $_SESSION['products_sort']['dir'] = $this->get['sort_dir'];
                    }else{
                        unset($_SESSION['products_sort']);
                    }
                }
                if(!empty($_SESSION['products_sort'])){
                    $sort = $_SESSION['products_sort'];
                }

                $main_filters_data = $this->registry->model->products->listCategoryValuesMainFilters($this->current_page['id'], $this->current_path);
                TPL::setVar('main_filters_data', $main_filters_data);
                
                $filters = $this->registry->model->products->listCategoryFilters($this->current_page['id'], $this->current_path);
                TPL::setVar('filters', $filters);
                
                $products = $this->registry->model->products->listCategoryItems($this->current_page['id'], $this->get['filter'], $sort, $this->get['offset']);
                TPL::setVar('products', $products);
                TPL::setVar('form_filters', $this->get['filter']);

                $get_filter_arr = array();
                foreach($this->get['filter'] as $key => $val){
                    if(is_array($val)){
                        foreach($val as $key_1 => $val_1){
                            $get_filter_arr[] = "filter[$key][$key_1]=$val_1";
                        }
                    }else{
                        $get_filter_arr[] = "filter[$key]=$val";
                    }
                }
                TPL::setVar('get_filter_str', implode("&", $get_filter_arr));
                
                $pr_obj_module_info = $this->registry->model->products->getProp('module_info');
                $paging = generatePaging($_GET['offset'], $this->registry->model->products->count, $pr_obj_module_info['xml_settings']['items_paging']['value'], 5);
                
                TPL::setVar('paging', $paging['loop']);
                TPL::setVar('is_paging', $paging);
                
                TPL::setVar('show_filters', true);
                
                $content_tpl = TPLDIR . "products/list.tpl";
            }
            
            if($this->current_path[1]['id']){
                $current_path_ids = array();
                $path = $this->current_path;
                foreach($path as $item){
                    $current_path_ids[] = $item['id'];
                }
                TPL::setVar('inner_menu', $this->mod->getMenu($this->current_path[1]['id'], $current_path_ids));
                TPL::setVar('inner_menu_content', TPL::parse(TPLDIR . "inner_menu.tpl"));
            }
            
            TPL::setVar('page_content', TPL::parse($content_tpl));
            return $this->frame();
	}        
        
	function blog(){
            
            cms::getInstance()->add_css('articles');
            TPL::setVar('page_data', $this->current_page);
            if(is_numeric($_GET['_ID_'])){

                $article = $this->registry->model->articles->loadItem($_GET['_ID_']);
                TPL::setVar('article', $article);
                
                $this->current_page['page_title'] .= " - " . $article['title'];
                $this->current_page['description'] = $article['short_description'];
                $this->current_page['og_image'] = $article['og_image'];
                
                $keywords = array();
                foreach($this->current_path as $val){
                    $keywords[] = $val['title'];
                }
                $keywords[] = $article['title'];
                $this->current_page['keywords'] = implode(", ", $keywords);

                $comments = $this->registry->model->comments->loadBy(array('category_id' => $_GET['_ID_']));
                foreach($comments as $i => $val){
                    $comments[$i]['title'] = nl2br($comments[$i]['title']);
                    $comments[$i]['c_date'] = substr($comments[$i]['c_date'], 0, 16);
                }
                TPL::setVar('comments', $comments);
                
                $tags = array();
                foreach($article['tags_arr'] as $tag){
                    $tags[] = $this->registry->model->tags->loadItem($tag['record_id']);
                }
                TPL::setVar('item_tags', $tags);
                
                TPL::setVar('page_content', TPL::parse(TPLDIR . "articles/item.tpl"));
                
            }else{
                
                $articles = $this->registry->model->articles->getArticles($this->current_path[2]['id'], $_GET['offset'], $_GET['tag']);
                TPL::setVar('items', $articles);

                $paging = generatePaging($_GET['offset'], $this->registry->model->articles->count, $this->registry->model->articles->getProp('paging'));
                TPL::setVar('paging', $paging['loop']);
                TPL::setVar('is_paging', $paging['is_paging']);

                TPL::setVar('page_content', TPL::parse(TPLDIR . "articles/list.tpl"));
                
            }
            return $this->frame();
	}
        
        function article(){
            
            cms::getInstance()->add_css('articles');
            TPL::setVar('page_data', $this->current_page);
            TPL::setVar('article', $this->registry->model->articles->loadItem($_GET['_ID_']));
            
            TPL::setVar('page_content', TPL::parse(TPLDIR . "articles/item.tpl"));
            return $this->frame();
            
        }
        
        function events(){
            
            TPL::setVar('page_data', $this->current_page);
            
            if(is_numeric($_GET['_ID_'])){
                
                $event_data = $this->registry->model->events->loadItem($_GET['_ID_']);
                TPL::setVar('event_data', $event_data);
                
                $this->current_page['page_title'] .= " - " . $event_data['title'];
                $this->current_page['description'] = $event_data['short_description'];
                
                $keywords = array();
                foreach($this->current_path as $val){
                    $keywords[] = $val['title'];
                }
                $keywords[] = $event_data['title'];
                $this->current_page['keywords'] = implode(", ", $keywords);

                TPL::setVar('page_content', TPL::parse(TPLDIR . "events/item.tpl"));
                
            }else{
                $this->registry->controller->events->showDayEvents();
            }
            
            return $this->frame();
        }
	
	// page not found 
	function page_not_found($msg){
		header('HTTP/1.0 404 Not Found');
		TPL::setVar('page_content', $msg);
		return $this->frame();
	}
	
	function error($number, $message, $file, $line){
		header('HTTP/1.0 404 Not Found');
		$error = array( 'type' => $number, 'message' => $message, 'file' => $file, 'line' => $line );
                TPL::setVar('page_content', "<pre>" . print_r($error, true) . "</pre>");
		return $this->frame();
	}
		
}

?>
