<?php
/*
 * Created on 2007.07.27
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(APP_CLASSDIR."modules.class.php");
class modules_banners extends modules {

    function __construct($module) {
    
    	parent::__construct($module);
    
    }
    
    function changeFlashLink($data){
    	
    	if($data['file']){
    		
    		$filename = UPLOADDIR.$data['file'];
			$handle = fopen($filename, "r+");
			$swf_file = fread($handle, filesize($filename));
			
			
			include_once(CLASSDIR."swf.class.php");
			$swf_obj = & new swf();
			
			if ($swf_obj->SWFVersion($swf_file) >= 3 && $swf_obj->SWFInfo($swf_file)) {
	            
	            // SWF's requiring player version 6+ which are already compressed should stay compressed
	            if ($swf_obj->SWFVersion($swf_file) >= 6 && $swf_obj->SWFCompressed($swf_file)) {
	                $compress = true;
	            } elseif (isset($compress)) {
	                $compress = true;
	            } else {
	                $compress = false;
	            }
	
	            if (!isset($convert_links)) {
	                $convert_links = array();
	            }
				
	            list($result, $parameters) = $swf_obj->SWFConvert($swf_file, $compress, $convert_links);
				
				
	            /*if ($result != $swf_file) {
	                
	                if (count($parameters) > 0) {
	                    // Set default link
	                    $row['url']    = "http://www.easywebmananger.com";
	                    $row['target'] = "_balnk";
	
	                    // Prepare the parameters
	                    $parameters_complete = array();
	
	                    while (list($key, $val) = each($parameters)) {
	                        if (isset($overwrite_source) && $overwrite_source[$val] != '') {
	                            $overwrite_link[$val] .= '|source:'.$overwrite_source[$val];
	                        }
	                        $parameters_complete[$key] = array(
	                            'link' => "http://www.easywebmananger.com",
	                            'tar'  => "_blank"
	                        );
	                    }
	                    $parameters = array('swf' => $parameters_complete);
	                } else {
	                    $parameters = '';
	                }
	
	            }*/
	            
	            //$row['pluginversion'] = $swf_obj->SWFVersion($result);
	            //pae($row);

	            if(!fwrite($handle, $result, strlen($result))) echo "error";
	            
	        }
    		
    	}
    	fclose($handle);
    	
    }
}


?>