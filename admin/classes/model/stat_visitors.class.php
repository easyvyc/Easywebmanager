<?php

include_once(APP_CLASSDIR."model.class.php");
class model_stat_visitors extends model {
	
	// constructor inherit record class
	function __construct(){
		
		parent::__construct("stat_visitors");
                $this->module_info['no_record_table'] = 1;
		
	}
        
        function getTableFields(){
            $table_list = array();
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['ip_address_title'], 
                            'column_name'=>'ipaddress', 
                            'elm_type'=>FRM_TEXT,
                            'w'=>3
            );
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['device_type'], 
                            'column_name'=>'device', 
                            'elm_type'=>FRM_TEXT,
                            'w'=>1
            );
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['user_agent'], 
                            'column_name'=>'user_agent', 
                            'elm_type'=>FRM_TEXT,
                            'w'=>5
            );
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['referer_title'], 
                            'column_name'=>'referer_domain', 
                            'elm_type'=>FRM_TEXT,
                            'w'=>5
            );
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['country_title'], 
                            'column_name'=>'country', 
                            'elm_type'=>FRM_TEXT,
                            'w'=>2
            );
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['enter_time_title'], 
                            'column_name'=>'visit_time', 
                            'elm_type'=>FRM_DATE,
                            'w'=>2
            );
            $table_list[] = array(
                            'title'=>cms::$phrases['main']['stat']['past_time_title'], 
                            'column_name'=>'past_time', 
                            'elm_type'=>FRM_TEXT,
                            'w'=>2
            );
            $this->table_list = $table_list; // For items list
            $this->table_fields = $table_list; // For item data
            
        }
        
        function getListingItems(){
            
            $category = $this->listing_filter_data['parent_id'];
            $order_by = $this->listing_filter_data['order_by'];
            $order_direction = $this->listing_filter_data['order_direction'];
            $offset = $this->listing_filter_data['offset'];
            $paging = $this->listing_filter_data['paging'];

            if ($order_by == '')
                $order_by = $this->module_info['default_sort'];
            if ($order_direction == '')
                $order_direction = $this->module_info['default_sort_direction'];

            if ($this->module_info['no_record_table'] == 1 && $order_by == 'R.sort_order') {
                $order_by = "";
            }

            $this->sqlQueryLimit = array('start' => $offset, 'paging' => $paging);
            if ($order_by != '')
                $this->sqlQueryOrder[] = " $order_by $order_direction ";

            
            $binds = $this->sqlQueryBinds;
            
            $list = $this->db->select($this->table . " T")
                    ->fields("T.*, TIMEDIFF(MAX(P.visit_time), MIN(P.visit_time)) AS past_time, COUNT(P.id) AS page_count")
                    ->joins("LEFT JOIN " . Config::$val['pr_code'] . "_stat_visitors_path P ON (T.id=P.visitor_id)")
                    ->where($this->sqlQueryWhere)
                    ->order($this->sqlQueryOrder)
                    ->group("T.id")
                    ->limit($this->sqlQueryLimit['start'], $this->sqlQueryLimit['paging'])
                    ->bind($binds)
                    ->result_array();

            return $list;
            
        }
	
		
}

?>