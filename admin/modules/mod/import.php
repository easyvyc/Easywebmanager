<?php
/*
 * Created on 2009.11.20
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(CLASSDIR."forms.class.php");
$form = new forms();
$form->debug=0;

$form->addField("action", array('type'=>FRM_HIDDEN, 'value'=>'import'));
$form->addField("file", array('type'=>FRM_FILE, 'title'=>"File", 'editorship'=>1, 'require'=>1));
$form->addField("submit", array('type'=>FRM_SUBMIT, 'default_value'=>$cms_phrases['main']['form']['submit']));

if(!empty($_POST)){
	
	if(isset($_POST['action']) && $_POST['action']=='import'){
	    $form_data = $form->validate($_POST);
	    if($form->error!=1){
		    
	    	eval('$arr=unserialize('.file_get_contents(UPLOADDIR.$form->elements['file']['value']).');');
		    
		    $form->removeUploadedFiles();
		    
		    include_once(CLASSDIR."module.class.php");
		    $module_obj = new module();
		    $module_obj->importModule($arr);
		    
		    //redirect("main.php?content={$_GET['content']}&page={$_GET['page']}&id={$_GET['id']}");
		    
		    echo "<script type=\"text/javascript\">";
		    echo "parent.document.getElementById('import_success').style.display='block'; parent.document.getElementById('import_form').style.display='none';";
		    echo "</script>";
		    exit;
		    
		}else{
			$form->error = 1;
			$form->elements['file']['style'] = "error";
			$form->elements['file']['show_error'] = 1;
		}

	}else{
	    $_POST = $form->elements;
	}
	$lng = $_POST['language'];
}
  

$form_data = $form->construct_form();
$tpl->setVar('form', $form_data);

$tpl->setVar('lng', $_SESSION['site_lng']);

$tpl->setVar('filter_page', '');


include_once(dirname(__FILE__)."/menu.php");


?>