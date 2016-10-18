<?php

include_once(CLASSDIR . "record.class.php");

class model extends record {

    public $record_columns = array('id', 'parent_id', 'create_date', 'sort_order', 'session_id');
    
    protected $admin = array();

    function __construct($module) {

        parent::__construct($module);

        $this->module_info['export'] = true;

        // Module language
        $this->language = $_SESSION['site_lng'];

        // Administrator
        $this->admin = $_SESSION['admin'];
    }

    /**
     * 
     * nustatoma ar irasas redaguotas visose kalbose
     * @param int $id
     */
    function getItemLangStatus($id) {

        if ($id == 0) {
            // Languages where admin dont have permissions
            $dienied_admin_langs = $this->registry->model->admins->loadLanguageRights($_SESSION['admin']['id']);
            foreach (Config::$val['default_page'] as $key => $val) {
                $arr[$key]['selected'] = (in_array($key, $dienied_admin_langs) ? 0 : 1);
                $arr[$key]['disabled'] = 0;
            }
        } else {
            $l_arr = $this->db->select($this->table)
                    ->fields("lng_saved, lng")
                    ->where("record_id=:id")
                    ->bind('id', $id)
                    ->result_array();
            $saved_count = array();
            foreach (Config::$val['default_page'] as $key => $val) {
                $arr[$key]['selected'] = 0;
                $arr[$key]['disabled'] = 0;
                foreach ($l_arr as $l_val) {
                    if ($l_val['lng'] == $key) {
                        $arr[$key]['selected'] = $l_val['lng_saved'] == 1 ? 0 : 1;
                        $arr[$key]['disabled'] = $l_val['lng_saved'];
                        if ($l_val['lng_saved'] == 1)
                            $saved_count[] = $key;
                        break;
                    }
                }
            }
            $cnt = count($saved_count);
            if ($cnt == 1) {
                if (!in_array($this->language, $saved_count)) {
                    foreach ($arr as $key => $val) {
                        $arr[$key]['selected'] = 0;
                    }
                }
            }
            if ($cnt > 1) {
                foreach ($arr as $key => $val) {
                    $arr[$key]['selected'] = 0;
                }
            }
        }
        return $arr;
    }

    /**
     * 
     */
    function getListingSum() {

        $category = $this->listing_filter_data['parent_id'];
        if ($this->module_info['no_record_table'] != 1) {
            $this->sqlQueryWhere[] = " R.parent_id=:__category__ ";
            $this->sqlQueryBinds['__category__'] = $category;
        }
        return $this->getCountSearchItems();
    }

    function setFilterValues($data){
        $arr = array();
        foreach($data as $key => $value){
            $arr[] = array('column_name' => $key, 'filter_value' => $value);
        }
        $this->setWhereClause($arr);
    }
    
