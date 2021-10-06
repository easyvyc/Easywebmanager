<?php

include_once(CLASSDIR."basic.class.php");
include_once(CLASSDIR."main_module.class.php");
class model extends basic {

	public $record_columns = array('id', 'parent_id', 'create_date', 'sort_order', 'trash', 'module_id', 'create_by_admin', 'last_modif_date', 'last_modif_by_admin');
	
        public $CategoriesTreeIds = array();
        
	private $admin = array('id'=>0);
	
    public $language;
    
    protected $load_module_info = true;
    
    function __construct($module) {
    	
    	parent::__construct($module);
    	
        // Module language
        $this->language = cms::$language;

        $this->table = Config::$val['pr_code'].'_'.$module;
        $this->tables['record'] = Config::$val['sb_record'];
        $this->tables['module'] = Config::$val['sb_module'];
        $this->tables['module_info'] = Config::$val['sb_module_info'];
        $this->tables['record_history'] = Config::$val['pr_code'] . "_record_history";
        $this->tables['relations'] = Config::$val['sb_relations'];

        if($this->load_module_info){
            $this->module_info = $this->getModule($module);
            $this->table_fields = $this->getTableFields();
        }

        if($this->module_info['additional_settings']){
            load_helpers('xml');
            $this->module_info['xml_settings'] = XML_Array::xmlStringToArray(html_entity_decode($this->module_info['additional_settings']));
        }
		
    }
    
    function setAdmin($admin){
    	$this->admin = $admin;
    }
    
    function getModule($id_or_name){
        return $this->db->select($this->tables['module'])
		        		 ->fields("*")
		        		 ->fields("title_lt AS title")
		        		 ->where("id=:id OR table_name=:table_name")
		        		 ->bind('id', $id_or_name)
		        		 ->bind('table_name', $id_or_name)->row_array();
        		 
    }
    
    function getTableFields(){
        $list = $this->db->select($this->tables['module_info'])
		        		 ->fields("*")
		        		 ->fields("title_lt AS title")
		        		 ->where("module_id=:module_id")
		        		 ->bind('module_id', $this->module_info['id'])
		        		 ->result_array();
        foreach($list as $i => $val){
            if($val['list_values']) $list[$i]['list_values'] = parse___list_values($val['list_values']);
        }
        return $list;
    }      
    
    function loadItem_search($id){
        $data = $this->loadItem($id);
        $desc = "";
        foreach($this->table_fields as $val){
            if(in_array($val['elm_type'], array(FRM_TEXT, FRM_TEXTAREA, FRM_HTML))){
                $desc .= " " . $data[$val['column_name']];
            }
        }
        $data['_DESC_'] = trim(html2text($desc));
        return $data;
    }
    
    function loadItem_main($id){
    	$n = count($this->table_fields);
        for($i=0, $fields=array(); $i<$n; $i++){
            $fields[] = $this->table_fields[$i]['column_name'];
        }
        
        $index_column_name = ($this->module_info['no_record_table']!=1?"record_id":"id");
        
        $query['where'] = array($index_column_name => $id);
        
        $list = $this->listSearchItems($query);
        $data = $list[0];
        
        return $data;
        
    }
    
