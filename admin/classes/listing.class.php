<?php

include_once(CLASSDIR . "basic.class.php");

class listing extends basic {

    private $tpl;
    private $results_paging = 10;
    private $grid_data = array();
    private $filterParams = array();
    private $paging_values = array(
        array('value' => 10),
        array('value' => 20),
        array('value' => 30),
        array('value' => 50),
        array('value' => 100),
        array('value' => 200),
        array('value' => 1000)
    );
    private $default_paging = 20;

    function __construct($name) {

        parent::__construct();

        // default template
        $this->tpl = TPLDIR . "blocks/listing.tpl";

        if (isset($this->post['action']) && $this->post['action'] == 'paging') {
            $this->get['offset'] = 0;
            $_SESSION['order']['paging'] = $this->post['paging_items'];
        }

        if (!isset($_SESSION['order']['paging'])) {
            $_SESSION['order']['paging'] = DEFAULT_PAGING;
        }
        if (isset($this->get['by'])) {
            $_SESSION['order'][$this->get['module']]['order_by'] = $this->get['by'];
        }
        if (isset($this->get['order'])) {
            $_SESSION['order'][$this->get['module']]['order_direction'] = $this->get['order'];
        }

        $this->selected_paging = $_SESSION['order']['paging'];
        $this->sort_by = $this->get['by'];
        $this->sort_direction = $this->get['order'];

        $this->grid_data['list_page'] = 'list';
        $this->grid_data['edit_page'] = 'edit';
        $this->grid_data['script'] = 'change_catalog_item_field';

        $this->grid_data['edit_button'] = 1;
        $this->grid_data['dublicate_button'] = 0;
        $this->grid_data['delete_button'] = 1;
        $this->grid_data['select_button'] = 1;
        $this->grid_data['dragndrop'] = 1;
        $this->grid_data['actions_button'] = 1;

        $this->grid_data['filter_form'] = 1;
        $this->grid_data['sort_form'] = 1;
        
        $this->grid_data['base_url'] = '';

        $this->set('grid_name', $name);
    }

    function set($key, $val) {
        $this->grid_data[$key] = $val;
    }

    function setTpl($file, $var) {
        $this->tpl = $file;
    }

