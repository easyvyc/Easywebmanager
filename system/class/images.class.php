<?php

include_once(CLASSDIR."files.class.php");
class images extends files {

    var $size_big_width = 500;
    var $size_big_height = 350;
    var $size_small_width = 170;
    var $size_small_height = 100;
    var $resize_image = true;
    var $resize_old_image = "";
    var $resize_by_big = 'x';
    var $resize_by_small = 'x';
    var $watermark_file = '';
    
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

    function createGDImage($name, $type){
		if($type==2){ // tikriname ar img jpg ne pagal extensiona
			$src_img = imagecreatefromjpeg($name);
		}
		if($type==1){ 
			$src_img = imagecreatefromgif($name);
		}
		if($type==3){ 
			$src_img = imagecreatefrompng($name);
		}
		if($type==6){ 
			$src_img=imagecreatefromwbmp($name);
		}
		return $src_img;
    }
    
    function process($name, $filename, $resize_params){
			
		$create_image_cache = false;
		
		if($filename=='' && !$create_image_cache){
			clearstatcache();
			$file_info_arr = pathinfo($name);
			if(!isset($file_info_arr['filename'])) $file_info_arr['filename'] = ereg_replace("/\.{$file_info_arr['extension']}$/", "", $file_info_arr['basename']);
			$dirname = ereg_replace("^".DOCROOT, "", $file_info_arr['dirname']."/");
			$cache_img = CACHEIMGDIR_.md5($dirname)."_".$file_info_arr['filename']."_".implode("-", $resize_params).".".$file_info_arr['extension'];
			if(file_exists($cache_img) && filemtime($cache_img) > filemtime($name)){
				//echo file_get_contents($cache_img);
				$this->download($cache_img);
				return false;
			}else{
				$create_image_cache = true;
			}
		}
		
		$gd2 = true;
		list ($width, $height, $type) = getimagesize($name);
		
		$src_img = $this->createGDImage($name, $type);
		
		$old_x = imageSX($src_img);
		$old_y = imageSY($src_img);
		
		$width = $resize_params['size_width'];
		$height = $resize_params['size_height'];
		
		if($old_x <= $width && $old_y <= $height){
			if ($name != $filename)
				copy($name, $filename);
		}
		
		if($resize_params['resize_type']=='1'){
			if($old_x/$width > $old_y/$height){
				$new_y = $height;
				$new_x = round($old_x/($old_y/$height));
			}else{
				$new_x = $width;
				$new_y = round($old_y/($old_x/$width));
			}
		}else{
			if($old_x/$width > $old_y/$height){
				$new_x = $width;
				$new_y = round($old_y/($old_x/$width));
			}else{
				$new_y = $height;
				$new_x = round($old_x/($old_y/$height));
			}
		}
		
		
		if($this->resize_image){
			
			if($new_x < $old_x || $new_y < $old_y)
				$src_img = $this->resize($filename, $src_img, $new_x, $new_y, $old_x, $old_y, $type, $resize_params);
			else
				//if($filename!='') 
				$src_img = $this->resize($filename, $src_img, $old_x, $old_y, $old_x, $old_y, $type, $resize_params);
				
			if($resize_params['resize_type']=='1'){
				if($old_x/$width > $old_y/$height){
					$X = round((($new_x>$old_x?$old_x:$new_x) - $width)/2);
					$Y = 0;
				}else{
					$X = 0;
					$Y = round((($new_y>$old_y?$old_y:$new_y) - $height)/2);
				}
				$Ydst = $Xdst = 0;
				if($new_x < $width || $old_x < $width){
					$Xdst = round(($width - ($new_x>$old_x?$old_x:$new_x))/2);
				}
				if($new_y < $height || $old_y < $height){
					$Ydst = round(($height - ($new_y>$old_y?$old_y:$new_y))/2);
				}
				//function crop($filename, $src_img, $dst_w, $dst_h, $src_x, $src_y, $src_w, $src_h, $type, $quality){
				$src_img = $this->crop($filename, $src_img, $width, $height, $X, $Y, $width, $height, $type, 100, $Xdst, $Ydst);
			}
		}

		//pae($resize_params);
		if($resize_params['water_sign']==1 && strlen($this->watermark_file)>0){
			$src_img = $this->createGDImage($filename, $type);
			$src_img = $this->watermark($filename, $src_img, ($new_x<$old_x?$new_x:$old_x), ($new_y<$old_y?$new_y:$old_y), $type, $resize_params);
		}
		
		if($filename==''){
			$this->create($src_img, $cache_img, $type, $resize_params['quality']);
			$this->download($cache_img);
			//echo file_get_contents($cache_img);
		}else{
			$this->create($src_img, $filename, $type, $resize_params['quality']);
		}

    }
    
    function create($src_img, $filename, $type, $quality=100){
		
    	if($type==2){
			imagejpeg($src_img, $filename, $quality);
		}
		if($type==1){
			imagegif($src_img, $filename);
		}
		if($type==3){
			imagepng($src_img, $filename);
		}
		if($type==6){
			imagewbmp($src_img, $filename);
		}			

		imagedestroy($src_img);
    	
    }
    