    function loadItem($id, $extra = false){

    	$data = $this->loadItem_main($id);
        
        if($this->module_info['no_record_table']!=1){
        	$data['id'] = $data['record_id'];
        }
        				 
        if(!empty($data)) {
            $data['isNew'] = 0;
            $n = count($this->table_fields);
            for($j=0; $j<$n; $j++){
        		if($this->table_fields[$j]['list_values']['source']=='DB'){
                            
                            if($this->table_fields[$j]['list_values']['no_rel'] != 1){
        			$relations_list = $this->getRelations(Config::$val['sb_relations'], $data['id'], $this->table_fields[$j], $this->language);
        			$c = count($relations_list); $value = ""; $title = ""; $rel_arr = array();
        			for($k=0; $k<$c; $k++){
        				$value .= $k!=0?"::":"";
        				$value .= $relations_list[$k]['value'];

        				$title .= $k!=0?";":"";
        				$title .= $relations_list[$k]['title'];
                                        
                                        $rel_arr[] = $relations_list[$k];
        			}
        			$data[$this->table_fields[$j]['column_name']."_list"] = $title;
                                $data[$this->table_fields[$j]['column_name'] . "_arr"] = $rel_arr;
        			$data[$this->table_fields[$j]['column_name']] = $value;
                                
                            }elseif($this->table_fields[$j]['list_values']['multiple'] != 1){
                                
                                $module_name = $this->table_fields[$j]['list_values']['module'];
                                $rel_data = $this->registry->model->{$module_name}->loadItem($data[$this->table_fields[$j]['column_name']]);
                                $data[$this->table_fields[$j]['column_name'] . "_list"] = $rel_data['title'];
                                
                            }else{
                                
                                $ids = explode("::", $data[$this->table_fields[$j]['column_name']]);
                                $module_name = $this->table_fields[$j]['list_values']['module'];
                                foreach($ids as $list_item_id){
                                    $rel_data = $this->registry->model->{$module_name}->loadItem_main($list_item_id);
                                    $data[$this->table_fields[$j]['column_name'] . "_arr"][] = $rel_data;
                                }
                            }
        		}
        		if($this->table_fields[$j]['elm_type'] == FRM_TEXTAREA){
        			$data[$this->table_fields[$j]['column_name']] = nl2br($data[$this->table_fields[$j]['column_name']]);
        		}
        	}
        	if($this->module_info['no_record_table']!=1){
		        $arr = $this->db->select($this->tables['record'])
		        				->where("id=:id")
		        				->bind('id', $id)
		        				->row_array();
		        if(!empty($arr)) {
		            foreach($arr as $key=>$val) {
		            	$data[$key] = $val;
		            }
		        }
        	}
        	
                if($extra){
                    $data['_PAGE_URL_'] = url_slug($data['title']);
                    $data['_DATE_'] = substr($data['create_date'], 0, 10);
                    $data['_AUTHOR_'] = $this->getAuthor($data['create_by_admin']);
                }
			
        	return $data;
        	
        } else {
            return false;
        }
    	
    }

	function listItems(){
		
//		$where = $binds = array();
//	        $where[] = "(R.trash!=1 OR R.trash IS NULL)";
//		if($this->module_info['multilng']==1){
//		        $where[] = "lng=:lng";
//	        	$binds['lng'] = $this->language;
//	        }
                
                return $this->listSearchItems();
		
//		$arr = $this->db->select($this->table . " T")
//						->fields("T.*, R.id AS id, R.module_id")
//						->joins("LEFT JOIN cms_record R ON R.id=T.record_id")
//						->where($where)
//						->bind($binds)
//						->result_array();
//		return $arr;
		
	}  
        
        function getTreeIds($cid){
            if(!empty($this->CategoriesTreeIds[$cid])) return $this->CategoriesTreeIds[$cid];
            $this->CategoriesTreeIds[$cid] = array();
            $list = $this->loadBy(array('parent_id' => $cid));
            foreach($list as $page_item){
                $this->CategoriesTreeIds[$cid][] = $page_item['id'];
                $tree_ids = $this->getTreeIds($page_item['id']);
                $this->CategoriesTreeIds[$cid] = array_merge($this->CategoriesTreeIds[$cid], $tree_ids);
            }
            return $this->CategoriesTreeIds[$cid];
        }


	function saveItem($data){
		
		if(is_numeric($data['id']) && $data['id']!=0){
			$id = $this->update($data, array('record_id'=>$data['id']));
		}else{
			$id = $this->insert($data);
		}
		
		return $id;
	}
    
        function updateField($id, $column, $value){
            $cond['record_id'] = $id;
            $data[$column] = $value;
            $this->update($data, $cond);
        }
        
	function update($data, $cond){
		
		$binds = $values = array();
		foreach($data as $key=>$val){
			$binds[$key] = $val;
			$values[] = "$key=:$key";
		}

		if(isset($data['id']) && is_numeric($data['id'])){
			$binds['record_id'] = $data['id'];
			$values[] = "record_id=:record_id";
		}
		
        foreach ($cond as $key => $val) {
            if(is_array($val)){
                $op = $val['op'];
                $value = $val['val'];
                $binds[$key . "_w"] = $value;
                $where[] = "$key $op :" . $key . "_w";
            }else{
                $binds[$key . "_w"] = $val;
                $where[] = "$key=:" . $key . "_w";
            }
        }
		
		$this->db->update($this->table)
				->values($values)
				->bind($binds)
				->where($where)
				->query();   		
		
		return $record_id;
		
	}
	
