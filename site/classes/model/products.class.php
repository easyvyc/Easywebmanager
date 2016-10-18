<?php

include_once(APP_CLASSDIR."model.class.php");
class model_products extends model {
	
        protected $paging = 20;
        private $papildomos_categories = false;
        
	function __construct(){
		
		parent::__construct("products");
		
	}
        
        function listMainItems(){
            $query['orders'] = "R.sort_order DESC";
            $query['limit'] = array(0, 20);
            $list = $this->listSearchItems($query);
            return $list;
        }
        
	function loadItem($id){
		$data = parent::loadItem($id);
                
                if($data['category']){
                    $page_data = $this->registry->model->pages->loadItem($data['category']);
                    $data['page_url'] = $page_data['page_url'];
                }
                
                $data['old_price'] = ($data['old_price']=='0.00'||!$data['old_price']||!$data['akcija']?0:$data['old_price']);
                
                $data['item_url'] = url_slug($data['title']);
                $data['url_to_share'] = urlencode(Config::$val['site_url'] . $this->language . $data['page_url'] . $data['item_url'] . "-" . $data['id'] . ".html");
                
                $product_image = $this->registry->model->products_images->loadByOne(array('product_id' => $id));
                
                if(!empty($product_image)){
                    $data['og_image'] = Config::$val['site_url'] . "index.php?module=products_images&method=show_image&column=image&id={$product_image['id']}&w=300&h=300&t=auto";
                    $data['image_id'] = $product_image['id'];
                }
                
		return $data;
	}
        
        function loadItem_search($id){
		$data = parent::loadItem_search($id);
                $data['page_url'] = $data['page_url'] . $data['item_url'] . "-" . $data['id'] . ".html";
		return $data;
        }
        
        function getCategoryListWhere($category){
            $this->registry->model->pages->getTreeIds($category);
            $tree_ids = $this->registry->model->pages->CategoriesTreeIds[$category];
            $index = 0; $tree_arr = $tree_lst = array();
            foreach($tree_ids as $tree_id){
                $tree_arr[] = "T.category=:___cat___" . $index;
                if($this->papildomos_categories) $tree_arr[] = "LST.list_item_id=:___cat___" . $index;
                $query['binds']['___cat___' . $index] = $tree_id;
                $index++;
            }
            $tree_arr[] = "T.category=:___cat___" . $index;
            if($this->papildomos_categories) $tree_arr[] = "LST.list_item_id=:___cat___" . $index;
            $query['binds']['___cat___' . $index] = $category;
            if(!empty($tree_arr))
                $query['where'] = "(" . implode(' OR ', $tree_arr) . ")";

            if($this->papildomos_categories) $query['joins'][] = "LEFT JOIN " . Config::$val['pr_code'] . "_relations LST ON (T.record_id=LST.item_id)";
            
            return $query;            
        }
        
        function listRelatedItems($category){
            $query = array();
            if(is_numeric($category)){
                $query = $this->getCategoryListWhere($category);
            }
            $query['orders'] = "RAND()";
            $query['limit'] = array(0, 4);
            return $this->listSearchItems($query);
        }
        
        function listAkcijosItems($sort=array(), $offset = 0){
            $query['where'] = " T.akcija=1 ";
            if($_SESSION['show_only_eshop_items']){
                $query['where'] .= " AND T.add2cart=1 ";
            }
            $paging = $this->module_info['xml_settings']['items_paging']['value'];
            $query['limit'] = array($offset * $paging, $paging);
            
            if(!empty($sort)){
                $query['orders'] = " T.{$sort['by']} {$sort['dir']} ";
            }
            
            $this->count = $this->getCountSearchItems($query);
            
            return $this->listSearchItems($query);
        }
        
