<?php

include_once (CLASSDIR . 'basic.class.php');

class controller extends basic {

    protected $mod;
    
    protected $something_after_success_action = '';

    protected $default_grid_data = array();
    
    function __construct($module) {

        parent::__construct();

        benchmark::mark('construct_controller', 'Controller objectas ' . $module);
        $this->mod = $this->registry->model->$module;
        $this->actions = $this->registry->actions->$module;
        // Module language
        $this->language = $_SESSION['site_lng'];
    }

    function _default() {
        return $this->listing(($this->get['cid'] ? $this->get['cid'] : 0));
    }
    
    function listing($parent_id = 0) {

        benchmark::mark('start_listing', 'Listingo pradzia');

        if($this->get['change_order']) $this->mod->changeOrder($this->get['firstid'], $this->get['lastid']);
        
        $this->mod->listingActions();
        $this->mod->filterListing();

        include_once(APP_CLASSDIR . "listing.class.php");
        $listing_obj = new listing($this->mod->module_info['table_name']);

        foreach($this->default_grid_data as $key => $val){
            $listing_obj->set($key, $val);
        }
        
        $listing_obj->setFilters($_SESSION['filters'][$this->mod->module_info['table_name']]);
        
        $listing_obj->setColumns($this->mod->table_list);

        $this->mod->prepareListing($listing_obj->columns);
        if($this->get['column'] && $this->get['cid']){
            if($this->get['cid'] == 'TEMP'){
                $this->mod->setFilterValues(array($this->get['column'] => 0));
                $this->mod->sqlQueryWhere['session_id'] = "R.session_id = :session_id ";
                $this->mod->sqlQueryBinds['session_id'] = session_id();
            }else{
                $this->mod->setFilterValues(array($this->get['column'] => $this->get['cid']));
            }
        }
        $sum_data = $this->mod->getListingSum($parent_id);
        $list_items = $this->addContextToList($this->mod->getListingItems($parent_id));
        //return "<pre>" . print_r($list_items, true) . "</pre>";

        $listing_obj->setItemsData($sum_data);
        $listing_obj->setItems($list_items);
        $listing_obj->paging($this->get['offset']);
        $listing_obj->pagingSelect();

        benchmark::mark('end_listing', 'Listingo pabaiga');

        $area = $this->get['area'];
        
        $listing_obj->set('base_url', 'module=' . $this->get['module'] . '&method=' . $this->get['method'] . '&area=' . $this->get['area'] . '&cid=' . $this->get['cid'] . ($this->get['column'] ? '&column=' . $this->get['column'] : '') . ($this->get['no_tree_reload'] ? '&no_tree_reload=1' : ''));
        
        return array(($area ? $area : 'content') => $listing_obj->generate());
    }

    function addContextToList($list) {

        $n = count($list);
        for ($i = 0; $i < $n; $i++) {

            $CONTENT = ($this->mod->module_info['catalog'] == 1 ? 'catalog' : $this->mod->module_info['table_name']);
            $list[$i]['main_action'] = "main.php?content=$CONTENT&module={$this->mod->module_info['table_name']}&page=list&id={$list[$i]['id']}";
            $list[$i]['action'] = "main.php?content=$CONTENT&module={$this->mod->module_info['table_name']}&page=list&id={$list[$i]['id']}#edit";

            if ($list[$i]['title']) {
                $list[$i]['title_short'] = mb_substr($list[$i]['title'], 0, 30, "UTF-8");
            }

            $list[$i]['context'] = $this->actions->getContextMenu($list[$i]);
            if (!isset($list[$i]['parent_id']))
                $list[$i]['parent_id'] = 0;
        }

        return $list;
    }

    function add_edit_form_save_languages($id) {
        // checkboxai pazymeti kuriose kalbose reik atlikt save'a
        $lang_saved_arr = $this->mod->getItemLangStatus($id);
        foreach (Config::$val['default_page'] as $key => $val) {
            if ($key != $this->language) {
                $lang_val[] = array(
                    'title' => strtoupper($key),
                    'value' => $key,
                    'selected' => (!empty($_POST) ? in_array($key, $_POST['language_actions']) : $lang_saved_arr[$key]['selected']),
                    'readonly' => $lang_saved_arr[$key]['disabled']
                );
            }
        }
        $fields["language_actions"] = array(
            'type' => FRM_CHECKBOX_GROUP,
            'title' => cms::$phrases['main']['catalog']['language_action_with_item'],
            'list_values' => $lang_val
        );
        return array_merge($fields, $this->mod->_table_fields);
    }

    // Start actions