    /**
     * Suformuojama sql uzklausa
     * @param array $arr
     */
    function setWhereClause($arr = array()) {
        //$this->sqlQueryWhere = array();
        $join_index = 1;
        foreach ($arr as $key => $val) {
            if (strlen($arr[$key]['filter_value']) == 0)
                continue;
            if (is_array($arr[$key]['filter_value'])) {
                $filter_value = $arr[$key]['filter_value'];
            } else {
                $filter_value = preg_replace("/\*/", "%", $arr[$key]['filter_value']);
            }
            switch ($arr[$key]['elm_type']) {
                case FRM_HIDDEN :
                    $this->sqlQueryWhere[$arr[$key]['column_name']] = "T.{$arr[$key]['column_name']} = :{$arr[$key]['column_name']} ";
                    $this->sqlQueryBinds[$arr[$key]['column_name']] = $filter_value;
                    break;
                case FRM_TEXTAREA :
                case FRM_TEXT :
                    $operation = "LIKE";

                    if (preg_match("/^=/", $filter_value))
                        $operation = "=";
                    if (preg_match("/^>/", $filter_value))
                        $operation = ">";
                    if (preg_match("/^</", $filter_value))
                        $operation = "<";
                    if (preg_match("/>$/", $filter_value))
                        $operation = "<";
                    if (preg_match("/<$/", $filter_value))
                        $operation = ">";

                    if ($operation == "LIKE") {
                        $this->sqlQueryWhere[$arr[$key]['column_name']] = "T.{$arr[$key]['column_name']} $operation :{$arr[$key]['column_name']} ";
                        $this->sqlQueryBinds[$arr[$key]['column_name']] = '%' . $filter_value . '%';
                    } else {
                        if (preg_match("/([0-9]+[\.]{0,1}[0-9]*)/", $filter_value, $matches)) {
                            $this->sqlQueryWhere[$arr[$key]['column_name']] = "T.{$arr[$key]['column_name']} $operation :{$arr[$key]['column_name']} ";
                        } else {
                            $this->sqlQueryWhere[$arr[$key]['column_name']] = "T.{$arr[$key]['column_name']} $operation :{$arr[$key]['column_name']} ";
                        }
                        $this->sqlQueryBinds[$arr[$key]['column_name']] = $filter_value;
                    }
                    break;
                case FRM_DATE :
                    if (strlen($val['filter_value_from'])) {
                        $this->sqlQueryWhere[$arr[$key]['column_name'] . "_from"] = " T.{$arr[$key]['column_name']}>=:{$arr[$key]['column_name']}_from ";
                        $this->sqlQueryBinds[$arr[$key]['column_name'] . "_from"] = $val['filter_value_from'];
                    }
                    if (strlen($val['filter_value_to'])) {
                        $this->sqlQueryWhere[$arr[$key]['column_name'] . "_to"] = " T.{$arr[$key]['column_name']}<=:{$arr[$key]['column_name']}_to ";
                        $this->sqlQueryBinds[$arr[$key]['column_name'] . "_to"] = $val['filter_value_to'];
                    }
                    break;
                case FRM_CHECKBOX :
                    if (strlen($filter_value)) {
                        $operation = "=";
                        $this->sqlQueryWhere[$arr[$key]['column_name']] = "T.{$arr[$key]['column_name']} $operation :{$arr[$key]['column_name']}";
                        $this->sqlQueryBinds[$arr[$key]['column_name']] = $filter_value;
                    }
                    break;
                case FRM_RADIO :
                case FRM_AUTOCOMPLETE :
                case FRM_SELECT :
                case FRM_CHECKBOX_GROUP :
                    $list_values = $this->_table_fields[$arr[$key]['column_name']]['list_values'];
                    if ($list_values['source'] == "DB") {
                        $operation = "LIKE";
                        $tbl = 'TBL' . $join_index;
                        $this->sqlQueryWhere[$arr[$key]['column_name']] = $tbl . ".title $operation :{$arr[$key]['column_name']} ";
                        $this->sqlQueryBinds[$arr[$key]['column_name']] = '%' . $filter_value . '%';
                        $this->sqlQueryJoins[] = " LEFT JOIN " . Config::$val['pr_code'] . "_{$list_values['module']} " . $tbl . " ON (" . $tbl . ".record_id=T.{$arr[$key]['column_name']} AND (" . $tbl . ".lng='' OR " . $tbl . ".lng IS NULL OR " . $tbl . ".lng='$this->language')) ";
                        $join_index++;
                    }
                    break;
                default: 
                    if (strlen($filter_value)) {
                        $operation = "=";
                        $this->sqlQueryWhere[$arr[$key]['column_name']] = "T.{$arr[$key]['column_name']} $operation :{$arr[$key]['column_name']}";
                        $this->sqlQueryBinds[$arr[$key]['column_name']] = $filter_value;
                    }
                    break;
            }
        }
    }

    function prepareListing($arr = array()) {

        $this->listing_filter_data['parent_id'] = ($this->module_info['maxlevel'] == 0 ? 0 : (is_numeric($this->get['id']) && $this->get['id'] > 0 ? $this->get['id'] : 0));
        $this->listing_filter_data['order_by'] = $_SESSION['order'][$this->module_info['table_name']]['order_by'];
        $this->listing_filter_data['order_direction'] = $_SESSION['order'][$this->module_info['table_name']]['order_direction'];
        $this->listing_filter_data['offset'] = ($this->get['offset'] < 0 ? 0 : $this->get['offset']) * $_SESSION['order']['paging'];
        $this->listing_filter_data['paging'] = $_SESSION['order']['paging'];

        $this->setWhereClause($arr);
    }

