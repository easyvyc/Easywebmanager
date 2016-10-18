<?php

include_once(APP_CLASSDIR."basic.class.php");
class model_record_lang extends basic {
	
        private $paging = 30;
	private $description_length = 500;
	private $precise_key = false;
	private $highlight_search_result = "<span class='highlight_search_result'>\\0</span>";
        
    
	function __construct(){
            parent::__construct("record_lang");
            $this->table = Config::$val['pr_code'] . "_record_lang";
            $this->tables['record'] = Config::$val['sb_record'];
            $this->tables['module'] = Config::$val['sb_module'];
            $this->tables['module_info'] = Config::$val['sb_module_info'];
            $this->language = cms::$language;
	}
        
        function set_paging($pgng){
            $this->paging = $pgng;
        }
        
        function get_paging(){
            return $this->paging;
        }
	
        function getSearchResults_count($key){
            $row = $this->createSearchQuery($key)->fields("COUNT(*) AS cnt")->row_array();
            return $row['cnt'];
        }
        
        // skirta produktu paieskai special gbaldai.lv
	function getSearchResultsProductsOnly($key, $offset = 0, $sort = array()){
            $query = $this->createSearchQuery($key)->fields("T.record_id, M.table_name")->limit($offset * $this->paging, $this->paging);
            if(!empty($sort)){
                $query->joins("LEFT JOIN " . Config::$val['pr_code'] . "_products PR ON (T.record_id = PR.record_id AND PR.lng='{$this->language}')");
                $query->order("PR.{$sort['by']} {$sort['dir']}");
            }
            $results = $query->result_array();
            $list = array();
            foreach($results as $val){
                
                $data = $this->registry->model->{$val['table_name']}->loadItem_search($val['record_id']);
                
                $description = $data['_DESC_'];
                //$description = preg_replace("/<script([^>]*?)>([^(</script>)]*)<\/script>/si", "", $description);
                $description_lower = mb_strtolower($description, "UTF-8");

                if($this->precise_key!==true){
                        $max_search_count = 0; $description_value = mb_substr($description, 0, $this->description_length, "UTF-8");;
                        foreach($_arr_key as $k=>$v){
                                $pos = mb_strpos($description_lower, $v, 0, "UTF-8");
                                $start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
                                $str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
                                $description = mb_substr($description, $start_pos, $str_len, "UTF-8");
                                $search_count = 0;
                                foreach($_arr_key as $k1=>$v1){
                                        if(mb_strpos($description, $v1, 0, "UTF-8")) $search_count++;
                                }
                                if($max_search_count < $search_count){
                                        $max_search_count = $search_count;
                                        $description_value = $description;
                                }
                        }

                        $description = $description_value;

                        foreach($_arr_key as $k=>$v){
                                $description = eregi_replace("$v", $this->highlight_search_result, $description);
                                $data['title'] = eregi_replace($v, $this->highlight_search_result, $data['title']);
                        }
                }else{
                        $pos = mb_strpos($description_lower, $key, 0, "UTF-8");
                        $start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
                        $str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
                        $description = mb_substr($description, $start_pos, $str_len, "UTF-8");
                        //$description = $description;
                        $description = eregi_replace("$key", $this->highlight_search_result, $description);
                        $data['title'] = eregi_replace($key, $this->highlight_search_result, $data['title']);
                }

                $data['_description_'] = $description;
                
                $list[] = $data;
                
            }
            return $list;
	}
        
        
        // bendra standartine paieska
	function getSearchResults($key, $offset = 0){
            $results = $this->createSearchQuery($key)->fields("T.record_id, M.table_name")->limit($offset * $this->paging, $this->paging)->result_array();
            $list = array();
            foreach($results as $val){
                
                $data = $this->registry->model->{$val['table_name']}->loadItem_search($val['record_id']);
                
                $description = $data['_DESC_'];
                //$description = preg_replace("/<script([^>]*?)>([^(</script>)]*)<\/script>/si", "", $description);
                $description_lower = mb_strtolower($description, "UTF-8");

                if($this->precise_key!==true){
                        $max_search_count = 0; $description_value = mb_substr($description, 0, $this->description_length, "UTF-8");;
                        foreach($_arr_key as $k=>$v){
                                $pos = mb_strpos($description_lower, $v, 0, "UTF-8");
                                $start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
                                $str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
                                $description = mb_substr($description, $start_pos, $str_len, "UTF-8");
                                $search_count = 0;
                                foreach($_arr_key as $k1=>$v1){
                                        if(mb_strpos($description, $v1, 0, "UTF-8")) $search_count++;
                                }
                                if($max_search_count < $search_count){
                                        $max_search_count = $search_count;
                                        $description_value = $description;
                                }
                        }

                        $description = $description_value;

                        foreach($_arr_key as $k=>$v){
                                $description = eregi_replace("$v", $this->highlight_search_result, $description);
                                $data['title'] = eregi_replace($v, $this->highlight_search_result, $data['title']);
                        }
                }else{
                        $pos = mb_strpos($description_lower, $key, 0, "UTF-8");
                        $start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
                        $str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
                        $description = mb_substr($description, $start_pos, $str_len, "UTF-8");
                        //$description = $description;
                        $description = eregi_replace("$key", $this->highlight_search_result, $description);
                        $data['title'] = eregi_replace($key, $this->highlight_search_result, $data['title']);
                }

                $data['_description_'] = $description;
                
                $list[] = $data;
                
            }
            return $list;
	}
        
        function createSearchQuery($key){
            return $this->db->select($this->table . " T")
                            ->joins("LEFT JOIN {$this->tables['record']} R ON (T.record_id = R.id)")
                            ->joins("LEFT JOIN {$this->tables['module']} M ON (T.module_id = M.id)")
                            ->where('T.search_text LIKE :search_text')
                            ->where('T.lng = :lng')
                            ->where('R.trash != 1')
                            ->where('M.search = 1')
                            ->where('M.disabled != 1')
                            ->bind('search_text', "%$key%")
                            ->bind('lng', $this->language);
        }
    
}

?>