        function listCategoryItems($category, $filters=array(), $sort=array(), $offset = 0){
            
            $query = array();
            if(is_numeric($category)){
                $query = $this->getCategoryListWhere($category);
            }
            if(!empty($filters)){
                $where_filters = array();
                $query['joins'] = array("LEFT JOIN " . Config::$val['pr_code'] . "_products_fields_values PV ON (T.record_id=PV.record_id AND PV.lng='$this->language')");
                foreach($filters as $filter_id => $filter_value){
                    if(isset($filter_value) && (strlen($filter_value) || !empty($filter_value))){
                        if(is_numeric($filter_id)){

                            if(is_array($filter_value)){
                                if($filter_value['min'] || $filter_value['max']){
                                    $where_filters[] = "PV.column_$filter_id >= :filter_value_min_$filter_id";
                                    $query['binds']['filter_value_min_' . $filter_id] = $filter_value['min'];
                                    $where_filters[] = "PV.column_$filter_id <= :filter_value_max_$filter_id";
                                    $query['binds']['filter_value_max_' . $filter_id] = $filter_value['max'];
                                }else{
                                    if($this->category_filters[$filter_id]['elm_type'] == FRM_CHECKBOX_GROUP){
                                        foreach($filter_value as $indx => $filter_value_item){
                                            $filter_value_arr[] = "PV.column_$filter_id LIKE :filter_value_1_" . $filter_id . "_" . $indx;
                                            $query['binds']['filter_value_1_' . $filter_id . "_" . $indx] = $filter_value_item;
                                            $filter_value_arr[] = "PV.column_$filter_id LIKE :filter_value_2_" . $filter_id . "_" . $indx;
                                            $query['binds']['filter_value_2_' . $filter_id . "_" . $indx] = "%" . $filter_value_item;
                                            $filter_value_arr[] = "PV.column_$filter_id LIKE :filter_value_3_" . $filter_id . "_" . $indx;
                                            $query['binds']['filter_value_3_' . $filter_id . "_" . $indx] = $filter_value_item . "%";
                                            $filter_value_arr[] = "PV.column_$filter_id LIKE :filter_value_4_" . $filter_id . "_" . $indx;
                                            $query['binds']['filter_value_4_' . $filter_id . "_" . $indx] = "%" . $filter_value_item . "%";
                                        }
                                    }else{
                                        if(!empty($filter_value)){
                                            $filter_value_arr = array();
                                            foreach($filter_value as $indx => $filter_value_item){
                                                $filter_value_arr[] = "PV.column_$filter_id = :filter_value_min_" . $filter_id . "_" . $indx;
                                                $query['binds']['filter_value_min_' . $filter_id . "_" . $indx] = $filter_value_item;
                                            }
                                            $where_filters[] = "(" . implode(" OR ", $filter_value_arr) . ")";
                                        }
                                    }
                                }
                            }else{
                                $where_filters[] = "PV.column_$filter_id = :filter_value_$filter_id";
                                $query['binds']['filter_value_' . $filter_id] = $filter_value;
                            }
                            
                        }else{
                            if(is_array($filter_value)){
                                $where_filters[] = "T.$filter_id >= :filter_value_min_$filter_id";
                                $query['binds']['filter_value_min_' . $filter_id] = $filter_value['min'];
                                $where_filters[] = "T.$filter_id <= :filter_value_max_$filter_id";
                                $query['binds']['filter_value_max_' . $filter_id] = $filter_value['max'];
                            }else{
                                $where_filters[] = "T.$filter_id = :filter_value_$filter_id";
                                $query['binds']['filter_value_' . $filter_id] = $filter_value;
                            }
                        }
                    }
                }
                if(!empty($where_filters))
                    $query['where'] .= " AND " . implode(" AND ", $where_filters);
            }
            $paging = $this->getPagingValue();
            $query['limit'] = array($offset * $paging, $paging);
            
            if(!empty($sort)){
                $query['orders'] = " T.{$sort['by']} {$sort['dir']} ";
            }

            $this->count = $this->getCountSearchItems($query);
            
            return $this->listSearchItems($query);
        }
        
        function listSearchItems($query){
            $query['joins'][] = "LEFT JOIN " . Config::$val['pr_code'] . "_pages P ON (P.record_id=T.category AND P.lng='$this->language')";
            $query['fields'][] = "DISTINCT R.id";
            $query['fields'][] = "T.*";
            $query['fields'][] = "R.*";
            $query['fields'][] = "P.page_url";
            $query['fields'][] = "IF(T.old_price > 0, FLOOR((T.old_price - T.price) * 100 / T.old_price), 0) AS discount_percent";
            if(!$query['orders']) $query['orders'] = "R.sort_order DESC";
            $list = parent::listSearchItems($query);
            foreach($list as $i => $val){
                $product_image = $this->registry->model->products_images->loadByOne(array('product_id' => $val['id']));
                if(!empty($product_image)) $list[$i]['image_id'] = $product_image['id'];
                $list[$i]['item_url'] = url_slug($val['title']);
                $list[$i]['old_price'] = ($list[$i]['akcija'] && $list[$i]['old_price'] > $list[$i]['price'] ? $list[$i]['old_price'] : 0);
                $list[$i]['price_eur'] = eur($list[$i]['price']);
                if($list[$i]['old_price']){
                    $list[$i]['old_price_eur'] = eur($list[$i]['old_price']);
                    $list[$i]['nuolaida_number'] = $list[$i]['old_price'] - $list[$i]['price'];
                    $list[$i]['nuolaida_percent'] = round($list[$i]['nuolaida_number'] * 100 / $list[$i]['old_price'], 0);//$list[$i]['old_price'] - $list[$i]['price'];
                }
            }
            return $list;
        }
        
