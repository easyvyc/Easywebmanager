<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_blocks extends controller {
	
	public function __construct() {
		parent::__construct ("blocks");
	}
	
	function save_post(){
		$page_id = $this->post['id'];
		$page_area = $this->post['area'];
		$value = $this->post['value'];
		return $this->save($page_id, $page_area, $value);
	}
	
	function save($page_id, $page_area, $value){
		
		$block_data = $this->mod->getBlock($page_id, $page_area);
		
		if(empty($block_data)){
			$data['isNew'] = 1;
			$data['id'] = 0;
			$data['parent_id'] = 0;
			$data['language'] = $this->language;
			$data['active'] = 1;
			$data['page_id'] = $page_id;
			$data['block_name'] = $page_area;
		}else{
			$data = $block_data;
			$data['isNew'] = 0;
			$data['parent_id'] = 0;
			$data['id'] = $block_data['record_id'];
			$data['language'] = $this->language;
		}
		
		$data['description'] = str_replace(":AMPERSAND:", "&", $value);

		return $this->mod->saveItem($data);
		
	}
		
}

?>