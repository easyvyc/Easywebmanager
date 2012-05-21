<?php
/*
 * Created on 2009.03.09
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
//error_reporting(E_ALL);

include_once(CLASSDIR."filemanager.class.php");
$filemanager_obj = new filemanager();


if(is_uploaded_file($_FILES['upload']['tmp_name'])){
	$arr = explode(".", $_FILES['upload']['name']);
	$ext = $arr[(count($arr)-1)];
	$FILE_UPLOAD_ERROR = 0;
	if(in_array($ext, $denied_upload_files)){
		$FILE_UPLOAD_ERROR = 1;
		$tpl->setVar('error', 1);
		$tpl->setVar('error_msg', $cms_phrases['main']['common']['wrong_extension_file']);
	}
	if($_FILES['upload']['error']!=0){
		$FILE_UPLOAD_ERROR = 1;
		$tpl->setVar('error', 1);
		$tpl->setVar('error_msg', $cms_phrases['main']['common']['too_big_file']);
	}
	if($FILE_UPLOAD_ERROR!=1){
		$filemanager_obj->path = $filemanager_obj->dir.urldecode($_GET['path'])."/";
		$filename = $filemanager_obj->upload($_FILES['upload']);
		//move_uploaded_file($_FILES['upload']['tmp_name'], $filemanager_obj->dir.urldecode($_GET['path']."/".$filename));
	}
}

if(isset($_GET['deletefile'])){
	$filemanager_obj->path = $filemanager_obj->dir.urldecode($_GET['path'])."/";
	if($_GET['multiple']==1){
		$files_arr = explode("::", $_GET['deletefile']);
		foreach($files_arr as $file){
			if(strlen($file)) $filemanager_obj->remove(urldecode($file));
		}		
	}else{
		$filemanager_obj->remove(urldecode($_GET['deletefile']));
	}
	unset($_GET['deletefile']);
	redirect("main.php?".http_build_query($_GET));
}

if(isset($_GET['downloadfile'])){
	if($_GET['multiple']==1){
		header('Content-Disposition: attachment; filename="Files.zip"');
		$files_arr = explode("::", $_GET['downloadfile']);
		
		//readfile($filemanager_obj->dir.urldecode($_GET['path'])."/".urldecode($_GET['downloadfile']));
	}else{
		header('Content-Disposition: attachment; filename="'.urldecode($_GET['downloadfile']).'"');
		readfile($filemanager_obj->dir.urldecode($_GET['path'])."/".urldecode($_GET['downloadfile']));
	}
}

if(isset($_GET['extractfile'])){
	$filemanager_obj->unzip($filemanager_obj->dir.urldecode($_GET['path'])."/".urldecode($_GET['extractfile']), $filemanager_obj->dir.urldecode($_GET['path'])."/");
	unset($_GET['extractfile']);
	redirect("main.php".http_build_query($_GET));
}


$list = $filemanager_obj->listFiles($filemanager_obj->dir.urldecode($_GET['path']));
foreach($list as $key=>$val){
	$list[$key]['file'] = urlencode("files/".urldecode($_GET['path'])."/".$val['title']);
	
	$list[$key]['alt_text'] = "{$list[$key]['title']} (".($list[$key]['is_img']?"{$list[$key]['size_width']}x{$list[$key]['size_height']}; ":"")."{$list[$key]['size_kb']}Kb)";
	
	$list[$key]['context'][] = array('title'=>$cms_phrases['modules']['context_menu']['select'], 'img'=>'reset', 'action'=>"selectFile('{$val['title']}', '{$main_configFile->variable['site_url']}', '{$main_configFile->variable['project_dir']}', 'files/".urldecode($_GET['path'])."/');");
	if(in_array(strtolower($list[$key]['ext']), $valid_images)){
		$list[$key]['context'][] = array('title'=>$cms_phrases['modules']['context_menu']['show'], 'img'=>'preview', 'action'=>"window.open('{$filemanager_obj->url}".urldecode($_GET['path'])."/{$val['title']}');");
		$list[$key]['context'][] = array('title'=>$cms_phrases['modules']['context_menu']['edit'], 'img'=>'edit', 'action'=>"editImageForm('{$val['title']}', '".urldecode($_GET['path'])."');");
		$list[$key]['img'] = 1;
	}
	if(in_array(strtolower($list[$key]['ext']), $valid_archives)){
		$list[$key]['context'][] = array('title'=>$cms_phrases['modules']['context_menu']['extract'], 'img'=>'zip', 'action'=>"location='main.php?content={$_GET['content']}&page={$_GET['page']}&path={$_GET['path']}&extractfile={$val['title']}';");
		$list[$key]['extract'] = 1;
	}
	$list[$key]['context'][] = array('title'=>$cms_phrases['modules']['context_menu']['download'], 'img'=>'export', 'action'=>"location='main.php?content={$_GET['content']}&page={$_GET['page']}&path={$_GET['path']}&downloadfile={$val['title']}';");
	$list[$key]['context'][] = array('title'=>$cms_phrases['modules']['context_menu']['delete'], 'img'=>'delete', 'action'=>"if(confirm('{$cms_phrases['modules']['context_menu']['delete_confirm']}')) location='main.php?content={$_GET['content']}&page={$_GET['page']}&path={$_GET['path']}&deletefile={$val['title']}';");
	
}
$tpl->setLoop('files', $list);

$arr = explode("/", urldecode($_GET['path']));
if(strlen($_GET['path'])>0){
	$r_path = "";
	foreach($arr as $i=>$val){
		$path_arr[] = array('path'=>$r_path.$val, 'title'=>$val);
		$r_path .= $val."/";
	}
}
$path_arr[0]['first'] = 1;
$tpl->setLoop('path', $path_arr);

$tpl->setVar('folder_path', $main_configFile->variable['project_dir']."files/".(strlen($_GET['path'])>0?$_GET['path']."/":""));
$tpl->setVar('folder_path_', "files/".(strlen($_GET['path'])>0?$_GET['path']."/":""));
$tpl->setVar('project_dir', $main_configFile->variable['project_dir']);

$tpl->setVar('config', $main_configFile->variable);

$tpl->setVar('get', $_GET);


$tpl->setVar('phrases', $cms_phrases);

if(isset($_GET['mode'])) $tpl->setVar('mode', array($_GET['mode']=>1));

include $tpl->parse();
exit;

?>