	function insert($data){
        
		if(!isset($data['parent_id']) || !is_numeric($data['parent_id'])){
			$data['parent_id'] = 0;
		}
		
		if(!isset($data['item_target_id'])){
			$data['item_target_id'] = 0;
		}
		
                if($this->module_info['no_record_table']!=1){
                    
                    $new_sort_order = $this->get_new_sort_order($data['parent_id']);

                    $this->db->insert($this->tables['record'])
                                    ->values("parent_id=:parent_id, module_id=:module_id, create_by_ip=:create_by_ip, create_by_admin=:create_by_admin, 
                                                            last_modif_by_admin=:create_by_admin, last_modif_by_ip=:create_by_ip, last_modif_date=NOW(), create_date=NOW(), 
                                                            sort_order=:sort_order")
                                    ->bind('parent_id', $data['parent_id'])
                                    ->bind('module_id', $this->module_info['id'])
                                    ->bind('create_by_ip', $_SERVER['REMOTE_ADDR'])
                                    ->bind('create_by_admin', $this->admin['id'])
                                    ->bind('sort_order', $new_sort_order)
                                    ->query();

                    $record_id = $this->db->last_insert_id();
                    
                }
		
		unset($data['item_target_id']);
		unset($data['parent_id']);
		
		$binds = $values = array();
		foreach($this->table_fields as $i=>$val){
                        $key = $val['column_name'];
                        if(isset($data[$key])){
                            $binds[$key] = $data[$key];
                            $values[] = "$key=:$key";
                        }
		}

                if($record_id){
                    $binds['record_id'] = $record_id;
                    $values[] = "record_id=:record_id";
                }
		
		$this->db->insert($this->table)
				->values($values)
				->bind($binds)
				->query();   		
		
		$table_id = $this->db->last_insert_id();
                
                // TODO: save relation
                
                //$this->registerEdit($record_id, array(), $data);
				
		return ($record_id ? $record_id : $table_id);
		
	}
	
    private function registerEdit($id, $old_data, $new_data){
    	$before = serialize($old_data);
    	$after = serialize($new_data);
	    $this->db->insert($this->tables['record_history'])
	    		 ->values("record_id=:record_id, data_before=:data_before, data_after=:data_after, modif_date=NOW(), admin_id=:admin_id")
	    		 ->bind('record_id', $id)
	    		 ->bind('data_before', $before)
	    		 ->bind('data_after', $after)
	    		 ->bind('admin_id', $this->admin['id'])
	    		 ->query();
    }
	
	function get_new_sort_order($parent_id = 0){
		$row = $this->db->select($this->tables['record'])
						->fields("MAX(sort_order) AS last_sort_order")
						->where("module_id=:module_id")
						->where("parent_id=:parent_id")
						->bind("module_id", $this->module_info['id'])
						->bind("parent_id", $parent_id)
						->limit(0,1)
						->row_array();
		return $row['last_sort_order'] + 1;
	}
	
        function checkExists($column, $value, $id){
                $cond[$column] = $value;
                if($id){
                    $cond['record_id'] = array('value'=>$id, 'op'=>'<>');
                }
                $arr = $this->loadBy($cond, true);
		return (!empty($arr) ? true : false);
        }
	

    function getPath($id, $path = array()){
    	$data = $this->loadItem($id);
    	$path[] = $data;
    	if($data['parent_id'] != 0){
    		$this->getPath($data['parent_id'], $path);
    	}else{
    		$this->path = array_reverse($path);
                $this->path[(count($this->path) - 1)]['last'] = true;
    	}
    }
    
    function path($id){
    	$path = $this->getPath($id);
    	return $this->path;
    }
    
    function loadNext($category, $sort_order){

    	if(isset($category) && is_numeric($category)){
    		$where['category'] = $category;
    	}
    	$where['sort_order'] = array('op'=>">", 'val'=>$sort_order);
    	
		$query = array(
						'limit'=>array(0, 1), 
						'where'=>$where,
						'orders'=>'R.sort_order DESC'
				);
		list($next) = $this->listSearchItems($query);
		
		$next['page_url'] = url_slug($next['title']);
		return $next;
		
    }
	
    function loadPrev($category, $sort_order){
    	
    	if(isset($category) && is_numeric($category)){
    		$where['category'] = $category;
    	}
    	$where['sort_order'] = array('op'=>"<", 'val'=>$sort_order);
    	
		$query = array(
						'limit'=>array(0, 1), 
						'where'=>$where,
						'orders'=>'R.sort_order DESC'
				);
		list($prev) = $this->listSearchItems($query);
		
		$prev['page_url'] = url_slug($prev['title']);
		return $prev;
		
    }    
    
    function loadByOne($cond, $all = false){
        $data = $this->loadBy($cond, $all);
        if(!empty($data[0])) return $data[0];
        else return array();
    }
    
	function loadBy($cond, $all = false){
		
		$binds = $where = array();
//		foreach($cond as $key=>$val){
//			if(is_array($val)){
//				$binds[$key] = $val['value'];
//				$where[] = (in_array($key, $this->record_columns)?"R.":"T.")."$key {$val['op']} :$key";
//			}else{
//				$binds[$key] = $val;
//				$where[] = (in_array($key, $this->record_columns)?"R.":"T.")."$key=:$key";
//			}
//		}
                
                $where = $cond;
                
                if(!$all){
                    $where['active'] = 1;
                }
		
                $query['where'] = $where;
                $query['joins'] = $joins;
                
                return $this->listSearchItems($query);
		
	}    
    
    function listSearchItems($query=array()){

        $request = $this->generateRequestForSearchItems($query);
        
        if(!empty($query['limit'])){
                $start = $query['limit'][0];
                if(is_numeric($query['limit'][1]))
                        $paging = $query['limit'][1];
        }
        
        if($query['orders']){
                $orders = $query['orders'];
        }else{
                $orders = $this->module_info['default_sort'];
        }
        
        if(empty($query['fields'])){
            $query['fields'][] = "DISTINCT T.record_id, T.*";
            if($this->module_info['no_record_table']!=1){
                $query['fields'][] = "R.*";
            }
        } 
        
        $arr = $this->db->select($this->table . " T")
                        ->fields($query['fields'])        
                        ->joins($request['joins'])
                        ->bind($request['binds'])
                        ->where($request['where'])
                        ->order($orders)
                        ->group($request['groups'])
                        ->limit($start, $paging)
                        ->result_array();   		
        return $arr;
    	
    }
    
    function getCountSearchItems($query = array()){
    	
    	$request = $this->generateRequestForSearchItems($query);
		
        $arr = $this->db->select($this->table . " T")
                        ->fields("COUNT(DISTINCT T.record_id) AS cnt")
                        ->joins($request['joins'])
                        ->bind($request['binds'])
                        ->where($request['where'])
                        ->group($request['groups'])
                        ->row_array();   		
        return $arr['cnt'];    	
    }
    
    function generateRequestForSearchItems($query = array()){
        
    	$binds = $where = $joins = $orders = $group = $limit = $fields = array();
        
    	if(is_array($query['where'])){
                foreach($query['where'] as $key=>$val){
                        $column_text = $key;
                        $bind_key = $key;
                        $op = "=";
                        if(is_array($val)){
                                if($val['column']) $column_text = $val['column'];
                                $op = $val['op'];
                                $value = $val['val'];
                        }else{
                                $value = $val;
                        }
                        if(strpos($column_text, '.')===false){
                            $column_text = (in_array($column_text, $this->record_columns) && $this->module_info['no_record_table']!=1 ? "R." : "T.") . $column_text;
                        }else{
                            $bind_key = str_replace('.', '___', $key);
                        }
                        $where[] = "$column_text $op :$bind_key";
                        $binds[$bind_key] = $value;
                }
    	}else{
    		$where[] = $query['where'];
    	}

        if(!empty($query['relations'])){
            foreach($query['relations'] as $key=>$val){
                    $relations[$key] = $val;
                    $where[] = "REL.list_item_id=:REL_$key";
                    $query['binds']['REL_' . $key] = $val;
            }
            $query['joins']['REL'] = "LEFT JOIN {$this->tables['relations']} REL ON(REL.item_id=T.record_id)";
        }
        
        if($this->module_info['no_record_table']!=1){
            $where[] = "T.active=1";
            $where[] = "R.trash!=1";
            $joins[] = "LEFT JOIN {$this->tables['record']} R ON (R.id=T.record_id)";
        }
    	
    	foreach($query['binds'] as $key=>$val){
    		$binds[$key] = $val;
    	}

        if(is_array($query['joins'])){
            foreach($query['joins'] as $join_str){
                    $joins[] = $join_str;
            }
        }else{
            $joins[] = $query['joins'];
        }
        
        if($query['groups']){
                $groups = $query['groups'];
        }else{
                $groups = null;
        }

        if($this->module_info['multilng']==1){
                $where[] = "T.lng=:lng";
                $binds['lng'] = $this->language;
        }
        
        return array('binds' => $binds, 'where' => $where, 'joins' => $joins, 'groups' => $groups, 'fields' => $query['fields']);
        
    }
    
    function getAuthor($author_id){

    	if(!isset($author_id) || !is_numeric($author_id) || $author_id == 0) return false;
    	
    	$row = $this->db->select($this->tables['record'])
    					->where('id=:id')
    					->bind('id', $author_id)
    					->row_array();
    					
    	$module = $this->getModule($row['module_id']);
    	
    	return $this->registry->model->{$module['table_name']}->loadItem($author_id);
    	
    }
    
    function getProp($prop){
        return $this->$prop;
    }
    
    function getSettings(){
        if(!empty($this->module_xml_settings)) return $this->module_xml_settings;
        $settings = array();
        foreach($this->module_info['xml_settings'] as $key => $val){
            if ($val['type'] == FRM_CHECKBOX_GROUP || $val['type'] == FRM_SELECT) {
                $val['value'] = explode("::", $val['value']);
            }
            if ($val['type'] == FRM_TEXTAREA) {
                $val['value'] = str_replace("{!{CDATA{", "<![CDATA[", $val['value']);
                $val['value'] = str_replace("}!}CDATA}", "]]>", $val['value']);
            }
            $settings[$key] = $val['value'];
        }
        $this->module_xml_settings = $settings;
        return $settings;
    }
    
    function getRelations($table, $id, $params, $lng) {

        $table = strlen($params['list_values']['relations_table']) > 0 ? $params['list_values']['relations_table'] : $table;
        if (isset($id) && is_numeric($id) && $id != 0) {
            $arr = array();
            if (strlen($params['list_values']['list_columns']) > 0 || !empty($params['list_values']['list_columns'])) {
                if (is_array($params['list_values']['list_columns']))
                    $arr = $params['list_values']['list_columns'];
                else
                    $arr = explode(",", $params['list_values']['list_columns']);
            }

            $sql_str = "";
            if (strlen($params['list_values']['list_columns']) == 0 || empty($params['list_values']['list_columns'])) {
                $sql_str = "M.title AS title";
            } else {
                foreach ($arr as $val) {
                    $sql_str .= " M.$val ','";
                }
                $sql_str = trim($sql_str);
                $sql_str = ereg_replace(" ", ", ", $sql_str);
                $sql_str = " CONCAT($sql_str) AS title ";
            }
            return $this->db->select("$table R")
                            ->fields("DISTINCT(M.record_id), R.list_item_id AS value, $sql_str")
                            ->joins("LEFT JOIN " . Config::$val['pr_code'] . "_{$params['list_values']['module']} M ON (M.record_id=R.list_item_id AND (M.lng='$lng' OR M.lng='' OR M.lng IS NULL)) ")
                            ->where("R.item_id=:id AND R.column_name=:column_name")
                            ->bind('id', $id)
                            ->bind('column_name', $params['column_name'])
                            ->result_array();
        }
    }    
    
    
    // Delete item from DB
    function removeItem($id) {

        if ($id == 0)
            return $id;

        //pae($this->table_fields);
        foreach ($this->table_fields as $key => $val) {
            if ($val['elm_type'] == FRM_IMAGE || $val['elm_type'] == FRM_FILE) {
                if ($val['multilng'] == 1) {
                    foreach (Config::$val['default_page'] as $lng => $lng_id) {
                        $this->img_delete($val, $id, $lng);
                    }
                } else {
                    $this->img_delete($val, $id, $this->language);
                }
            }
            if ($val['elm_type'] == FRM_LIST) {

                if ($val['list_values']['source'] == "DB") {
                    $record_list_obj = $this->registry->model->create($val['list_values']['module']);
                    $query['where'] = " T.{$val['list_values']['get_category']}=$id AND T.{$val['list_values']['get_column_name']}='{$val['column_name']}' ";
                    $search_list = $record_list_obj->listSearchItems($query);
                    foreach ($search_list as $val) {
                        $record_list_obj->removeItem($val['id']);
                    }
                }
            }
        }

        if ($this->module_info['no_record_table'] != 1) {
            $this->db->delete($this->table)->where("record_id=:id")->bind('id', $id)->query();
        } else {
            $this->db->delete($this->table)->where("id=:id")->bind('id', $id)->query();
        }

        if ($this->module_info['no_record_table'] != 1) {
            $this->db->delete($this->tables['record'])
                    ->where("id=:id")
                    ->bind('id', $id)
                    ->query();
            $id_arr = $this->db->select($this->tables['record'])
                    ->fields("id, module_id")
                    ->where("parent_id=:id")
                    ->bind('id', $id)
                    ->result_array();
            $n = count($id_arr);
            for ($i = 0; $i < $n; $i++) {
                if ($id_arr[$i]['module_id'] != $this->module_info['id']) {
                    $mod_obj = $this->registry->model->call($id_arr[$i]['module_id'], 'removeItem', array($id_arr[$i]['id']));
                } else {
                    $this->removeItem($id_arr[$i]['id']);
                }
            }

            $this->db->delete(Config::$val['sb_admin_module_rights'])
                    ->where("record_id=:id")
                    ->bind('id', $id)
                    ->query();
        }
    }    
    
    // TODO:
	function getRelation(){
		
	}
    
}
?>