    /**
     * 
     * Display new item form
     */
    function new_item($default_data = array(), $show_actions = true) {
        $id = 0;

        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=new_item&id=$id', $('#{$mod['id']}')));";

        $mod['hiddens']['id'] = 0;
        $mod['hiddens']['isNew'] = 1;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = ($this->get['id'] ? $this->get['id'] : 0);
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->mod->_table_fields;
        if ($mod['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields = $this->add_edit_form_save_languages($id);
            // cia jeigu custom form template reikia pridet kalbu checkboxus
            if ($mod['form_tpl'])
                $mod['form_tpl'] = "{tpl.language_actions}" . $mod['form_tpl'];
        }
        if (!empty($default_data)) {
            foreach ($default_data as $column => $value) {
                if ($fields[$column])
                    $fields[$column]['default_value'] = $value;
            }
        }
        
        // delete temporary FRM_LIST items
        if(empty($_POST)){
            foreach($fields as $fld){
                if($fld['type'] == FRM_LIST){
                    $frm_list_items = $this->registry->model->{$fld['list_values']['module']}->loadBy(array($fld['list_values']['column'] => 0, 'session_id' => session_id()));
                    foreach($frm_list_items as $frm_list_item){
                        $this->registry->model->{$fld['list_values']['module']}->delete($frm_list_item['id']);
                    }
                }
            }
        }
        
        $form_content = $this->editForm($mod, $fields, $default_data);

        $this->get['method'] = 'new_item';
        
        return ($show_actions ? $this->actions($id) : "") . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
    }
    
    function create_from(){
        $default_data = $_SESSION['create_from'][$this->mod->module_info['table_name']];
        unset($_SESSION['create_from'][$this->mod->module_info['table_name']]);
        return $this->new_item($default_data);
    }
    
    function create_from_listing($default_data = array()){
        $id = 0;

        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=create_from_listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&id=0&no_tree_reload=1&json=1', $('#{$mod['id']}')));";

        $mod['hiddens']['id'] = 0;
        $mod['hiddens']['isNew'] = 1;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = ($this->get['id'] ? $this->get['id'] : 0);
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->mod->_table_fields;
        if ($mod['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields = $this->add_edit_form_save_languages($id);
            // cia jeigu custom form template reikia pridet kalbu checkboxus
            if ($mod['form_tpl'])
                $mod['form_tpl'] = "{tpl.language_actions}" . $mod['form_tpl'];
        }
        $default_data[$this->get['column']] = $this->get['cid'];
        if (!empty($default_data)) {
            foreach ($default_data as $column => $value) {
                if ($fields[$column])
                    $fields[$column]['default_value'] = $value;
            }
        }
        $this->something_after_success_action = 'create_from_listing';
        $form_content = $this->editForm($mod, $fields, $default_data);
        $this->something_after_success_action = '';

        $this->get['method'] = 'new_item';
        
        if($this->get['json']){
            return array('_WINDOW_content_' . $mod['table_name'] . '_' . $this->get['column'] . '_' . $this->get['cid']  => "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        }
        
    }
    
    function create_from_autocomplete($default_data = array()){
        $id = 0;

        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=create_from_autocomplete&column={$this->get['column']}&multiple={$this->get['multiple']}&id=0&no_tree_reload=1&json=1', $('#{$mod['id']}')));";

        $mod['hiddens']['id'] = 0;
        $mod['hiddens']['isNew'] = 1;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = ($this->get['id'] ? $this->get['id'] : 0);
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->mod->_table_fields;
        if ($mod['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields = $this->add_edit_form_save_languages($id);
            // cia jeigu custom form template reikia pridet kalbu checkboxus
            if ($mod['form_tpl'])
                $mod['form_tpl'] = "{tpl.language_actions}" . $mod['form_tpl'];
        }
        $default_data[$this->get['column']] = $this->get['cid'];
        if (!empty($default_data)) {
            foreach ($default_data as $column => $value) {
                if ($fields[$column])
                    $fields[$column]['default_value'] = $value;
            }
        }
        $this->something_after_success_action = 'create_from_autocomplete';
        $form_content = $this->editForm($mod, $fields, $default_data);
        $this->something_after_success_action = '';

        $this->get['method'] = 'new_item';
        
        if($this->get['json']){
            return array('_WINDOW_content_' . $mod['table_name'] . '_' . $this->get['column'] . '_' . $this->get['cid']  => "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        }        
    }
    
    function copy_from_listing(){
        
        $id = $this->get['id'];
        
        $default_data = $this->mod->loadItem($id);
        $default_data['id'] = 0;
        $this->get['id'] = $default_data['parent_id'];
        
        return $this->create_from_listing($default_data);
        
    }

    function edit_from_listing(){
        $id = $this->get['id'];
        //return $this->actions($id)."<div id='action_area_$id' class='action_area'>".$this->editItemForm($id)."</div>";

        $data = $this->mod->loadItem($id);
        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=edit_from_listing&id={$this->get['id']}&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1&json=1', $('#{$mod['id']}')));";

        $mod['hiddens']['id'] = $id;
        $mod['hiddens']['isNew'] = 0;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = ($parent_id ? $parent_id : $data['parent_id']);
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->mod->_table_fields;
        if ($mod['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields = $this->add_edit_form_save_languages($id);
            // cia jeigu custom form template reikia pridet kalbu checkboxus
            if ($mod['form_tpl'])
                $mod['form_tpl'] = "{tpl.language_actions}" . $mod['form_tpl'];
        }

        $this->something_after_success_action = 'edit_from_listing';
        $form_content = $this->editForm($mod, $fields, $data);
        $this->something_after_success_action = '';

        $this->get['method'] = 'edit';
        
        if($this->get['json']){
            return array('_WINDOW_content_' . $mod['table_name'] . '_' . $this->get['column'] . '_' . $this->get['cid']  => "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        }
    }
    
    function info_from_listing(){
        return $this->info(false);
    }
    
    function copy($show_actions){
        
        $id = $this->get['id'];
        
        $default_data = $this->mod->loadItem($id);
        $default_data['id'] = 0;
        $this->get['id'] = $default_data['parent_id'];
        
        $return = $this->new_item($default_data, $show_actions);
        
        // copy temporary FRM_LIST items
        if(empty($_POST)){
            $fields = $this->mod->table_fields;
            foreach($fields as $fld){
                if($fld['type'] == FRM_LIST){
                    $frm_list_items = $this->registry->model->{$fld['list_values']['module']}->loadBy(array($fld['list_values']['column'] => $id));
                    foreach($frm_list_items as $frm_list_item){
                        $frm_list_item[$fld['list_values']['column']] = 0;
                        $listing_module_fields = $this->registry->model->{$fld['list_values']['module']}->table_fields;
                        foreach($listing_module_fields as $listing_module_field){
                            if($listing_module_field['type'] == FRM_IMAGE){
                                $file_name_temp = "{$fld['list_values']['module']}-{$listing_module_field['column_name']}-0";
                                $file_pathinfo = pathinfo(UPLOADDIR . $frm_list_item[$listing_module_field['column_name']]);
                                copy(UPLOADDIR . $frm_list_item[$listing_module_field['column_name']], TEMPDIR . $file_name_temp . "." . $file_pathinfo['extension']);
                            }
                        }
                        $this->registry->model->{$fld['list_values']['module']}->insert($frm_list_item);
                    }
                }
            }
        }
        
        return $return;
    }
    
    function info($show_actions = true){
        
        $id = $this->get['id'];

        $data = $this->mod->loadItem($id);
        
        $data['create_by_admin'] = $this->mod->loadItemAuthor($data['create_by_admin']);
        $data['last_modif_by_admin'] = $this->mod->loadItemAuthor($data['last_modif_by_admin']);
        
        $data['module_info'] = $this->mod->module_info;
        
        $lang_saved_arr = $this->mod->getItemLangStatus($id);
        TPL::setVar('item_lng_status', $lang_saved_arr);
        
        TPL::setVar('info_extra', array());
        
        TPL::setVar('info', $data);
        $content = TPL::parse(TPLDIR . "blocks/info.tpl");
        
        return ($show_actions ? $this->actions($id) : "") . "<div id='action_area_$id' class='action_area'>" . $content . "</div>";
    }
    
    function note($show_actions = true){
        
        $id = $this->get['id'];

        $data = $this->mod->loadItem($id);
        
        if($_POST['action'] && $_POST['action'] == 'note'){
            $note_data = array();
            $note_data['note'] = htmlspecialchars($_POST['note']);
            $note_data['item_id'] = $id;
            $note_data['active'] = 1;
            $note_data['author_id'] = $_SESSION['admin']['id'];
            $note_data['comment_date'] = date("Y-m-d H:i:s");
            $this->registry->model->notes->insert($note_data);
        }
        
        $notes = $this->registry->model->notes->loadBy(array('item_id' => $id));
        foreach($notes as $i => $note){
            $notes[$i]['text'] = nl2br($note['note']);
            $author_data = $this->registry->model->admins->loadItem($note['author_id']);
            $notes[$i]['author'] = $author_data['title'];
        }
        
        TPL::setVar('notes', $notes);
        TPL::setVar('item', $data);
        
        TPL::setVar('module_info', $this->mod->module_info);
        $content = TPL::parse(TPLDIR . "blocks/notes.tpl");
        
        return ($show_actions ? $this->actions($id) : "") . "<div id='action_area_$id' class='action_area'>" . $content . "</div>";
    }

    
    /**
     * 
     * Display item edit form
     */
    function edit($show_actions = true) {

        $id = $this->get['id'];
        //return $this->actions($id)."<div id='action_area_$id' class='action_area'>".$this->editItemForm($id)."</div>";

        $data = $this->mod->loadItem($id);
        $mod = $this->mod->module_info;

        $mod['name'] = 'save';
        $mod['id'] = '_FORM_' . $mod['table_name'] . '_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=edit&id=$id', $('#{$mod['id']}')));";
        $mod['redirect'] = "admin.php?module={$mod['table_name']}&method=edit&id=$id&ajax=1&form_success=1";

        $mod['hiddens']['id'] = $id;
        $mod['hiddens']['isNew'] = ($id ? 0 : 1);
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['parent_id'] = ($parent_id ? $parent_id : $data['parent_id']);
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $fields = $this->mod->_table_fields;
        if ($mod['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields = $this->add_edit_form_save_languages($id);
            // cia jeigu custom form template reikia pridet kalbu checkboxus
            if ($mod['form_tpl'])
                $mod['form_tpl'] = "{tpl.language_actions}" . $mod['form_tpl'];
        }

        $form_content = $this->editForm($mod, $fields, $data);

        return ($show_actions ? $this->actions($id) : "") . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
    }

    function editForm($mod, $fields, $data) {

        $form_obj = new Form($mod, $fields, $data);

        // set action to save data to current controller -> model -> table_name -> _FOR_database
        $form_obj->set('target', 'database');

        $form_obj->set('form_error_message', cms::$phrases['main']['common']['form_validation_error']);
        $form_obj->set('form_success_message', cms::$phrases['main']['common']['form_saved_success']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['main']['form']['submit']);

        $form_content = $form_obj->process($this->post) . $this->something_after_success_submit($form_obj->return_val());

        return $form_content;
    }

    /**
     * if successfuly form submited then add to form html something like <scripts>
     * @param unknown_type $return_val
     */
    function something_after_success_submit($return_val) {
        if (isset($return_val)) {
            switch($this->something_after_success_action){
                case 'edit_from_listing':
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .formElementsField, #_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .submit_block').hide(); " .
                            "\$NAV.get('?module={$this->get['module']}&method=listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1');" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}_{$this->get['column']}_{$this->get['cid']}'); }, 2000); " .
                            "</script>";
                    break;
                case 'create_from_listing':
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']} .formElementsField, #_WINDOW_content_{$this->get['module']} .submit_block').hide(); " .
                            "\$NAV.get('?module={$this->get['module']}&method=listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1');" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}'); }, 2000); " .
                            "</script>";
                    break;
                case 'create_from_autocomplete':
                    $item_data = $this->mod->loadItem($return_val);
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']} .formElementsField, #_WINDOW_content_{$this->get['module']} .submit_block').hide(); " .
                            ($this->get['multiple'] ? "" : "eFORM.clear_autocomplete_value('{$this->get['column']}');") .
                            "eFORM.add_autocomplete_value('{$this->get['column']}', { 'value':$return_val, 'label':'{$item_data['title']}' } );" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}'); }, 2000); " .
                            "</script>";
                    break;
                default:
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            " \$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'edit', '$return_val'); " .
                            "</script>";
            }
        }
    }

    /**
     * if successfuly form submited then add to form html something like <scripts>
     * @param unknown_type $return_val
     */
    function something_after_success_delete($return_val) {
        if($return_val){
            switch($this->something_after_success_action){
                case 'delete_from_listing':
                    return "<script>" .
                            "\$NAV.is_not_saved = false; " .
                            "\$('#_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .formElementsField, #_WINDOW_content_{$this->get['module']}_{$this->get['column']}_{$this->get['cid']} .submit_block').hide(); " .
                            "\$NAV.get('?module={$this->get['module']}&method=listing&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1');" . 
                            "setTimeout(function(){ \$NAV.close_dialog('{$this->get['module']}_{$this->get['column']}_{$this->get['cid']}'); }, 2000); " .
                            "</script>";
                    break;
                default:
                    return "<p class=\"msg formsuccess\">" . cms::$phrases['main']['catalog']['delete_done'] . "</p><script> \$NAV.is_not_saved = false; </script>";
            }
        }
    }

    function delete($show_actions = true) {

        $id = $this->get['id'];

        $data = $this->mod->loadItem($id);
        //$mod = $this->mod->module_info;

        $mod['table_name'] = $this->mod->module_info['table_name'];
        $mod['name'] = 'delete';
        $mod['target'] = 'delete';
        $mod['id'] = '_FORM_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post('?module={$mod['table_name']}&method=delete&id=$id', $('#{$mod['id']}')));";

        $fields = array();
        $fields['delete_all'] = array(
            'type' => FRM_CHECKBOX,
            'title' => cms::$phrases['main']['catalog']['language_delete_all'],
            'value' => 1,
            'checked' => 1,
            'editorship' => 1,
            'field_extra_params' => " onclick=\"javascript: var i=1; if(this.checked==true) while(document.getElementById('ELMID_language_actions_'+i)) document.getElementById('ELMID_language_actions_'+i++).checked=true; \""
        );

        if ($this->mod->module_info['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields['language_actions'] = array(
                'type' => FRM_CHECKBOX_GROUP,
                'title' => cms::$phrases['main']['catalog']['language_delete_item'],
                'list_values' => array('source' => 'DB', 'module' => $mod['table_name'], 'method' => 'get_lngs_for_delete', 'parent_id' => $id),
                'field_extra_params' => "onclick=\"javascript: if(this.checked!=true) $('#ELMID_delete_all').attr('checked',false);\" ",
                'editorship' => 1
            );
        }

        $mod['hiddens']['id'] = $id;

        $form_obj = new Form($mod, $fields, $data);

        $form_obj->set('form_success_message', cms::$phrases['main']['catalog']['delete_done']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['main']['catalog']['confirm_delete_yes']);

        $form_content = $form_obj->process($this->post);
        if($form_obj->return_val()){
            $html = $this->something_after_success_delete($form_obj->return_val());
            $show_actions = false;
        }else{
            $html = $form_content . $this->something_after_success_delete($form_obj->return_val());
        }

        return ($show_actions ? $this->actions($id) : "") . "<div id='action_area_$id' class='action_area'>" . $html . "</div>";
    }
    
    function delete_from_listing(){
        
        $id = $this->get['id'];

        $data = $this->mod->loadItem($id);
        //$mod = $this->mod->module_info;

        $mod['table_name'] = $this->mod->module_info['table_name'];
        $mod['name'] = 'delete';
        $mod['target'] = 'delete';
        $mod['id'] = '_FORM_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post('?module={$mod['table_name']}&method=delete_from_listing&id={$id}&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1&json=1', $('#{$mod['id']}')));";

        $fields = array();
        $fields['delete_all'] = array(
            'type' => FRM_CHECKBOX,
            'title' => cms::$phrases['main']['catalog']['language_delete_all'],
            'value' => 1,
            'checked' => 1,
            'editorship' => 1,
            'field_extra_params' => " onclick=\"javascript: var i=1; if(this.checked==true) while(document.getElementById('ELMID_{$mod['id']}_language_actions_'+i)) document.getElementById('ELMID_{$mod['id']}_language_actions_'+i++).checked=true; \""
        );

        if ($this->mod->module_info['multilng'] == 1 && count(Config::$val['default_page']) > 1) {
            $fields['language_actions'] = array(
                'type' => FRM_CHECKBOX_GROUP,
                'title' => cms::$phrases['main']['catalog']['language_delete_item'],
                'list_values' => array('source' => 'DB', 'module' => $mod['table_name'], 'method' => 'get_lngs_for_delete', 'parent_id' => $id),
                'field_extra_params' => "onclick=\"javascript: if(this.checked!=true) $('#ELMID_{$mod['id']}_delete_all').attr('checked',false);\" ",
                'editorship' => 1
            );
        }

        $mod['hiddens']['id'] = $id;

        $form_obj = new Form($mod, $fields, $data);

        $form_obj->set('form_success_message', cms::$phrases['main']['catalog']['delete_done']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['main']['catalog']['confirm_delete_yes']);

        $this->something_after_success_action = 'delete_from_listing';
        $html = $form_obj->process($this->post) . $this->something_after_success_delete($form_obj->return_val());
        $this->something_after_success_action = '';
        
        $this->get['method'] = 'delete';
        
        if($this->get['json']){
            return array('_WINDOW_content_' . $mod['table_name'] . '_' . $this->get['column'] . '_' . $this->get['cid']  => "<div id='action_area_$id' class='action_area'>" . $html . "</div>");
        }else{
            return "<div id='action_area_$id' class='action_area'>" . $html . "</div>";
        }
        
    }

    function pdf() {

        $id = $this->get['id'];
        $data = $this->mod->loadItem($id);
    }

    /**
     * Module settings
     */
    function settings() {

        $id = 0;
        $mod = $this->mod->module_info;
        $mod['form_tpl'] = '';
        $mod['name'] = 'save';
        $mod['id'] = '_FORM_settings';
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=settings', $('#{$mod['id']}')));";

        $mod['hiddens']['id'] = 0;
        $mod['hiddens']['isNew'] = 0;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $data = $fields = array();
        foreach ($this->mod->module_info['xml_settings'] as $key => $val) {
            $val['title'] = $val['title_' . $_SESSION['admin_interface_language']];
            $val['editable'] = 1;
            $val['column_name'] = $key;
            $val['method'] = "show_image_settings";
            $fields[$key] = $val;
            if ($val['type'] == FRM_CHECKBOX_GROUP || $val['type'] == FRM_SELECT) {
                $val['value'] = explode("::", $val['value']);
            }
            if ($val['type'] == FRM_TEXTAREA) {
                $val['value'] = str_replace("{!{CDATA{", "<![CDATA[", $val['value']);
                $val['value'] = str_replace("}!}CDATA}", "]]>", $val['value']);
            }
            $data[$key] = $val['value'];
        }

        $form_obj = new Form($mod, $fields, $data);

        // set action to save data to current controller -> model -> table_name -> _FOR_database
        $form_obj->set('target', 'settings');

        $form_obj->set('form_error_message', cms::$phrases['main']['common']['form_validation_error']);
        $form_obj->set('form_success_message', cms::$phrases['main']['common']['form_saved_success']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['main']['form']['submit']);

        $form_content = $form_obj->process($this->post) . $this->something_after_success_submit($form_obj->return_val());

        return $this->actions($id) . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
    }

    /**
     * Module export
     */
    function export() {

        $id = 0;
        $mod = $this->mod->module_info;
        $mod['form_tpl'] = '';
        $mod['name'] = 'save';
        $mod['id'] = '_FORM_export';
        $mod['action'] = "?module={$mod['table_name']}&method=export";

        $mod['hiddens']['id'] = 0;
        $mod['hiddens']['isNew'] = 1;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];

        $module_columns = $data = $fields = array();
        foreach ($this->mod->_table_fields as $val) {
            $module_columns[] = array('id' => $val['column_name'], 'title' => $val['title'], 'selected' => true);
        }
        $fields['add_header'] = array(
            'title' => cms::$phrases['main']['common']['form_export_add_header_title'],
            'editable' => true,
            'column_name' => 'add_header',
            'required' => false,
            'default_value' => 1,
            'type' => FRM_CHECKBOX
        );
        $fields['type'] = array(
            'title' => cms::$phrases['main']['common']['form_export_type_title'],
            'editable' => true,
            'column_name' => 'type',
            'required' => true,
            'type' => FRM_RADIO,
            'default_value' => 'excel',
            'list_values' => array(
                array('id' => 'csv', 'title' => 'CSV'),
                array('id' => 'excel', 'title' => 'Excel'),
                //array('id' => 'xml', 'title' => 'XML'),
                array('id' => 'json', 'title' => 'JSON')
            )
        );
        $fields['fields'] = array(
            'title' => cms::$phrases['main']['common']['form_export_fields_title'],
            'editable' => true,
            'column_name' => 'type',
            'required' => true,
            'type' => FRM_CHECKBOX_GROUP,
            'list_values' => $module_columns
        );

        $form_obj = new Form($mod, $fields, $data);

        // set action to save data to current controller -> model -> table_name -> _FOR_database
        $form_obj->set('target', 'export');

        $form_obj->set('form_error_message', cms::$phrases['main']['common']['form_validation_error']);
        $form_obj->set('form_success_message', cms::$phrases['main']['common']['form_saved_success']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['modules']['context_menu']['export_title']);

        $form_content = $form_obj->process($this->post) . $this->something_after_success_submit($form_obj->return_val());

        return $this->actions($id) . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
    }

    // End actions

    function actions($id) {
        //if($id==0) return "";
        $actions = $this->actions->listItems($id);
        foreach ($actions as $key => $val) {
            $actions[$key]['action'] = preg_replace("/{id}/", $id, $actions[$key]['action']);
            $actions[$key]['active'] = ($this->get['method'] == $val['name'] ? 1 : 0);
        }
        TPL::setVar('id', $id);
        TPL::setVar('actions', $actions);
        return TPL::parse(TPLDIR . "blocks/actions.tpl");
    }

    function change_field() {

        $id = $this->post['id'];
        $column = $this->post['column'];
        $value = $this->post['value'];
        $json = new stdClass();

        $data = array();
        $data[$column] = $value;
        $data['id'] = $id;
        $data['language'] = $this->language;

        $elm_obj = Form::createElement($column, $this->mod->_table_fields[$column]);
        if ($elm_obj->validate($data)) {
            $this->mod->updateField($id, $column, $value);
            $json->error = 0;
            $json->value = $value;
        } else {
            $json->error = 1;
            $json->error_message = $elm_obj->getMessage();
            $json->value = $value;
        }
        $json->elm_type = $elm_obj->get('elm_type');
        $json->debug = benchmark::result();
        echo json_encode($json);
        exit;
    }

    function save($data) {
        
    }

    function listAutocompleteItems(){
        $columns = array();
        if($this->get['columns']){
            $columns = preg_split("/,+/", $this->get['columns']);
        }
        $list = $this->mod->listAutocompleteItems($this->get['term'], $columns);
        
        $_list = array();
        foreach($list as $val){
            if($this->get['list_title']){
                $label = $this->get['list_title'];
                foreach($this->mod->table_fields as $column_data){
                    $label = str_replace("{" . $column_data['column_name'] . "}", $val[$column_data['column_name']], $label);
                }
            }else{
                $label = $val['title'];
            }
            $_list[] = array('value'=>$val['id'], 'label'=>$label);
        }
        
        return json_encode($_list);
    }

    function tree() {

        //pae($this->mod);

        $str = "<div class=\"mod_actions\">" .
                "<a href=\"javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=new_item'));\"><img src=\"admin/images/actions/new.gif\" alt=\"\" class=\"vam\" />&nbsp;" . cms::$phrases['main']['catalog']['new_element'] . "</a>" .
                ($this->mod->module_info['additional_settings'] ? "<a href=\"javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=settings'));\"><img src=\"admin/images/actions/settings.gif\" alt=\"\" class=\"vam\" />&nbsp;" . cms::$phrases['main']['catalog']['settings'] . "</a>" : "") .
                ($this->mod->module_info['export'] ? "<a href=\"javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=export'));\"><img src=\"admin/images/actions/export.gif\" alt=\"\" class=\"vam\" />&nbsp;" . cms::$phrases['main']['catalog']['export'] . "</a>" : "") .
                "</div>";

        return $str;
    }

    function tree_replace_item() {
        return $this->mod->changeParentId($this->get['branch_id'], $this->get['parent_branch_id'], ($this->get['sort_to_item_id'] ? $this->get['sort_to_item_id'] : 0));
    }

    function outputItem($id, $type = 'array') {
        $data = $this->mod->loadItem($id);
        switch ($type) {
            case 'json':
                return json_encode($data);
                break;
            case 'array':
                return print_r($data, true);
                break;
        }
    }

    function get_file(){

        $column = $this->get['column'];
        $item_id = $this->get['id'];
        $type = $this->get['t'];
        
        // jei form save action buvo klaidu, tai pirma reik tikrint tem direktorija
        $tmp_prior = $this->get['tmp'];

        if ($item_id != 0) {

            $data = $this->mod->loadItem($item_id);
            $file_name = $data[$column];

            if ($tmp_prior) {
                $file = TEMPDIR . $file_name;
                if (!file_exists($file)) {
                    $file = UPLOADDIR . $file_name;
                }
            } else {
                $file = UPLOADDIR . $file_name;
                if (!file_exists($file)) {
                    $file = TEMPDIR . $file_name;
                }
            }
        } else {

            $list = glob(TEMPDIR . "{$this->mod->module_info['table_name']}-$column-0.*");
            $file = $list[0];
        }


        if (!file_exists($file)) {
            exit("No file.");
        }

        if($type == 'download'){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$file_name);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;            
        }

    }

    function show_image() {

        $column = $this->get['column'];
        $item_id = $this->get['id'];
        $img_width = $this->get['w'];
        $img_height = $this->get['h'];
        $img_type = $this->get['t'];

        // jei form save action buvo klaidu, tai pirma reik tikrint tem direktorija
        $tmp_prior = $this->get['tmp'];

        if ($item_id != 0) {

            $data = $this->mod->loadItem($item_id);
            $file_name = $data[$column];

            if ($tmp_prior) {
                $file = TEMPDIR . $file_name;
                if (!file_exists($file)) {
                    $file = UPLOADDIR . $file_name;
                }
            } else {
                $file = UPLOADDIR . $file_name;
                if (!file_exists($file)) {
                    $file = TEMPDIR . $file_name;
                }
            }
        } else {

            $list = glob(TEMPDIR . "{$this->mod->module_info['table_name']}-$column-0.*");
            $file = $list[0];
        }


        if (!file_exists($file)) {
            exit("No file.");
        }

        $img_params = array(
            'size_width' => $this->get['w'],
            'size_height' => $this->get['h'],
            'resize_type' => $this->get['t'],
            'quality' => 100
        );

        include_once(CLASSDIR . "images.class.php");
        $img_obj = new images();
        $img_obj->process($file, '', $img_params);
        exit;
    }

    function show_image_settings() {

        $column = $this->get['column'];
        $img_width = $this->get['w'];
        $img_height = $this->get['h'];
        $img_type = $this->get['t'];

        // jei form save action buvo klaidu, tai pirma reik tikrint tem direktorija
        $tmp_prior = $this->get['tmp'];

        $file_name = $this->mod->module_info['xml_settings'][$column]['value'];

        if ($tmp_prior) {
            $file = TEMPDIR . $file_name;
            if (!file_exists($file)) {
                $file = UPLOADDIR . $file_name;
            }
        } else {
            $file = UPLOADDIR . $file_name;
            if (!file_exists($file)) {
                $file = TEMPDIR . $file_name;
            }
        }

        if (!file_exists($file)) {
            exit("No file - $file");
        }

        $img_params = array(
            'size_width' => $this->get['w'],
            'size_height' => $this->get['h'],
            'resize_type' => $this->get['t'],
            'quality' => 100
        );

        include_once(CLASSDIR . "images.class.php");
        $img_obj = new images();
        $img_obj->process($file, '', $img_params);
        exit;
    }

    function _FORM_export($form_obj) {

        ini_set('memory_limit', '2048M');

        $data = $form_obj->getData();

        $items = $this->mod->listSearchItems();
        $fields = $data['fields'];
        
        $fresh_items = array();
        
        if($data['add_header']){
            $header = array();
            foreach ($fields as $field) {
                $header[$field] = $this->mod->_table_fields[$field]['title'];
            }
            $fresh_items[] = $header;
            //$fresh_items[] = array();
        }
        
        foreach ($items as $val) {
            $item_row = array();
            foreach ($fields as $field) {
                switch ($this->mod->_table_fields[$field]['elm_type']) {
                    case FRM_IMAGE:
                    case FRM_FILE:
                        $item_row[$field] = ($val[$field] ? UPLOADURL . $val[$field] : "");
                        break;
                    default:
                        $item_row[$field] = $val[$field];
                }
            }
            $fresh_items[] = $item_row;
        }

        //pae($fresh_items);
        
        switch ($data['type']) {
            case 'csv':
                $file_contents = "";
                $buffer = fopen('php://temp', 'r+');
                foreach ($fresh_items as $row) {
                    fputcsv($buffer, $row);
                    rewind($buffer);
                    $file_contents .= stream_get_contents($buffer);
                }
                fclose($buffer);

                header("Pragma: public"); // required
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Description: File Transfer");
                header("Content-Type: application/csv");
                header('Content-Disposition: attachment; filename="' . $this->mod->module_info['table_name'] . '-export(' . date('Ymd') . ').csv"');
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . mb_strlen($file_contents, "UTF-8"));

                echo $file_contents;
                exit;

                break;
            case 'excel':
//				$xls = new ExportXLS($this->mod->module_info['table_name'] . '-export(' . date('Ymd') . ').xls');
//				$xls->addHeader($fields);
//				$xls->addRow($fresh_items);
//				$xls->sendFile();

                $objPHPExcel = new PHPExcel();

                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Easywebmanager")
                            ->setLastModifiedBy($this->admin['title'])
                            ->setTitle($this->mod->module_info['title'] . " (" . date("Y-m-d") . ")")
                            ->setSubject("")
                            ->setDescription("")
                            ->setKeywords("")
                            ->setCategory("");


                // Add some data
                $objPHPExcel->setActiveSheetIndex(0);

                
                
                $n = count($this->mod->table_fields);
                $m = count($fresh_items);
                for ($i = 0; $i < $n; $i++) {
                    for ($j = 0; $j < $m; $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $fresh_items[$j][$this->mod->table_fields[$i]['column_name']]);
                    }
                }

                $objPHPExcel->setActiveSheetIndex(0);

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $this->mod->module_info['table_name'] . '-export(' . date('Ymd') . ').xls' . '"');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');

                exit;
                break;
            case 'json':
                $file_contents = json_encode($fresh_items);

                header("Pragma: public"); // required
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Description: File Transfer");
                header("Content-Type: application/json");
                header('Content-Disposition: attachment; filename="' . $this->mod->module_info['table_name'] . '-export(' . date('Ymd') . ').json"');
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . mb_strlen($file_contents, "UTF-8"));

