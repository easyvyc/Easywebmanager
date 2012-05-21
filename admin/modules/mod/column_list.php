<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();

if(!isset($_GET['module_id'])) $_GET['module_id'] = $_GET['id'];


if(!in_array($_GET['module_id'], $admin_obj->modules_rights)){

	if(isset($_GET['action']) && isset($_GET['column_id']) && $_GET['action']!='change_order' && $_GET['action']!='delete'){
	
		$modules->loadColumn($_GET['column_id']);
		$column_data = $modules->data;
		
		if(!ereg('text', strtolower($column_data['column_type'])) && !ereg('blob', strtolower($column_data['column_type']))){
		    $modules->changeStatus($configFile->variable['sb_module_info'], $_GET['action'], $_GET['column_id']);
		    if($_GET['action']=='index'){
		    	$modules->loadModule($_GET['module_id']);
		    	$module_data = $modules->data;
		    	if($column_data['index']==0){
		    		$sql = "ALTER TABLE {$configFile->variable['pr_code']}_{$module_data['table_name']} ADD INDEX ( {$column_data['column_name']} )";
		    	}else{
		    		$sql = "ALTER TABLE {$configFile->variable['pr_code']}_{$module_data['table_name']} DROP INDEX {$column_data['column_name']} ";
		    	}
		    	$database->exec($sql, __FILE__, __LINE__);
		    }
		}elseif($_GET['action']!='index'){
			
	        if($_SESSION['admin']['permission']!=1 && in_array($_GET['action'], $this->column_fields_for_superadmin)){
	        }else{
	        	$modules->changeStatus($configFile->variable['sb_module_info'], $_GET['action'], $_GET['column_id']);
	        }
			
		}
	}
	
	if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
	    $modules->changeColumnsOrder($_GET['firstid'], $_GET['lastid']);
	}
	
	if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['deleteid'])){
	    $modules->deleteColumn($_GET['deleteid']);
	}
	
	
	$_GET['module'] = 'settings';
	if(isset($_POST['action']) && $_POST['action']=='paging'){
		$_GET['offset'] = 0;
		$_SESSION['order']['paging'] = $_POST['paging_items'];
	}
	if(!isset($_SESSION['order']['paging'])){
		$_SESSION['order']['paging'] = DEFAULT_PAGING;
	}
	if(isset($_GET['by'])){
		$_SESSION['order']['columns']['order_by'] = $_GET['by'];
	}
	if(isset($_GET['order'])){
		$_SESSION['order'][$_GET['columns']]['order_direction'] = $_GET['order'];
	}
	if(!isset($_SESSION['order']['columns']['order_by'])){
		$_SESSION['order']['columns']['order_by'] = "sort_order";
	}
	if(!isset($_SESSION['order']['columns']['order_direction']) || strlen($_SESSION['order']['columns']['order_direction'])==0){
		$_SESSION['order']['columns']['order_direction'] = "ASC";
	}		
	
	$table_list = array();
	$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['column_title'], 'column_name'=>'title', 'editorship'=>0, 'elm_type'=>FRM_TEXT, 'no_sort'=>1);
	$table_list[] = array('title'=>$cms_phrases['main']['settings']['columns']['column_name'], 'column_name'=>'column_name', 'editorship'=>0, 'elm_type'=>FRM_TEXT, 'no_sort'=>1);
	$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['require'], 'column_name'=>'require', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX, 'no_sort'=>1);
	$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['list'] , 'column_name'=>'list', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX, 'no_sort'=>1);
	$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['multilng'], 'column_name'=>'multilng', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX, 'no_sort'=>1);

	if($_SESSION['admin']['permission']==1){
		$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['editable'], 'column_name'=>'editable', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX, 'no_sort'=>1);
		$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['superadmin'], 'column_name'=>'super_user', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX, 'no_sort'=>1);
		$table_list[] = array('title'=>$cms_phrases['main']['settings']['module']['index'], 'column_name'=>'index', 'editorship'=>1, 'elm_type'=>FRM_CHECKBOX, 'no_sort'=>1);
	}
	
	
	include_once(CLASSDIR."grid.class.php");
	$grid_obj = & new grid();
	$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
	$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");
	$grid_obj->setColumns($table_list);
	
	
	$items = $modules->listColumns($_GET['module_id'], $_SESSION['order']['columns']['order_by'], $_SESSION['order']['columns']['order_direction']);
	$grid_obj->setItems($items);
	$grid_obj->setItemsCount(count($items));
	$grid_obj->paging_items = count($items);
	$grid_obj->paging(0);
	$grid_obj->pagingSelect(0);
	
	//include $grid_obj->tpl->parse(); exit;
	$tpl_grid = & $grid_obj->tpl;
	
	$tpl_grid->setVar('module.table_name', 'modules');
	
	$grid_obj->grid_data['list_page'] = 'column_list';
	$grid_obj->grid_data['edit_page'] = 'edit_column';
	$grid_obj->grid_data['script'] = 'change_column_item_field';
	$grid_obj->grid_data['select_button'] = 0;
	
	$grid_obj->generate();
	$tpl->setCodeBlock('items_list_content', 'include $grid_obj->tpl->cacheFile;');
	
}


$tpl->setVar('empty', (empty($items)?1:0));

$tpl->setVar('module_id', $_GET['module_id']);

$modules->loadModule($_GET['module_id']);
$tpl->setVar('module_data', $modules->data);

$tpl->setVar('super_admin', $_SESSION['admin']['permission']==1?1:0);

include_once(dirname(__FILE__)."/menu.php");
        
?>