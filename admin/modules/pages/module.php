<?php


// Default items in page
$_paging = 20;

if(!isset($_GET['id'])) $_GET['id'] = 0;

/*
if($_GET['id']==1){
	$_GET['page'] = isset($_GET['page'])?$_GET['page']:'list';
	redirect("main.php?content={$_GET['content']}&module={$_GET['module']}&page={$_GET['page']}");
}
*/

// Set language
if(isset($_GET['lng'])) $_SESSION['site_lng'] = $_GET['lng'];
$lng = $_SESSION['site_lng'];


$record = $main_object->create($_GET['module']);

if($_GET['new']==1 && !is_numeric($_GET['mod_id'])){
	
	$list = $module->listModulesPages($record->module_info['id']);
	$tpl->setLoop('modules_list', $list);
	
	$tpl->setVar('modules_list', 1);
	
}else{
	
	if($_GET['new']==1){
		$mod_id = $_GET['mod_id'];
	}else{
		$item_data = $record->loadItem($_GET['id']);
		$mod_id = $item_data['mod_id'];
	}
	
	$module->loadModule($mod_id);
	$child_mod_obj = $main_object->create($module->data['table_name']);
	
	
}







if(is_numeric($item_data['mod_id'])){
}else{
	echo "ERROR";
	exit;
}



include_once(CLASSDIR."forms.class.php");
$form_obj = & new forms();   

$path_tpl_name = MODULESDIR.$module_name."/templates/path.tpl";
$elm_tbl_header_tpl_name = MODULESDIR.$module_name."/templates/elements_table_header.tpl";
$elm_filter_form_tpl_name = MODULESDIR.$module_name."/templates/elements_filter_form.tpl";

$tpl_path = & new easytpl($path_tpl_name, "templateVariables");
$tpl_headers = & new easytpl($elm_tbl_header_tpl_name, "templateVariables");
$tpl_filters = & new easytpl($elm_filter_form_tpl_name, "templateVariables");


if(isset($_GET['action']) && $_GET['action']=='status' && isset($_GET['statusid'])){
    $child_mod_item_data = $child_mod_obj->loadItem($_GET['statusid']);
    $child_mod_obj->changeStatus($_GET['statusid']);
    unset($child_mod_item_data);
}

if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    $child_mod_item_data = $child_mod_obj->loadItem($_GET['deleteid']);
    $child_mod_obj->delete($_GET['deleteid']);
    unset($child_mod_item_data);
}


include_once(dirname(__FILE__)."/main.php");


if(!empty($_POST)){

	$_SERVER_QUERY_STRING = ereg_replace("\&offset=[0-9]", "", $_SERVER['QUERY_STRING']);
	$_SERVER_QUERY_STRING = ereg_replace("\&c_offset=[0-9]", "", $_SERVER['QUERY_STRING']);

	if(isset($_POST['action']) && $_POST['action']=='action_with_selected_items'){
		if($_POST['action_choice']=="delete"){
			foreach($_POST['chk'] as $key=>$val){
				$child_mod_obj->delete($_POST['chk'][$key]);
			}
		}
		if($_POST['action_choice']!="delete" && $_POST['action_choice']!="mail"){
			foreach($_POST['chk'] as $key=>$val){
				$child_mod_obj->changeFieldStatus($_SESSION['site_lng'], $_POST['action_choice'], $_POST['chk'][$key]);
			}
			
		}
		redirect("main.php?".$_SERVER_QUERY_STRING);

	}
	if(isset($_POST['action']) && $_POST['action']=='paging'){
		$_GET['offset'] = 0;
		$_SESSION['order']['paging'] = $_POST['paging_items'];
	}
	if(isset($_POST['action']) && $_POST['action']=='filter'){
		$child_mod_obj->getTableFields(0); // uzkrauna elementu laukus
		foreach($child_mod_obj->table_list as $key => $val){
			if(isset($_POST[$val['column_name']])){
				if(strlen($_POST[$val['column_name']])>0){
					$searchValue = addslashes($_POST[$val['column_name']]);
					$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$val['column_name']]['value'] = $searchValue;
					$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$val['column_name']]['column'] = $val['column_name'];
					$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$val['column_name']]['type'] = $val['type'];
				}else{
					unset($_SESSION['filters'][$child_mod_obj->module_info['table_name']][$val['column_name']]);
				}
			}
		}
		$_SESSION['filters']['category_id'] = $_GET['id'];
		$_SERVER_QUERY_STRING = ereg_replace("\&offset=[0-9]", "", $_SERVER['QUERY_STRING']);
		$_SERVER_QUERY_STRING = ereg_replace("\&c_offset=[0-9]", "", $_SERVER['QUERY_STRING']);
		redirect("main.php?".$_SERVER_QUERY_STRING);

	}
	if(isset($_POST['action']) && $_POST['action']=='empty_filters'){
		unset($_SESSION['filters'][$child_mod_obj->module_info['table_name']]);
	}
	
}

