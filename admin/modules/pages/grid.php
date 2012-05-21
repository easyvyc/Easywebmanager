<?php
/*
 * Created on 2008.07.20
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$tpl_grid->tplVars = $tpl->tplVars;

if(isset($_POST['action']) && $_POST['action']=='paging'){
	$_GET['offset'] = 0;
	$_SESSION['order']['paging'] = $_POST['paging_items'];
}
if(!isset($_SESSION['order']['paging'])){
	$_SESSION['order']['paging'] = DEFAULT_PAGING;
}


// 
if(isset($_GET['by'])){
	$_SESSION['order'][$_GET['module']]['order_by'] = $_GET['by'];
}
if(isset($_GET['order'])){
	$_SESSION['order'][$_GET['module']]['order_direction'] = $_GET['order'];
}
if(!isset($_SESSION['order'][$_GET['module']]['order_by'])){
	$_SESSION['order'][$_GET['module']]['order_by'] = strlen($record->module_info['default_sort'])>0?$record->module_info['default_sort']:"R.sort_order";
}
if(!isset($_SESSION['order'][$_GET['module']]['order_direction']) || strlen($_SESSION['order'][$_GET['module']]['order_direction'])==0){
	$_SESSION['order'][$_GET['module']]['order_direction'] = (strlen($record->module_info['default_sort_direction'])>0?$record->module_info['default_sort_direction']:"ASC");
}
$tpl_grid->setVar('order_by_'.$_SESSION['order'][$_GET['module']]['order_by'], 1);



if(!isset($_GET['offset'])){
	$_GET['offset'] = 0;
}


if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
    $record->loadItem($_GET['deleteid']);
    $record->delete($_GET['deleteid']);
   	$tpl_grid->setVar('tree_reload', 1);
}


if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
    $record->changeOrder($_GET['firstid'], $_GET['lastid']);
    $record->loadItem($_GET['firstid']);
    $tpl_grid->setVar('tree_reload', 1);
}


if(!empty($_POST)){

	$_SERVER_QUERY_STRING = ereg_replace("\&offset=[0-9]", "", $_SERVER['QUERY_STRING']);
	$_SERVER_QUERY_STRING = ereg_replace("\&c_offset=[0-9]", "", $_SERVER['QUERY_STRING']);

	if(isset($_GET['action']) && $_GET['action']=='action_with_selected_items'){
		if($_GET['action_choice']=="delete"){
			foreach($_POST['chk'] as $key=>$val){
				$record->delete($_POST['chk'][$key]);
			}
		}
		if($_GET['action_choice']!="delete"){
			foreach($_POST['chk'] as $key=>$val){
				$record->changeFieldStatus($_SESSION['site_lng'], $_GET['action_choice'], $_POST['chk'][$key]);
			}
		}

		$tpl_grid->setVar('tree_reload', 1);
		redirect("main.php?".$_SERVER_QUERY_STRING."&tree_reload=1");
	}
}



$record->getTableFields(0);
$count = $record->listItemsElementsCount($_GET['id']);
//$_GET['id'], $_SESSION['order'][$_GET['module']]['order_by'], $_SESSION['order'][$_GET['module']]['order_direction'],
//pae($_SESSION['order']);
$list_items = $record->listItemsElements($_GET['id'], $_SESSION['order'][$_GET['module']]['order_by'], $_SESSION['order'][$_GET['module']]['order_direction'], ($_GET['offset']<0?0:$_GET['offset'])*$_SESSION['order']['paging'], $_SESSION['order']['paging']);
$n = count($list_items);
$CONTENT = $_GET['content'];
for($i=0; $i<$n; $i++){
	
	$context = array();
	
	$context[] = array('img'=>($list_items[$i]['lng_saved']==1?'edit':'not_saved'), 'title'=>$cms_phrases['modules']['context_menu']['edit'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id={$list_items[$i]['id']}");
	$context[] = array('img'=>'inner', 'title'=>$cms_phrases['modules']['context_menu']['view_inner'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=list&id={$list_items[$i]['id']}");
	$context[] = array('img'=>'new_element', 'title'=>$cms_phrases['modules']['context_menu']['create_inner'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id=0&new=1&parent_id={$list_items[$i]['id']}");
	
	if($record->module_info['table_name']=='pages'){
		$context[] = array('img'=>'meta', 'title'=>$cms_phrases['main']['pages']['meta_tags'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=list&id={$list_items[$i]['id']}&meta=1");
	}
	
	$context[] = array('img'=>'duplicate', 'title'=>$cms_phrases['main']['common']['duplicate_title'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=edit&id=0&parent_id={$list_items[$i]['parent_id']}&new=1&duplicate={$list_items[$i]['id']}");
	
	if($list_items[$i]['mod_id']){
		$context[] = array('img'=>'mod', 'title'=>$cms_phrases['modules']['context_menu']['module'], 'action'=>"main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=module&id={$list_items[$i]['id']}&parent_id={$list_items[$i]['id']}");
	}
	
	$a_action = "javascript: void(ajaxChangeFieldCheckbox('{$configFile->variable['site_url']}', document.getElementById('chk_{$list_items[$i]['id']}_active').value, {$list_items[$i]['id']}, {$list_items[$i]['parent_id']}, 'active', '{$record->module_info['table_name']}', '{$_SESSION['site_lng']}', event));";
	if($list_items[$i]['active']==1)
		$context[] = array('img'=>'status_0', 'title'=>$cms_phrases['modules']['context_menu']['hide'], 'action'=>$a_action);
	else
		$context[] = array('img'=>'status_1', 'title'=>$cms_phrases['modules']['context_menu']['show'], 'action'=>$a_action);
	$context[] = array('img'=>'delete', 'title'=>$cms_phrases['modules']['context_menu']['delete'], 'action'=>"javascript: if(confirm('{$cms_phrases['modules']['context_menu']['delete_confirm']}')) top.content.location='{$configFile->variable['admin_site_url']}main.php?content=$CONTENT&module={$record->module_info['table_name']}&page=list&action=delete&deleteid={$list_items[$i]['id']}&id={$list_items[$i]['parent_id']}';");
	
	$list_items[$i]['context'] = $context;
}

$tpl_grid->setLoop('items', @$list_items);

$tpl_grid->setVar('not_empty_elements', $count);

// paging for items list
$paging_arr = generatePaging($_GET['offset'], $count, $_SESSION['order']['paging'], RESULTS_PAGING);
$tpl_grid->setLoop('paging', $paging_arr['loop']);
$tpl_grid->setVar('paging', $paging_arr);


foreach($record->table_list as $key=>$val){
	if(($record->table_list[$i]['super_user']==0 || $record->table_list[$i]['super_user']==1 && $_SESSION['admin']['permission']==1)){
		
		$record->table_list[$i]['editable'] = 1;

		switch($val['elm_type']){
			case FRM_TEXT:
			case FRM_TEXTAREA:
			case FRM_HTML:
				$record->table_list[$key]['w'] = 10;
				$record->table_list[$key]['elm_text'] = 1;
				break;
			case FRM_DATE:
				$record->table_list[$key]['w'] = 2;
				break;
			case FRM_BUTTON:
			case FRM_SUBMIT:
				$record->table_list[$key]['w'] = 2;
				break;
			case FRM_LIST:
			case FRM_TREE:
				$record->table_list[$key]['w'] = 2;
				break;
			case FRM_IMAGE:
			case FRM_FILE:
				$record->table_list[$key]['w'] = 3;
				break;
			case FRM_RADIO:
			case FRM_SELECT:
			case FRM_CHECKBOX_GROUP:
				$record->table_list[$key]['w'] = 5;
				$record->table_list[$key]['elm_choice'] = 1;
				$items_list = $form_obj->getSelectItems($record->table_list[$key]);
				$record->table_list[$key]['choice_arr'] = $items_list;
				break;
			case FRM_CHECKBOX:
				$record->table_list[$key]['button'] = 1;
				$record->table_list[$key]['elm_button'] = 1;
				$record->table_list[$key]['w'] = 1;
				break;
			default: 
				$record->table_list[$key]['elm_text'] = 1;
				$record->table_list[$key]['w'] = 10;
		}
		
		//$record->table_list[$key-]['second_column_name'] = $record->table_list[$key+1]['column_name'];

		//$record->table_list[$key]['resizer'] = (strlen($record->table_list[$key+1]['column_name'])?1:0);

		/*if(isset($_SESSION['order'][$_GET['module']]['order_by']) && $_SESSION['order'][$_GET['module']]['order_by']==$val['column_name']){
			$record->table_list[$key]['___sort___'] = 1;
		}
		$record->table_list[$key]['___'.$_SESSION['order'][$_GET['module']]['order_direction'].'___'] = 1;*/
		
		if(isset($_SESSION['order'][$_GET['module']]['order_by']) && $_SESSION['order'][$_GET['module']]['order_by']==$val['column_name'] && $_SESSION['order'][$_GET['module']]['order_direction']=='ASC'){
			$record->table_list[$key]['sort_up'] = 1;
		}
		if(isset($_SESSION['order'][$_GET['module']]['order_by']) && $_SESSION['order'][$_GET['module']]['order_by']==$val['column_name'] && $_SESSION['order'][$_GET['module']]['order_direction']=='DESC'){
			$record->table_list[$key]['sort_down'] = 1;
		}
		
		$record->table_list[$key]['I'] = $key;
		$table_list[] = $record->table_list[$key];

		if(count($table_list)>1)
			$table_list[count($table_list)-2]['second_column_name'] = $record->table_list[$key]['column_name'];
		
	}
	
	
}

$tpl_grid->setLoop('fields', $table_list);


$n = count($IN_ONE_PAGE_LIST);
for($i=0; $i<$n; $i++){
	if($IN_ONE_PAGE_LIST[$i]['value']==$_SESSION['order']['paging']){
		$IN_ONE_PAGE_LIST[$i]['active'] = 1;
	}
}
$tpl_grid->setLoop('items_in_one_page', $IN_ONE_PAGE_LIST);


$tpl_grid->setVar('config', $configFile->variable);
$tpl_grid->setVar('get', $_GET);


?>