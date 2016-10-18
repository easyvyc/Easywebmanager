<?php

include_once(CLASSDIR."basic.class.php");
class main_module extends basic {
    
    public $table;
    public $module_fields_for_superadmin = array('parent_module', 'admin_catalog', 'multilng', 'tree', 'mod_pages', 'search', 'cache', 'forbid_delete', 'disabled', 'no_record_table');
    public $column_fields_for_superadmin = array('editable', 'superadmin', 'index', 'column_type', 'column_type_more', 'no_standart_tpl', 'field_html', 'function', 'class_method', 'error_message', 'htmlspecialchars', 'CE');
    
    private static $instance;
    
    function __construct(){

        parent::__construct();
        
        $this->table = Config::$val['sb_module'];
        $this->table_info = Config::$val['sb_module_info'];
        $this->table_categories = Config::$val['sb_module_categories'];
        
        $this->language = $_SESSION['admin_interface_language'];
        
        $this->setModuleTableFields();
        //$this->setModuleInfoTableFields();
        
        if(!isset($this->language)) $this->language = Config::$val['default_lng'];

    }
    
    function getInstance(){
    	if(!is_object(self::$instance)){
    		self::$instance = new main_module();
    	}
    	return self::$instance;		    	
    }
    
    function setModuleTableFields(){

		$this->_table_fields['title_lt'] = array(
                                                        'title'=>cms::$phrases['main']['settings']['module']['title_lt'], 
                                                        'required'=>1, 
                                                        'type'=>'text', 	
                                                        'editable'=>1	
		);
		$this->_table_fields['title_en'] = array(
                                                        'title'=>cms::$phrases['main']['settings']['module']['title_en'], 
                                                        'required'=>1, 
                                                        'type'=>'text', 	
                                                        'editable'=>1	
		);
		$this->_table_fields['table_name'] = array(
                                                        'title'=>cms::$phrases['main']['settings']['module']['table_name'],
                                                        'required'=>1, 
                                                        'type'=>'text', 	
                                                        'editable'=>1, 
                                                        'class_method'=>"module=modules::method=checkExistTableName::admin_error_msg=".cms::$phrases['main']['settings']['module']['table_name_exists'], 
                                                        'function'=>"function=valid_table_name::admin_error_msg=".cms::$phrases['main']['settings']['module']['not_valid_table_name']	
		);
//		$this->_table_fields['no_standart_tpl'] = array(
//											'title'=>cms::$phrases['main']['settings']['module']['no_standart_tpl'], 
//											'required'=>0, 
//											'type'=>'checkbox', 
//											'editorship'=>1, 
//											'default_value'=>1
//		);
//		$this->_table_fields['area_html'] = array(
//											'title'=>cms::$phrases['main']['settings']['module']['area_html'], 
//											'required'=>0, 
//											'type'=>'html', 
//											'editorship'=>1, 
//											'htmlspecialchars'=>1, 
//											'list_values'=>array(
//															'mode'=>'block', 
//															'toolbar'=>'Default', 
//															'height'=>'350'
//											)
//		);
		//$this->_table_fields['no_standart_tpl'] = array('onclick'=>"getDefaultModuleTemplate(this, this.form.elements['field_html'], {$modules->data['id']});");
		//$this->_table_fields['additional_submit_action'] = array('title'=>cms::$phrases['main']['settings']['module']['additional_submit_action'],'require'=>0, 'type'=>'text', 		'value'=>$modules->data['additional_submit_action'], 'editorship'=>1, "extra_params"=>"style='width:650px;'");
		$this->_table_fields['multilng'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['multilng'],	
											'required'=>0, 
											'type'=>'checkbox', 	
											'editable'=>1	
		);
		$this->_table_fields['default_sort'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['default_sort'], 
											'required'=>1, 
											'type'=>'text', 
                                                                                        'default_value'=>'R.sort_order ASC',
											'editable'=>1
		);
		$this->_table_fields['maxlevel'] = array( 
											'title' => cms::$phrases['main']['settings']['module']['maxlevel'], 
											'type' => 'text', 
											'required' => 1, 
                                                                                        'default_value' => 0,
											'editable'=>1 
		);
		$this->_table_fields['additional_settings'] = array(
											'title' => cms::$phrases['main']['settings']['module']['additional_settings'], 
											'type' => 'textarea', 
											'required' => 0, 
											'editable'=>1 
		);
		$this->_table_fields['folder_id'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['folder'], 			
											'required'=>1, 
											'type'=>FRM_SELECT, 	
											'editable'=>1,
                                                                                        'list_values'=>array('source'=>'DB', 'module'=>'module_category', 'parent_id'=>0)
		);    	
		$this->_table_fields['category'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['category'], 			
											'required'=>0, 
											'type'=>FRM_CHECKBOX, 	
											'editable'=>1	
		);    	
		$this->_table_fields['cache'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['cache'], 			
											'required'=>0, 
											'type'=>FRM_CHECKBOX, 	
											'editable'=>1	
		);    	
		$this->_table_fields['tree'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['tree'], 			
											'required'=>0, 
											'type'=>FRM_CHECKBOX, 	
											'editable'=>1	
		);    	
		$this->_table_fields['no_record_table'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['no_record_table'], 			
											'required'=>0, 
											'type'=>FRM_CHECKBOX, 	
											'editable'=>1	
		);    	
		$this->_table_fields['search'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['search'], 			
											'required'=>0, 
											'type'=>FRM_CHECKBOX, 	
											'editable'=>1	
		);    	
		$this->_table_fields['disabled'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['disabled'], 			
											'required'=>0, 
											'type'=>FRM_CHECKBOX, 	
											'editable'=>1	
		);
		$this->_table_fields['form_tpl'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['form_tpl'], 			
											'required'=>0, 
											'type'=>'html', 	
											'editable'=>1	
		);
		$this->_table_fields['description'] = array(
											'title'=>cms::$phrases['main']['settings']['module']['description'], 			
											'required'=>0, 
											'type'=>'textarea', 	
											'editable'=>1	
		);
                
                $this->table_fields = array();
                foreach($this->_table_fields as $key => $val){
                    $this->table_fields[] = $key;
                }

    }

