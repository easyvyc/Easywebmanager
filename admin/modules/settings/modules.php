<?php

include_once(CLASSDIR."module.class.php");
$modules = new module();


if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action']!='change_order' && $_GET['action']!='delete'){
	if(!in_array($_GET['id'], $admin_obj->modules_rights))
    
        if($_SESSION['admin']['permission']!=1 && in_array($action, $this->module_fields_for_superadmin)){
        }else{
        	$modules->changeStatus($configFile->variable['sb_module'], $_GET['action'], $_GET['id']);
        }
    	
}

if(isset($_GET['action']) && $_GET['action']=='change_order' && isset($_GET['firstid']) && isset($_GET['lastid'])){
    $modules->changeOrder($_GET['firstid'], $_GET['lastid']);
}

if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['id'])){
    if(!in_array($_GET['id'], $admin_obj->modules_rights))
    	$modules->deleteModule($_GET['id']);
}

$items = $modules->listModules();
if($_SESSION['admin']['permission']!=1){
	$n = count($items);
	for($i=0; $i<$n; $i++){
		if($items[$i]['admin_catalog']==1 && !in_array($items[$i]['id'], $admin_obj->modules_rights))
			$items_[] = $items[$i];
	}
}else{
	$items_ = $items;
}
$tpl->setLoop('items', $items_);

$tpl->setVar('empty', empty($items_)?1:0);

$tpl->setVar('super_admin', $_SESSION['admin']['permission']==1?1:0);

include_once(dirname(__FILE__)."/menu.php");
        
?>