                echo $file_contents;
                exit;
                break;
            case 'xml':
                $file_contents = "";

                $file_contents = XML_Array::array_listToXmlString($fresh_items, $this->mod->module_info['table_name']);

                header("Pragma: public"); // required
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Description: File Transfer");
                header("Content-Type: application/xml");
                header('Content-Disposition: attachment; filename="' . $this->mod->module_info['table_name'] . '-export(' . date('Ymd') . ').xml"');
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . mb_strlen($file_contents, "UTF-8"));

                echo $file_contents;
                exit;
                break;
        }
    }

    function _FORM_settings($form_obj) {

        $data = $form_obj->getData();
        $hiddens = $form_obj->get("hiddens");

        foreach ($this->mod->module_info['xml_settings'] as $key => $val) {
            if ($val['type'] == FRM_IMAGE || $val['type'] == FRM_FILE) {
                $file_name_temp = "{$this->mod->module_info['table_name']}-$key-0";
                $file_name_targ = "{$this->mod->module_info['table_name']}-$key-0";
                $f_temp = glob(TEMPDIR . $file_name_temp . "*");
                if (!empty($f_temp)) {
                    $tmp_file = $f_temp[0];
                    $path_parts = pathinfo($tmp_file);
                    $data[$key] = $file_name_targ . "." . $path_parts['extension'];
                    $target_file = UPLOADDIR . $data[$key];
                    copy($tmp_file, $target_file);
                    chmod($target_file, 0777);
                    unlink($tmp_file);
                }
            }
            if (($val['type'] == FRM_CHECKBOX_GROUP || $val['type'] == FRM_SELECT) && is_array($data[$key])) {
                $data[$key] = implode("::", $data[$key]);
            }
            if ($val['type'] == FRM_TEXTAREA) {
                $data[$key] = str_replace("<![CDATA[", "{!{CDATA{", $data[$key]);
                $data[$key] = str_replace("]]>", "}!}CDATA}", $data[$key]);
            }
            
            $this->mod->module_info['xml_settings'][$key]['value'] = $data[$key];
        }

        $xml = XML_Array::arrayToXmlString($this->mod->module_info['xml_settings']);
        //$xml = htmlentities("<items>" . $xml . "</items>", ENT_COMPAT | ENT_HTML401, "UTF-8");
        $xml = htmlspecialchars("<items>" . $xml . "</items>", ENT_COMPAT | ENT_HTML401, "UTF-8");
        //$xml = addcslashes($xml, "'");
        
//        $xml = str_replace("&scaron;", "š", $xml);
//        $xml = str_replace("&Scaron;", "Š", $xml);

        $this->mod->module->saveSettings($xml, $this->mod->module_info['id']);
    }

    function _FORM_delete($form_obj) {

        $data = $form_obj->getData();
        $hiddens = $form_obj->get("hiddens");

        $item_data = $this->mod->loadItem($hiddens['id']);

        if ($data['delete_all'] == 1) {
            $this->mod->delete($hiddens['id']);
        } else {
            $this->mod->deleteLang($hiddens['id'], $data['language_actions']);
        }
        
        $return_val = $item_data['parent_id'];
        if(!$return_val){
            $return_val = (!empty($item_data));
        }
        
        return $return_val;
    }

    function _FORM_mailto($form_obj) {

        include_once(CLASSDIR_ . "phpmailer.class.php");
        $mailer = new PHPMailer();

        $mailer->CharSet = "UTF-8";
        $mailer->Subject = "{$form_obj->settings['title']} " . Config::$val['pr_url'];
        $message = date('Y-m-d') . "\r\n";
        $mailer->ContentType = "text/plain";
        foreach ($form_obj->fields as $key => $val) {
            if ($val['elm_type'] == FRM_SELECT || $val['elm_type'] == FRM_RADIO || $val['elm_type'] == FRM_CHECKBOX_GROUP) {
                $val['value'] = $form_obj->data[$key];
                if ($val['list_values']['source'] == 'DB') {
                    unset($filters_record);
                    $filters_record = $this->registry->model->{$val['list_values']['module']};
                    if (!is_array($val['value']))
                        $arr_val = explode("::", $val['value']);
                    else
                        $arr_val = $val['value'];
                    if (!empty($arr_val))
                        $val['value'] = "";
                    foreach ($arr_val as $k => $v) {
                        if (is_numeric($v)) {
                            $filters_data = $filters_record->loadItem($v);
                            $val['value'] .= $filters_data['title'] . "; "; //$_POST[$key];
                        }
                    }
                }
            }
            if ($val['elm_type'] != FRM_HIDDEN && $val['elm_type'] != FRM_SUBMIT && $val['elm_type'] != FRM_BUTTON && $val['elm_type'] != FRM_FILE && $val['elm_type'] != FRM_IMAGE)
                $message .= "{$val['title']}: {$val['value']}\r\n";
            if ($val['elm_type'] == FRM_FILE || $val['elm_type'] == FRM_IMAGE) {
                if (file_exists($_FILES[$val['column_name']]['tmp_name'])) {
                    $mailer->AddAttachment($_FILES[$val['column_name']]['tmp_name'], $_FILES[$val['column_name']]['name']);
                } elseif (file_exists(UPLOADDIR . $val['value'])) {
                    $mailer->AddAttachment(UPLOADDIR . $val['value'], $val['value']);
                }
            }

            if ($val['elm_type'] == FRM_HTML) {
                $mailer->ContentType = "text/html";
            }
        }
        if ($mailer->ContentType == "text/html") {
            $message = preg_replace("/\r\n/", "<br>", $message);
        }
        $mailer->Body = $message;

        $mailto = (strlen($form_obj->settings['emails']) > 0 ? $form_obj->settings['emails'] : Config::$val['pr_email']);
        $mailer->AddAddress($mailto);
        $mailer->From = isset($form_obj->data['email']) ? $form_obj->data['email'] : $mailto;
        $mailer->FromName = Config::$val['pr_url'];
        $mailer->Send();
    }

    function _FORM_database($form_obj) {

        $data = $form_obj->getData();

        $hiddens = $form_obj->get("hiddens");

//		$data['isNew'] = $hiddens['isNew'];
//		$data['is_category'] = $hiddens['is_category'];
//		$data['id'] = $hiddens['id'];
//		$data['parent_id'] = $hiddens['parent_id'];
        $data['language'] = $this->mod->language;

        $r_id = $this->mod->saveItem($data);

        return $r_id;
    }

    function _FORM_session($form_obj) {
        $_SESSION[$form_obj->get('variable')] = $form_obj->getData();
    }

    function _FORM_soap($form_obj) {
        
    }

    function _FORM_curl($form_obj) {
        
    }

    /**
     * 
     * Enter description here ...
     * @param unknown_type $value
     * @param unknown_type $column
     * @param unknown_type $data
     */
    function checkDataExist($value, $column, $data) {
        $list = $this->mod->loadItemByColumnValue($column, $value);
        foreach ($list as $i => $val) {
            if ($data['id'] != $val['id']) {
                return false;
            }
        }
        return true;
    }

    /**
     * 
     * return module name
     */
    function __toString() {
        return $this->mod->module_info['table_name'];
    }

}

?>
