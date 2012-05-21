<?php

include_once(CLASSDIR."modules/pages.class.php");
$pages = new pages("pages");

include_once(CLASSDIR."forms.class.php");
$form = new forms();

$form->imgDir= ICOTPLDIR;
$form->imgUrl= ICOTPLURL;

$_GET['tpl_id'] = $_GET['id'];

$data = $pages->getTemplateById($_GET['tpl_id']);

if($_GET['tpl_id']==0){
	$data['isNew'] = 1;
}else{
	$data['isNew'] = 0;
	$filename = TPLDIR."templates/".$data['name'].".tpl";
	$file = fopen($filename, "r");
	$data['tpl_file'] = fread($file, filesize($filename));
	fclose($file);
}

$form->addField("action", 	array('type'=>'hidden', 'value'=>'save', 'title'=>'', 'require'=>0));
$form->addField("id", 		array('type'=>'hidden', 'value'=>$data['id'], 'title'=>'', 'require'=>0));
$form->addField("isNew", 	array('type'=>'hidden', 'value'=>$data['isNew'], 'title'=>'', 'require'=>0));

$form->addField("name", array('type'=>'text', 'value'=>$data['name'], 'title'=>'Pavadinimas', 'require'=>1, 'editorship'=>1));
$form->addField("file1", array('type'=>'image', 'value'=>$data['file1'], 'title'=>'Ikona', 'require'=>1, 'editorship'=>1, 'extra_params'=>'prefix||size=250x200||quality=90', 'list_values'=>array("dir"=>"files/ico_tpl/", "tpl_file"=>"settings/templates/ico_tpl.tpl")));

$form->addField("tmpl_image_map", array('type'=>'textarea', 'value'=>$data['tmpl_image_map'], 'title'=>'Map\'as', 'require'=>1, 'html'=>1, 'escape'=>1, 'editorship'=>1, 'extra_params'=>"style='height:200px;'"));
//if($data['isNew']!=1)
//$form->addField("tpl_file", array('type'=>'html', 'value'=>$data['tpl_file'], 'title'=>'Html', 'require'=>1, 'editorship'=>1));
$form->addField("defaultas", array('type'=>'checkbox', 'value'=>$data['defaultas'], 'title'=>'Default', 'checked'=>$data['defaultas'], 'require'=>0, 'editorship'=>1));

$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action']=='save'){
	    $form->validate($_POST);
	    if($form->error!=1){
	    	if(isset($_POST['delete_file1'])){
	    		$form->img->remove($_POST['old_file1']);
	    		$_POST['file1'] = "";
	    	}
		    $id = $pages->saveTemplate($_POST);
		    header("Location: main.php?content=settings&page=template&tpl_id=$id");
		    exit;
	    }else{
	    	$data = $_POST;
	    }
	}
}

$tpl->setVar('admin_img_url', ICOTPLURL);

$form_data = $form->construct_form();
$tpl->setVar('form', $form_data);

include_once(dirname(__FILE__)."/menu.php");

?>
