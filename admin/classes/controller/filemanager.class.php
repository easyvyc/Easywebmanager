<?php

include_once (CLASSDIR.'basic.class.php');
class controller_filemanager extends basic {
	
	public function __construct() {
		parent::__construct ();
		$this->mod = $this->registry->model->filemanager;
		$this->valid_images = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'psd');
	}
	
	function getFolder(){
		
		$folder = $this->get['folder'];
		
		$list = $this->mod->folder($folder);
		
		$main_dir = $this->mod->getMainDir();
		
		$_list = array();
		foreach($list as $val){
			$arr = array();
			$arr['file'] = str_replace(DOCROOT, "", $val);
			$arr['folder'] = trim(str_replace($main_dir, "", $val), "/");
			$path_parts = pathinfo($val);
			$arr['name'] = $path_parts['basename'];
			if(is_dir($val)){
				$arr['is_folder'] = true;
				$arr['title'] = $arr['name'] . " - (".count($this->mod->folder($arr['folder']))." files)";
			}else{
				$arr['size'] = round(filesize($val)/(1024), 2);
				if(in_array(strtolower($path_parts['extension']), $this->valid_images)){
					$arr['is_img'] = true;
					list($arr['img_w'], $arr['img_h']) = getimagesize($val);
				}
				$arr['title'] = $arr['name']." - ({$arr['size']}Kb" . ($arr['is_img']?" {$arr['img_w']}x{$arr['img_h']}":"") . ")";
			}
			$_list[] = $arr;
		}
		
		$pth = explode("/", $folder);
		$path = array(); $path_val = array();
		foreach($pth as $val){
			$path_val[] = $val;
			$path[] = array('name'=>$val, 'path'=>trim(implode("/", $path_val), "/"));
		}
		TPL::setVar('path', $path);
		TPL::setVar('list', $_list);
		
		TPL::setVar('css', generate_css(APP_NAME, array('filemanager')));
		
		return TPL::parse(TPLDIR."filemanager/index.tpl");
		
	}
	
	function thumb_img(){
		
		$main_dir = $this->mod->getMainDir();
		$file = $main_dir . $this->get['file'];
		
		if(!file_exists($file)){
			exit("No file.");
		}
		
		$img_params = array(
							'size_width'=>50, 
							'size_height'=>50, 
							'resize_type'=>0, 
							'quality'=>100
		);
		
		include_once(CLASSDIR."images.class.php");
		$img_obj = new images();
		$img_obj->process($file, '', $img_params);
		exit;
		
	}
	
}

?>