    function getModulesSum($joins, $where, $binds=array()){
    	return $this->db->select($this->table . " T")
		    			->fields("COUNT(DISTINCT id) as _COUNT_")
		    			->joins($joins)
		    			->bind($binds)
		    			->where($where)->row_array();
    }
    
    function listModules($joins=array(), $where=array(), $orders=array(), $limit=array(), $binds=array()){

    	return $this->db->select($this->table . " T")
    					->fields("T.*, T.title_$this->language AS title, 1 AS editorship")
    					->joins($joins)
    					->where($where)
    					->order($orders)
    					->limit($limit)
    					->bind($binds)
    					->result_array();
    	
    }
    
    function listFolders(){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	return $this->db->select($this->table_categories)
    					->fields("*, title_$lng AS title")
    					->result_array();
    }

    function listAdminModules($admin_id, $sort_by="sort_order", $sort_direction="ASC"){
        $admin_modules_rights = $this->registry->model->admins->loadModuleRights($admin_id);
        $items = $this->listModules('', array('disabled!=1'), "$sort_by $sort_direction", '');

		if($_SESSION['admin']['permission']!=1){
			$n = count($items);
			for($i=0; $i<$n; $i++){
				$items[$i]['lng_saved'] = 1;
				if(!in_array($items[$i]['id'], $admin_modules_rights))
					$items_[] = $items[$i];
			}
		}else{
			$n = count($items);
			for($i=0; $i<$n; $i++){
				$items[$i]['lng_saved'] = 1;
				$items_[] = $items[$i];
			}
		}
        return $items_;
    }
    function getModule($id_or_name){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
        return $this->db->select($this->table)
		        		 ->fields("*")
		        		 ->fields("title_$lng AS title")
		        		 ->where("id=:id OR table_name=:table_name")
		        		 ->bind('id', $id_or_name)
		        		 ->bind('table_name', $id_or_name)->row_array();
        		 
    }

    function changeValue($table, $field, $id, $value){
        
        $this->db->update($table)
        	 ->where("id=:id")
        	 ->values("`$field`=:val")
        	 ->bind('id', $id)
                 ->bind('val', $value)
        	 ->query();
       return true; 
    }
    
    function changeStatus($table, $action, $id){
        
    	$row = $this->db->select($table)
		    			->where("id=:id")
		    			->bind('id', $id)
		    			->fields("`$action` AS action")
		    			->row_array();
    	
        $set = ($row['action']!=1?1:0);

        $this->update($table)
        	 ->where("id=:id")
        	 ->values("`$action`=$set")
        	 ->bind('id', $id)
        	 ->query();
        
    }
    
