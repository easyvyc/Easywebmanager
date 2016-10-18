<?php

include_once(CLASSDIR."files.class.php");
include_once(CLASSDIR."image/imageLib.class.php");
class images extends files {
    
    function __construct() {
        parent::__construct();
    }
    

    
    function save($file){
    	if(strlen($this->resize_old_image)>0){
    		$filename = $this->resize_old_image;
        	$this->resize_old_image = "";
        }else{
        	$filename = files::save($file);
        }
        
        if(strlen($filename)>0){
	         foreach($this->resize_params as $key=>$val){
		         $filename_prefix = $val['prefix'].$filename;
		         $this->process($this->path.$filename, $this->path.$filename_prefix, $val);
		         chmod($this->path.$filename_prefix, 0777);
	         }
	         //pae($this->resize_params);
		}
        //pae($this->resize_params);
        return $filename;
    }

    function process($name, $filename, $resize_params){
			
		$create_image_cache = false;
                $always_create_cache_img = false;
		
                if(preg_match("|^http(s)?://|i", $name)){
			$file_url = true;
                }

                $name_urled = $name;
                if($file_url){
                    $name_urled = preg_replace("/\s/", "%20", $name);
                }
                
                list($original_imamge_width, $original_imamge_height) = getimagesize($name_urled);
                
                if($resize_params['size_width'] > $original_imamge_width && $resize_params['size_height'] > $original_imamge_height){
                    if($file_url){
			redirect($name);
		    }else{
                        $this->download($name);
		    }
                    return false;
                } 
                
		if($filename==''){
			clearstatcache();
			$file_info_arr = pathinfo($name);
			if(!isset($file_info_arr['filename'])) $file_info_arr['filename'] = preg_replace("/\.{$file_info_arr['extension']}$/", "", $file_info_arr['basename']);
			$dirname = str_replace(DOCROOT, "", $file_info_arr['dirname']."/");
			$cache_img = CACHEIMGDIR.md5($dirname)."_".$file_info_arr['filename']."_".implode("-", $resize_params).".".$file_info_arr['extension'];
                        if($always_create_cache_img){
                            $create_image_cache = true;
                        }else{
                            if(file_exists($cache_img) && filemtime($cache_img) > filemtime($name)){
                                    //echo file_get_contents($cache_img);
                                    $this->download($cache_img);
                                    return false;
                            }else{
                                    $create_image_cache = true;
                            }
        		}
		}
		
                if(strpos($name, Config::$val['site_url'])===0){
                    $name = str_replace(Config::$val['site_url'], DOCROOT, $name);
                }
                
		$img_obj = new imageLib($name);
		$img_obj->resizeImage($resize_params['size_width'], $resize_params['size_height'], ($resize_params['resize_type'] ? $resize_params['resize_type'] : 'auto'));
		
		if($resize_params['water_sign']==1 && strlen($this->watermark_file)>0){
			$img_obj->addWatermark($this->watermark_file, 'br', 10);
		}
		
		if($filename==''){
			$img_obj->saveImage($cache_img, $resize_params['quality']);
                        chmod($cache_img, 0777);
			$this->download($cache_img);
		}else{
			$img_obj->saveImage($filename, $resize_params['quality']);
                        chmod($filename, 0777);
		}

    }
    
    function delete($id){
        $sql = "SELECT filename FROM $this->table WHERE id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	$this->remove($row['filename']);
    	$sql = "DELETE FROM $this->table WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function remove($file){
    	unlink($this->path.$file);
    }
}
?>
