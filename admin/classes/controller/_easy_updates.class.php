<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller__easy_updates extends controller {
	
	public function __construct() {
		parent::__construct ("_easy_updates");
	}
	
	function listing(){

		$table_list = array();
		$table_list[] = array(
								'title'=>cms::$phrases['update']['updates_title_title'], 
								'column_name'=>'title', 
								'elm_type'=>FRM_TEXT, 
								'no_sort'=>1
		);
		$table_list[] = array(
								'title'=>cms::$phrases['update']['updates_description_title'], 
								'column_name'=>'description', 
								'elm_type'=>FRM_TEXT, 
								'no_sort'=>1
		);
		
		benchmark::mark('start_listing', 'Listingo pradzia');
		
    	include_once(APP_CLASSDIR."listing.class.php");
		$listing_obj = new listing("_easy_update");
    	
		$listing_obj->setColumns($table_list);
		
		$listing_obj->set('edit_button', 0);
		$listing_obj->set('delete_button', 0);
		$listing_obj->set('select_button', 0);
		$listing_obj->set('dragndrop', 0);
		$listing_obj->set('actions_button', 0);
		$listing_obj->set('filter_form', 0);
		
    	$list_items = $this->mod->getListingItems();
    	
    	$listing_obj->setItems($list_items);
		
    	if(empty($list_items)){
    		$_count = 0;
    	}else{
    		$_count = count($list_items);
    	}
    	
	    $listing_obj->setItemsData(array('_COUNT_'=>$_count));
    	
    	benchmark::mark('end_listing', 'Listingo pabaiga');
    	
    	return $listing_obj->generate() . ($_count ? "<a href=\"javascript: void(\$NAV.get('?module=_easy_updates&method=update'));\" class=''>" . cms::$phrases['update']['update_button'] . "</a>" : "");		
	}
	
	function update(){
		
		include_once(CLASSDIR . "ftpclient.class.php");
		$ftpclient_obj = new ftpclient();
		$ftpclient_obj->debug = 0;

		if($this->config['ftp_hostname']){
	
			if($ftpclient_obj->ftp_connect($this->config['ftp_hostname'], $this->config['ftp_port'])){
		
				if($ftpclient_obj->ftp_login($this->config['ftp_username'], $this->config['ftp_password'])){
		
					$list_items = $this->mod->getListingItems();
					
					$update_log = array();
					
					foreach($list_items as $update){
						
						$this->mod->startUpdate($update['id']);

						$update_log[] = "Start update: {$update['title']} (time - " . date("Y-m-d H:i:s") . ")";
						
						$update_files_list = $this->mod->getUpdateFilesList($update['id']);
						
						$arr = explode("/", DOCROOT);
						foreach($arr as $val){
							if(strlen($val)>0)
								$ftpclient_obj->ftp_chdir($val);
						}
			
						$root_site_dir = $ftpclient_obj->ftp_pwd();
						
						$n = count($update_files_list);
						for($i=0; $i<$n; $i++){
							$fileContent = $this->mod->getUpdateFile($update_files_list[$i]['file']);
							$temp_file = FILESDIR . "temp/tmp.dat";
							$update_files_list[$i]['destination'] = str_replace("{ADMIN}/", $this->config['admin_dir'], $update_files_list[$i]['destination']);
							$dir_arr = explode("/", $update_files_list[$i]['destination']);
							foreach($dir_arr as $val){
								if(strlen($val)>0){
									if(!$ftpclient_obj->ftp_chdir($val)){
										$ftpclient_obj->ftp_mkdir($val);
										$ftpclient_obj->ftp_chdir($val);
									}
								}
							}
							$new_file = $update_files_list[$i]['title'];
							$file = fopen($temp_file, "w+");
							
							if(fwrite($file, $fileContent)){
								fclose($file);
								if(!$ftpclient_obj->ftp_put($new_file, $temp_file)){
									$update_log[] = "Uploaded file canceled: {$update_files_list[$i]['destination']}$new_file (time - " . date("Y-m-d H:i:s") . ")";
								}else{
									$update_log[] = "Uploaded file successsfully: {$update_files_list[$i]['destination']}$new_file (time - " . date("Y-m-d H:i:s") . ")";
								}
								
							}else{
								fclose($file);
							}
							unlink($temp_file);
			
							$ftpclient_obj->ftp_chdir("/");
							$ftpclient_obj->ftp_chdir($root_site_dir);
		
							if($update_files_list[$i]['file_type']=='php'){
								include(DOCROOT . $update_files_list[$i]['destination'] . $new_file);
								$update_log[] = "Executed file: {$update_files_list[$i]['destination']}$new_file (time - " . date("Y-m-d H:i:s") . ")";
							}
		
							if($update_files_list[$i]['file_type']=='zip'){
								
								$zip_file = DOCROOT . $update_files_list[$i]['destination'] . $new_file;
								$zip_file_name = $update_files_list[$i]['destination'] . $new_file;
								$zip = zip_open($zip_file);
								$destination_directory = $update_files_list[$i]['destination'];
								
								if ($zip) {
								
								    while ($zip_entry = zip_read($zip)) {
								
								        if (zip_entry_open($zip, $zip_entry, "r")) {
								            $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
											if(zip_entry_filesize($zip_entry) > 0){
												
												$temp_file = FILESDIR . "temp/tmp.dat";
												$dir_arr = explode("/", $destination_directory . zip_entry_name($zip_entry));
												for($i=0; $i<(count($dir_arr)-1); $i++){
													if(strlen($dir_arr[$i])>0){
														if(!$ftpclient_obj->ftp_chdir($dir_arr[$i])){
															$ftpclient_obj->ftp_mkdir($dir_arr[$i]);
															$ftpclient_obj->ftp_chdir($dir_arr[$i]);
														}
													}
												}
												$new_file = $dir_arr[(count($dir_arr)-1)];
												$file = fopen($temp_file, "w+");
												
												if(fwrite($file, $buf)){
													fclose($file);
													if(!$ftpclient_obj->ftp_put($new_file, $temp_file)){
														$update_log[] = "Uploaded file canceled: {$update_files_list[$i]['destination']}$new_file, from zip file: $zip_file_name (time - " . date("Y-m-d H:i:s") . ")";
													}else{
														$update_log[] = "Uploaded file successfully: {$update_files_list[$i]['destination']}$new_file, from zip file: $zip_file_name (time - " . date("Y-m-d H:i:s") . ")";
													}
													
												}else{
													fclose($file);
												}
												unlink($temp_file);
								
												$ftpclient_obj->ftp_chdir("/");
												$ftpclient_obj->ftp_chdir($root_site_dir);
									
									            zip_entry_close($zip_entry);
											}
											
								        }
								        
								    }
								
								    zip_close($zip);
								
								}
								unlink($zip_file);					
								
							}
					
						}
						
						$this->mod->endUpdate($update['id']);
						$update_log[] = "End update: {$update['title']} (time - " . date("Y-m-d H:i:s") . ")";
						
					}
				
				}else{
					return array('_SCRIPT_' => "<script type=\"text/javascript\"> alert('" . cms::$phrases['update']['wrong_config'] . "'); </script>"); 
				}
				
		
			}else{
				return array('_SCRIPT_' => "<script type=\"text/javascript\"> alert('" . cms::$phrases['update']['wrong_config'] . "'); </script>"); 
			}
			$ftpclient_obj->ftp_quit();
			
		}else{
			return array('_SCRIPT_' => "<script type=\"text/javascript\"> alert('" . cms::$phrases['update']['wrong_config'] . "'); </script>"); 
			
		}			
		
		return "<h3>" . cms::$phrases['update']['update_complete'] . "</h3><br /><br />" . implode("<br />", $update_log);
	}
	
	function tree(){
		return;
	}
	
}

?>