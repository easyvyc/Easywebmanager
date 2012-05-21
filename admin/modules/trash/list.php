<?php
/*
 * Created on 2007.07.28
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



$_paging = 20;

include_once(CLASSDIR."trash.class.php");
$trash_obj = & new trash();

if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    $trash_obj->delete($_GET['deleteid']);
}

if(isset($_GET['action']) && $_GET['action']=='reset' && isset($_GET['resetid'])){
    $trash_obj->reset($_GET['resetid']);
}

if(!empty($_POST)){

	$_SERVER_QUERY_STRING = ereg_replace("\&offset=[0-9]", "", $_SERVER['QUERY_STRING']);
	$_SERVER_QUERY_STRING = ereg_replace("\&c_offset=[0-9]", "", $_SERVER['QUERY_STRING']);

	
	if(isset($_GET['action']) && $_GET['action']=='action_with_selected_items'){
		if($_GET['action_choice']=="remove"){
			foreach($_POST['chk'] as $key=>$val){
				$trash_obj->delete($_POST['chk'][$key]);
			}
		}
		if($_GET['action_choice']=="reset"){
			foreach($_POST['chk'] as $key=>$val){
				$trash_obj->reset($_POST['chk'][$key]);
			}
		}
	}
	
	if(isset($_POST['action']) && $_POST['action']=='paging'){
		$_GET['offset'] = 0;
		$_SESSION['order']['paging'] = $_POST['paging_items'];
	}
	if(isset($_POST['action']) && $_POST['action']=='c_paging'){
		$_GET['c_offset'] = 0;
		$_SESSION['order']['c_paging'] = $_POST['c_paging_items'];
	}

	/*if(isset($_POST['action']) && $_POST['action']=='filter'){
		foreach($trash_obj->table_list as $key => $val){
			if(isset($_POST[$val['column_name']])){
				if(strlen($_POST[$val['column_name']])>0){
					$searchValue = addslashes($_POST[$val['column_name']]);
					$_SESSION['filters']['trash'][$val['column_name']]['value'] = $searchValue;
					$_SESSION['filters']['trash'][$val['column_name']]['column'] = $val['column_name'];
					$_SESSION['filters']['trash'][$val['column_name']]['type'] = $val['type'];
				}else{
					unset($_SESSION['filters']['trash'][$val['column_name']]);
				}
			}
		}
		$_SESSION['filters']['category_id'] = $_GET['id'];
		$_SERVER_QUERY_STRING = ereg_replace("\&offset=[0-9]", "", $_SERVER['QUERY_STRING']);
		$_SERVER_QUERY_STRING = ereg_replace("\&c_offset=[0-9]", "", $_SERVER['QUERY_STRING']);
		redirect("main.php?".$_SERVER_QUERY_STRING);
	}
	if(isset($_POST['action']) && $_POST['action']=='empty_filters'){
		unset($_SESSION['filters']['trash']);
	}*/
}

if(isset($_GET['by'])){
	$_SESSION['order']['trash']['order_by'] = $_GET['by'];
}
if(isset($_GET['order'])){
	$_SESSION['order']['trash']['order_direction'] = $_GET['order'];
}
if(!isset($_GET['offset'])){
	$_GET['offset'] = 0;
}
if(!isset($_GET['c_offset'])){
	$_GET['c_offset'] = 0;
}
if(!isset($_SESSION['order']['trash']['order_by'])){
	$_SESSION['order']['trash']['order_by'] = "R.last_modif_date";
}
if(!isset($_SESSION['order']['trash']['order_direction']) || strlen($_SESSION['order']['trash']['order_direction'])==0){
	$_SESSION['order']['trash']['order_direction'] = "DESC";
}
if(!isset($_SESSION['order']['paging'])){
	$_SESSION['order']['paging'] = $_paging;
}
if(!isset($_SESSION['order']['c_paging'])){
	$_SESSION['order']['c_paging'] = $_paging;
}

$tpl->setVar('order_by_'.$_SESSION['order']['trash']['order_by'], 1);
$tpl->setVar('order_direction', $_SESSION['order']['trash']['order_direction']);



$table_fields = array();

$arr_view = array('elm_custom'=>1, 'w'=>1, 'button'=>1, 'tpl'=>"<center><a href=\"javascript: $('show_trash_item_main').style.display='block'; PageClass.getPageContent('{$configFile->variable['admin_site_url']}main.php?content=trash&page=item&id=<id>&ajax=1&area=show_trash_item', 'show_trash_item', 1);\"><img src=\"images/preview.gif\" alt=\"\" border=\"0\"></a></center>");
$table_fields[] = array('title'=>$cms_phrases['main']['trash']['view_title'], 'column_name'=>'view', 'editorship'=>1, 'elm_type'=>FRM_CUSTOM, 'no_sort'=>1, 'params'=>$arr_view);