    function changeOrder($lastid, $firstid){
        
        $sort1 = $this->db->select($this->table)
                            ->fields("sort_order")
                            ->where("id=:id")
                            ->bind('id', $firstid)
                            ->row_array();
        
        $sort2 = $this->db->select($this->table)
                            ->fields("sort_order")
                            ->where("id=:id")
                            ->bind('id', $lastid)
                            ->row_array();
        
        if($sort1['sort_order']>$sort2['sort_order']){
        	$set = "sort_order=sort_order-1";
        	$where = "sort_order<=:s1 AND sort_order>=:s2";
        }else{
        	$set = "sort_order=sort_order+1";
        	$where = "sort_order>=:s1 AND sort_order<=:s2";
        }
        				  
        $this->db->update($this->table)
        		 ->values($set)
        		 ->where($where)
        		 ->bind('s1', $sort1['sort_order'])
        		 ->bind('s2', $sort2['sort_order'])
        		 ->query();
        				  
        $this->db->update($this->table)
        		 ->values("sort_order=:s1")
        		 ->where("id=:id")
        		 ->bind('s1', $sort1['sort_order'])
        		 ->bind('id', $lastid)
        		 ->query();
        		 
    }
    
    function saveModule($data, $default_columns=1){
        
    	$this->db->startTransaction();
    	
        $data['table_name'] = strtolower($data['table_name']);
        
        if($data['isNew']==1){

            if($_SESSION['admin']['permission']!=1){
                    $data['parent_module'] = 0;
                    $data['admin_catalog'] = 1;
                    $data['multilng'] = 1;
                    $data['tree'] = 1;
                    $data['mod_pages'] = 1;
                    $data['search'] = 1;
                    $data['cache'] = 1;
                    $data['disabled'] = 1;
                    $data['no_record_table'] = 0;
                    $data['no_standart_tpl'] = 0;
                    $data['area_html'] = '';
                    $data['additional_submit_action'] = '';
                    $data['maxlevel'] = 0;
                    $data['additional_settings'] = '';
            }

            $row = $this->db->select($this->table)
                            ->fields("MAX(sort_order) + 1 AS `new_order`")
                            ->row_array();
            
            $data['sort_order'] = $row['new_order'];
            $sql = "CREATE TABLE `".Config::$val['pr_code']."_{$data['table_name']}` " .
            		"(`id` int(10) NOT NULL auto_increment, `record_id` int(10) NOT NULL default '0', " .
            		"`lng` varchar(255) default NULL, `lng_saved` tinyint(1) NOT NULL default '0', " .
            		"PRIMARY KEY  (`id`), " .
            		"KEY `record_id` (`record_id`) ) " .
            		"AUTO_INCREMENT=1 ;";
            $this->db->query($sql);
            
            $arr = array();
            foreach($data as $key=>$val){
            	if(in_array($key, $this->table_fields))
            		$arr[] = " $key='".addcslashes($val, "'\\")."' ";
            }
            
            $this->db->insert($this->table)
            		 ->values($arr)
            		 ->query();
            
            $id = $this->db->last_insert_id();
            
            $this->saveSettings($data['additional_settings'], $id);
            
            if($default_columns==1){

	            unset($data);
				$data = array(	'module_id'=>$id, 
                                                'isNew'=>1, 
                                                'title_lt'=>'Pavadinimas',
                                                'title_en'=>'Title',  
                                                'column_name'=>'title', 
                                                'column_type'=>'varchar(255)', 
                                                'elm_type'=>'text', 
                                                'default_value'=>'', 
                                                'list_values'=>'',
                                                'extra_params'=>'', 
                                                'function'=>'', 
                                                'class_method'=>'', 
                                                'error_message'=>'', 
                                                'require'=>1,
                                                'list'=>1, 
                                                'editorship'=>1, 
                                                'htmlspecialchars'=>1, 
                                                'multilng'=>1, 
                                                'CE'=>2 );
				$this->saveColumn($data);
	
	            unset($data);
				$data = array(	'module_id'=>$id, 
                                                'isNew'=>1, 
                                                'title_lt'=>'Trumpas aprašymas',
                                                'title_en'=>'Short description',  
                                                'column_name'=>'short_description', 
                                                'column_type'=>'text', 
                                                'elm_type'=>'textarea', 
                                                'default_value'=>'', 
                                                'list_values'=>'',
                                                'extra_params'=>'', 
                                                'function'=>'', 
                                                'class_method'=>'', 
                                                'error_message'=>'', 
                                                'require'=>0,
                                                'list'=>0, 
                                                'editorship'=>1, 
                                                'htmlspecialchars'=>1, 
                                                'multilng'=>0, 
                                                'CE'=>2 );
				$this->saveColumn($data);
	
	            unset($data);
				$data = array(	'module_id'=>$id, 
                                                'isNew'=>1, 
                                                'title_lt'=>'Paveikslėlis',
                                                'title_en'=>'Image',  
                                                'column_name'=>'image', 
                                                'column_type'=>'varchar(255)', 
                                                'elm_type'=>'image', 
                                                'default_value'=>'', 
                                                'list_values'=>'',
                                                'extra_params'=>'prefix=thumb_||size=90x50||quality=80::prefix=||size=500x500||quality=80||water_sign=1', 
                                                'function'=>'', 
                                                'class_method'=>'', 
                                                'error_message'=>'', 
                                                'require'=>0,
                                                'list'=>0, 
                                                'editorship'=>1, 
                                                'htmlspecialchars'=>1, 
                                                'multilng'=>0, 
                                                'CE'=>2 );
				$this->saveColumn($data);
				            
	            unset($data);
				$data = array(	'module_id'=>$id, 
                                                'isNew'=>1, 
                                                'title_lt'=>'Aktyvus',
                                                'title_en'=>'Active',  
                                                'column_name'=>'active', 
                                                'column_type'=>'tinyint(1)', 
                                                'elm_type'=>'checkbox', 
                                                'default_value'=>'1', 
                                                'list_values'=>'',
                                                'extra_params'=>'', 
                                                'function'=>'', 
                                                'class_method'=>'', 
                                                'error_message'=>'', 
                                                'require'=>0,
                                                'list'=>1, 
                                                'editorship'=>1, 
                                                'htmlspecialchars'=>1, 
                                                'multilng'=>0, 
                                                'CE'=>2);
				$this->saveColumn($data);
            	
            }

        }else{
            
        	$row = $this->db->select($this->table)
            				->fields("table_name")
            				->where("id=:id")
            				->bind('id', $data['id'])
            				->row_array();
            
            if($row['table_name'] != $data['table_name']){
                $sql = "ALTER TABLE `".Config::$val['pr_code']."_{$row['table_name']}` RENAME `".Config::$val['pr_code']."_{$data['table_name']}`";
                $this->db->query($sql);
            }
            
            $values = $binds = array();
            foreach($data as $key=>$val){
            	if(in_array($key, $this->table_fields)){
            		$values[] = " $key=:$key ";
            		$binds[$key] = $val;
            	}
            }
            
            $this->db->update($this->table)
            		 ->values($values)
            		 ->where("id=:id")
            		 ->bind('id', $data['id'])
            		 ->bind($binds)
            		 ->query();

            $id = $data['id'];
            
            $this->saveSettings($data['additional_settings'], $id);
            
        }
        
        $this->db->commitTransaction();
        
        return $id;
        
    }
    