if(isset($_GET['by'])){
	$_SESSION['order'][$_GET['module']]['order_by'] = $_GET['by'];
}
if(isset($_GET['order'])){
	$_SESSION['order'][$_GET['module']]['order_direction'] = $_GET['order'];
}
if(!isset($_GET['offset'])){
	$_GET['offset'] = 0;
}

if(!isset($_SESSION['order'][$_GET['module']]['order_by'])){
	$_SESSION['order'][$_GET['module']]['order_by'] = strlen($child_mod_obj->module_info['default_sort'])>0?$child_mod_obj->module_info['default_sort']:"R.sort_order";
}
if(!isset($_SESSION['order'][$_GET['module']]['order_direction']) || strlen($_SESSION['order'][$_GET['module']]['order_direction'])==0){
	$_SESSION['order'][$_GET['module']]['order_direction'] = (strlen($child_mod_obj->module_info['default_sort_direction'])>0?$child_mod_obj->module_info['default_sort_direction']:"ASC");
}
if(!isset($_SESSION['order']['paging'])){
	$_SESSION['order']['paging'] = $_paging;
}


$tpl_headers->setVar('order_by_'.$_SESSION['order'][$_GET['module']]['order_by'], 1);
$tpl_headers->setVar('order_direction', $_SESSION['order'][$_GET['module']]['order_direction']);


if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
    $child_mod_obj->changeOrder($_GET['firstid'], $_GET['lastid']);
    $child_mod_item_data = $child_mod_obj->loadItem($_GET['firstid']);
    //redirect();
}

$tpl_path->setVar('data', $item_data);
$path = $record->getPath((isset($_GET['new'])?$_GET['parent_id']:$item_data['parent_id']));

if(isset($_SESSION['filter']['category_id']) && $_GET['page']=='filters_list'){
	$n = count($record->path);
	for($i=0, $true=false; $i<$n; $i++){
		if($record->path[$i]['id']==$_SESSION['filter']['category_id']){
			$true = true;
		}
		if($true){
			$path[] = $record->path[$i];
		}
	}
	$tpl_path->setVar('filter_module', 1);
}else{
	$path = $record->path;
}
$tpl_path->setLoop('path', $path);



$child_mod_obj->getTableFields(0); // uzkrauna elementu laukus
//pa($record->table_list);


$child_mod_obj->setWhereClause($_SESSION['filters'][$child_mod_obj->module_info['table_name']]);
$count = $child_mod_obj->listItemsElementsCount($_GET['id']);
$child_mod_obj->shorten_texts = 20;
$list_products = $child_mod_obj->listItemsElements($_GET['id'], $_SESSION['order'][$_GET['module']]['order_by'], $_SESSION['order'][$_GET['module']]['order_direction'], ($_GET['offset']<0?0:$_GET['offset'])*$_SESSION['order']['paging'], $_SESSION['order']['paging']);
$child_mod_obj->shorten_texts = 0;

$child_mod_obj->setWhereClause();
$tpl->setLoop('items', @$list_products);

$tpl->setVar('items_count', $count);


$paging_arr = generatePaging($_GET['offset'], $count, $_SESSION['order']['paging'], RESULTS_PAGING);
$tpl->setLoop('paging', $paging_arr['loop']);
$tpl->setVar('paging', $paging_arr);



