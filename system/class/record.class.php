<?php
include_once(CLASSDIR."basic.class.php");
include_once(CLASSDIR."main_module.class.php");
abstract class record extends basic {
    
	public $module_info;
	public $table_fields;
    public $table_list;
    public $table;
    public $viewAllItems = 1;
	
    protected $tables;
    
    /*
    siusksles
    public $data = array();
	
    private $shorten_texts = 0;
    private $imgobjects = array();
    private $xmlCfg;
    private $trash = 0;
    private $where_clause = "";
    */
    
    
    function __construct($module){
        
        parent::__construct();
        
        $this->module = main_module::getInstance();
        
        // DB tables
        $this->tables['module'] = Config::$val['sb_module'];
        $this->tables['module_info'] = Config::$val['sb_module_info'];
        $this->tables['record'] = Config::$val['sb_record'];
        $this->table = Config::$val['pr_code'].'_'.$module;
        $this->table_relations = Config::$val['sb_relations'];
        
        // Get module information
        $this->module_info = $this->info($module);
        // Get module table fields
        $this->getTableFields();
        
    }
    
    
    /**
     * Load module information
     * @param string $module
     */
    private function info($module){
        // Load module info
        $data = $this->module->getModule($module);
        // Parse module xml settings
        if(strlen($data['additional_settings'])>0){
        	// TODO: reikia sutvarkyt cia
        	$data['xml_settings'] = File::xmlStringToArray(html_entity_decode($data['additional_settings']));
        }
        return $data;
    }
    
    private function getTableFields(){
        
        // List module columns
        $table_fields = $this->module->listColumns($this->module_info['id']);
        $n = count($table_fields);
        for($i=0, $arr=array(), $arr1=array(); $i<$n; $i++){
        	// Parse list_values data string to array
        	$table_fields[$i]['list_values'] = $this->parseString2Array($table_fields[$i]['list_values']);
        	$table_fields[$i]['type'] = $table_fields[$i]['elm_type'];
        	if($table_fields[$i]['elm_type']==FRM_IMAGE){
        		// Parse image parametters from string to array
        		$table_fields[$i]['image_extra'] = $this->getValueParamsImages($table_fields[$i]['extra_params']);
        	}
        	
			// Select module fields for superadmin
			$arr1[] = $table_fields[$i];
            if($table_fields[$i]['list']==1){
            	if($this->admin['permission']==1 || ($this->admin['permission']!=1 && $table_fields[$i]['super_user']!=1))
                	$arr[] = $table_fields[$i];            	
            }
            
        }
        // Create associative array
        foreach($arr1 as $key=>$val){
        	$arr2[$val['column_name']] = $val;
        }
        $this->table_list = $arr; // For items list
        $this->table_fields = $arr1; // For item data
        $this->_table_fields = $arr2; // For item data (assoc array)

    }
    
    function loadItem($id, $parent_id=0){
        
        if(!is_numeric($id) || $id<0) return false;
        
        $n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "".$this->table_fields[$i]['column_name'].", ";
        }
        
        $index_column_name = ($this->module_info['no_record_table']!=1?"record_id":"id");
        
        $sql = "SELECT $fields " .
        		" $index_column_name AS id, lng, lng_saved " .
        		" FROM $this->table " .
        		" WHERE $index_column_name=$id " .
        		($this->module_info['multilng']==1?"AND lng='$this->language'":"");
        $data = $this->db->query($sql)->row_array();
        
        if(!empty($data)) {
            $data['isNew'] = 0;
            for($j=0; $j<$n; $j++){
        		if($this->table_fields[$j]['list_values']['source']=='DB'){
        			$relations_list = $this->getRelations($this->table_relations, $data['id'], $this->table_fields[$j], $this->language);
        			$c = count($relations_list); $value = ""; $title = "";
        			for($k=0; $k<$c; $k++){
        				$value .= $k!=0?"::":"";
        				$value .= $relations_list[$k]['value'];

        				$title .= $k!=0?";":"";
        				$title .= $relations_list[$k]['title'];
        			}
        			$data[$this->table_fields[$j]['column_name']."_list"] = $title;
        			$data[$this->table_fields[$j]['column_name']] = $value;
        		}
        	}
        	if($this->module_info['no_record_table']!=1){
		        $sql = "SELECT * FROM {$this->tables['record']} WHERE id=$id";
		        $arr = $this->db->query($sql)->row_array();
		        if(!empty($arr)) {
		            foreach($arr as $key=>$val) {
		            	$data[$key] = $val;
		            }
		        }
        	}
        } else {
            $data['id'] = 0;
            $data['parent_id'] = $parent_id;
            $data['isNew'] = 1;
        }
        
