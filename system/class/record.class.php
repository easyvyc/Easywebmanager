<?php

include_once(CLASSDIR . "basic.class.php");
include_once(CLASSDIR . "main_module.class.php");

abstract class record extends basic {

    public $module_info;
    public $table_fields;
    public $table_list;
    public $table;
    public $viewAllItems = 1;
    protected $tables;

    function __construct($module) {

        parent::__construct();

        $this->module = main_module::getInstance();

        // DB tables
        $this->tables['module'] = Config::$val['sb_module'];
        $this->tables['module_info'] = Config::$val['sb_module_info'];
        $this->tables['record'] = Config::$val['sb_record'];
	$this->tables['record_lang'] = Config::$val['sb_record_lang'];
        $this->table = Config::$val['pr_code'] . '_' . $module;
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
    private function info($module) {
        // Load module info
        $data = $this->module->getModule($module);
        // Parse module xml settings
        if (strlen($data['additional_settings']) > 0) {
            load_helpers('xml');
            $data['xml_settings'] = XML_Array::xmlStringToArray(html_entity_decode($data['additional_settings']));
        }
        return $data;
    }

    protected function getTableFields() {

        // List module columns
        $table_fields = $this->module->listColumns($this->module_info['id']);
        $n = count($table_fields);

        foreach ($table_fields as $i => $val) {
            // Parse list_values data string to array
            if ($val['list_values'])
                $table_fields[$i]['list_values'] = parse___list_values($val['list_values']);

            $table_fields[$i]['type'] = $val['elm_type'];

            // Parse image parametters from string to array
            if ($val['extra_params'])
                $table_fields[$i]['image_extra'] = parse___extra_params($val['extra_params']);

            $table_fields_assoc[$val['column_name']] = $table_fields[$i];

            if ($table_fields[$i]['list'] == 1) {
                if ($this->admin['permission'] == 1 || ($this->admin['permission'] != 1 && $table_fields[$i]['super_user'] != 1))
                    $table_list[] = $table_fields[$i];
            }
        }

        $this->table_list = $table_list; // For items list
        $this->table_fields = $table_fields; // For item data
        $this->_table_fields = $table_fields_assoc; // For item data (assoc array)
    }

    function loadItem($id, $parent_id = 0) {

        if (!is_numeric($id) || $id < 0)
            return false;

        $n = count($this->table_fields);
        for ($i = 0, $fields = ''; $i < $n; $i++) {
            $fields.= "" . $this->table_fields[$i]['column_name'] . ", ";
        }

        $index_column_name = ($this->module_info['no_record_table'] != 1 ? "record_id" : "id");

        $where = $binds = array();
        $where[] = "$index_column_name=:id";
        $binds['id'] = $id;
        if ($this->module_info['multilng'] == 1) {
            $where[] = "lng=:lng";
            $binds['lng'] = $this->language;
        }

        $data = $this->db->select($this->table)
                ->fields($fields . " $index_column_name AS id, lng, lng_saved")
                ->where($where)
                ->bind($binds)
                ->row_array();

        if (!empty($data)) {
            $data['isNew'] = 0;
            for ($j = 0; $j < $n; $j++) {
                if ($this->table_fields[$j]['list_values']['source'] == 'DB') {
                    if($this->table_fields[$j]['list_values']['no_rel'] != 1 || $this->table_fields[$j]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$j]['list_values']['multiple']){
                    $relations_list = $this->getRelations($this->table_relations, $data['id'], $this->table_fields[$j], $this->language);
                    $c = count($relations_list);
                    $value = "";
                    $title = "";
                        $arr = array();
                    for ($k = 0; $k < $c; $k++) {
                        $value .= $k != 0 ? "::" : "";
                        $value .= $relations_list[$k]['value'];
                            $arr[] = $relations_list[$k]['value'];

                        $title .= $k != 0 ? ";" : "";
                        $title .= $relations_list[$k]['title'];
                    }
                    if(count($arr) > 1){
                        $data[$this->table_fields[$j]['column_name']] = $arr;
                    }
                    $data[$this->table_fields[$j]['column_name'] . "_list"] = $title;
                    }else{
                        $module_name = $this->table_fields[$j]['list_values']['module'];
                        $rel_data = $this->registry->model->{$module_name}->loadItem($data[$this->table_fields[$j]['column_name']]);
                        $data[$this->table_fields[$j]['column_name'] . "_list"] = $rel_data['title'];
                    }
                    //$data[$this->table_fields[$j]['column_name']] = $value;
                }
            }
            if ($this->module_info['no_record_table'] != 1) {
                $arr = $this->db->select($this->tables['record'])
                        ->where("id=:id")
                        ->bind('id', $id)
                        ->row_array();
                if (!empty($arr)) {
                    foreach ($arr as $key => $val) {
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

    function loadItemAuthor($id) {

        if ($this->module_info['no_record_table'] == 1)
            return array();

        $row = $this->db->select("{$this->tables['record']} R")
                ->fields("M.*")
                ->joins("LEFT JOIN {$this->tables['module']} M ON (R.module_id=M.id)")
                ->where("R.id=:id")
                ->bind('id', $id)
                ->row_array();

        if (!empty($row)) {
            $author_obj = $this->registry->model->create($row['table_name']);
            $author_data = $author_obj->loadItem($id);
            $author_data['module_title'] = $row['title'];
            if ($row['table_name'] == 'admins')
                $author_data['title'] = $author_data['login'] . ", " . $author_data['firstname'] . " " . $author_data['lastname'];
            $data = $author_data;
        }else {
            $data['id'] = 0;
        }

        return $data;
    }
    
    function getLastSortOrder($parent_id){
        $sort = $this->db->select($this->tables['record'])
                ->fields("IF(MAX(sort_order) IS NOT NULL, MAX(sort_order), 0) AS sorder")
                ->where("parent_id=:parent_id")
                ->bind('parent_id', $parent_id)
                ->row_array();
        return $sort['sorder'];
    }
    
    function generateCleanText4Search($id){
        
        if(!is_numeric($id)) return false;
        
        $data = $this->loadItem($id);
        
        $values = array();
        foreach($this->table_fields as $val){
            if($val['elm_type'] == FRM_SELECT || $val['elm_type'] == FRM_RADIO || $val['elm_type'] == FRM_CHECKBOX_GROUP || $val['elm_type'] == FRM_AUTOCOMPLETE){
                $txt = trim($data[$val['column_name'] . '_list']);
                if($txt) $values[] = $txt;
            }
            if($val['elm_type'] == FRM_TEXT || $val['elm_type'] == FRM_TEXTAREA || $val['elm_type'] == FRM_HTML || $val['elm_type'] == FRM_DATE){
                $txt = $data[$val['column_name']];
                if($val['elm_type'] == FRM_HTML){
                    $txt = trim(html2text($txt));
                }else{
                    $txt = trim($txt);
                }
                if($txt) $values[] = $txt;
            }
        }
        $value = implode("\n | \n", $values);
        
        $exists = $this->db->select($this->tables['record_lang'])
                ->fields("record_id")
                ->where("record_id=:record_id")
                ->where("lng=:lng")
                ->where("module_id=:module_id")
                ->bind('lng', $this->language)
                ->bind('record_id', $id)
                ->bind('module_id', $this->module_info['id'])
                ->row_array();
        
        // jei reiksme tuscia nebus ko ieskot tai trinam lauk jei yra
        if($value == '' && $exists){
            $this->db->delete($this->tables['record_lang'])
                    ->where("record_id=:record_id")
                    ->where("lng=:lng")
                    ->where("module_id=:module_id")
                    ->bind('lng', $this->language)
                    ->bind('record_id', $id)
                    ->bind('module_id', $this->module_info['id'])
                    ->query();
            return false;
        }
        
        if($exists){
            $this->db->update($this->tables['record_lang'])
                    ->values('search_text = :value')
                    ->where("record_id=:id")
                    ->where("lng=:lng")
                    ->where("module_id=:module_id")
                    ->bind('id', $id)
                    ->bind('module_id', $this->module_info['id'])
                    ->bind('lng', $this->language)
                    ->bind('value', $value)
                    ->query();
        }else{
            $this->db->insert($this->tables['record_lang'])
                    ->values('search_text = :value, record_id = :record_id, module_id = :module_id, lng = :lng')
                    ->bind('value', $value)
                    ->bind('record_id', $id)
                    ->bind('module_id', $this->module_info['id'])
                    ->bind('lng', $this->language)
                    ->query();
        }
    }    

    function saveItem($data) {

        if ($data['isNew'] != 1) {
            if ($this->loadAdminRights($this->admin['id'], $data['id']) != 1)
                return $data['id'];
        } else {
            if ($this->module_info['disabled'] == 1 && is_numeric($_GET['parent_record_id']))
                if ($this->loadAdminRights($this->admin['id'], $_GET['parent_record_id']) != 1)
                    return $_GET['parent_record_id'];
                else
                if ($this->loadAdminRights($this->admin['id'], $data['parent_id']) != 1)
                    return $data['id'];
        }

        // parent_id visalaika turi tureti reiksme, jei nenustatyta tai turi but nulis
        if (!isset($data['parent_id']) && !is_numeric($data['parent_id']))
            $data['parent_id'] = 0;

        if ($this->module_info['multilng'] == 1) {
            $languages_arr[$data['language']] = Config::$val['default_page'][$data['language']];
            $lang_arr = $data['language_actions'];
            foreach ($lang_arr as $val) {
                $languages_arr[$val] = Config::$val['default_page'][$val];
            }
        } else {
            $languages_arr[Config::$val['default_lng']] = Config::$val['default_page'][$this->config->variable['default_lng']];
        }

        if ($this->module_info['no_record_table'] == 1) {
            $index_column_name = "id";
        } else {
            $index_column_name = "record_id";
        }

        $this->db->startTransaction();

        if ($data['isNew'] == 1) {

            if ($this->module_info['no_record_table'] == 1) {
                $record_id = $data['id'];
            } else {
                
                $sort_sorder = $this->getLastSortOrder($data['parent_id']) + 1;
                
                $this->db->insert($this->tables['record'])
                        ->values("sort_order=:sort_order, parent_id=:parent_id, module_id=:module_id, create_by_ip=:create_by_ip, create_by_admin=:create_by_admin, create_date=NOW()")
                        ->bind('sort_order', $sort_sorder)
                        ->bind('parent_id', $data['parent_id'])
                        ->bind('module_id', $this->module_info['id'])
                        ->bind('create_by_ip', $_SERVER['REMOTE_ADDR'])
                        ->bind('create_by_admin', $this->admin['id'])
                        ->query();
                $record_id = $this->db->last_insert_id();
            }
            if ($this->module_info['multilng'] == 1) {
                foreach ($languages_arr as $key => $val) {
                    $this->db->insert($this->table)
                            ->values("record_id=:record_id, lng=:lng")
                            ->bind('record_id', $record_id)
                            ->bind('lng', $key)
                            ->query();
                }
            } else {
                if ($this->module_info['no_record_table'] == 1) {
                    $this->db->insert($this->table)->values("id=0")->query();
                    $record_id = $this->db->last_insert_id();
                } else {
                    $sql = "INSERT INTO $this->table SET record_id=$record_id";
                    $this->db->insert($this->table)->values("record_id=:record_id")->bind('record_id', $record_id)->query();
                }
            }
        } else {

            $binds = $where = array();
            $binds['id'] = $data['id'];
            $where[] = "$index_column_name=:id";
            if ($this->module_info['multilng'] == 1) {
                $binds['lng'] = $this->language;
                $where[] = "lng=:lng";
            }

            $row = $this->db->select($this->table)
                    ->fields("id")
                    ->where($where)
                    ->bind($binds)
                    ->row_array();

            if (!empty($row)) {
                $data_ = $row;
            } elseif ($this->module_info['no_record_table'] != 1) {
                $binds = array();
                $binds['record_id'] = $data['id'];
                if ($this->module_info['multilng'] == 1) {
                    $binds['lng'] = $this->language;
                }
                $this->db->insert($this->table)
                        ->values("record_id=:record_id " . ($this->module_info['multilng'] == 1 ? ", lng=:lng" : ""))
                        ->bind($binds)
                        ->query();
                $data_['id'] = $this->db->last_insert_id();
            }
            $record_id = $data['id'];
        }

        $n = count($this->table_fields);

        $non_multilng_binds = $non_multilng_values = array();
        foreach ($languages_arr as $key => $val) {
            for ($i = 0, $binds = $values = array(); $i < $n; $i++) {

                if ($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) {
                    $file_name_temp = "{$this->module_info['table_name']}-{$this->table_fields[$i]['column_name']}-" . ($data['isNew'] == 1 ? "0" : $record_id);
                    $file_name_targ = "{$this->module_info['table_name']}-{$this->table_fields[$i]['column_name']}-$record_id";
                    $f_temp = glob(TEMPDIR . $file_name_temp . "*");
                    if (!empty($f_temp)) {
                        $tmp_file = $f_temp[0];
                        $path_parts = pathinfo($tmp_file);
                        $data[$this->table_fields[$i]['column_name']] = $file_name_targ . "." . $path_parts['extension'];
                        $target_file = UPLOADDIR . $data[$this->table_fields[$i]['column_name']];
                        copy($tmp_file, $target_file);
                        chmod($target_file, 0777);
                        unlink($tmp_file);
                    }
                }
                if (($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && (isset($data['delete_' . $this->table_fields[$i]['column_name']]))) {
                    $data[$this->table_fields[$i]['column_name']] = "";
                    unlink($target_file);
                }

                if ($this->table_fields[$i]['type'] == FRM_PASSWORD && $data[$this->table_fields[$i]['column_name']] == '') {
                    continue;
                }
                //$fields .= $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."', ";
                $binds[$this->table_fields[$i]['column_name']] = $data[$this->table_fields[$i]['column_name']];
                $values[] = $this->table_fields[$i]['column_name'] . "=:" . $this->table_fields[$i]['column_name'];

                if (($this->table_fields[$i]['type'] == FRM_SELECT || $this->table_fields[$i]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$i]['type'] == FRM_AUTOCOMPLETE || $this->table_fields[$i]['type'] == FRM_RADIO || $this->table_fields[$i]['type'] == FRM_CATEGORIES_TREE)) {
                    if($this->table_fields[$i]['list_values']['no_rel'] != 1 || $this->table_fields[$i]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$i]['list_values']['multiple']){
                        $this->saveRelations($this->table_relations, $record_id, $data[$this->table_fields[$i]['column_name']], $this->table_fields[$i]);
                    } 
                    if(is_array($data[$this->table_fields[$i]['column_name']])){
                        $data[$this->table_fields[$i]['column_name']] = implode("::", $data[$this->table_fields[$i]['column_name']]);
                    }
                }
                
                if($this->table_fields[$i]['type'] == FRM_LIST){
                    if($data['isNew'] == 1){
                        $frm_list_items = $this->registry->model->{$this->table_fields[$i]['list_values']['module']}->loadBy(array($this->table_fields[$i]['list_values']['column'] => 0, 'session_id' => session_id()));
                        foreach($frm_list_items as $frm_list_item){
                            $this->registry->model->{$this->table_fields[$i]['list_values']['module']}->updateField($frm_list_item['id'], $this->table_fields[$i]['list_values']['column'], $record_id);
                        }
                    }
                }

                if ($this->table_fields[$i]['multilng'] == 0 && $key == $data['language']) {
                    $non_multilng_binds[$this->table_fields[$i]['column_name']] = $data[$this->table_fields[$i]['column_name']];
                    $non_multilng_values[] = $this->table_fields[$i]['column_name'] . "=:" . $this->table_fields[$i]['column_name'];
                }
            }

            $this->registerLastEdit($record_id);

            if ($this->module_info['multilng'] == 1) {
                $row = $this->db->select($this->table)
                        ->where("record_id=:record_id AND lng=:lng")
                        ->bind('record_id', $record_id)
                        ->bind('lng', $key)
                        ->row_array();
                if (empty($row)) {
                    $this->db->insert($this->table)
                            ->values("record_id=:record_id, lng=:lng")
                            ->bind('record_id', $record_id)
                            ->bind('lng', $key)
                            ->query();
                }
            }

            $binds['record_id'] = $record_id;
            if ($this->module_info['multilng'] == 1) {
                $binds['lng'] = $key;
            }
            $this->db->update($this->table)
                    ->values($values)
                    ->where(($this->module_info['multilng'] == 1 ? "lng=:lng AND" : "") . " $index_column_name=:record_id")
                    ->bind($binds)
                    ->query();

            if ($this->module_info['multilng'] == 0 && $key == $data['language'])
                break;
        }

        if (!empty($non_multilng_binds)) {
            $this->db->update($this->table)
                    ->values($non_multilng_values)
                    ->where("$index_column_name=:record_id")
                    ->bind('record_id', $record_id)
                    ->bind($non_multilng_binds)
                    ->query();
        }

        // pazymima kad sioj kalboj irasas redaguotas
        $binds = $where = array();
        $where[] = "$index_column_name=:record_id";
        $binds['record_id'] = $record_id;
        if ($this->module_info['multilng'] == 1) {
            $binds['lng'] = $this->language;
            $where[] = "lng=:lng";
        }
        $this->db->update($this->table)
                ->values("lng_saved=1")
                ->where($where)
                ->bind($binds)
                ->query();

        if ($this->module_info['cache'] == 1) {
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }
        
        $this->generateCleanText4Search($record_id);

        $this->db->commitTransaction();

        return $record_id;
    }

    // import from csv
    function insertListItems($arr, $parent_id) {

        if ($this->loadAdminRights($this->admin['id'], $parent_id) != 1)
            return $parent_id;

        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {

            $new_item = true;
            $data = array();
            if (isset($arr[$i]['id']) && is_numeric($arr[$i]['id'])) {
                $item_data = $this->loadItem($arr[$i]['id'], $parent_id);
                $new_item = ($item_data['isNew'] == 1 ? true : false);
                $data = $item_data;
            }

            foreach ($arr[$i] as $key => $val) {

                if ($this->_table_fields[$key]['type'] == FRM_SELECT || $this->_table_fields[$key]['type'] == FRM_RADIO) {

                    $column_par = $this->_table_fields[$key]['list_values'];

                    if ($column_par['module']) {

                        $list_record_obj = $this->registry->model->create($column_par['module']);

                        if (isset($column_par['list_columns']) && $column_par['list_columns']['source'] == "DB") {
                            $_arr = explode(",", $column_par['list_columns']);
                            foreach ($_arr as $k => $v) {
                                $srt[] = " T.$v ";
                            }
                            $list_record_obj->sqlQueryWhere[] = " CONCAT(" . implode(",", $srt) . ")=:title_value ";
                        } else {
                            $list_record_obj->sqlQueryWhere[] = " T.title=:title_value ";
                        }
                        $list_record_obj->sqlQueryBinds['title_value'] = $val;

                        $list_record_obj->sqlQueryWhere[] = " R.parent_id=:parent_id ";
                        $list_record_obj->sqlQueryBinds['parent_id'] = $column_par['parent_id'];
                        $lst = $list_record_obj->listSearchItems();

                        if (isset($lst[0]['id']))
                            $data[$key] = $lst[0]['id'];
                    }else {
                        //$data[$key] = $this->db->escape($arr[$i][$key]);
                    }
                } elseif ($this->_table_fields[$key]['type'] == FRM_DATE) {

                    $data[$key] = str_replace(" ", "-", $arr[$i][$key]);
                } else {

                    $data[$key] = $arr[$i][$key];
                }
            }

            if ($new_item) {
                $data['isNew'] = 1;
                $data['parent_id'] = $parent_id;
                $data['language'] = $this->language;

                foreach (Config::$val['default_page'] as $key => $val) {
                    $lang_arr[] = $key;
                }
                $data['language_actions'] = implode("::", $lang_arr);
            } else {
                $data['isNew'] = 0;
                $data['id'] = $arr[$i]['id'];
                $data['parent_id'] = $parent_id;
                $data['language'] = $this->language;
            }
            $this->saveItem($data);
        }
    }

    // use in saveItem when field FRM_SELECT, FRM_CHECKBOX_GROUP, FRM_RADIO, FRM_CATEGORIES_TREE
    function saveRelations($table, $id, $data, $params) {

        $table = strlen($params['list_values']['relations_table']) > 0 ? $params['list_values']['relations_table'] : $table;
        $this->db->delete($table)
                ->where("item_id=:id AND column_name=:column_name")
                ->bind('id', $id)
                ->bind('column_name', $params['column_name'])
                ->query();
        if (!is_array($data))
            $arr = explode("::", $data);
        else
            $arr = $data;
        foreach ($arr as $val) {
            if (is_numeric($val)) {
                $row = $this->db->select($table)
                        ->fields("COUNT(*) AS cnt")
                        ->where("item_id=:id AND column_name=:column_name AND list_item_id=:list_item_id")
                        ->bind('id', $id)
                        ->bind('column_name', $params['column_name'])
                        ->bind('list_item_id', $val)
                        ->row_array();
                if ($row['cnt'] == 0) {
                    $this->db->insert($table)
                            ->values("item_id=:id, column_name=:column_name, list_item_id=:list_item_id")
                            ->bind('id', $id)
                            ->bind('column_name', $params['column_name'])
                            ->bind('list_item_id', $val)
                            ->query();
                }
            }
        }
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

    function listItems($category = 0) {

        $this->sqlQueryWhere[] = " R.parent_id=:category ";
        $this->sqlQueryBinds['category'] = $category;
        if ($this->module_info['no_record_table'] != 1)
            $this->sqlQueryOrder[] = " R.sort_order ";
        return $this->listSearchItems();
    }

    // 
    function getPath($id, $_data = array()) {
        if ($id != 0) {
            $n = count($this->table_fields);
            for ($i = 0, $fields = array(); $i < $n; $i++) {
                $fields[] = $this->table_fields[$i]['column_name'];
            }
            $row = $this->db->select("$this->table T")
                    ->fields($fields)
                    ->fields("R.id, R.parent_id, T.lng, T.lng_saved, 1 AS not_last")
                    ->joins("LEFT JOIN {$this->tables['record']} R ON (T.record_id=R.id)")
                    ->where("R.id=:id " . ($this->module_info['multilng'] == 1 ? " AND T.lng=:lng " : "") . "")
                    ->bind('id', $id)
                    ->bind('lng', $this->language)
                    ->row_array();
            $_data[] = $row;

            $this->getPath($row['parent_id'], $_data);
        } else {
            $_data = @array_reverse($_data);
            $this->path_arr = $_data;
            return $_data;
        }
    }

    // Remove item to trash 
    function delete($id) {

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
            return $id;

        if ($this->module_info['no_record_table'] == 1) {
            $this->deleteFromTrash($id);
        } else {
            $this->db->update($this->tables['record'])
                    ->values("trash=1")
                    ->where("id=:id")
                    ->bind('id', $id)
                    ->query();

            $this->registerLastEdit($id);
        }

        if ($this->module_info['cache'] == 1) {
            $sql = "UPDATE {} SET  WHERE ";
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }

        return $id;
    }

    function deleteLang($id, $lang_arr) {
        foreach ($lang_arr as $val) {
            $this->db->delete($this->table)
                    ->where("record_id=:record_id AND lng=:lng")
                    ->bind('record_id', $id)
                    ->bind('lng', $val)
                    ->query();
        }

        // Jei istrintos visos kalbos tai ir record lentelej reikia naikint irasa
        $arr = $this->db->select($this->table)
                ->where("record_id=:id")
                ->bind('id', $id)
                ->result_array();
        if (count($arr) == 0) {
            // i siukslyne ismest nebera prasmes, tai remove nafik visai 
            $this->deleteFromTrash($id);
        }
    }

    // Reset(back) item from trash
    function resetFromTrash($id) {

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
            return $id;

        $this->db->update($this->tables['record'])
                ->values("trash=0")
                ->where("id=:id")
                ->bind('id', $id)
                ->query();

        $this->registerLastEdit($id);

        if ($this->module_info['cache'] == 1) {
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }
    }

    // Delete item from DB
    function deleteFromTrash($id) {

        if ($id == 0)
            return $id;

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
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
                    $mod_obj = $this->registry->model->call($id_arr[$i]['module_id'], 'deleteFromTrash', array($id_arr[$i]['id']));
                } else {
                    $this->deleteFromTrash($id_arr[$i]['id']);
                }
            }

            $this->db->delete(Config::$val['sb_admin_module_rights'])
                    ->where("record_id=:id")
                    ->bind('id', $id)
                    ->query();
        }
    }

    // Register last editor
    function registerLastEdit($id) {

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
            return $id;

        if ($this->module_info['no_record_table'] == 1)
            return $id;

        $this->db->update($this->tables['record'])
                ->values("last_modif_by_ip=:last_modif_by_ip, last_modif_by_admin=:last_modif_by_admin, last_modif_date=NOW(), session_id=:session_id")
                ->where("id=:id")
                ->bind('id', $id)
                ->bind('last_modif_by_ip', $_SERVER['REMOTE_ADDR'])
                ->bind('last_modif_by_admin', $this->admin['id'])
                ->bind('session_id', session_id())
                ->query();
    }

    function changeFieldStatus($lng, $column, $id) {

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
            return $id;

        foreach ($this->table_fields as $key => $val) {
            if ($this->table_fields[$key]['column_name'] == $column) {
                $index = $key;
            }
        }
        if ($this->table_fields[$index]['multilng'] == 1) {
            $this->db->update($this->table)
                    ->values("$column=IF($column=1, 0, 1)")
                    ->where("record_id=:id " . ($this->module_info['multilng'] == 1 ? " AND lng=:lng " : "") . "")
                    ->bind('id', $id)
                    ->bind('lng', $lng)
                    ->query();
        } else {
            $this->db->update($this->table)
                    ->values("$column=IF($column=1, 0, 1)")
                    ->where("record_id=:id")
                    ->bind('id', $id)
                    ->query();
        }

        if ($this->module_info['cache'] == 1) {
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }

        $this->registerLastEdit($id);
    }

    function updateField($id, $field, $value) {

        if ($this->loadAdminRights($this->admin['id'], $id) != 1)
            return false;

        $where = $binds = array();
        if($this->module_info['no_record_table'] != 1){
            $where[] = "record_id=:id";
        }else{
            $where[] = "id=:id";
        }
        $binds['field'] = $value;
        $binds['id'] = $id;
        if ($this->module_info['multilng'] == 1 && $this->_table_fields[$field]['multilng'] == 1) {
            $where[] = "lng=:lng";
            $binds['lng'] = $this->language;
        }
        $this->db->update($this->table)
                ->values("$field=:field")
                ->where($where)
                ->bind($binds)
                ->query();

        $this->registerLastEdit($id);

        if ($this->module_info['cache'] == 1) {
            $this->db->update($this->tables['module'])
                    ->values("last_modify_time=NOW()")
                    ->where("id=:id")
                    ->bind('id', $this->module_info['id'])
                    ->query();
        }

        return true;
    }

    function img_delete($column, $id, $lng) {

        if (!is_numeric($id))
            return false;

        // patikrinama ar nera daugiau irasu kuriems yra priskirtas tas img
        $arr = $this->db->select($this->table)
                ->fields("{$column['column_name']} AS img")
                ->where("record_id=:id")
                ->bind('id', $id)
                ->result_array();

        if (count($arr) < 2 || $column['multilng'] == 0) {
            $row = $this->db->select($this->table)
                    ->fields("{$column['column_name']} AS img")
                    ->where("record_id=:id")
                    ->bind('id', $id)
                    ->row_array();

            // TODO: $this->img no longer available
            $this->img = new images();
            $this->img->resize_params = $column['image_extra'];
            $this->img->remove($row['img']);
        }
    }

    function checkDataExistInCategory($value, $column_name, $data) {

        $row = $this->db->query("{$this->tables['record']} R")
                ->fields("R.id")
                ->joins("LEFT JOIN $this->table T ON (T.record_id=R.id) ")
                ->where("R.id!=:id AND R.parent_id=:parent_id AND T.$column_name=:value AND R.trash!=1")
                ->bind('id', $data['id'])
                ->bind('parent_id', $data['parent_id'])
                ->bind('value', $value)
                ->row_array();
        if (empty($row))
            return 0;
        else
            return 1;
    }

    function checkDataExist($value, $column_name, $data) {
        if (isset($data['id']) && is_numeric($data['id'])) {
            $row = $this->db->select("$this->table T")
                    ->fields("R.id, R.trash")
                    ->joins("INNER JOIN {$this->tables['record']} R ON (R.id=T.record_id) ")
                    ->where("T.$column_name=:value AND T.record_id!=:record_id")
                    ->bind('value', $value)
                    ->bind('record_id', $data['id'])
                    ->row_array();
            if (empty($row)) {
                return true;
            } else {
                if ($row['trash'] == 1) {
                    // 
                    $this->deleteFromTrash($row['id']);
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    function getCountSearchItems() {
        $column_result = array();
        foreach ($this->table_fields as $i => $val) {
            if ($val['column_result'] != "")
                $column_result[] = " {$val['column_result']}(T.{$val['column_name']}) AS {$val['column_name']}_result ";
        }
        if ($this->module_info['no_record_table'] != 1) {

            $where = array();
            $where[] = "R.trash!=1";
            $binds = $this->sqlQueryBinds;
            if ($this->module_info['multilng'] == 1) {
                $where[] = "T.lng=:lng";
                $binds['lng'] = $this->language;
            }
            if ($this->viewAllItems != 1) {
                $where[] = "T.active=1";
            }

            $row = $this->db->select("$this->table T")
                    ->fields("COUNT(DISTINCT R.id) as _COUNT_")
                    ->fields($column_result)
                    ->joins("LEFT JOIN {$this->tables['record']} R ON (R.id=T.record_id " . ($this->module_info['multilng'] == 1 ? "AND T.lng=:lng" : "") . ")")
                    ->joins($this->sqlQueryJoins)
                    ->where($where)
                    ->where($this->sqlQueryWhere)
                    ->bind($binds)
                    ->row_array();
        } else {

            $where = array();
            $binds = $this->sqlQueryBinds;
            if ($this->module_info['multilng'] == 1) {
                $where[] = "T.lng=:lng";
                $binds['lng'] = $this->language;
            }
            if ($this->viewAllItems != 1) {
                $where[] = "T.active=1";
            }
            $row = $this->db->select("$this->table T")
                    ->fields("COUNT(DISTINCT T.id) as _COUNT_")
                    ->fields($column_result)
                    ->joins($this->sqlQueryJoins)
                    ->where($where)
                    ->where($this->sqlQueryWhere)
                    ->bind($binds)
                    ->row_array();
        }
        return $row;
    }

    function listSearchItems() {

        benchmark::mark('', 'listSearchItems ' . $this->module_info['table_name']);

        $n = count($this->table_fields);

        for ($i = 0, $fields = array(); $i < $n; $i++) {
            if ($this->table_fields[$i]['column_name'])
                $fields[] = "T." . $this->table_fields[$i]['column_name'];
        }

        if ($this->module_info['no_record_table'] != 1) {

            $where = array();
            $where[] = "R.trash!=1";
            $binds = $this->sqlQueryBinds;
            if ($this->module_info['multilng'] == 1) {
                $where[] = "T.lng=:lng";
                $binds['lng'] = $this->language;
            }
            if ($this->viewAllItems != 1) {
                $where[] = "T.active=1";
            }

            $arr = $this->db->select("{$this->tables['record']} R")
                    ->fields($this->sqlQueryFields)
                    ->fields($fields)
                    ->fields("R.id, R.parent_id, R.sort_order, R.module_id, T.active, R.is_category, R.create_date, R.last_modif_date, T.lng, T.lng_saved, 1 AS editorship")
                    ->joins("INNER JOIN $this->table T ON (R.id=T.record_id " . ($this->module_info['multilng'] == 1 ? "AND T.lng='$this->language'" : "") . ")")
                    ->joins($this->sqlQueryJoins)
                    ->where($where)
                    ->where($this->sqlQueryWhere)
                    ->group($this->sqlQueryGroup)
                    ->order($this->sqlQueryOrder)
                    ->limit($this->sqlQueryLimit['start'], $this->sqlQueryLimit['paging'])
                    ->bind($binds)
                    ->result_array();
        } else {

            $where = array();
            $binds = $this->sqlQueryBinds;
            if ($this->module_info['multilng'] == 1) {
                $where[] = "T.lng=:lng";
                $binds['lng'] = $this->language;
            }
            if ($this->viewAllItems != 1) {
                $where[] = "T.active=1";
            }

            $arr = $this->db->select("$this->table T")
                    ->fields($this->sqlQueryFields)
                    ->fields($fields)
                    ->fields("T.id AS id, T.active, T.lng, T.lng_saved, 1 AS editorship")
                    ->joins($this->sqlQueryJoins)
                    ->where(($this->viewAllItems == 1 ? "" : "T.active=1"))
                    ->where($where)
                    ->where($this->sqlQueryWhere)
                    ->group($this->sqlQueryGroup)
                    ->order($this->sqlQueryOrder)
                    ->limit($this->sqlQueryLimit['start'], $this->sqlQueryLimit['paging'])
                    ->bind($binds)
                    ->result_array();
        }

        $m = count($arr);
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                
                if($this->table_fields[$j]['list_values']['no_load'] == '1'){
                    // nieko nereikia keisti
                    continue;
                }
                
                if($this->table_fields[$j]['list_values']['no_rel'] != 1){
                    $relations_list = array();
                    if ($this->table_fields[$j]['list_values']['source'] == 'DB') {
                        $relations_list = $this->getRelations(Config::$val['sb_relations'], $arr[$i]['id'], $this->table_fields[$j], $this->language);
                        $c = count($relations_list);
                        $value = "";
                        $ids = "";
                        for ($k = 0; $k < $c; $k++) {
                            $ids .= $k != 0 ? "::" : "";
                            $value .= $k != 0 ? "; " : "";
                            $value .= $relations_list[$k]['title'];
                            $ids .= $relations_list[$k]['value'];
                        }
                        $arr[$i][$this->table_fields[$j]['column_name']] = $value;
                        $arr[$i][$this->table_fields[$j]['column_name'] . '_ids'] = $ids;
                        $arr[$i][$this->table_fields[$j]['column_name'] . '_arr'] = $relations_list[$k];
                    }
                }else{
                    $module_name = $this->table_fields[$j]['list_values']['module'];
                    $rel_data = $this->registry->model->{$module_name}->loadItem($arr[$i][$this->table_fields[$j]['column_name']]);
                    $arr[$i][$this->table_fields[$j]['column_name'] . "_ids"] = $rel_data['id'];
                    $arr[$i][$this->table_fields[$j]['column_name'] . "_arr"] = array($rel_data);
                    $arr[$i][$this->table_fields[$j]['column_name']] = $rel_data['title'];
                }
                if ($this->table_fields[$j]['elm_type'] == FRM_TEXTAREA) {
                    $arr[$i][$this->table_fields[$j]['column_name']] = nl2br($arr[$i][$this->table_fields[$j]['column_name']]);
                }
            }
        }

        $this->reset_sql_query();

        benchmark::mark('', $sql);

        return $arr;
    }

    function reset_sql_query() {
        $this->sqlQueryJoins = array();
        $this->sqlQueryFields = array();
        $this->sqlQueryBinds = array();
        $this->sqlQueryWhere = array();
        $this->sqlQueryOrder = array();
        $this->sqlQueryLimit = array();
    }

    function listAutocompleteValues($ids) {
        $arr = explode("::", $ids);
        $n = array();
        foreach ($arr as $val) {
            if (is_numeric($val))
                $n[] = " T.record_id=$val ";
        }
        if (count($n) > 0) {
            $this->sqlQueryWhere[] = "(" . implode(" OR ", $n) . ") ";
            return $this->listSearchItems();
        }
        return array();
    }

    function get_autocomplete_list($field, $code, $limit, $left = true, $right = true) {
        $code = addcslashes($code, "\\'");
        $fields = explode(",", $field);
        $arr = array();
        foreach ($fields as $val) {
            $arr[] = "T.$val LIKE '" . ($left ? "%" : "") . "$code" . ($right ? "%" : "") . "'";
        }
        $this->sqlQueryWhere[] = "(" . implode(" OR ", $arr) . ")";
        if (is_numeric($limit))
            $this->sqlQueryLimit = array('start' => 0, 'paging' => $limit);
        $list = $this->listSearchItems();

        foreach ($list as $val) {
            $list_[] = "{$val['title']} ---{$val['id']}";
        }

        return $list_;
    }

}

?>