    function filterListing() {
        if (isset($this->post['action']) && $this->post['action'] == 'filter') {
            $this->get['offset'] = 0;
            unset($_SESSION['filters'][$this->module_info['table_name']]);
            foreach ($this->table_list as $key => $val) {
                if (!empty($this->post['filteritem___' . $val['column_name']])) {
                    $_SESSION['filters'][$this->module_info['table_name']][$val['column_name']] = $this->post['filteritem___' . $val['column_name']];
                }
            }
        }

        if (!isset($_SESSION['order'][$this->get['module']]['order_by'])) {
            $_SESSION['order'][$this->get['module']]['order_by'] = strlen($this->module_info['default_sort']) > 0 ? $this->module_info['default_sort'] : "R.sort_order";
        }
        if (!isset($_SESSION['order'][$this->get['module']]['order_direction']) || strlen($_SESSION['order'][$this->get['module']]['order_direction']) == 0) {
            $_SESSION['order'][$this->get['module']]['order_direction'] = "";
        }
    }

    function listingActions() {

        if (isset($this->get['action']) && $this->get['action'] == 'delete' && isset($this->get['deleteid'])) {
            //$this->loadItem($this->get['deleteid']);
            $this->delete($this->get['deleteid']);
        }

        if (isset($this->get['action']) && $this->get['action'] == 'change_order' && isset($this->get['firstid']) && isset($this->get['lastid'])) {
            $this->changeOrder($this->get['firstid'], $this->get['lastid']);
            $this->loadItem($this->get['firstid']);
        }

        if (isset($this->get['action']) && $this->get['action'] == 'action_with_selected_items') {
            if ($this->get['action_choice'] == "delete") {
                foreach ($this->post['chk'] as $key => $val) {
                    $this->delete($this->post['chk'][$key]);
                }
            }
            if ($this->get['action_choice'] != "delete") {
                foreach ($this->post['chk'] as $key => $val) {
                    $this->changeFieldStatus($_SESSION['site_lng'], $this->get['action_choice'], $this->post['chk'][$key]);
                }
            }
        }
    }

    function getListingItems() {

        $category = $this->listing_filter_data['parent_id'];
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

        if ($this->module_info['no_record_table'] != 1) {
            $this->sqlQueryWhere[] = " R.parent_id=:__category__ ";
            $this->sqlQueryBinds['__category__'] = $category;
        }

        $this->sqlQueryLimit = array('start' => $offset, 'paging' => $paging);
        if ($order_by != '')
            $this->sqlQueryOrder[] = " $order_by $order_direction ";
        
        $list = $this->listSearchItems();

        return $list;
    }

    function changeOrder($lastid, $firstid) {
        $sort1 = $this->db->select($this->tables['record'])
                ->fields("sort_order, parent_id")
                ->where("id=:id")
                ->bind('id', $firstid)
                ->row_array();
        $sort2 = $this->db->select($this->tables['record'])
                ->fields("sort_order, parent_id")
                ->where("id=:id")
                ->bind('id', $lastid)
                ->row_array();
        if ($sort1['sort_order'] > $sort2['sort_order']) {
            $this->db->update($this->tables['record'])
                    ->values("sort_order=sort_order-1")
                    ->where("sort_order<=:sort1 AND sort_order>=:sort2 AND parent_id=:parent_id AND module_id=:module_id")
                    ->bind('sort1', $sort1['sort_order'])
                    ->bind('sort2', $sort2['sort_order'])
                    ->bind('parent_id', $sort2['parent_id'])
                    ->bind('module_id', $this->module_info['id'])
                    ->query();
        } else {
            $this->db->update($this->tables['record'])
                    ->values("sort_order=sort_order+1")
                    ->where("sort_order>=:sort1 AND sort_order<=:sort2 AND parent_id=:parent_id AND module_id=:module_id")
                    ->bind('sort1', $sort1['sort_order'])
                    ->bind('sort2', $sort2['sort_order'])
                    ->bind('parent_id', $sort2['parent_id'])
                    ->bind('module_id', $this->module_info['id'])
                    ->query();
        }

        $this->db->update($this->tables['record'])
                ->values("sort_order=:sort")
                ->where("id=:id")
                ->bind('sort', $sort1['sort_order'])
                ->bind('id', $lastid)
                ->query();

        if ($this->module_info['cache'] == 1) {
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }
    }

    function checkRecordParentId($column, $data) {

        if (is_numeric($column['value']))
            $post_value = $this->getPath($column['value']);
        if (is_numeric($data['id']))
            $data_value = $this->getPath($data['id']);

        $index = count($data_value) - 1;

        if ($index < 0)
            return false;

        if ($data_value[$index]['id'] != $post_value[$index]['id']) {
            return false;
        } else {
            return true;
        }
    }

