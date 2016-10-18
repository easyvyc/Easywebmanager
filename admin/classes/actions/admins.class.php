<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_admins extends actions {

    function __construct() {
    	
    	parent::__construct("admins");
        
        $this->remove("copy");

//		$this->add("rights", array(
//									'title'=>cms::$phrases['main']['admins']['rights_title'], 
//									'img'=>'rights',
//									'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'rights', '{id}'));"
//							),
//					 2);
//		$this->add("logins", array(
//									'title'=>cms::$phrases['main']['admins']['login_stats'], 
//									'img'=>'logins',
//									'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'logins', '{id}'));"
//							),
//					 3);
					 
    }
    
    function _rights(){

    	global $cms_phrases, $main_configFile, $module;
    	
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		
		$record = $this->registry->model->create($_GET['module']);
		
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