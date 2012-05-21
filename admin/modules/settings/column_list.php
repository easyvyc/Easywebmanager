<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();

if(!isset($_GET['module_id'])) $_GET['module_id'] = $_GET['id'];

if(!in_array($_GET['module_id'], $admin_obj->modules_rights)){

	if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action']!='change_order' && $_GET['action']!='delete'){
	
		$modules->loadColumn($_GET['id']);
		$column_data = $modules->data;
		
		if(!ereg('text', strtolower($column_data['column_type'])) && !ereg('blob', strtolower($column_data['column_type']))){
		    $modules->changeStatus($configFile->variable['sb_module_info'], $_GET['action'], $_GET['id']);
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
	        	$modules->changeStatus($configFile->variable['sb_module_info'], $_GET['action'], $_GET['id']);
	        }
			
		}
	}
	
	if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
	    $modules->changeColumnsOrder($_GET['firstid'], $_GET['lastid']);
	}
	
	if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['id'])){
	    $modules->deleteColumn($_GET['id']);
	}
	
	
	$items = $modules->listColumns($_GET['module_id']);
	$tpl->setLoop('items', $items);

	
}


$tpl->setVar('empty', (empty($items)?1:0));

$tpl->setVar('module_id', $_GET['module_id']);

$modules->loadModule($_GET['module_id']);
$tpl->setVar('module_data', $modules->data);

$tpl->setVar('super_admin', $_SESSION['admin']['permission']==1?1:0);

include_once(dirname(__FILE__)."/menu.php");
        
?>