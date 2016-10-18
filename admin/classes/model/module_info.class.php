<?php

include_once(CLASSDIR."main_module.class.php");
include_once(APP_CLASSDIR.'model.class.php');
class model_module_info extends model {
	
	private $module;
	
	public function __construct() {
		
		basic::__construct();
		
		$this->module = new main_module();
		$this->admin = $_SESSION['admin'];
                $this->language = $_SESSION['admin_interface_language'];
		
		$this->module_info = array('table_name'=>'module_info', 'default_sort'=>'sort_order', 'default_sort_direction'=>'ASC');
		
                $this->table = Config::$val['pr_code'] . "_module_info";
                
                $this->table_fields();
		$this->table_list();
		
	}
        
	function table_fields(){
		$this->_table_fields['module_id'] = array(
                                        'title'=>cms::$phrases['main']['settings']['module']['title_lt'], 
                                        'required'=>1, 
                                        'type'=>FRM_HIDDEN, 	
                                        'editable'=>1	
                );
		$this->_table_fields['title_lt'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['title'] . " (LT)", 
                                        'required'=>1, 
                                        'type'=>FRM_TEXT, 	
                                        'editable'=>1	
                );
		$this->_table_fields['title_en'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['title'] . " (EN)", 
                                        'required'=>1, 
                                        'type'=>FRM_TEXT, 	
                                        'editable'=>1	
                );
		$this->_table_fields['column_name'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['column_name'], 
                                        'required'=>1, 
                                        'type'=>FRM_TEXT, 	
                                        'editable'=>1	
                );
		$this->_table_fields['column_type'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['column_type'], 
                                        'required'=>1, 
                                        'type'=>FRM_TEXT, 	
                                        'editable'=>1	
                );
		$this->_table_fields['elm_type'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['elm_type'], 
                                        'required'=>1, 
                                        'type'=>FRM_SELECT,
                                        'list_values'=>get_elm_types(),
                                        'editable'=>1	
                );
		$this->_table_fields['default_value'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['default_value'], 
                                        'required'=>0, 
                                        'type'=>FRM_TEXT, 	
                                        'editable'=>1	
                );
		$this->_table_fields['list_values'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['list_values'], 
                                        'required'=>0, 
                                        'type'=>FRM_TEXTAREA, 	
                                        'editable'=>1	
                );
		$this->_table_fields['validator'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['validator'], 
                                        'required'=>0, 
                                        'type'=>FRM_TEXTAREA, 	
                                        'editable'=>1	
                );
		$this->_table_fields['required'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['require'], 
                                        'required'=>0, 
                                        'type'=>FRM_CHECKBOX, 	
                                        'editable'=>1	
                );
		$this->_table_fields['list'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['list'], 
                                        'required'=>0, 
                                        'type'=>FRM_CHECKBOX, 	
                                        'editable'=>1	
                );
		$this->_table_fields['editable'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['editable'], 
                                        'required'=>0, 
                                        'type'=>FRM_CHECKBOX, 	
                                        'editable'=>1	
                );
		$this->_table_fields['multilng'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['multilng'], 
                                        'required'=>0, 
                                        'type'=>FRM_CHECKBOX, 	
                                        'editable'=>1	
                );
		$this->_table_fields['index'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['index'], 
                                        'required'=>0, 
                                        'type'=>FRM_CHECKBOX, 	
                                        'editable'=>1	
                );
		$this->_table_fields['description'] = array(
                                        'title'=>cms::$phrases['main']['settings']['columns']['description'], 
                                        'required'=>0, 
                                        'type'=>FRM_TEXTAREA, 	
                                        'editable'=>1	
                );
                foreach($this->_table_fields as $key => $val){
                    $this->_table_fields[$key]['column_name'] = $key;
                    $this->_table_fields[$key]['elm_type'] = $val['type'];
                    $this->_table_fields[$key]['editorship'] = $val['editable'];
                }
                
	}
	
