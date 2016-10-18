<?php

include_once(APP_CLASSDIR."model.class.php");
class model_articles extends model {
	
        protected $paging = 12;
    
	function __construct(){
		
            parent::__construct("articles");

            $this->table_text = Config::$val['sb_text'];
            $this->table_tpl = Config::$val['sb_template'];

            if(is_numeric($this->module_info['xml_settings']['items_paging']['value']) && $this->module_info['xml_settings']['items_paging']['value'] > 1){
                $this->paging = $this->module_info['xml_settings']['items_paging']['value'];
            }

	}
        
        function listMain(){
            $query['orders'] = "R.sort_order DESC";
            $query['limit'] = array(0, 4);
            $list = $this->listSearchItems($query);
            return $list;
        }
        
        function listAllItems($offset = 0){
            $paging = $this->paging;
            
            $query['orders'] = "R.sort_order DESC";
            $query['limit'] = array($offset * $paging, $paging);
            $this->count = $this->getCountSearchItems($query);
            $list = $this->listSearchItems($query);
            
            return $list;
        }
        
        function getArticles($product_category, $offset = 0, $tag = ''){

            $paging = $this->paging;
            
            if($product_category){
                $query['relations']['category'] = $product_category;
            }
            if($tag){
                $tag_data = $this->registry->model->tags->loadByOne(array('title' => trim($tag)));
                if(!empty($tag_data)){
                    $query['relations']['tags'] = $tag_data['id'];
                }
            }
            
            $query['orders'] = "R.sort_order DESC";
            $query['limit'] = array($offset * $paging, $paging);
            $this->count = $this->getCountSearchItems($query);
            
            $list = $this->listSearchItems($query);
            
            return $list;
            
        }

        function listByTema($tema, $offset = 0){
            
            $paging = $this->paging;
            
            $query['relations'] = array('tema' => $tema);
            $query['orders'] = "R.sort_order DESC";
            $query['limit'] = array($offset * $paging, $paging);
            $this->count = $this->getCountSearchItems($query);
            $list = $this->listSearchItems($query);
            
            return $list;
        }
        
	function loadByUrl($path){
		$row = $this->db->select($this->table)
                                ->fields("*, record_id AS id")
                                ->where("page_url=:path")
                                ->where("active=1")
                                ->bind('path', $path)
                                ->row_array();
		if(is_numeric($row['id']) && $row['id'] != 0){
			$row['page_area'] = $this->getPageBlocks($row['id']);
		}
		return $row;
	}
        
	function loadItem($id){
            load_helpers("date");
            $data = parent::loadItem($id);
            if($data['category']){
                $page_data = $this->registry->model->pages->loadItem($data['category']);
                $data['page_url'] = $page_data['page_url'];
            }else{
                $page_data = $this->registry->model->pages->loadByTemplate('blog');
                $data['page_url'] = $page_data['page_url'];
            }
            $data['news_date_text'] = date_format_text($data['news_date'], $this->language);
            if($data['image']){
                $data['og_image'] = Config::$val['site_url'] . "index.php?module=articles&method=show_image&column=image&id={$data['id']}&w=300&h=300&t=auto";
            }
            $data['item_url'] = url_slug($data['title']);
            $data['url_to_share'] = urlencode(Config::$val['site_url'] . $data['page_url'] . $data['item_url'] . "-" . $data['id'] . ".html");
            return $data;
	}
        
        function loadItem_search($id){
		$data = parent::loadItem_search($id);
                $data['page_url'] = $this->language . "/" . $data['page_url'] . "-" . $data['id'] . ".html";
		return $data;
        }
        
        function listSearchItems($query){
            $query['joins'][] = "LEFT JOIN " . Config::$val['pr_code'] . "_pages P ON (P.record_id=T.category AND P.lng='$this->language')";
            $query['fields'][] = "DISTINCT R.id";
            $query['fields'][] = "T.*";
            $query['fields'][] = "R.*";
            $query['fields'][] = "P.page_url";
//            if(!$query['orders']) $query['orders'] = "RP.sort_order ASC, R.sort_order DESC";
            $list = parent::listSearchItems($query);
            foreach($list as $i => $val){
                $list[$i]['title'] = trim($val['title']);
                $list[$i]['item_url'] = url_slug($val['title']);
                if($list[$i]['tags']){
                    $arr = explode("::", $list[$i]['tags']);
                    $tags = array();
                    foreach($arr as $tag_id){
                        $tags[] = $this->registry->model->tags->loadItem($tag_id);
                    }
                    $list[$i]['tags'] = $tags;
                }
            }
            return $list;
        }
        
	
}

?>