    function resize($filename, $src_img, $thumb_w, $thumb_h, $old_x, $old_y, $type, $resize_params){
    	
    	$gd2 = true;
		if ($gd2 == "") {
			$dst_img = ImageCreate($thumb_w, $thumb_h);
			imagecolortransparent($dst_img, imagecolorallocate($dst_img, 0, 0, 0) );
        	imagealphablending($dst_img, false);
        	imagesavealpha($dst_img, true);
			imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		} else {
			$dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
		    if ( ($type == IMAGETYPE_GIF) || ($type == IMAGETYPE_PNG) ) {
		      $trnprt_indx = imagecolortransparent($src_img);
		      // If we have a specific transparent color
		      if ($trnprt_indx >= 0) {
		        // Get the original image's transparent color's RGB values
		        $trnprt_color    = imagecolorsforindex($src_img, $trnprt_indx);
		        // Allocate the same color in the new image resource
		        $trnprt_indx    = imagecolorallocate($dst_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
		        // Completely fill the background of the new image with allocated color.
		        imagefill($dst_img, 0, 0, $trnprt_indx);
		        // Set the background color for new image to transparent
		        imagecolortransparent($dst_img, $trnprt_indx);
		      } 
		      // Always make a transparent background color for PNGs that don't have one allocated already
		      elseif ($type == IMAGETYPE_PNG) {
		        // Turn off transparency blending (temporarily)
		        imagealphablending($dst_img, false);
		        // Create a new transparent color for image
		        $color = imagecolorallocatealpha($dst_img, 0, 0, 0, 127);
		        // Completely fill the background of the new image with allocated color.
		        imagefill($dst_img, 0, 0, $color);
		        // Restore transparency blending
		        imagesavealpha($dst_img, true);
		      }
		    }
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		}
		
		//imagedestroy($dst_img);
		return $dst_img;
		    	
    }
    
    
    function crop($filename, $src_img, $dst_w, $dst_h, $src_x, $src_y, $src_w, $src_h, $type, $quality, $dst_pos_x=0, $dst_pos_y=0){
    	
    	$gd2 = true;
		if ($gd2 == "") {
			$dst_img = ImageCreate($dst_w, $dst_h);
			imagecolortransparent($dst_img, imagecolorallocate($dst_img, 0, 0, 0) );
        	imagealphablending($dst_img, false);
        	imagesavealpha($dst_img, true);
			imagecopyresized($dst_img, $src_img, $dst_pos_x, $dst_pos_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		} else {
			$dst_img = ImageCreateTrueColor($dst_w, $dst_h);
			if ( ($type == IMAGETYPE_GIF) || ($type == IMAGETYPE_PNG) ) {
		      $trnprt_indx = imagecolortransparent($src_img);
		      // If we have a specific transparent color
		      if ($trnprt_indx >= 0) {
		        // Get the original image's transparent color's RGB values
		        $trnprt_color    = imagecolorsforindex($src_img, $trnprt_indx);
		        // Allocate the same color in the new image resource
		        $trnprt_indx    = imagecolorallocate($dst_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
		        // Completely fill the background of the new image with allocated color.
		        imagefill($dst_img, 0, 0, $trnprt_indx);
		        // Set the background color for new image to transparent
		        imagecolortransparent($dst_img, $trnprt_indx);
		      } 
		      // Always make a transparent background color for PNGs that don't have one allocated already
		      elseif ($type == IMAGETYPE_PNG) {
		        // Turn off transparency blending (temporarily)
		        imagealphablending($dst_img, false);
		        // Create a new transparent color for image
		        $color = imagecolorallocatealpha($dst_img, 0, 0, 0, 127);
		        // Completely fill the background of the new image with allocated color.
		        imagefill($dst_img, 0, 0, $color);
		        // Restore transparency blending
		        imagesavealpha($dst_img, true);
		      }
		    }        	
        	imagecopyresampled($dst_img, $src_img, $dst_pos_x, $dst_pos_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		}
		
		return $dst_img;      	
    	
    }
    
	function watermark($saveFile, $sourcefile_id, $w, $h, $fileType, $params){ 
	    
	    list ($width, $height, $type) = getimagesize($this->watermark_file);
		
		$watermarkfile_id = $this->createGDImage($this->watermark_file, $type);
	    
	    imageAlphaBlending($watermarkfile_id, false); 
	    imageSaveAlpha($watermarkfile_id, true); 
	    
		$sourcefile_width=$w; 
	    $sourcefile_height=$h; 
	    $watermarkfile_width=$width; 
	    $watermarkfile_height=$height; 
	    
        $dest_x = 10; 
        $dest_y = 10; 
	    
	    if($fileType == 1){ 
	        $tempimage = imagecreatetruecolor($sourcefile_width,$sourcefile_height); 
	        imagecopy($tempimage, $sourcefile_id, 0, 0, 0, 0,$sourcefile_width, $sourcefile_height); 
	        $sourcefile_id = $tempimage; 
	    } 
	    imagecopy($sourcefile_id, $watermarkfile_id, $dest_x, $dest_y, 0, 0,$watermarkfile_width, $watermarkfile_height); 
	    switch($fileType) { 
	        case(3): 
	            imagepng ($sourcefile_id,$saveFile); 
	        break; 
	        
	        default: 
	            imagejpeg ($sourcefile_id,$saveFile); 
	    }        
	      
	    imagedestroy($watermarkfile_id); 
	    return $sourcefile_id; 
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
    	foreach($this->resize_params as $key=>$val){
    		unlink($this->path.$val['prefix'].$file);
    	}
    }
}
?>