    function saveSettings($str, $module_id){
        
        $this->db->update($this->table)
        		 ->values("additional_settings=:additional_settings")
        		 ->where("id=:id")
        		 ->bind('additional_settings', $str)
        		 ->bind('id', $module_id)
        		 ->query();
        
    }
    
    function importModule($data){
    	
    	$this->db->startTransaction();
    	
    	$mod = $this->loadModuleByTablename($data['table_name']);
    	
    	if(!empty($mod)){
    		$data['isNew'] = 0;
    		$data['id'] = $mod['id'];
    	}else{
    		$data['isNew'] = 1;
    	}
    	
    	$id = $this->saveModule($data, 0);
    	
    	foreach($data['module_columns'] as $i=>$val){
    		if($data['isNew']==1){
    			$val['isNew'] = 1;
    			$val['module_id'] = $id;
    		}else{
    			$val['isNew'] = 1;
    			$val['module_id'] = $id;
    			
    			$columns = $this->listColumns($id);
    			foreach($columns as $j=>$column_val){
    				if($column_val['column_name']==$val['column_name']){
    					$val['id'] = $column_val['id'];
    					$val['isNew'] = 0;
    					break;
    				}
    			}
    		}    		
    		$this->saveColumn($val);
    	}
    	
    	$this->db->commitTransaction();
    	
    }
    
    function deleteModule($id){
        
    	$this->db->startTransaction();
    	
        $row = $this->db->select($this->table)
        				->fields("table_name")
        				->where("id=:id")
        				->bind('id', $id)
        				->row_array();

        $arr = $this->db->select(Config::$val['pr_code']."_record")
        				->fields("id")
        				->where("module_id=:id")
        				->bind('id', $id)
        				->result_array();
        				
        foreach($arr as $key=>$val){
	        $this->db->delete(Config::$val['sb_admin_module_rights'])
	        		 ->where("record_id=:id")
	        		 ->bind('id', $val['id'])
	        		 ->query();
		}

        $this->db->delete(Config::$val['pr_code']."_record")
        		 ->where("module_id=:id")
        		 ->bind('id', $id)
        		 ->query();
        
        $this->db->delete($this->table_info)
        		 ->where("module_id=:id")
        		 ->bind('id', $id)
        		 ->query();
        		 
        $sql = "DROP TABLE ".Config::$val['pr_code']."_{$row['table_name']}";
        $this->db->query($sql);
        
        $this->db->delete($this->table)
        		 ->where("id=:id")
        		 ->bind('id', $id)
        		 ->query();
        		 
       	$this->db->commitTransaction();
       	
    }
    
