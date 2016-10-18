<?php

include_once(CLASSDIR."files.class.php");
class filemanager extends files {

    function filemanager() {

        files::files();
        $this->dir = FILESDIR;
        $this->url = FILESURL;
    
    }
    
    function listFolders($parent){
    	$dir = dir($parent);
    	$i=1;
		while (false !== ($entry = $dir->read())) {
			//echo $parent.$entry."<br>";
			if($entry!='.' && $entry!='..' && is_dir($parent.$entry))
		   		$folders[] = array('title'=>$entry, 'parent_id'=>$parent);
		}
		$dir->close();
		return $folders;
    }
    
    function listFiles($parent){
    	$dir = dir($parent);
    	$i=1;
		while (false !== ($entry = $dir->read())) {
			//echo $parent."/".$entry."<br>";
			if($entry!='.' && $entry!='..' && !is_dir($parent."/".$entry)){
				$arr = explode(".", $entry);
				$mtime = filemtime($parent."/".$entry);
				$fsize = filesize($parent."/".$entry);
				$img_info = getimagesize($parent."/".$entry);
				$folders[] = array('title'=>$entry, 'id'=>$i++, 'parent'=>$parent, 'ext'=>strtolower($arr[count($arr)-1]), 'filemtime'=>$mtime, 'time'=>date("Y-m-d H:i:s", $mtime), 'filesize'=>$fsize, 'size_kb'=>round($fsize/1024, 2), 'size_mb'=>round($fsize/(1024*1024), 2), 'size_width'=>$img_info[0], 'size_height'=>$img_info[1], 'is_img'=>$img_info[0]);
			}
		}
		if(isset($_GET['sort'])) usort($folders, "cmp_{$_GET['sort']}");
		else usort($folders, "cmp_fname");
		$dir->close();
		return $folders;
    }
    
    function removeDir($dir){
    	if(is_dir($this->dir.$dir)){
    		$listfolders = $this->listFolders($this->dir.$dir);
    		foreach($listfolders as $i=>$val){
    			$this->removeDir($dir.$val['title']."/");
    		}
    		$listfiles = $this->listFiles($this->dir.$dir);
    		foreach($listfiles as $i=>$val){
    			unlink($this->dir.$dir.$val['title']);
    		}
    		rmdir($this->dir.$dir);
    	}
    	return false;
    }
    
    function remove($file){
    	files::remove($file);
    	$file_info_arr = pathinfo($file);
		if(!isset($file_info_arr['filename'])) $file_info_arr['filename'] = preg_replace("/\.{$file_info_arr['extension']}$/", "", $file_info_arr['basename']);
		$dirname = str_replace(FILESDIR, "", $this->path);
		$pattern = CACHEIMGDIR_.md5($dirname)."_".$file_info_arr['filename']."_*.".$file_info_arr['extension'];
    	$files_arr = glob($pattern, GLOB_NOSORT);
    	foreach($files_arr as $val){
    		@unlink($val);
    	}
    }

    
}

function cmp_ext($a, $b) {
	if ($a['ext'] == $b['ext']) {
        return 0;
    }
    return ($a['ext'] > $b['ext']) ? 1 : -1;
}

function cmp_date($a, $b) {
	if ($a['filemtime'] == $b['filemtime']) {
        return 0;
    }
    return ($a['filemtime'] > $b['filemtime']) ? -1 : 1;
}

function cmp_size($a, $b) {
	if ($a['filesize'] == $b['filesize']) {
        return 0;
    }
    return ($a['filesize'] > $b['filesize']) ? 1 : -1;
}

function cmp_fname($a, $b) {
	if ($a['title'] == $b['title']) {
        return 0;
    }
    return ($a['title'] > $b['title']) ? 1 : -1;
}





?>