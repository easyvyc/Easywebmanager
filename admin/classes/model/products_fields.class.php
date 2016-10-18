<?php

include_once(CLASSDIR."model.class.php");
class model_products_fields extends model {

    function __construct() {
    	parent::__construct("products_fields");
    }
    
    function getCategoryFields($category_id){
        $this->listing_filter_data['parent_id'] = 0;
        $this->setFilterValues(array('category_id' => $category_id));
        $fields = $this->getListingItems($category_id);
        
        $fld_list = array();
        foreach($fields as $key => $val){
            $fields[$key]['editable'] = true;
            $fields[$key]['type'] = $val['elm_type'];
            $fields[$key]['name'] = 'column_' . $val['id'];
            if(in_array($val['elm_type'], array(FRM_SELECT, FRM_RADIO, FRM_CHECKBOX_GROUP))){
                $fields[$key]['list_values'] = array('source' => 'CALL', 'no_rel' => 1, 'module' => 'products_fields_options', 'method' => 'listOptions', 'parent_id' => $val['id']);
            }
            if(in_array($val['elm_type'], array('custom'))){
                $fields[$key]['list_values'] = parse___list_values($fields[$key]['list_values']);
                if($fields[$key]['list_values']['elm_type']){
                    $fields[$key]['type'] = $fields[$key]['elm_type'] = $fields[$key]['list_values']['elm_type'];
                }
            }
            $fld_list['column_' . $val['id']] = $fields[$key];
        }
        
        return $fld_list;
    }
    
    function frm_types_list(){
        $frm_types = array();
        $frm_types[FRM_TEXT] = array('value' => FRM_TEXT, 'title' => 'Tekstinis laukelis', 'db_type' => 'varchar(255)');
        $frm_types[FRM_TEXTAREA] = array('value' => FRM_TEXTAREA, 'title' => 'Tekstinis laukelis (textarea)', 'db_type' => 'text');
        $frm_types[FRM_CHECKBOX] = array('value' => FRM_CHECKBOX, 'title' => 'Checkbox', 'db_type' => 'tinyint(1)');
        $frm_types[FRM_CHECKBOX_GROUP] = array('value' => FRM_CHECKBOX_GROUP, 'title' => 'Checkbox group', 'db_type' => 'varchar(255)');
        $frm_types[FRM_RADIO] = array('value' => FRM_RADIO, 'title' => 'Radio', 'db_type' => 'int(11)');
        $frm_types[FRM_SELECT] = array('value' => FRM_SELECT, 'title' => 'Select', 'db_type' => 'int(11)');
        //$frm_types[FRM_IMAGE] = array('value' => FRM_IMAGE, 'title' => 'Image', 'db_type' => 'varchar(255)');
        $frm_types['custom'] = array('value' => 'custom', 'title' => 'Custom', 'db_type' => 'text');
        return $frm_types;
    }
    
    function use_as_filter_options(){
        $frm_types = array();
        $frm_types['none'] = array('value' => 'none', 'title' => 'Do not use');
        $frm_types['select'] = array('value' => 'select', 'title' => 'Dropdown box');
        $frm_types['checkbox'] = array('value' => 'checkbox', 'title' => 'Checkbox group');
        $frm_types['range'] = array('value' => 'range', 'title' => 'Range slider');
        return $frm_types;
    }
    
    function saveItem($data){
        
        $frm_types = $this->frm_types_list();
        
        if($data['isNew']!=1){
            $old_data = $this->loadItem($data['id']);
        }
        
        $id = parent::saveItem($data);
        
        if($data['isNew']==1){
            $column_data['isNew'] = 1;
            $column_data['id'] = 0;
        }else{
            if($old_data['elm_type'] != $data['elm_type']){
                $column_data['isNew'] = 0;
                $column_data['id'] = $old_data['column_id'];
            }
        }

        if($column_data['isNew'] || $column_data['id']){
            $column_data['module_id'] = $this->registry->model->products_fields_values->module_info['id'];
            $column_data['column_name'] = 'column_' . $id;
            $column_data['column_type'] = $frm_types[$data['elm_type']]['db_type'];
            $column_id = $this->registry->model->module_info->saveItem($column_data);
            $this->updateField($id, 'column_id', $column_id);
        }
        
        return $id;
        
    }
    
    function setFilterValues($data){
        unset($data['category_id']);
        return parent::setFilterValues($data);
    }
    
    function getListingSum($category_id) {

        $this->registry->model->pages->getPath($category_id);
        $pages_path = $this->registry->model->pages->path_arr;
        foreach($pages_path as $path_data){
            $where_path_arr[] = "T.category_id = {$path_data['id']}";
        }
        $this->sqlQueryWhere[] = "(" . implode(" OR ", $where_path_arr) . ")";

        return $this->getCountSearchItems();
    }    
    
    function getListingItems($category_id){
        
        $order_by = $this->listing_filter_data['order_by'];
        $order_direction = $this->listing_filter_data['order_direction'];
        $offset = $this->listing_filter_data['offset'];
        $paging = $this->listing_filter_data['paging'];

        if ($order_by == '')
            $order_by = $this->module_info['default_sort'];
        if ($order_direction == '')
            $order_direction = $this->module_info['default_sort_direction'];

        $arr = preg_split("/\s/", $order_by);
        if(count($arr) > 1){
            $order_by = $this->listing_filter_data['order_by'] = $arr[0];
            $order_direction = $this->listing_filter_data['order_direction'] = $arr[1];
        }
        
        if ($this->module_info['no_record_table'] == 1 && $order_by == 'R.sort_order') {
            $order_by = "";
        }

        $this->registry->model->pages->getPath($category_id);
        $pages_path = $this->registry->model->pages->path_arr;
        foreach($pages_path as $path_data){
            $where_path_arr[] = "T.category_id = {$path_data['id']}";
        }
        $this->sqlQueryWhere[] = "(" . implode(" OR ", $where_path_arr) . ")";
        
        $this->sqlQueryLimit = array('start' => $offset, 'paging' => $paging);
        if ($order_by != '')
            $this->sqlQueryOrder[] = " $order_by $order_direction ";
        
        $list = $this->listSearchItems();

        return $list;
        
        
    }
    
    function delete($id){
        $old_data = $this->loadItem($id);
        $this->registry->model->module_info->delete($old_data['column_id']);
        return parent::delete($id);
    }
    
}
?>