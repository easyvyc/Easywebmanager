<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_subscribers extends actions {

    function __construct() {
    	parent::__construct();
    }
    
    function _import(){

    	global $cms_phrases, $main_configFile, $module;
    	
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		$form->debug=0;
		
		$subs_obj = $this->registry->modules->create($_GET['module']);
		
		$form->addField('category', $subs_obj->_table_fields['category']);
		
		$form->addField('emails_text', array('title'=>$cms_phrases['main']['subscribers']['import_text'], 'type'=>FRM_TEXTAREA, 'value'=>'', 'editorship'=>1));
		$form->addField('emails_file', array('title'=>$cms_phrases['main']['subscribers']['import_file'], 'type'=>FRM_FILE, 'value'=>'', 'editorship'=>1));

		$form->addField("action", array('type'=>'hidden', 'value'=>'import', 'title'=>'', 'require'=>0));
		$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));		
		
		$form->formName = 'import';
		$form->formAction = "ajax.php?get=catalog/actions&action=import&module={$_GET['module']}&id={$_GET['id']}";

		if(!empty($_POST)){
			if(isset($_POST['action']) && $_POST['action']=='import'){
			    $form->validate($_POST);
			    if($form->error!=1){
					
					$counter = 0;
					$regexp = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
					if(strlen($_POST['emails_text'])){
					    preg_match_all($regexp, $_POST['emails_text'], $m);
						$emails = isset($m[0]) ? $m[0] : array();
						foreach($emails as $val){
							if($subs_obj->insertEmail($val, $_POST['category'])){
								$counter++;
							}
						}
					}
					if(is_uploaded_file($_FILES['file_emails_file']['tmp_name'])){
				 		$str = file_get_contents(UPLOADDIR.$form->elements['emails_file']['value']);
				 		preg_match_all($regexp, $str, $m);
						$emails = isset($m[0]) ? $m[0] : array();
						foreach($emails as $val){
							if($subs_obj->insertEmail($val, $_POST['category']))
								$counter++;
						}
				 	}
				 	$form->removeUploadedFiles();
				    $form->create_in_iframe = 1;
			    	//redirect("{$configFile->variable['site_admin_url']}ajax.php?get=catalog/actions&action=import&module={$_GET['module']}&id={$_GET['id']}");
			    }else{
			    	$data = $_POST;
			    }
			}	
		}
		
		if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='import'){
			header("Content-Type: text/html; charset=utf-8");
			if($form->error!=1){
				echo "<script type=\"text/javascript\"> top.content.document.getElementById('EDIT_area__action').innerHTML='".preg_replace("/{c}/", $counter, $cms_phrases['main']['subscribers']['inserted_emails_count'])."'; </script>";
				exit;
			}else{
				$form_data = $form->construct_form();
			}
		}else{
			$form_data = $form->construct_form();
		}

						
		echo $form_data;
		exit;

    	
    }
    
}
?>