        return $data;
        
    }
    
    function loadItemAuthor($id){
 		
    	if($this->module_info['no_record_table']==1) return array();
    	
 		$sql = "SELECT M.* FROM {$this->tables['record']} R " .
 				" LEFT JOIN {$this->tables['module']} M ON (R.module_id=M.id) WHERE R.id=$id ";
 		$row = $this->db->query($sql)->row_array();
		
		if(!empty($row)){
			$author_obj = $this->registry->modules->create($row['table_name']);
			$author_data = $author_obj->loadItem($id);
			$author_data['module_title'] = $row['title'];
			if($row['table_name']=='admins') $author_data['title'] = $author_data['login'].", ".$author_data['firstname']." ".$author_data['lastname'];
			$data = $author_data;
		}else{
			$data['id'] = 0;
		}
		
		return $data;
			
    }
    
    function saveItem($data){
    	
        if($data['isNew']!=1){
        	if($this->loadAdminRights($this->admin['id'], $data['id'])!=1) return $data['id'];
        } else {
			if($this->module_info['disabled']==1 && is_numeric($_GET['parent_record_id']))
				if($this->loadAdminRights($this->admin['id'], $_GET['parent_record_id'])!=1) return $_GET['parent_record_id'];
			else
				if($this->loadAdminRights($this->admin['id'], $data['parent_id'])!=1) return $data['id'];
        }

        if($this->module_info['multilng']==1){
        	$languages_arr[$data['language']] = Config::$val['default_page'][$data['language']];
        	if(strlen($data['language_actions'])){
	        	$lang_arr = explode("::", $data['language_actions']);
	        	foreach($lang_arr as $val){
	        		$languages_arr[$val] = Config::$val['default_page'][$val];
	        	}
        	}
        }else{
        	$languages_arr[Config::$val['default_lng']] = Config::$val['default_page'][$this->config->variable['default_lng']];
        }

        if($this->module_info['no_record_table']==1){
        	$index_column_name = "id";
        }else{
        	$index_column_name = "record_id";
        }        
        
        if($data['isNew']==1){
            
        	if($this->module_info['no_record_table']==1){
            	$record_id = $data['id'];
            }else{
	            $sql = "SELECT IF(MAX(sort_order)+1 IS NOT NULL, MAX(sort_order)+1, 1) AS sorder FROM {$this->tables['record']} WHERE parent_id={$data['parent_id']}";
	            $sort = $this->db->query($sql)->row_array();
	            $sql = "INSERT INTO {$this->tables['record']} SET sort_order={$sort['sorder']}, parent_id={$data['parent_id']}, module_id={$this->module_info['id']}, create_by_ip='{$_SERVER['REMOTE_ADDR']}', create_by_admin={$this->admin['id']}, create_date=NOW()";
	            $this->db->query($sql);
	            $record_id = $this->db->insert_id();
            }
            if($this->module_info['multilng']==1){
	            foreach($languages_arr as $key=>$val){
		            $sql = "INSERT INTO $this->table SET record_id=$record_id, lng='$key'";
		            $this->db->query($sql);   
	            }
            }else{
            	if($this->module_info['no_record_table']==1){
	            	$sql = "INSERT INTO $this->table SET id=0";
		            $this->db->query($sql);   
            		$record_id = $this->db->insert_id();
            	}else{
	            	$sql = "INSERT INTO $this->table SET record_id=$record_id";
		            $this->db->query($sql);   
            	}
            }
            
        }else{
            
            $sql = "SELECT id FROM $this->table WHERE $index_column_name={$data['id']} ".($this->module_info['multilng']==1?" AND lng='$this->language'":"");
            $q = $this->db->query($sql);
            if($q->num_rows()>0){
                $data_ = $q->row_array();
            }elseif($this->module_info['no_record_table']!=1){
                $sql = "INSERT INTO $this->table SET record_id={$data['id']} ".($this->module_info['multilng']==1?", lng='$this->language'":"");
                $this->db->query($sql);
                $data_['id'] = $this->db->insert_id();
            }
            $record_id = $data['id'];
            
        }
        
        $n = count($this->table_fields);
      
        $non_multilng_fields=array();
        foreach($languages_arr as $key=>$val){
	        for($i=0, $fields=''; $i<$n; $i++){

            	if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && ($_FILES['file_'.$this->table_fields[$i]['column_name']]['size']>0)){
                    //if(is_uploaded_file($_FILES[$column_name]['tmp_name'])) $this->img->remove($data['old_'.$k]);
			    	$this->img->resize_params = $this->table_fields[$i]['image_extra'];
			    	$this->img->remove($data['old_'.$this->table_fields[$i]['column_name']]);
                }
                if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && (isset($data['delete_'.$this->table_fields[$i]['column_name']]))){
                	$this->img_delete($this->table_fields[$i], $data['id'], $key);
                    $data[$this->table_fields[$i]['column_name']] = '';
                }
	            if($this->table_fields[$i]['type'] == FRM_PASSWORD && $data[$this->table_fields[$i]['column_name']]==''){
                	continue;
                }                
                $fields .= $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."', ";

                if(($this->table_fields[$i]['type'] == FRM_SELECT || $this->table_fields[$i]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$i]['type'] == FRM_AUTOCOMPLETE || $this->table_fields[$i]['type'] == FRM_RADIO || $this->table_fields[$i]['type'] == FRM_CATEGORIES_TREE)){
                	$this->saveRelations($this->table_relations, $record_id, $data[$this->table_fields[$i]['column_name']], $this->table_fields[$i]);
                }
                
                if($this->table_fields[$i]['multilng']==0 && $key==$data['language']){
                	$non_multilng_fields[] = $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."'";
                }

	        }
	        
	        if(isset($data['parent_id']) && is_numeric($data['parent_id'])){
		        $sql = "UPDATE {$this->tables['record']} SET parent_id={$data['parent_id']} WHERE id=$record_id";
		        $this->db->query($sql);
	        }
	        
	        $this->registerLastEdit($record_id);
			
			if($this->module_info['multilng']==1){
				$sql = "SELECT * FROM $this->table WHERE record_id=$record_id AND lng='$key'";
				$row = $this->db->query($sql)->row_array();
				if(empty($row)){
		            $sql = "INSERT INTO $this->table SET record_id=$record_id, lng='$key'";
		            $this->db->query($sql);   
				}
			}
	        
	        $sql = "UPDATE $this->table SET $fields " .
	        		" lng=lng WHERE ".($this->module_info['multilng']==1?"lng='$key' AND":"")." $index_column_name=".$record_id."";
	        $this->db->query($sql);
	        
	        if($this->module_info['multilng']==0 && $key==$data['language']) break;
	        
        }
        
        if(!empty($non_multilng_fields)){
	        $sql = "UPDATE $this->table SET ".implode(", ", $non_multilng_fields)." WHERE $index_column_name=$record_id";
	        $this->db->query($sql);   
        }


        // pazymima kad sioj kalboj irasas redaguotas
        $sql = "UPDATE $this->table SET lng_saved=1 WHERE $index_column_name=$record_id ".($this->module_info['multilng']==1?" AND lng='$this->language'":"");
        $this->db->query($sql);   
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
		
        return $record_id;
        
    }

    
    // import from csv
    function insertListItems($arr, $parent_id){
    	
    	if($this->loadAdminRights($this->admin['id'], $parent_id)!=1) return $parent_id;
    	
    	$n = count($arr);
    	for($i=0; $i<$n; $i++){
    		
    		$new_item = true; $data = array();
    		if(isset($arr[$i]['id']) && is_numeric($arr[$i]['id'])){
    			$item_data = $this->loadItem($arr[$i]['id'], $parent_id);
    			$new_item = ($item_data['isNew']==1?true:false);
    			$data = $item_data;
    		}
    		
    		foreach($arr[$i] as $key=>$val){
    			
    			$val = $this->db->escape($val);
    			
    			if($this->_table_fields[$key]['type'] == FRM_SELECT || $this->_table_fields[$key]['type'] == FRM_RADIO){
    				
    				$column_par = $this->_table_fields[$key]['list_values'];

    				if($column_par['module']){

	    				$list_record_obj = $this->registry->modules->create($column_par['module']);
	    				
	    				if(isset($column_par['list_columns']) && $column_par['list_columns']['source']=="DB"){
	    					$_arr = explode(",", $column_par['list_columns']);
	    					foreach($_arr as $k=>$v){
	    						$srt[] = " T.$v ";
	    					}
	    					$list_record_obj->sqlQueryWhere = " CONCAT(".implode(",", $srt).")='$val' AND ";
	    				}else{
	    					$list_record_obj->sqlQueryWhere = " T.title='$val' AND ";
	    				}
	    				
	    				$list_record_obj->sqlQueryWhere .= " R.parent_id={$column_par['parent_id']} AND ";
	    				$lst = $list_record_obj->listSearchItems();
	    				
	    				if(isset($lst[0]['id'])) $data[$key] = $lst[0]['id'];
    					
    				}else{
    					$data[$key] = $this->db->escape($arr[$i][$key]);
    				}
    				
    			}elseif($this->_table_fields[$key]['type'] == FRM_DATE){
    				
    				$data[$key] = str_replace(" ", "-", $this->db->escape($arr[$i][$key]));
    				
    			}else{
    				
    				$data[$key] = $this->db->escape($arr[$i][$key]);
    				
    			}
    		}
    		
    		if($new_item){
	    		$data['isNew'] = 1;
	    		$data['parent_id'] = $parent_id;
	    		$data['language'] = $this->language;
	    		
	    		foreach(Config::$val['default_page'] as $key=>$val){
	    			$lang_arr[] = $key;
	    		}
	    		$data['language_actions'] = implode("::", $lang_arr);
	    		
    		}else{
	    		$data['isNew'] = 0;
	    		$data['id'] = $arr[$i]['id'];
	    		$data['parent_id'] = $parent_id;
	    		$data['language'] = $this->language;
    		}
    		$this->saveItem($data);
    	}

    }

    // use in saveItem when field FRM_SELECT, FRM_CHECKBOX_GROUP, FRM_RADIO, FRM_CATEGORIES_TREE
    function saveRelations($table, $id, $data, $params){
    	
    	$table = strlen($params['list_values']['relations_table'])>0?$params['list_values']['relations_table']:$table;
    	$sql = "DELETE FROM $table WHERE item_id=$id AND column_name='{$params['column_name']}'";
    	$this->db->query($sql);
    	if(!is_array($data)) 
    		$arr = explode("::", $data);
    	else
    		$arr = $data;
    	foreach($arr as $val){
    		if(is_numeric($val)){
	    		$sql = "SELECT COUNT(*) AS cnt FROM $table WHERE item_id=$id AND column_name='{$params['column_name']}' AND list_item_id=$val";
	    		$row = $this->db->query($sql)->row_array();
	    		if($row['cnt']==0){
		    		$sql = "INSERT INTO $table SET item_id=$id, column_name='{$params['column_name']}', list_item_id=$val";
		    		$this->db->query($sql);
	    		}
    		}
    	}
    	
    }
    
	function getRelations($table, $id, $params, $lng){
		
		$table = strlen($params['list_values']['relations_table'])>0?$params['list_values']['relations_table']:$table;
		if(isset($id) && is_numeric($id) && $id!=0){
			$arr = array();
			if(strlen($params['list_values']['list_columns'])>0 || !empty($params['list_values']['list_columns'])){
				if(is_array($params['list_values']['list_columns']))
					$arr = $params['list_values']['list_columns'];
				else
					$arr = explode(",", $params['list_values']['list_columns']);
			}
			
			$sql_str = "";
			if(strlen($params['list_values']['list_columns'])==0 || empty($params['list_values']['list_columns'])){
				$sql_str = "M.title AS title";
			}else{
				foreach($arr as $val){
					$sql_str .= " M.$val ','";
				}
				$sql_str = trim($sql_str);
				$sql_str = ereg_replace(" ", ", ", $sql_str);
				$sql_str = " CONCAT($sql_str) AS title ";
			}
			$sql = "SELECT DISTINCT(M.record_id), R.list_item_id AS value, $sql_str " .
					" FROM $table R " .
					" LEFT JOIN ".Config::$val['pr_code']."_{$params['list_values']['module']} M " .
					" ON (M.record_id=R.list_item_id AND (M.lng='$lng' OR M.lng='' OR M.lng IS NULL)) " .
					" WHERE R.item_id=$id AND R.column_name='{$params['column_name']}'";
			return $this->db->query($sql)->result_array();
		}
	}
    
    function listItems($category=0){
        
        $this->sqlQueryWhere = " R.parent_id=$category AND ";
        if($this->module_info['no_record_table']!=1) $this->sqlQueryOrder = " ORDER BY R.sort_order ";
        return $this->listSearchItems();
        
    }
    
    // 
    function getPath($id, $_data = array()){
        if($id!=0){
            $n = count($this->table_fields);
            for($i=0, $fields=''; $i<$n; $i++){
                $fields.= "".$this->table_fields[$i]['column_name'].", ";
            }            
            $sql = "SELECT R.id, R.parent_id, $fields T.lng, T.lng_saved, 1 AS not_last FROM $this->table T" .
		    		" LEFT JOIN {$this->tables['record']} R" .
		    		" ON (T.record_id=R.id)" .
		    		" WHERE R.id=$id ".($this->module_info['multilng']==1?" AND T.lng='{$this->language}' ":"")."";
		    $row = $this->db->query($sql)->row_array();
		    $_data[] = $row;
		    
		    $this->getPath($row['parent_id'], $_data);
        }else{
            $_data = @array_reverse($_data);
            return $_data;
        }
    }
    
    // Remove item to trash 
    function delete($id){
    	
        if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
        
        if($this->module_info['no_record_table']==1){
        	$this->deleteFromTrash($id);
        }else{
	    	$sql = "UPDATE {$this->tables['record']} SET trash=1 WHERE id=$id";
	    	$this->db->query($sql);
	
	        $this->registerLastEdit($id);
        }
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
        
        return $id;
    	
    }
    
    function deleteLang($id, $lang_arr){
    	foreach($lang_arr as $val){
    		$sql = "DELETE FROM $this->table WHERE record_id=$id AND lng='$val'";
    		$this->db->query($sql);
    	}
    	
    	// Jei istrintos visos kalbos tai ir record lentelej reikia naikint irasa
		$sql = "SELECT * FROM $this->table WHERE record_id=$id";
		$q = $this->db->query($sql);
		if($q->num_rows()==0){
    		// i siukslyne ismest nebera prasmes, tai remove nafik visai 
    		$this->deleteFromTrash($id);
		}
    }
    
    // Reset(back) item from trash
    function resetFromTrash($id){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	$sql = "UPDATE {$this->tables['record']} SET trash=0 WHERE id=$id";
    	$this->db->query($sql);

		$this->registerLastEdit($id);	
    	
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
    	
    }
    
    // Delete item from DB
    function deleteFromTrash($id){
    	
    	if($id==0) return $id;
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	//pae($this->table_fields);
    	foreach($this->table_fields as $key => $val){
    		if($val['elm_type'] == FRM_IMAGE || $val['elm_type'] == FRM_FILE){
		        if($val['multilng']==1){
			        foreach(Config::$val['default_page'] as $lng=>$lng_id){
			        	$this->img_delete($val, $id, $lng);
			        }
		        }else{
			        $this->img_delete($val, $id, $this->language);
		        }
    		}
    		if($val['elm_type'] == FRM_LIST){

				if($val['list_values']['source']=="DB"){
					$record_list_obj = $this->registry->modules->create($val['list_values']['module']);
					$record_list_obj->sqlQueryWhere = " T.{$val['list_values']['get_category']}=$id AND T.{$val['list_values']['get_column_name']}='{$val['column_name']}' AND ";
					$search_list = $record_list_obj->listSearchItems();
					foreach($search_list as $val){
						$record_list_obj->deleteFromTrash($val['id']);
					}
				}
    		}
    	}
    	
    	if($this->module_info['no_record_table']!=1){
        	$sql = "DELETE FROM $this->table WHERE record_id=$id";
        }else{
        	$sql = "DELETE FROM $this->table WHERE id=$id";
        }
        $this->db->query($sql);
        
        if($this->module_info['no_record_table']!=1){
        	$sql = "DELETE FROM {$this->tables['record']} WHERE id=$id";
	        $this->db->query($sql);
	        $sql = "SELECT id, module_id FROM {$this->tables['record']} WHERE parent_id=$id";

	        $id_arr = $this->db->query($sql)->result_array();
	        $n = count($id_arr);
	        for($i=0; $i<$n; $i++){
	        	if($id_arr[$i]['module_id'] != $this->module_info['id']){
	        		$mod_obj = $this->registry->modules->call($id_arr[$i]['module_id'], 'deleteFromTrash', array($id_arr[$i]['id']));
	        	}else{
	        		$this->deleteFromTrash($id_arr[$i]['id']);
	        	}
	        }
	        
	        $sql = "DELETE FROM ".Config::$val['sb_admin_module_rights']." WHERE record_id=$id";
	        $this->db->query($sql);
        }
        
        
    }
    
    // Register last editor
    function registerLastEdit($id){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	if($this->module_info['no_record_table']==1) return $id;
    	
    	$sql = "UPDATE {$this->tables['record']} SET last_modif_by_ip='{$_SERVER['REMOTE_ADDR']}', last_modif_by_admin={$this->admin['id']}, last_modif_date=NOW() WHERE id=$id";
        $this->db->query($sql);
    }
    
    function changeFieldStatus($lng, $column, $id){
        
        if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
        
        foreach($this->table_fields as $key => $val){
        	if($this->table_fields[$key]['column_name']==$column){
        		$index = $key;
        	}
        }
        if($this->table_fields[$index]['multilng']==1)
        	$sql = "UPDATE $this->table SET $column=IF($column=1, 0, 1) WHERE record_id=$id ".($this->module_info['multilng']==1?" AND lng='$lng' ":"")."";
        else
        	$sql = "UPDATE $this->table SET $column=IF($column=1, 0, 1) WHERE record_id=$id";
        $this->db->query($sql);
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
        
        $this->registerLastEdit($id);
        
    }
    
    function updateField($id, $field, $value){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return false;
    	
    	$value = $this->db->escape_str($value);
    	$field = $this->db->escape_str($field);
    	
    	$sql = "UPDATE $this->table SET $field='$value' WHERE record_id=$id";
    	$this->db->query($sql);
    	
    	$this->registerLastEdit($id);

        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
        
        return true;
    	
    }
    
    function changeOrder($lastid, $firstid){
        $sql = "SELECT sort_order, parent_id FROM {$this->tables['record']} WHERE id=$firstid";
        $sort1 = $this->db->query($sql)->row_array();
        $sql = "SELECT sort_order, parent_id FROM {$this->tables['record']} WHERE id=$lastid";
        $sort2 = $this->db->query($sql)->row_array();

        if($sort1['sort_order']>$sort2['sort_order'])
        	$sql = "UPDATE {$this->tables['record']} SET sort_order=sort_order-1 WHERE sort_order<={$sort1['sort_order']} AND sort_order>={$sort2['sort_order']} AND parent_id={$sort2['parent_id']} AND module_id={$this->module_info['id']}";//"UPDATE {$this->tables['record']} SET sort_order={$sort2['sort_order']} WHERE id=$firstid";
        else
        	$sql = "UPDATE {$this->tables['record']} SET sort_order=sort_order+1 WHERE sort_order>={$sort1['sort_order']} AND sort_order<={$sort2['sort_order']} AND parent_id={$sort2['parent_id']} AND module_id={$this->module_info['id']}";//"UPDATE {$this->tables['record']} SET sort_order={$sort2['sort_order']} WHERE id=$firstid";
        $this->db->query($sql);
        $sql = "UPDATE {$this->tables['record']} SET sort_order={$sort1['sort_order']} WHERE id=$lastid";
        $this->db->query($sql);
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
    }

	function checkRecordParentId($column, $data){

		if(is_numeric($column['value'])) $post_value = $this->getPath($column['value']);
		if(is_numeric($data['id'])) $data_value = $this->getPath($data['id']);
		
		$index = count($data_value)-1;
		
		if($index<0) return false;
		
		if($data_value[$index]['id'] != $post_value[$index]['id']){
			return false;
		}else{
			return true;
		}
		
	}    
    
    function changeParentId($id, $parent_id){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	$sql = "UPDATE {$this->tables['record']} SET parent_id=$parent_id WHERE id=$id";
    	$this->db->query($sql);
    	
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->query($sql);
        }
        
        $this->registerLastEdit($id);
        
    }
    
    function img_delete($column, $id, $lng){
    	
    	if(!is_numeric($id)) return false;

    	// patikrinama ar nera daugiau irasu kuriems yra priskirtas tas img
    	$sql = "SELECT {$column['column_name']} AS img FROM $this->table WHERE record_id=$id ";
    	$arr = $this->db->query($sql)->result_array();

    	if(count($arr)<2 || $column['multilng']==0){
	    	$sql = "SELECT {$column['column_name']} AS img FROM $this->table WHERE record_id=$id ".($column['multilng']==1?" AND lng='$lng' ":"");
	    	$row = $this->db->query($sql)->row_array();
	    	
	    	// TODO: $this->img no longer available
	    	$this->img->resize_params = $column['image_extra'];
	    	$this->img->remove($row['img']);
    	}
    	
    }
    
	function checkDataExistInCategory($elm_data, $data){

		$sql = "SELECT R.id FROM {$this->tables['record']} R " .
				" LEFT JOIN $this->table T " .
				" ON (T.record_id=R.id) " .
				" WHERE R.id!={$data['id']} AND R.parent_id={$data['parent_id']} AND T.{$elm_data['column_name']}='{$elm_data['value']}' AND R.trash!=1 ";
		$row = $this->db->query($sql)->row_array();
		if(empty($row))
			return 0;
		else
			return 1;

	}

    function checkDataExist($value, $data){
    	if(isset($data['id']) && is_numeric($data['id'])){
	    	$sql = "SELECT R.id, R.trash FROM $this->table T " .
	    			" INNER JOIN {$this->tables['record']} R " .
	    			" ON (R.id=T.record_id) " .
	    			" WHERE T.{$value['column_name']}='{$value['value']}' AND T.record_id!={$data['id']} ";
	    	$row = $this->db->query($sql)->row_array();
	    	if(empty($row)){
	    		return true;
	    	}else{
	    		if($row['trash']==1){
	    			// 
	    			$this->deleteFromTrash($row['id']);
	    			return true;
	    		}else{
	    			return false;
	    		}
	    	}
    	}else{
    		return false;
    	}
    }
	
    function getCountSearchItems(){
    	$column_result = "";
    	foreach($this->table_fields as $i=>$val){
    		if($val['column_result']!="") $column_result .= " , {$val['column_result']}(T.{$val['column_name']}) AS {$val['column_name']}_result ";
    	}
    	if($this->module_info['no_record_table']!=1){
    		$sql = "SELECT COUNT(DISTINCT R.id) as _COUNT_ " . $column_result .
        		" FROM $this->table T " .
        		" LEFT JOIN {$this->tables['record']} R " .
        		" ON (R.id=T.record_id ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").") " .
        		$this->sqlQueryJoins .     	
    			" WHERE R.trash!=1 AND ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"");
    		
    	}else{
    		$sql = "SELECT COUNT(DISTINCT T.id) as _COUNT_ " . $column_result .
        		" FROM $this->table T " .
        		$this->sqlQueryJoins .     	
    			" WHERE ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"");
    		
    	}
    	$row = $this->db->query($sql)->row_array();
    	return $row;
    }
    
    function listSearchItems(){
    	
    	benchmark::mark('', 'listSearchItems '.$this->module_info['table_name']);
    	
		$n = count($this->table_fields); $JOINS="";
        for($i=0, $fields=$this->fields; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }
        // TODO: sicia neaisku kam
        if($this->module_info['mod_pages']==81){ // if parent module 'pages' then get url & other seo
        	$this->sqlQueryJoins .= " LEFT JOIN ".Config::$val['pr_code']."_pages PG ON (R.id=PG.record_id AND PG.lng='$this->language') ";
        	$fields .= " PG.page_url, PG.page_title, ";
        }
        if($this->module_info['no_record_table']!=1){
        	$sql = "SELECT $fields R.id, R.parent_id, R.sort_order, T.active, R.is_category, R.create_date, R.last_modif_date, T.lng, T.lng_saved, 1 AS editorship FROM {$this->tables['record']} R " .
        		" INNER JOIN $this->table T " .
        		" ON (R.id=T.record_id ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").")" .
        		$this->sqlQueryJoins . 
				" WHERE R.trash!=1 AND ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").
        		" ".$this->sqlQueryGroup.
				" ".$this->sqlQueryOrder.
        		" ".$this->sqlQueryLimit;
        }else{
        	$sql = "SELECT $fields T.id AS id, T.active, T.lng, T.lng_saved, 1 AS editorship FROM $this->table T " .
        		$this->sqlQueryJoins . 
				" WHERE ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").
        		" ".$this->sqlQueryGroup.
				" ".$this->sqlQueryOrder.
        		" ".$this->sqlQueryLimit;
        }
		
		$arr = $this->db->query($sql)->result_array();

        $m = count($arr);
        for($i=0; $i<$m; $i++){
        	for($j=0; $j<$n; $j++){
        		if($this->table_fields[$j]['list_values']['source']=='DB'){
        			$relations_list = $this->getRelations(Config::$val['sb_relations'], $arr[$i]['id'], $this->table_fields[$j], $this->language);
        			$c = count($relations_list); $value = ""; $ids = "";
        			for($k=0; $k<$c; $k++){
        				$ids .= $k!=0?"::":"";
        				$value .= $k!=0?"; ":"";
        				$value .= $relations_list[$k]['title'];
        				$ids .= $relations_list[$k]['value'];
        			}
        			$arr[$i][$this->table_fields[$j]['column_name']] = $value;
        			$arr[$i][$this->table_fields[$j]['column_name'].'_ids'] = $ids;
        		}
        		if($this->table_fields[$j]['elm_type']==FRM_TEXTAREA){
        			$arr[$i][$this->table_fields[$j]['column_name']] = nl2br($arr[$i][$this->table_fields[$j]['column_name']]);
        		}
        	}
        }
        
        benchmark::mark('', $sql);
        
        $this->sqlQueryJoins = "";
        $this->fields = "";
        $this->sqlQueryWhere = "";
        $this->sqlQueryOrder = $this->Default_sqlQueryOrder;
        $this->sqlQueryLimit = "";
        return $arr;
    }
    
    function listAutocompleteValues($ids){
    	$arr = explode("::", $ids);
    	$n = array();
    	foreach($arr as $val) {
    		if(is_numeric($val)) $n[] = " T.record_id=$val ";
    	}
    	if(count($n)>0){
    		$this->sqlQueryWhere = "(".implode(" OR ", $n).") AND ";
    		return $this->listSearchItems();
    	}	
    	return array();
    }

	function get_autocomplete_list($field, $code, $limit, $left=true, $right=true){
		$code = addcslashes($code, "\\'");
		$fields = explode(",", $field);
		$arr = array();
		foreach($fields as $val){
			$arr[] = "T.$val LIKE '".($left?"%":"")."$code".($right?"%":"")."'";
		}
		$this->sqlQueryWhere = "(".implode(" OR ", $arr).") AND ";
		if(is_numeric($limit)) $this->sqlQueryLimit = " LIMIT 0, $limit ";
		$list = $this->listSearchItems();
		
		foreach($list as $val){
			$list_[] = "{$val['title']} ---{$val['id']}";
		}
		
		return $list_;
	}    
    
    
}        
        
?>