$table_fields[] = array('title'=>$cms_phrases['main']['trash']['title'], 'column_name'=>'title', 'editorship'=>0, 'elm_type'=>FRM_TEXT, 'no_sort'=>1);
$table_fields[] = array('title'=>$cms_phrases['main']['trash']['module'], 'column_name'=>'module_title', 'editorship'=>0, 'elm_type'=>FRM_TEXT);
$table_fields[] = array('title'=>$cms_phrases['main']['trash']['create_date'], 'column_name'=>'create_date', 'editorship'=>0, 'elm_type'=>FRM_DATE);
$table_fields[] = array('title'=>$cms_phrases['main']['trash']['last_modif_date'], 'column_name'=>'last_modif_date', 'editorship'=>0, 'elm_type'=>FRM_DATE);

$arr_reset = array('elm_custom'=>1, 'w'=>1, 'button'=>1, 'tpl'=>"<center><a href=\"javascript: if(confirm('{$cms_phrases['main']['trash']['reset_confirm']}')) PageClass.getPageContent('{$configFile->variable['admin_site_url']}main.php?content=trash&page=list&action=reset&resetid=<id>&ajax=1&area=tpl_grid', 'items_list_grid');\"><img src=\"images/reset.gif\" alt=\"\" border=\"0\"></a></center>");
$table_fields[] = array('title'=>$cms_phrases['main']['trash']['reset_title'], 'column_name'=>'reset', 'editorship'=>1, 'elm_type'=>FRM_CUSTOM, 'no_sort'=>1, 'params'=>$arr_reset);
$arr_delete = array('elm_custom'=>1, 'w'=>1, 'button'=>1, 'tpl'=>"<center><a href=\"javascript: if(confirm('{$cms_phrases['main']['trash']['delete_confirm']}')) PageClass.getPageContent('{$configFile->variable['admin_site_url']}main.php?content=trash&page=list&action=delete&deleteid=<id>&ajax=1&area=tpl_grid', 'items_list_grid');\"><img src=\"images/delete.gif\" alt=\"\" border=\"0\"></a></center>");
$table_fields[] = array('title'=>$cms_phrases['main']['trash']['delete_title'], 'column_name'=>'remove', 'editorship'=>1, 'elm_type'=>FRM_CUSTOM, 'no_sort'=>1, 'params'=>$arr_delete);


include_once(CLASSDIR."grid.class.php");
$grid_obj = & new grid();
$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");


if(isset($_POST['action']) && $_POST['action']=='filter'){
	$_GET['offset'] = 0;
	unset($_SESSION['filters']['trash']);
	foreach($table_fields as $key=>$val){
		if(strlen($_POST['filteritem___'.$val['column_name']]) || is_array($_POST['filteritem___'.$val['column_name']])){
			$_SESSION['filters']['trash'][$val['column_name']] = $_POST['filteritem___'.$val['column_name']];
		}
	}
}
$grid_obj->set_filterParams($_SESSION['filters']['trash']);

$grid_obj->setColumns($table_fields);

//pae($_SESSION['filters']['trash']);
$trash_obj->setWhereClause($_SESSION['filters']['trash']);
$count = $trash_obj->listCount();
$trash_obj->shorten_texts = 20;
//pa($_SESSION['order']['trash']);
$items = $trash_obj->listItems($_GET['id'], $_SESSION['order']['trash']['order_by'], $_SESSION['order']['trash']['order_direction'], ($_GET['offset']<0?0:$_GET['offset'])*$_SESSION['order']['paging'], $_SESSION['order']['paging']);
$trash_obj->shorten_texts = 0;
$trash_obj->setWhereClause();

$grid_obj->setItems($items);
$grid_obj->setItemsCount($count);
$grid_obj->paging_items = $_SESSION['order']['paging'];
$grid_obj->paging($_GET['offset']);
$grid_obj->pagingSelect($IN_ONE_PAGE_LIST);

//include $grid_obj->tpl->parse(); exit;
$tpl_grid = & $grid_obj->tpl;

$tpl_grid->setVar('module.table_name', 'modules');

$grid_obj->grid_data['list_page'] = 'list';
$grid_obj->grid_data['edit_page'] = 'edit';
$grid_obj->grid_data['script'] = 'change_module_item_field';
$grid_obj->grid_data['dragndrop'] = 0;
$grid_obj->grid_data['delete_button'] = 0;
$grid_obj->grid_data['edit_button'] = 0;

$grid_obj->generate();
$tpl->setCodeBlock('items_list_content', 'include $grid_obj->tpl->cacheFile;');


$tpl->setVar('module', $trash_obj->module_info);
$tpl->setVar('module.title', $cms_phrases['top']['trash']);


$tpl->setVar('upload_url', UPLOADURL);

$n = count($IN_ONE_PAGE_LIST);
for($i=0; $i<$n; $i++){
	if($IN_ONE_PAGE_LIST[$i]['value']==$_SESSION['order']['paging']){
		$IN_ONE_PAGE_LIST[$i]['active'] = 1;
	}
}
$tpl->setLoop('items_in_one_page', $IN_ONE_PAGE_LIST);

$tpl->setVar('get', $_GET);

$tpl->setVar('lng', $lng);
$tpl->setVar('easyweb', $_SESSION['easy']);

$tpl->setVar('filter_page', '');

include_once(dirname(__FILE__)."/menu.php");

?>