    function changeParentId($id, $parent_id, $sort_to_item_id = 0) {

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
            return $id;

        $sort_order = $this->getLastSortOrder($parent_id) + 1;
        
        $this->db->update($this->tables['record'])
                ->values("parent_id=:parent_id")
                ->values("sort_order=:sort_order")
                ->where("id=:id")
                ->bind('parent_id', $parent_id)
                ->bind('sort_order', $sort_order)
                ->bind('id', $id)
                ->query();

        if ($this->module_info['cache'] == 1) {
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }
        
        if ($sort_to_item_id != 0) {
            $this->changeOrder($id, $sort_to_item_id);
        }

        $this->registerLastEdit($id);
    }

    /**
     * 
     * Returns checkbox list(languages) for delete item action
     * @param integer $id
     */
    function get_lngs_for_delete($id) {
        $dienied_admin_langs = $this->registry->model->admins->loadLanguageRights($_SESSION['admin']['id']);
        $lang_saved_arr = $this->getItemLangStatus($id);
        $lang_val = array();
        foreach (Config::$val['default_page'] as $key => $val) {
            if (!in_array($key, $dienied_admin_langs))
                $lang_val[] = array('title' => strtoupper($key), 'value' => $key, 'selected' => true);
        }
        return $lang_val;
    }

    function loadAdminRights($admin_id, $record_id) {

        if (RESTART_SESSION == 1)
            return;

        if (!isset($admin_id))
            return 0;

        // always have permission to change owner account
        if ($admin_id == $record_id)
            return 1;

        $row = $this->db->select(Config::$val['sb_record'])
                ->where("id=:id")
                ->bind('id', $record_id)
                ->row_array();

        if (is_numeric($row['module_id'])) {
            $mod = $this->db->select(Config::$val['sb_module'])
                    ->where("id=:id")
                    ->bind('id', $row['module_id'])
                    ->row_array();
        }

        // Put admin rights to array 
        $arr = strlen($this->admin['mod_rights']) ? explode("::", $this->admin['mod_rights']) : array();
        // If item module is disabled
        if ($mod['disabled'] == 1 || $this->module_info['disabled'] == 1) {
            if (in_array($_SESSION['filter_item']['list_values']['get_category']['value'], $arr)) {
                return 0;
            }
        } else {
            // If module blocks then always have permission
            if ($this->module_info['table_name'] == 'blocks') {
                return 1;
            }
            if (in_array($this->module_info['id'], $arr) && is_numeric($this->module_info['id'])) {
                return 0;
            }
        }

        // If item is new
        if (!isset($record_id))
            return 1;

        $arr = $this->db->select(Config::$val['sb_admin_module_rights'])
                ->where("admin_id=:admin_id AND record_id=:record_id")
                ->bind('admin_id', $admin_id)
                ->bind('record_id', $record_id)
                ->row_array();
        if (empty($arr))
            return 1;
        else
            return 0;
    }

    function listAdminRights($rights_table, $admin_id, $module_id, $parent_id = 0, $offset = 0, $paging = 20) {

        global $RESTART_SESSION;
        if ($RESTART_SESSION == 1)
            return;

        $n = count($this->table_fields);
        for ($i = 0, $fields = array(); $i < $n; $i++) {
            $fields[] = " T." . $this->table_fields[$i]['column_name'] . " ";
        }

        if ($this->module_info['no_record_table'] != 1)
            $order = " ORDER BY R.sort_order ASC ";

        $arr = $this->db->select("{$this->tables['record']} R")
                ->fields($fields)
                ->fields("R.parent_id, R.id, U.rights, IF(U.rights IS NULL, 0, U.rights) AS prm, T.lng_saved")
                ->joins("LEFT JOIN {$this->table} T ON (R.id=T.record_id) ")
                ->joins("LEFT JOIN $rights_table U ON (R.id=U.record_id AND U.admin_id=$admin_id) ")
                ->where("R.parent_id=:parent_id AND R.trash!=1 " . ($this->module_info['multilng'] == 1 ? " AND T.lng=:lng " : ""))
                ->bind('parent_id', $parent_id)
                ->bind('lng', $this->language)
                ->order($order)
                ->limit($start, $offset * $paging)
                ->result_array();

        return $arr;
    }