        function listCategoryFilters($category_id, $pages_path = array()){

            if(empty($pages_path)){
                $pages_path = $this->registry->model->pages->path($category_id);
            }
            $query['where'] = "use_filter != 'none'";
            if(!empty($pages_path)){
                $where_path_arr = array();
                foreach($pages_path as $path_data){
                    $where_path_arr[] = "T.category_id = {$path_data['id']}";
                }
                $query['where'] .= " AND (" . implode(" OR ", $where_path_arr) . ") ";
            }else{
                return false;
            }
            
            $n_list = array();
            $list = $this->registry->model->products_fields->listSearchItems($query);
            foreach($list as $i => $val){
                $list[$i]['use_filter_' . $val['use_filter']] = true;
                if($val['use_filter'] == 'range'){
                    $minmax = $this->registry->model->products_fields_values->loadMinMax($val['id'], $category_id);
                    $list[$i]['min_value_rng'] = $list[$i]['min_value'] = $minmax['min_val'];
                    $list[$i]['max_value_rng'] = $list[$i]['max_value'] = $minmax['max_val'];
                    if($_GET['filter'][$val['id']]['min']){
                        $list[$i]['min_value_rng'] = $_GET['filter'][$val['id']]['min'];
                    }
                    if($_GET['filter'][$val['id']]['max']){
                        $list[$i]['max_value_rng'] = $_GET['filter'][$val['id']]['max'];
                    }
                }else{
                    $list[$i]['elm_type_list'] = in_array($val['elm_type'], array(FRM_SELECT, FRM_RADIO, FRM_CHECKBOX_GROUP));
                    if(!$list[$i]['elm_type_list']){
                        $list[$i]['options'] = $this->registry->model->products_fields_values->getOptionsValues($val['id'], $category_id, $val['use_filter']);
                    }else{
                        $list[$i]['options'] = $this->registry->model->products_fields_options->listOptions($val['id'], $_GET['filter'][$val['id']]);
                    }
                    $n_list[$list[$i]['id']] = $list[$i];
                }
            }
            
            $this->category_filters = $n_list;
            
            return $list;
        }
        
        function listCategoryValuesMainFilters($category_id){
            
            if(!$this->registry->model->products->categories_tree_temp[$category_id]){
                $this->registry->model->products->categories_tree_temp[$category_id] = $this->registry->model->pages->loadTree($category_id);
            }
            $where_path_arr = array();
            $where_path_arr[] = "T.category = $category_id";
            foreach($this->registry->model->products->categories_tree_temp[$category_id] as $path_data){
                $where_path_arr[] = "T.category = {$path_data['id']}";
            }
            $query_where = " (" . implode(" OR ", $where_path_arr) . ") ";

            $row = $this->db->select($this->table . " T")
                            ->fields("FLOOR(MIN(T.price)) AS min_price, CEIL(MAX(T.price)) AS max_price")
                            ->where($query_where)
                            ->where('T.lng = :lng')
                            ->bind('lng', $this->language)
                            ->row_array();
            
            $row['min_price'] = floordec($row['min_price'], 1);
            $row['max_price'] = ceildec($row['max_price'], 1);
            
            $step = rounddec(($row['max_price'] - $row['min_price']) / 4, 1);
            if(($row['max_price'] - $row['min_price']) > 100){
                $row['range_values_arr'] = true;
                $row['range_values']['v1'] = $row['min_price'];
                $row['range_values']['v2'] = $row['min_price'] + $step;
                $row['range_values']['v3'] = $row['min_price'] + $step * 2;
                $row['range_values']['v4'] = $row['min_price'] + $step * 3;
                $row['range_values']['v5'] = $row['max_price'];
            }else{
                $row['range_values_arr'] = false;
            }
            
            return $row;
            
        }
        
        function setPagingValue($paging){
            $_SESSION['selected_paging_number'] = $paging;
}

        function getPagingValue(){
            if($_SESSION['selected_paging_number']) return $_SESSION['selected_paging_number'];
            else return $this->module_info['xml_settings']['items_paging']['value'];
        }
        
        function getPagingOptions(){
            
            $opt = array();
            
            //$opt[] = array('value'=>3, 'title'=>'- 3 -');
            $opt[] = array('value'=>9, 'title'=>'- 9 -');
            $opt[] = array('value'=>18, 'title'=>'- 18 -');
            $opt[] = array('value'=>36, 'title'=>'- 36 -');
            $opt[] = array('value'=>72, 'title'=>'- 72 -');
            
            foreach($opt as $i => $val){
                if($val['value'] == $_SESSION['selected_paging_number']) $opt[$i]['selected'] = true;
            }
            
            return $opt;
            
        }
        
        function setSortingValue($sorting){
            $_SESSION['selected_sorting_value'] = $sorting;
        }
        
        function getSortingValue(){
            if($_SESSION['selected_sorting_value']) return $_SESSION['selected_sorting_value'];
        }
        
        
        function getSortingOptions(){
            
            $phrases = $this->registry->controller->phrases->loadPhrases();
            
            $opt = array();
            
            $opt[] = array('value'=>'priceasc', 'title'=>$phrases['sorting_priceasc']);
            $opt[] = array('value'=>'pricedesc', 'title'=>$phrases['sorting_pricedesc']);
            $opt[] = array('value'=>'abcasc', 'title'=>$phrases['sorting_abcasc']);
            
            foreach($opt as $i => $val){
                if($val['value'] == $_SESSION['selected_sorting_value']) $opt[$i]['selected'] = true;
            }
            
            return $opt;
            
        }
        
}

?>
