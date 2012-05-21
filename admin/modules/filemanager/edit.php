<?php
/*
 * Created on 2009.06.05
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

error_reporting(E_ERROR);
include_once(CLASSDIR."filemanager.class.php");
$filemanager_obj = new filemanager();

include_once(CLASSDIR."images.class.php");
$img_obj = & new images();

if(isset($_GET['downloadfile'])){
	header('Content-Disposition: attachment; filename="'.urldecode($_GET['downloadfile']).'"');
	readfile($filemanager_obj->dir.urldecode($_GET['path'])."/".urldecode($_GET['downloadfile']));
}

$tpl->setVar('folder_path', $folder_path = $main_configFile->variable['project_dir']."files/".(strlen($_GET['path'])>0?$_GET['path']."/":""));

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$file_path = DOCROOT."files/".(strlen($_GET['path'])>0?$_GET['path']."/":"");
	$file = $file_path.$_POST['file'];
	list ($width, $height, $type) = getimagesize($file);
	$img_obj->path = $file_path;
	$new_file = $img_obj->setFilename($_POST['file']);
	$new_file_name = $file_path.$new_file;
	
	$dst_img = $img_obj->crop($new_file_name, $img_obj->createGDImage($file, $type), $_POST['w'],$_POST['h'], $_POST['x'], $_POST['y'], $_POST['w'],$_POST['h'], $type, 100);
	if($_POST['resize_img']==1){
		$rx = $_POST['img_sizing_value_x'] / $_POST['w'];
		$ry = $_POST['img_sizing_value_y'] / $_POST['h'];
		if($rx<$ry){
			$new_w = $_POST['img_sizing_value_x'];
			$new_h = $_POST['h'] * $rx;
		}else{
			$new_w = $_POST['w'] * $ry;
			$new_h = $_POST['img_sizing_value_y'];
		}
		$dst_img = $img_obj->resize($new_file_name, $dst_img, $new_w, $new_h, $_POST['w'],$_POST['h'], $type, array('quality'=>100));	
	}
	$img_obj->create($dst_img, $new_file_name, $type, 100);
	
	//$dst_w, $dst_h, $src_x, $src_y, $src_w, $src_h
	//redirect("main.php?content={$_GET['content']}&page={$_GET['page']}&path={$_GET['path']}&file=$new_file");
	
	redirect("main.php?content={$_GET['content']}&page={$_GET['page']}&path={$_GET['path']}&file=$new_file");
	
	/*
	echo "<script type=\"text/javascript\">" .
			"parent.changeImg('http://vytautas/demo/images/0.gif');" .
			"parent.document.getElementById('file').value='$new_file';" .
			"</script>";
	exit;
	*/
}

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


$tpl->setVar('phrases', $cms_phrases);
$tpl->setVar('config', $main_configFile->variable);

$tpl->setVar('get', $_GET);

if(isset($_GET['mode'])) $tpl->setVar('mode', array($_GET['mode']=>1));

$tpl->setVar('folder_path', $main_configFile->variable['project_dir']."files/".(strlen($_GET['path'])>0?$_GET['path']."/":""));
$tpl->setVar('folder_path_', "files/".(strlen($_GET['path'])>0?$_GET['path']."/":""));
$tpl->setVar('project_dir', $main_configFile->variable['project_dir']);


include $tpl->parse();
exit;

?>