if(empty($list_products)&&$count>0){
	$n = floor($count/$_SESSION['order']['paging'])-1;
	//pa($_SESSION['order']);
	//echo "main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page=list&id={$_GET['id']}&offset=$n";
	//exit;
	redirect("main.php?content={$_GET['content']}&module={$record->module_info['table_name']}&page={$_GET['page']}&id={$_GET['id']}&file_id={$_GET['file_id']}&offset=$n");
}

$n = count($child_mod_obj->table_list);
for($i=0; $i<$n; $i++){
	if(($child_mod_obj->table_list[$i]['super_user']==0 || $child_mod_obj->table_list[$i]['super_user']==1 && $_SESSION['admin']['permission']==1)){
		$child_mod_obj->table_list[$i]['editable'] = 1;
		switch($child_mod_obj->table_list[$i]['type']){
			case FRM_TEXT :
			case FRM_NUMBER :
			case FRM_FLOAT :
				$child_mod_obj->table_list[$i]['text'] = 1;
				$child_mod_obj->table_list[$i]['elm_text'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "<input type=\"text\" id=\"id_{$child_mod_obj->table_list[$i]['column_name']}_{items.id}\" class=\"listFrmText\" onkeypress=\"javascript: ajaxChangeFieldText('{$configFile->variable['site_url']}', this.value, {items.id}, {items.parent_id}, '{$child_mod_obj->table_list[$i]['column_name']}', '{$child_mod_obj->module_info['table_name']}', '{$_SESSION['site_lng']}');\">";
				$child_mod_obj->table_list[$i]['filterContent'] = "<input type=\"text\" class=\"listFrmText\" name=\"{$child_mod_obj->table_list[$i]['column_name']}\" value=\"{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}\">";
			break;
			case FRM_TEXTAREA :
				$child_mod_obj->table_list[$i]['text'] = 1;
				$child_mod_obj->table_list[$i]['elm_textarea'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "<textarea id=\"id_{$child_mod_obj->table_list[$i]['column_name']}_{items.id}\" class=\"listFrmText\" onkeypress=\"javascript: ajaxChangeFieldTextarea('{$configFile->variable['site_url']}', this.value, {items.id}, {items.parent_id}, '{$child_mod_obj->table_list[$i]['column_name']}', '{$child_mod_obj->module_info['table_name']}', '{$_SESSION['site_lng']}');\"></textarea>";
				$child_mod_obj->table_list[$i]['filterContent'] = "<input type=\"text\" class=\"listFrmText\" name=\"{$child_mod_obj->table_list[$i]['column_name']}\" value=\"{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}\">";
			break;
			case FRM_SELECT :
			case FRM_CHECKBOX_GROUP :
			case FRM_RADIO :
				$child_mod_obj->table_list[$i]['text'] = 1;
				$child_mod_obj->table_list[$i]['elm_choice'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "<select id=\"id_{$child_mod_obj->table_list[$i]['column_name']}_{items.id}\" class=\"listFrmSelect\" onkeypress=\"javascript: if(window.event.keyCode == 27) show_hide('fieldContent_{items.id}_{$child_mod_obj->table_list[$i]['column_name']}', 'fieldEdit_{items.id}_{$child_mod_obj->table_list[$i]['column_name']}');\" onchange=\"javascript: ajaxChangeFieldSelect('{$configFile->variable['site_url']}', this.options[this.selectedIndex].value, {items.id}, {items.parent_id}, '{$child_mod_obj->table_list[$i]['column_name']}', '{$child_mod_obj->module_info['table_name']}', '{$_SESSION['site_lng']}');\" ></select>";
				$items_list = $form_obj->getSelectItems($child_mod_obj->table_list[$i]); $items_list_count = count($items_list);
				$child_mod_obj->table_list[$i]['filterContent'] = "<select name=\"{$child_mod_obj->table_list[$i]['column_name']}\" class=\"listFrmSelect\">" .
						"<option value=''>--{$cms_phrases['main']['common']['show_all_list']}--</option>";
						//"<loop name=\"arr_{$child_mod_obj->table_list[$i]['column_name']}\">" .
				for($c=0; $c<$items_list_count; $c++){
					$child_mod_obj->table_list[$i]['filterContent'] .= "<option value='{$items_list[$c]['id']}' ".($items_list[$c]['id']==$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']?"selected":"").">".(strlen($items_list[$c]['title'])>30?mb_substr($items_list[$c]['title'],0,27)."...":$items_list[$c]['title'])."</option>";
				}
						//"</loop name=\"arr_{$child_mod_obj->table_list[$i]['column_name']}\">" .
				$child_mod_obj->table_list[$i]['filterContent'] .= "</select>";
				$tpl_filters->setLoop("arr_{$child_mod_obj->table_list[$i]['column_name']}", $items_list);
				$tpl->setLoop("arr_{$child_mod_obj->table_list[$i]['column_name']}", $items_list);
			break;
			case FRM_DATE :
				$child_mod_obj->table_list[$i]['text'] = 1;
				$child_mod_obj->table_list[$i]['elm_date'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "<table border=0 cellpadding=0 cellspacing=0><tr><td>
					<input type='text' class='listFrmDate' name='id_{$child_mod_obj->table_list[$i]['column_name']}_{items.id}' onclick=\"javascript: ajaxChangeFieldDate('{$configFile->variable['site_url']}', this.value, {items.id}, {items.patent_id}, '{$child_mod_obj->table_list[$i]['column_name']}', '{$child_mod_obj->module_info['table_name']}', '{$_SESSION['site_lng']}');\">
					</td><td><input type=\"button\" value=\"...\" class=\"listFrmDateBtn\" onclick=\"javascript: displayCalendar(document.forms['list'].elements('id_{$child_mod_obj->table_list[$i]['column_name']}_{items.id}'),'yyyy-mm-dd',this); return false;\">
					</td></tr></table>";
				$child_mod_obj->table_list[$i]['filterContent'] = "<input type=\"text\" class=\"listFrmText\" name=\"{$child_mod_obj->table_list[$i]['column_name']}\" value=\"{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}\">";
//				$child_mod_obj->table_list[$i]['filterContent'] = "<table border=0 cellpadding=0 cellspacing=0><tr><td>
//					<input type='text' class='listFrmDate' name='{$child_mod_obj->table_list[$i]['column_name']}' value='{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}'>
//					</td><td><input type=\"button\" value=\"...\" class=\"listFrmDateBtn\" onclick=\"javascript: displayCalendar(document.forms['filter'].elements('{$child_mod_obj->table_list[$i]['column_name']}'),'yyyy-mm-dd',this); return false;\">
//					</td></tr></table>";
			break;
			case FRM_CHECKBOX :
				$child_mod_obj->table_list[$i]['button'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "";
				$child_mod_obj->table_list[$i]['filterContent'] = "";
				//$child_mod_obj->table_list[$i]['editContent'] = "<center><img src=\"".(strlen($_SESSION['easyweb']['filepath'])?"file://".$_SESSION['easyweb']['filepath']:"")."images/status_{items.{$child_mod_obj->table_list[$i]['column_name']}}.gif\" border=\"0\" style=\"cursor:pointer;\" onclick=\"javascript: ajaxChangeFieldCheckbox('{$configFile->variable['site_url']}', '{items.{$child_mod_obj->table_list[$i]['column_name']}}', {items.id}, {items.parent_id}, '{$child_mod_obj->table_list[$i]['column_name']}', '{module.table_name}', '{$_SESSION['site_lng']}');\"></center>";
				if(isset($_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value'])){
					$arr = explode("::", $_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']);
				}else{
					 $arr[0] = "0"; $arr[1] = "1";
					 $_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value'] = "0::1";
				}
				$child_mod_obj->table_list[$i]['filterContent'].= "<img src=\"images/status_1".($arr[1]=="1"?"_checked":"").".gif\" onclick=\"javascript: changeCheckboxFilterValue(this, '{$child_mod_obj->table_list[$i]['column_name']}', '1');\" hspace=\"5\">";
				$child_mod_obj->table_list[$i]['filterContent'].= "<img src=\"images/status_0".($arr[0]=="0"?"_checked":"").".gif\" onclick=\"javascript: changeCheckboxFilterValue(this, '{$child_mod_obj->table_list[$i]['column_name']}', '0');\" hspace=\"5\">";
				$child_mod_obj->table_list[$i]['filterContent'].= "<input type=\"hidden\" name=\"{$child_mod_obj->table_list[$i]['column_name']}\" value=\"{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}\">";
			break;
			case FRM_IMAGE :
				$child_mod_obj->table_list[$i]['image'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "";
				$child_mod_obj->table_list[$i]['filterContent'] = "<input type=\"text\" class=\"listFrmText\" name=\"{$child_mod_obj->table_list[$i]['column_name']}\" value=\"{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}\">";
				$tpl->setVar('import_from_zip', 1);
			break;
			case FRM_FILE :
				$child_mod_obj->table_list[$i]['file'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "";
				$child_mod_obj->table_list[$i]['filterContent'] = "<input type=\"text\" class=\"listFrmText\" name=\"{$child_mod_obj->table_list[$i]['column_name']}\" value=\"{$_SESSION['filters'][$child_mod_obj->module_info['table_name']][$child_mod_obj->table_list[$i]['column_name']]['value']}\">";
				$tpl->setVar('import_from_zip', 1);
			break;
			default:
				$child_mod_obj->table_list[$i]['text'] = 1;
				$child_mod_obj->table_list[$i]['editContent'] = "";
				$child_mod_obj->table_list[$i]['filterContent'] = "";
		}
	}
	$child_mod_obj->table_list[$i]['short_title'] = (mb_strlen($child_mod_obj->table_list[$i]['title'], "UTF-8")>17?mb_substr($child_mod_obj->table_list[$i]['title'], 0, 15, "UTF-8")."..":$child_mod_obj->table_list[$i]['title']);
}

$tpl_filters->setFastLoop('fields', $child_mod_obj->table_list);
//$tpl_headers->setFastLoop('fields', $record->table_list);
//$tpl->setFastLoop('fields', $record->table_list);

$tpl->setVar('fields_list_count', count($record->table_list));
$tpl->setVar('not_empty_filters_elements', (count($list_products)>0?1:0));
//$tpl_headers->setVar('parent_id', $_GET['id']);

//$tpl->setVar('new_category', (!isset($_GET['ce'])||$_GET['ce']==1?1:0));
//$tpl->setVar('new_item', (isset($_GET['id'])&&$_GET['id']!=0?1:0));


$tpl->setVar('module', $record->module_info);
$tpl->setVar('child_module', $child_mod_obj->module_info);


//$tpl->setVar('module', $record->module_info);
//$tpl_categories->setVar('module', $record->module_info);
//$tpl_path->setVar('module', $record->module_info);
//$tpl_headers->setVar('module', $record->module_info);
//$tpl_filters->setVar('module', $record->module_info);


$tpl_headers->parse();
$tpl->setCodeBlock('table_header', 'include $tpl_headers->cacheFile;');
$tpl_filters->parse();
$tpl->setCodeBlock('elements_filter_form', 'include $tpl_filters->cacheFile;');

$tpl->setVar('upload_url', UPLOADURL);

$n = count($IN_ONE_PAGE_LIST);
for($i=0; $i<$n; $i++){
	if($IN_ONE_PAGE_LIST[$i]['value']==$_SESSION['order']['paging']){
		$IN_ONE_PAGE_LIST[$i]['active'] = 1;
	}
}
$tpl->setLoop('items_in_one_page', $IN_ONE_PAGE_LIST);

$tpl->setVar('get', $_GET);
//$tpl_categories->setVar('get', $_GET);


$tpl_path->parse();
$tpl->setCodeBlock('path', 'include $tpl_path->cacheFile;');


//$tpl_categories->parse();
//$tpl->setCodeBlock('categories', 'include $tpl_categories->cacheFile;');

//$tpl->parse();
//$tpl->setCodeBlock('elements', 'include $tpl->cacheFile;');


$tpl->setVar('parent_id', $_GET['id']);
$tpl->setVar('lng', $lng);
$tpl->setVar('easyweb', $_SESSION['easy']);

$tpl->setVar('filter_page', 'module_');

if($record->module_info['category']==0) $tpl->setVar('tree_reload', 0);

include_once(dirname(__FILE__)."/menu.php");

if(isset($_GET['ajax']) && $_GET['ajax']==1){
	include $tpl->parse();
	exit;
}

include_once(dirname(__FILE__)."/inc/screenshot.php");

?>