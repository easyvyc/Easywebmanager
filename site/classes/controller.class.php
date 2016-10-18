<?php

include_once (CLASSDIR.'basic.class.php');
class controller extends basic {
	
	protected $mod;
	
	function __construct($module) {
		
		parent::__construct ();
		benchmark::mark('construct_controller', 'Controller objectas '.$module);
		$this->mod = $this->registry->model->$module;
		
		// Module language
		$this->language = cms::$language;
    	    	
	}
	
	function show_image(){
		
		$column = $this->get['column'];
		$item_id = $this->get['id'];
		$img_width = $this->get['w'];
		$img_height = $this->get['h'];
		$img_type = $this->get['t'];
		
		// jei form save action buvo klaidu, tai pirma reik tikrint tem direktorija
		$tmp_prior = $this->get['tmp'];
		
                return $this->show_image_func($item_id, $column, $img_width, $img_height, $img_type, $tmp_prior);

	}
        
        function show_image_func($item_id, $column, $img_width, $img_height, $img_type, $tmp_prior = false){
		if($item_id != 0){
			
			$data = $this->mod->loadItem($item_id);
			$file_name = $data[$column];

			if($tmp_prior){
				$file = TEMPDIR.$file_name;
				if(!file_exists($file)){
					$file = UPLOADDIR.$file_name;
				}
			}else{
				$file = UPLOADDIR.$file_name;
				if(!file_exists($file)){
					$file = TEMPDIR.$file_name;
				}
			}
			
		}else{
                    $list = glob(TEMPDIR."{$this->mod->module_info['table_name']}-$column-0.*");
                    $file = $list[0];
		}

		if(!file_exists($file)){
                    exit("No file.");
		}
		
		$img_params = array(
                    'size_width'=>$img_width, 
                    'size_height'=>$img_height, 
                    'resize_type'=>$img_type, 
                    'quality'=>100
		);
		
		include_once(CLASSDIR."images.class.php");
		$img_obj = new images();
		$img_obj->process($file, '', $img_params);
		exit;            
        }
		
	/**
	 * 
	 * return module name
	 */
	function __toString(){
		return $this->mod->module_info['table_name'];
	}
	
}

?>