    function listSoapUsersRights($rights_table, $id){
    	$list = $this->listAdminModules($rights_table, $id);
    	foreach($list as $val){
    		if($val['table_name']!='soap_users' && $val['table_name']!='admins'){
    			if($val['rights']!=0) $val['readonly'] = 1;
    			$list_[] = $val;
    		}
    	}
    	return $list_;
    }
    
    function saveAdminRights($rights_table, $data){
    	foreach($data['module'] as $key=>$val){
    		
    		$row = $this->db->select($rights_table)
    						->fields("id")
    						->where("admin_id=:admin_id AND module_id=:module_id")
    						->bind('admin_id', $data['admin_id'])
    						->bind('module_id', $key)
    						->row_array();
    		
    		if(empty($row)){
    			$this->db->insert($rights_table)
    					 ->values("admin_id=:admin_id, rights=:rights")
    					 ->bind('admin_id', $data['admin_id'])
    					 ->bind('rights', $data['module'][$key])
    					 ->query();
    		}else{
    			$this->db->update($rights_table)
    					 ->values("rights=:rights")
    					 ->where("admin_id=:admin_id")
    					 ->bind('rights', $data['module'][$key])
    					 ->bind('admin_id', $data['admin_id'])
    					 ->query();
    		}
    	}
    }
    
    function loadAdminModuleRights($rights_table, $admin_id, $mod){
    	$module = $this->loadModuleByTablename($mod);
    	$sql = "SELECT rights FROM  WHERE admin_id=$admin_id AND module_id={$module['id']}";
    	$row = $this->db->select($rights_table)
    					->fields("rights")
    					->where("admin_id=:admin_id AND module_id=:module_id")
    					->bind('admin_id', $admin_id)
    					->bind('module_id', $module['id'])
    					->row_array();
    	return $row['rights'];
    }
    
    function checkExistColumnName($value, $data){
    	
		$value = strtolower($value['value']);
		
		$mod = $this->getModule($data['module_id']);
		$table_name = Config::$val['pr_code']."_".$mod['table_name'];
		
    	if($data['isNew']==1){
    		
    		$result = mysql_list_fields(Config::$val['database'], $table_name);
    		$columns = mysql_num_fields($result);
			for ($i = 0; $i < $columns; $i++) {
				$arr_tbl[] = mysql_field_name($result, $i);
			}
			if(in_array($value, $arr_tbl)){
				return true;
			}
    		
    	}else{
    		
            $row = $this->db->select($this->table_info)
            				->where("column_name=:column_name AND module_id=:module_id")
            				->bind('column_name', $value)
            				->bind('module_id', $data['module_id'])
            				->row_array();
            if(!empty($row)){
    			if($row['id']!=$data['id']){
    				return true;
    			}	
    		}else{
	    		$result = mysql_list_fields(Config::$val['database'], $table_name);
	    		$columns = mysql_num_fields($result);
				for ($i = 0; $i < $columns; $i++) {
					$arr_tbl[] = mysql_field_name($result, $i);
				}
				if(in_array($value, $arr_tbl)){
					return true;
				}
    		}
    		
    	}
    	
    	return false;
    
    }

    function checkExistTableName($value, $data){
		
		$value = strtolower($value['value']);
		
    	if($data['isNew']==1){
    		
    		$table_name = Config::$val['pr_code']."_".$value;
    		$result = $this->db->query("SHOW TABLES")->result_array();
    		foreach ($result as $row) {
				$arr_tbl[] = strtolower($row[0]);
			}
			if(in_array($table_name, $arr_tbl)){
				return false;
			}
    		
    	}else{
    		
            $row = $this->db->select($this->table)
            				->where("table_name=:table_name")
            				->where("id!=:id")
            				->bind('table_name', $value)
            				->bind('id', $data['id'])
            				->row_array();
            if(!empty($row)){
   		    	return false;
    		}
    		
    	}
    	
    	return true;
    	
    }
    
    function listColumns($module_id){
        return $this->registry->model->module_info->listColumns($module_id);
    }
    
    function saveColumn($data){
        return $this->registry->model->module_info->saveItem($data);
    }
    
}
        
?>