	function table_list(){
		$table_list = array();
		$table_list[] = $this->_table_fields['title_' . $_SESSION['admin_interface_language']];
                $table_list[] = $this->_table_fields['column_name'];
                $table_list[] = $this->_table_fields['column_type'];
                $table_list[] = $this->_table_fields['elm_type'];
                $table_list[] = $this->_table_fields['required'];
                $table_list[] = $this->_table_fields['list'];
                $table_list[] = $this->_table_fields['editable'];
                $table_list[] = $this->_table_fields['multilng'];
                $table_list[] = $this->_table_fields['index'];
                
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['column_name'], 'column_name'=>'column_name', 'editorship'=>0, 'elm_type'=>FRM_TEXT);
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['elm_type'], 'column_name'=>'elm_type', 'editorship'=>1, 'elm_type'=>FRM_SELECT);
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['catalog'] , 'column_name'=>'tree', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['cache'], 'column_name'=>'cache', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['no_record_table'], 'column_name'=>'no_record_table', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['search'], 'column_name'=>'search', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
//		$table_list[] = array('title'=>cms::$phrases['main']['settings']['columns']['disabled'], 'column_name'=>'disabled', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX);
		
		$this->table_list = $table_list;
	} 

	function getListingSum($parent_id = 0){
            if(is_numeric($parent_id) && $parent_id != 0){
                    $where[] = " T.module_id=:module_id ";
                    $binds['module_id'] = $parent_id;
            }
            return $this->db->select($this->table . " T")
                            ->fields("COUNT(DISTINCT id) as _COUNT_")
                            ->bind($binds)
                            ->where($where)->row_array();
		
	}
	
	function getListingItems($parent_id = 0){

            $order_by = $this->listing_filter_data['order_by'];
            $order_direction = $this->listing_filter_data['order_direction'];
            $offset = $this->listing_filter_data['offset'];
            $paging = $this->listing_filter_data['paging'];

            if($order_by=='') $order_by = $this->module_info['default_sort'];
            if($order_direction=='') $order_direction = $this->module_info['default_sort_direction'];

            if($offset && $paging){
                    $this->sqlQueryLimit = " $offset, $paging ";
            }
            if(is_numeric($parent_id) && $parent_id != 0){
                    $this->sqlQueryWhere[] = " T.module_id=:module_id ";
                    $this->sqlQueryBinds['module_id'] = $parent_id;
            }
            if($order_by!='') $this->sqlQueryOrder = " $order_by $order_direction ";
            
            $list = $this->listColumns($parent_id, $order_by, $order_direction);
            
            //$list = $this->listColumns($this->sqlQueryJoins, $this->sqlQueryWhere, $this->sqlQueryOrder, $this->sqlQueryLimit, $this->sqlQueryBinds);
            
            return $list;     

        }
	
    function loadItem($id){
    	
    	$lng = $this->language;
        // Kitu kalbu kolkas negali buti, tik LT EN
    	if($this->language!='lt') $lng = "en"; 

        return $this->data = $this->db->select($this->table)
                                        ->fields("*, title_$lng AS title")
                                        ->where("id=:id")
                                        ->bind('id', $id)
                                        ->row_array();
        
    }
    
    function delete($id){

    	$is_already_transaction = $this->db->startTransaction();
    	
    	$row = $this->db->select("$this->table I")
                        ->fields("I.column_name, T.table_name")
                        ->joins("LEFT JOIN " . $this->module->table . " T ON (I.module_id=T.id)")
                        ->where("I.id=:id")
                        ->bind('id', $id)
                        ->row_array();
    	
    	$this->db->delete($this->table)
    			 ->where("id=:id")
    			 ->bind('id', $id)
    			 ->query();
    			 
        $sql = "ALTER TABLE ".Config::$val['pr_code']."_{$row['table_name']} DROP {$row['column_name']}";
        $this->db->query($sql);
        
        if(!$is_already_transaction) $this->db->commitTransaction();
        
    }
    
    function changeOrder($lastid, $firstid){
    	
    	$is_already_transaction = $this->db->startTransaction();
    	
    	$sort1 = $this->db->select($this->table)
    					  ->fields("sort_order, module_id")
    					  ->where("id=:id")
    					  ->bind('id', $firstid)
    					  ->row_array();
    	
    	$sort2 = $this->db->select($this->table)
    					  ->fields("sort_order, module_id")
    					  ->where("id=:id")
    					  ->bind('id', $lastid)
    					  ->row_array();

        if($sort1['sort_order']>$sort2['sort_order']){
        	$sort_order_value = "sort_order=sort_order-1";
        	$where = "sort_order<=:sort1 AND sort_order>=:sort2 AND module_id=:module_id";
        }else{
        	$sort_order_value = "sort_order=sort_order+1";
        	$where = "sort_order>=:sort1 AND sort_order<=:sort2 AND module_id=:module_id";
        }

        $this->db->update($this->table)
        		 ->values($sort_order_value)
        		 ->where($where)
        		 ->bind('module_id', $sort2['module_id'])
        		 ->bind('sort1', $sort1['sort_order'])
        		 ->bind('sort2', $sort2['sort_order'])
        		 ->query();
        
        
        $this->db->update($this->table)
        		 ->values("sort_order=:sort_order")
        		 ->where("id=:id")
        		 ->bind('id', $lastid)
        		 ->bind('sort_order', $sort1['sort_order'])
        		 ->query();
        
        if(!$is_already_transaction) $this->db->commitTransaction();
        
    }
    
    function updateField($id, $field, $value){
    	$this->module->changeValue($this->table, $field, $id, $value);
    }   
    
    function saveItem($data) {
        
    	$mod = $this->module->getModule($data['module_id']);
        
        if($data['isNew']==1){
			
            $is_already_transaction = $this->db->startTransaction();

            $sort = $this->db->select($this->table)
                            ->fields("IF(MAX(sort_order)+1 IS NOT NULL, MAX(sort_order)+1, 1) AS sorder")
                            ->where("module_id=:id")
                            ->bind('id', $data['module_id'])
                            ->row_array();
			
            $data['sort_order'] = $sort['sorder'];
            
            $sql = "ALTER TABLE `".Config::$val['pr_code']."_{$mod['table_name']}` ADD `{$data['column_name']}` {$data['column_type']}";
            $this->db->query($sql);
            
            $values = $binds = array();
            foreach($data as $key=>$val){
                if($this->_table_fields[$key]){
                    $values[] = " `$key`=:$key ";
                    $binds[$key] = $val;
                }
            }
            $values[] = " sort_order=:sort_order ";
            $binds['sort_order'] = $data['sort_order'];
            
            $this->db->insert($this->table)
            		 ->values($values)
            		 ->bind($binds)
            		 ->query();
            
            $id = $this->db->last_insert_id();
            
            if(!$is_already_transaction) $this->db->commitTransaction();
            
            return $id;
            
        }else{
            
            $is_already_transaction = $this->db->startTransaction();
        	
        	$row = $this->db->select($this->table)
        					->fields("column_name")
        					->where("id=:id")
        					->bind('id', $data['id'])
        					->row_array();
        	
            $sql = "ALTER TABLE `".Config::$val['pr_code']."_{$mod['table_name']}` CHANGE `{$row['column_name']}` `{$data['column_name']}` {$data['column_type']}";
            $this->db->query($sql);

            $values = $binds = array();
            foreach($data as $key=>$val){
            	if($this->_table_fields[$key]){
                    $values[] = " `$key`=:$key ";
                    $binds[$key] = $val;
                }
            }
            
            $this->db->update($this->table)
                    ->values($values)
                    ->where("id=:id")
                    ->bind($binds)
                    ->bind('id', $data['id'])
                    ->query();
            
            if(!$is_already_transaction) $this->db->commitTransaction();
            
            return $data['id'];
            
        } 

    }
    
    
    
    
    
    function listColumns($module_id, $sort_by="sort_order", $sort_direction="ASC"){
    	
    	if(!isset($module_id) || !is_numeric($module_id)) return false;
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	if($sort_by=='title') $sort_by = "title_".$lng;
    	
        return $this->db->select($this->table)
                        ->fields("*, title_$lng AS title, 1 AS lng_saved, module_id AS parent_id, 1 AS editorship")
                        ->where("module_id=:module_id")
                        ->bind('module_id', $module_id)
                        ->order("$sort_by $sort_direction")
                        ->result_array();    	

    }
    
}

?>