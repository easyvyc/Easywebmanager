<?php

include_once(APP_CLASSDIR . "model.class.php");

class model_templates extends model {

    function __construct() {

        parent::__construct("templates");
        
        $this->module_info['no_record_table'] = 1;
        $this->module_info['table_name'] = 'templates';
        $this->module_info['export'] = false;
        
        $this->_table_fields['title'] = array('title'=>'Title', 'elm_type'=>FRM_TEXT, 'editable'=>1, 'required'=>1);
        $this->_table_fields['name'] = array('title'=>'Name', 'elm_type'=>FRM_TEXT, 'editable'=>1, 'required'=>1);
	$this->_table_fields['active'] = array('title'=>'Active', 'elm_type'=>FRM_CHECKBOX, 'editable'=>1, 'editorship'=>1);
        
        foreach($this->_table_fields as $key => $val){
            $val['column_name'] = $key;
            $this->table_fields[] = $val;
            $this->table_list[] = $val;
        }
        
    }

    function listPageSelect(){
        $list = $this->listActiveItems();
        foreach($list as $i => $val){
            $list[$i]['id'] = $val['name'];
        }
        return $list;
    }
    
}

?>