    function getCountAdminRights($rights_table, $admin_id, $module_id, $parent_id = 0) {

        global $RESTART_SESSION;
        if ($RESTART_SESSION == 1)
            return;

        $n = count($this->table_fields);
        for ($i = 0, $fields = array(); $i < $n; $i++) {
            $fields[] = " T." . $this->table_fields[$i]['column_name'] . " ";
        }

        $arr = $this->db->select("{$this->tables['record']} R")
                ->fields("R.parent_id, R.id, U.rights, IF(U.rights IS NULL, 0, U.rights) AS prm, T.lng_saved")
                ->joins("LEFT JOIN {$this->table} T ON (R.id=T.record_id)")
                ->joins("LEFT JOIN $rights_table U ON (R.id=U.record_id AND U.admin_id=$admin_id)")
                ->where("R.parent_id=:parent_id AND R.trash!=1 " . ($this->module_info['multilng'] == 1 ? " AND T.lng=:lng " : ""))
                ->bind('parent_id', $parent_id)
                ->bind('lng', $this->language)
                ->result_array();

        return count($arr);
    }

    function delete($id) {
        parent::deleteFromTrash($id);
        foreach($this->table_fields as $fld){
            if($fld['elm_type'] == FRM_LIST){
                $this->registry->model->{$fld['list_values']['module']}->delete_list_items($fld['list_values']['column'], $id);
            }
        }
    }
    
    function delete_list_items($column, $value){
        $list = $this->loadItemByColumnValue($column, $value);
        foreach($list as $item){
            $this->delete($item['id']);
        }
    }

    function loadItemByColumnValue($column, $value) {
        $this->sqlQueryWhere = array("T.$column = :column_search_value");
        $this->sqlQueryBinds = array('column_search_value' => $value);
        $arr = $this->listSearchItems();
        return $arr;
    }
    
    function loadByOne($cond, $all = true){
        $data = $this->loadBy($cond, $all);
        if(!empty($data)) return $data[0];
    }
    
    function loadBy($cond, $all = true){

            $binds = $where = array();
            if(is_array($cond)){
                foreach($cond as $key=>$val){
                        if(is_array($val)){
                                $binds[$key] = $val['value'];
                                $where[] = (in_array($key, $this->record_columns)?"R.":"T.")."$key {$val['op']} :$key";
                        }else{
                                $binds[$key] = $val;
                                $where[] = (in_array($key, $this->record_columns)?"R.":"T.")."$key=:$key";
                        }
                }
            }elseif(!empty($cond)){
                $where[] = $cond;
            }

            if(!$all){
                $where[] = "T.active=1";
                if($this->module_info['no_record_table']!=1){
                    $where[] = "R.trash!=1";
                }
            }
            
            if($this->module_info['multilng'] == 1){
                $where[] = "T.lng='$this->language'";
            }
            
            if($this->module_info['default_sort']){
                $order = $this->module_info['default_sort'];
            }
            
            $joins = array();
            if($this->module_info['no_record_table']!=1){
                $joins[] = "LEFT JOIN {$this->tables['record']} R ON (R.id=T.record_id)";
            }

            $arr = $this->db->select($this->table . " T")
                            ->joins($joins)
                            ->bind($binds)
                            ->where($where)
                            ->order($order)
                            ->result_array();   		
            return $arr;

    }
    
    function listAutocompleteItems($term, $columns){
        // default autocomplete search column 'title'
        if(empty($columns)){
            $columns[] = 'title';
        }
        $where_columns = array();
        foreach($columns as $column){
            $where_columns[] = "T.$column LIKE :atocomplete_value_$column";
            $this->sqlQueryBinds["atocomplete_value_$column"] = '%' . $term . '%';
        }
        $this->sqlQueryWhere[] = "(" . implode(" OR ", $where_columns) . ")";
        
        $list = $this->listSearchItems();
        return $list;
    }

    function listActiveItems() {
        return $this->loadItemByColumnValue('active', 1);
    }
    
    function isSub($parent_id){
            $this->listing_filter_data['parent_id'] = $parent_id;
            $res = $this->getListingSum();
            return $res['_COUNT_'];
    }
    
    function insert($data){
        
        $data['isNew'] = 1;
        $data['id'] = 0;
        $data['parent_id'] = 0;
        $data['language'] = $this->language;
        $languages = array();
        foreach(Config::$val['default_page'] as $lng => $lng_main_id){
            $languages[] = $lng;
        }
        $data['language_actions'] = $languages;
        
        return $this->saveItem($data);
    }

}

?>