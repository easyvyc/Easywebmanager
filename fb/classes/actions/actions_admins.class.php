<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_admins extends actions {

    function __construct() {
    	
    	parent::__construct();
    	
    }
    
    function _logins(){
    	
    	global $templateVariables, $cms_phrases;
    	
    	$record = $this->main_object->create("admins");
    	
		if(isset($_POST['action']) && $_POST['action']=='paging'){
			$_GET['offset'] = 0;
			$_SESSION['order']['paging'] = $_POST['paging_items'];
		}    	
    	
		include_once(CLASSDIR."grid.class.php");
		$grid_obj = & new grid();
		//$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
		//$grid_obj->set_filterParams($_SESSION['filters'][$record->module_info['table_name']]);
		$grid_obj->setTpl(DOCROOT.$this->config->variable['admin_dir']."templates/grid.tpl", "templateVariables");
		$table_fields = array();
		$table_fields[] = array('column_name'=>'login_time', 'title'=>$cms_phrases['main']['admins']['login_time'], 'elm_type'=>FRM_DATE, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
		$table_fields[] = array('column_name'=>'logout_time', 'title'=>$cms_phrases['main']['admins']['logout_time'], 'elm_type'=>FRM_DATE, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
		$table_fields[] = array('column_name'=>'all_time', 'title'=>$cms_phrases['main']['admins']['past_time'], 'elm_type'=>FRM_TEXT, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
		$table_fields[] = array('column_name'=>'ipaddress', 'title'=>$cms_phrases['main']['admins']['ipaddress'], 'elm_type'=>FRM_TEXT, 'editorship'=>0, 'w'=>5, 'no_sort'=>1);
		$grid_obj->setColumns($table_fields);
		
		//$record->setWhereClause($grid_obj->columns);
		$count = $record->getAdminStatCount($_GET['id']);
		$list_items = $record->getAdminStat($_GET['id'], ($_GET['offset']<0?0:$_GET['offset'])*$_SESSION['order']['paging'], $_SESSION['order']['paging']);
		
		$grid_obj->setItems($list_items);
		$grid_obj->setItemsCount($count);
		$grid_obj->paging_items = $_SESSION['order']['paging'];
		$grid_obj->paging($_GET['offset']);
		$grid_obj->pagingSelect($GLOBALS['IN_ONE_PAGE_LIST']);
		
		
		$grid_obj->grid_data['edit_button'] = 0;
		$grid_obj->grid_data['dublicate_button'] = 0;
		$grid_obj->grid_data['delete_button'] = 0;
		$grid_obj->grid_data['select_button'] = 0;
		$grid_obj->grid_data['filter_form'] = 0;
		$grid_obj->grid_data['dragndrop'] = 0;
		
		$grid_obj->grid_data['grid_name'] = 'admin_logins';
		$grid_obj->grid_data['list_page'] = 'logins';
		$grid_obj->grid_data['edit_page'] = 'logins';
		
		
		$grid_obj->tpl->setVar('module', $record->module_info);
		$grid_obj->tpl->setVar('parent_id', $_GET['id']);
		
		$grid_obj->generate();
		echo "<div id='{$grid_obj->grid_data['grid_name']}_grid'>";
		include $grid_obj->tpl->cacheFile;
		echo "</div>";
		exit;
	    	
    }

    function _rights(){

    	global $main_object, $cms_phrases, $main_configFile, $module;
    	
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		
		$record = $main_object->create($_GET['module']);
		
		$record->loadItem($_GET['id']);
		
		$lng_rights = $record->loadLanguageRights($_GET['id']);
		$admin_lng_rights = explode("::", $_SESSION['admin']['lng_rights']);
		
		$arr = array();
		foreach($main_configFile->variable['default_page'] as $key => $val){
			$arr['readonly'] = 0;
			$arr['id'] = $val;
			$arr['title'] = strtoupper($key);
			$arr['value'] = $key;
			$arr['checked'] = (in_array($arr['value'], $lng_rights)?0:1);
			if(in_array($arr['value'], $lng_rights)){
				$lang_arr_values[] = $arr['id'];
			}
			if(in_array($arr['value'], $admin_lng_rights)){
				$arr['readonly'] = 1;
			}
			$lang_arr[] = $arr;
				
		}
		//pae($lng_rights);
		$form->addField('languages', array('title'=>$cms_phrases['main']['settings']['website_languages'], 'type'=>'checkbox_group', 'value'=>$lang_arr_values, 'list_values'=>$lang_arr, 'editorship'=>1));
		

		$mod_rights = $record->loadModuleRights($_GET['id']);
		$admin_mod_rights = $record->loadModuleRights($_SESSION['admin']['id']);
		
		$arr = array();
		$list = $record->module->listModules();
		foreach($list as $key => $val){
			if($val['disabled'] != 1){
				$arr = $val;
				$arr['value'] = $val['id'];
				$arr['checked'] = (in_array($val['id'], $mod_rights)?0:1);
				$arr['editorship'] = (in_array($val['id'], $admin_mod_rights)?0:1);
				$mod_arr[] = $arr;
				if(in_array($val['id'], $mod_rights))
					$mod_arr_values[] = $arr['id'];
			}
		}
		
		
		//$form->addField("sep_first_sep", 	array('type'=>FRM_SEPARATOR, 'title'=>"Moduliai", 'block_extra_params'=>"class='sep_top_border'"));
		$n = count($mod_arr);
		
		for($i=0; $i<$n; $i++){
			$form->addField("modules[{$mod_arr[$i]['table_name']}]", 	array('type'=>FRM_CHECKBOX, 'title'=>$mod_arr[$i]['title'], 'default_value'=>$mod_arr[$i]['id'], 'value'=>$mod_arr[$i]['checked'], 'onclick'=>'', 'editorship'=>$mod_arr[$i]['editorship']));
		}
		
		$form->addField("admin_id", 	array('type'=>'hidden', 'value'=>$_GET['id'], 'title'=>'', 'require'=>0));

		$form->addField("action", array('type'=>'hidden', 'value'=>'rights', 'title'=>'', 'require'=>0));
		$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));		
		
		$form->formName = 'rights';
		$form->formAction = "javascript: void(top.content.PageClass.submitForm('{$configFile->variable['site_admin_url']}ajax.php?get=catalog/actions&action=rights&module={$_GET['module']}&id={$_GET['id']}', 'EDIT_area__action', top.content.document.forms['rights']));";

		if(!empty($_POST)){
			if(isset($_POST['action']) && $_POST['action']=='rights'){
			    $form->validate($_POST);
			    if($form->error!=1){

			    	$record->saveLanguageRights($_GET['id'], $_POST['languages']);
			    	
			    	foreach($_POST['mod'] as $key => $val){
			    		$post_data['modules'][] = $val;
			    	}
					$record->saveModuleRights($_GET['id'], $_POST['modules']);
			    	
			    	redirect("{$configFile->variable['site_admin_url']}ajax.php?get=catalog/actions&action=rights&module={$_GET['module']}&id={$_GET['id']}");
			    }else{
			    	$data = $_POST;
			    }
			}	
		}
		
		$form_data = $form->construct_form();
		
		
						
		echo $form_data;
		exit;

    }
        
}

?>