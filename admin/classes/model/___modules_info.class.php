<?php

include_once(CLASSDIR."main_module.class.php");
include_once(APP_CLASSDIR.'model.class.php');
class model_module_info extends model {
	
    private $module;
    private $info_table_fields = array("module_id", "title", "title_lt", "title_en", "description", "column_name", "column_type", "elm_type", "default_value", "list_values", "required", "validator", "super_user", "list", "editable", "multilng", "index", "lng", "sort_order");
    
    public function __construct() {

        basic::__construct();

        $this->module = new main_module();
        $this->admin = $_SESSION['admin'];

        $this->module_info = array('table_name'=>'module_info', 'default_sort'=>'sort_order', 'default_sort_direction'=>'ASC');

    }
	
    function loadItem($id){
    	return $this->module->loadColumn($id);
    }
    
    function delete($id){
    	$this->module->deleteColumn($id);
    }
    
    function changeOrder($lid, $fid){
    	$this->module->changeColumnsOrder($lid, $fid);
    }
    
    function saveColumn($data){
        
        $mod = $this->module->getModule($data['module_id']);
        
        if($data['isNew']==1){

            $sort = $this->db->select($this->table)
                                ->fields("IF(MAX(sort_order)+1 IS NOT NULL, MAX(sort_order)+1, 1) AS sorder")
                                ->where("module_id=:module_id")
                                ->bind('module_id', $data['module_id'])
                                ->row_array();
            $data['sort_order'] = $sort['sorder'];            
            
            $sql = "ALTER TABLE `" . Config::$val['pr_code'] . "_{$mod['table_name']}` ADD `{$data['column_name']}` {$data['column_type']}";
            $this->db->query($sql);
            
            $values = $binds = array();
            foreach($data as $key=>$val){
                if(in_array($key, $this->info_table_fields)){
                    $values[] = " `$key`=:$key ";
                    $binds[$key] = $val;
                }
            }
            $this->db->insert($this->table)
                        ->values($values)
                        ->binds($binds)
                        ->query();
            
            $id = $this->db->last_insert_id();
            
            
            return $id;
            
        }else{
            
            $row = $this->db->select($this->table)
                                ->fields("column_name")
                                ->where("id=:id")
                                ->bind('id', $data['id'])
                                ->row_array();
            
            $sql = "ALTER TABLE `" . Config::$val['pr_code'] . "_{$mod['table_name']}` CHANGE `{$row['column_name']}` `{$data['column_name']}` {$data['column_type']}";
            $this->db->query($sql);
            
            $values = $binds = array();
            foreach($data as $key=>$val){
                if(in_array($key, $this->info_table_fields)){
                    $values[] = " `$key`=:$key ";
                    $binds[$key] = $val;
                }
            }
            $this->db->update($this->table)
            		 ->values($values)
            		 ->where("id=:id")
            		 ->bind('id', $data['id'])
            		 ->bind($binds)
            		 ->query();

            
            return $data['id'];
            
        } 
               
    }
    
//    # TODO: perdaryti db uzklausas
//    function loadColumn($id){
//    	$lng = $this->language;
//        if($this->language!='lt') $lng = "en"; 
//    	$sql = "SELECT *, title_$lng AS title FROM $this->table_info WHERE id=$id";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        return $this->data = $this->db->row();        
//    }
//    
//    function listColumns($module_id, $sort_by="sort_order", $sort_direction="ASC"){
//    	$lng = $this->language;
//        if($this->language!='lt') $lng = "en"; 
//    	if($sort_by=='title') $sort_by = "title_".$lng;
//        $sql = "SELECT *, title_$lng AS title, 1 AS lng_saved, module_id AS parent_id, 1 AS editorship FROM $this->table_info WHERE module_id=$module_id ORDER BY $sort_by $sort_direction";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        return $this->db->arr();
//    }
//    
//    function deleteColumn($id){
//        $sql = "SELECT I.column_name, T.table_name FROM $this->table_info I LEFT JOIN $this->table T ON (I.module_id=T.id) WHERE I.id=$id";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        $row = $this->db->row();
//        $sql = "DELETE FROM $this->table_info WHERE id=$id";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        $sql = "ALTER TABLE ".$this->config->variable['pr_code']."_{$row['table_name']} DROP {$row['column_name']}";
//        $this->db->exec($sql, __FILE__, __LINE__);
//    }
//    
//    function changeColumnsOrder($lastid, $firstid){
//        $sql = "SELECT sort_order, module_id FROM $this->table_info WHERE id=$firstid";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        $sort1 = $this->db->row();
//        $sql = "SELECT sort_order, module_id FROM $this->table_info WHERE id=$lastid";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        $sort2 = $this->db->row();
//
//        if($sort1['sort_order']>$sort2['sort_order'])
//        	$sql = "UPDATE $this->table_info SET sort_order=sort_order-1 WHERE sort_order<={$sort1['sort_order']} AND sort_order>={$sort2['sort_order']} AND module_id={$sort2['module_id']}";
//        else
//        	$sql = "UPDATE $this->table_info SET sort_order=sort_order+1 WHERE sort_order>={$sort1['sort_order']} AND sort_order<={$sort2['sort_order']} AND module_id={$sort2['module_id']}";
//        $this->db->exec($sql, __FILE__, __LINE__);
//        $sql = "UPDATE $this->table_info SET sort_order={$sort1['sort_order']} WHERE id=$lastid";
//        $this->db->exec($sql, __FILE__, __LINE__);	
//    }    
	
}

?>