    function setColumns($columns) {

        foreach ($columns as $key => $val) {
            if (($columns[$key]['super_user'] == 0 || $columns[$key]['super_user'] == 1 && $_SESSION['admin']['permission'] == 1)) {
                $columns[$key]['editable'] = $columns[$key]['editorship'];

                $columns[$key]['filter_value'] = $this->filterParams[$val['column_name']];
                switch ($val['elm_type']) {
                    case FRM_TEXT:
                    case FRM_TEXTAREA:
                    case FRM_HTML:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 10;
                        $columns[$key]['elm_text'] = 1;
                        break;
                    case FRM_DATE:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 2;
                        $columns[$key]['elm_date'] = 1;
                        $columns[$key]['filter_value_from'] = $columns[$key]['filter_value']['from'];
                        $columns[$key]['filter_value_to'] = $columns[$key]['filter_value']['to'];
                        if (strlen($columns[$key]['filter_value_from']) || strlen($columns[$key]['filter_value_to'])) {
                            $columns[$key]['filter_value'] = 1;
                            if (strlen($columns[$key]['filter_value_from'])) {
                                $arr = explode("-", $columns[$key]['filter_value_from']);
                                $columns[$key]['filter_value_back_from'] = date("Y-m-d", mktime(0, 0, 0, $arr[1], $arr[2] - 1, $arr[0]));
                                $columns[$key]['filter_value_fwd_from'] = date("Y-m-d", mktime(0, 0, 0, $arr[1], $arr[2] + 1, $arr[0]));
                            }
                            if (strlen($columns[$key]['filter_value_to'])) {
                                $arr = explode("-", $columns[$key]['filter_value_to']);
                                $columns[$key]['filter_value_back_to'] = date("Y-m-d", mktime(0, 0, 0, $arr[1], $arr[2] - 1, $arr[0]));
                                $columns[$key]['filter_value_fwd_to'] = date("Y-m-d", mktime(0, 0, 0, $arr[1], $arr[2] + 1, $arr[0]));
                            }
                        }else{
                            $columns[$key]['filter_value'] = 0;
                        }
                        break;
                    case FRM_BUTTON:
                    case FRM_SUBMIT:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 2;
                        break;
                    case FRM_LIST:
                    case FRM_TREE:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 2;
                        break;
                    case FRM_IMAGE:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 3;
                        if (isset($columns[$key]['list_values']['dir'])) {
                            $columns[$key]['path'] = $columns[$key]['list_values']['dir'];
                        } elseif (isset($columns[$key]['list_values']['abs_dir'])) {
                            $columns[$key]['path'] = $columns[$key]['list_values']['abs_dir'];
                            $columns[$key]['abs_path'] = 1;
                        } else {
                            $columns[$key]['path'] = str_replace(DOCROOT_, "", UPLOADDIR);
                        }

                        $columns[$key]['elm_image'] = 1;
                        break;
                    case FRM_FILE:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 3;
                        $columns[$key]['elm_file'] = 1;
                        break;
                    case FRM_RADIO:
                    case FRM_SELECT:
                    case FRM_CHECKBOX_GROUP:
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 5;
                        $columns[$key]['elm_choice'] = 1;
                        if($columns[$key]['list_values']['module']){
                            if($columns[$key]['list_values']['method'])
                                $columns[$key]['choice_arr_json'] = json_encode($this->registry->model->{$columns[$key]['list_values']['module']}->{$columns[$key]['list_values']['method']}());
                            else
                                $columns[$key]['choice_arr_json'] = json_encode($this->registry->model->{$columns[$key]['list_values']['module']}->listSearchItems());
                        }
                        
                        break;
                    case FRM_CHECKBOX:
                        $columns[$key]['button'] = 1;
                        $columns[$key]['elm_button'] = 1;
                        $columns[$key]['value_' . $columns[$key]['filter_value']] = 1;
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 1;
                        break;
                    case FRM_CUSTOM:
                        foreach ($val['params'] as $k1 => $v1)
                            $columns[$key][$k1] = $v1;
                        break;
                    default:
                        $columns[$key]['elm_text'] = 1;
                        if (!isset($columns[$key]['w']))
                            $columns[$key]['w'] = 10;
                }
                if ($this->sort_by == $val['column_name'] && $this->sort_direction == 'ASC') {
                    $columns[$key]['sort_up'] = 1;
                }
                if ($this->sort_by == $val['column_name'] && $this->sort_direction == 'DESC') {
                    $columns[$key]['sort_down'] = 1;
                }

                $columns[$key]['I'] = $key;
                $table_list[] = $columns[$key];

                if (count($table_list) > 1)
                    $table_list[count($table_list) - 2]['second_column_name'] = $columns[$key]['column_name'];
            }
        }

        $this->columns = $table_list;
        TPL::setVar('fields', $this->columns);
    }

    function setItemsData($data) {

        $this->count = $data['_COUNT_'];
        TPL::setVar('elements_count', $data['_COUNT_']);
        TPL::setVar('filter_elements_count', $this->count);

        TPL::setVar('not_empty_elements', $data['_COUNT_']);
        TPL::setVar('not_empty_filter_elements', $this->count);
    }

    function setItems($list_items) {

        TPL::setVar('items', $list_items);
    }

    function paging($offset) {
        if (!isset($offset) || !is_numeric($offset))
            $offset = 0;
        $paging_arr = generatePaging($offset, $this->count, $this->selected_paging, $this->results_paging);
        TPL::setVar('paging', $paging_arr);
        TPL::setVar('paging_loop', $paging_arr['loop']);
    }

    function pagingSelect() {
        TPL::setVar('items_in_one_page', 1);
        if ($this->paging_values == 0) {
            TPL::setVar('items_in_one_page', 0);
            return false;
        }
        $n = count($this->paging_values);
        for ($i = 0; $i < $n; $i++) {
            if ($this->paging_values[$i]['value'] == $this->selected_paging) {
                $this->paging_values[$i]['active'] = 1;
            }
        }
        TPL::setVar('items_in_one_page', $this->paging_values);
    }

    function action($obj, $method, $params = null) {
        return call_user_method($method, $obj, $params);
    }

    function generate() {

        // jei irasu yra, bet pagal paieskos filtrus nieko nerasta (kad rodytu filtru paieskos juosta)
        if (count($this->filterParams) > 0) {
            TPL::setVar('not_empty_elements', 1);
        }

        TPL::setVar('grid_data', $this->grid_data);
        TPL::setVar('get', $_GET);

        return TPL::parse($this->tpl);
    }

    function setFilters($data) {
        foreach ($data as $key => $val) {
            $this->filterParams[$key] = $val;
        }
    }

}

?>