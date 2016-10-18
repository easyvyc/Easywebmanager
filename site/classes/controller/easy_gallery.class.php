<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_easy_gallery extends controller {
	
	
	function __construct(){
		parent::__construct("easy_gallery");
	}
        
        function show_image(){
            return $this->get_image($this->get['f'], $this->get['w'], $this->get['h'], $this->get['t']);
        }
        
        function get_image($file, $width, $height, $type){
            
            $img_params = array(
                                                    'size_width'=>$width, 
                                                    'size_height'=>$height, 
                                                    'resize_type'=>$type, 
                                                    'quality'=>100
            );

            include_once(CLASSDIR."images.class.php");
            $img_obj = new images();
            $img_obj->process($file, '', $img_params);
            exit;
            
        }
        
}
?>