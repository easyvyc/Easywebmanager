<?php
/*
 * Created on 2006.9.14
 * step5.php
 * Vytautas
 */
//pa($_SESSION['update']);
$param['update_id'] = $_SESSION['update'][$_SESSION['update']['current_update_id']]['record_id'];

include_once(CLASSDIR."ftpclient.class.php");
$ftpclient_obj = & new ftpclient();

$ftpclient_obj->debug = 0;

$_updateExist = $client->call('getUpdateFilesList', $param);
$updateExist = $_updateExist[0];

if($updateExist['value']!=false){

	if(isset($updateExist['value']['item']['id'])){
		$arr = $updateExist['value']['item'];
		unset($updateExist['value']['item']);
		$updateExist['value']['item'][] = $arr;
	}
	
	$n = count($updateExist['value']['item']);
	
	if($configFile->variable['ftp_hostname']){
		
		if($ftpclient_obj->ftp_connect($configFile->variable['ftp_hostname'], $configFile->variable['ftp_port'])){
	
			if($ftpclient_obj->ftp_login($configFile->variable['ftp_username'], $configFile->variable['ftp_password'])){
	
				$arr = explode("/", DOCROOT_);
				foreach($arr as $val){
					if(strlen($val)>0)
						$ftpclient_obj->ftp_chdir($val);
				}
	
				$root_site_dir = $ftpclient_obj->ftp_pwd();
				//echo "<br><br>$pwd<br><br>";
				//pa($updateExist['value']['item']);
				for($i=0; $i<$n; $i++){
					$file_param = $param;
					$file_param['file'] = $updateExist['value']['item'][$i]['file'];
					$fileContent = $client->call('getUpdateFile', $file_param);
					//createFolders(DOCROOT_, $updateExist['value']['item'][$i]['destination']);
					//chmod(DOCROOT_.$updateExist['value']['item'][$i]['destination'], 0777);
					
					$temp_file = FILESDIR."temp/tmp.dat";
					
					$updateExist['value']['item'][$i]['destination'] = ereg_replace("{ADMIN}/", $configFile->variable['admin_dir'], $updateExist['value']['item'][$i]['destination']);
					$dir_arr = explode("/", $updateExist['value']['item'][$i]['destination']);
					foreach($dir_arr as $val){
						if(strlen($val)>0){
							if(!$ftpclient_obj->ftp_chdir($val)){
								$ftpclient_obj->ftp_mkdir($val);
								$ftpclient_obj->ftp_chdir($val);
							}
						}
					}
					$new_file = $updateExist['value']['item'][$i]['title'];
					$file = fopen($temp_file, "w+");
					
					if(fwrite($file, $fileContent)){
						fclose($file);
						if(!$ftpclient_obj->ftp_put($new_file, $temp_file)){
							$updateExist['errorMessage'] .= "\r\nNegali įrašyti failo: ".DOCROOT_.$updateExist['value']['item'][$i]['destination']."\r\n";
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////  Veiksmai atstatantys viska kaip buvo  ////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
							$tpl_main->setVar('error', $client->getError() . " <br> " . nl2br($updateExist['errorMessage']));
						}
						
					}else{
						fclose($file);
					}
					unlink($temp_file);
	
					$ftpclient_obj->ftp_chdir("/");
					$ftpclient_obj->ftp_chdir($root_site_dir);

					if($updateExist['value']['item'][$i]['file_type']=='php'){
						include(DOCROOT_.$updateExist['value']['item'][$i]['destination'].$new_file);
					}

					if($updateExist['value']['item'][$i]['file_type']=='zip'){
						
						$zip_file = DOCROOT_.$updateExist['value']['item'][$i]['destination'].$new_file;
						$zip = zip_open($zip_file);
						$destination_directory = $updateExist['value']['item'][$i]['destination'];
						
						if ($zip) {
						
						    while ($zip_entry = zip_read($zip)) {
//						        echo "Name:               " . zip_entry_name($zip_entry) . "\n";
//						        echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
//						        echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
//						        echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";
						
						        if (zip_entry_open($zip, $zip_entry, "r")) {
//						            echo "File Contents:\n";
						            $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
//						            echo "$buf\n";


									if(zip_entry_filesize($zip_entry) > 0){
										
										$temp_file = FILESDIR."temp/tmp.dat";
										$dir_arr = explode("/", $destination_directory.zip_entry_name($zip_entry));
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
												$updateExist['errorMessage'] .= "\r\nNegali įrašyti failo: ".zip_entry_name($zip_entry)."\r\n";
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////  Veiksmai atstatantys viska kaip buvo  ////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
												$tpl_main->setVar('error', $client->getError() . " <br> " . nl2br($updateExist['errorMessage']));
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
				
				$next_step = $_GET['step'] + 1;
				redirect("update.php?step=$next_step&update_id={$param['update_id']}");
			
			}else{
				//$tpl_main->setVar('error', "Netinkami ftp prisijungimo duomenys. Patikrinkite konfiguracini faila.");
				echo "<script type=\"text/javascript\"> top.content.showSystemMessage(2); </script>"; exit;
			}
			
	
		}else{
			echo "<script type=\"text/javascript\"> top.content.showSystemMessage(2); </script>"; exit;
			//$tpl_main->setVar('error', "Negali prisijungti prie serverio ftp. Patikrinkite konfiguracini faila.");
		}
		$ftpclient_obj->ftp_quit();
		
	}else{
		echo "<script type=\"text/javascript\"> top.content.showSystemMessage(2); </script>"; exit;
		//$tpl_main->setVar('error', "Negali prisijungti prie serverio ftp. Patikrinkite konfiguracini faila.");
		
	}
	
	
}else{
	$tpl_main->setVar('error', $client->getError() . " <br> " . nl2br($updateExist['errorMessage']));
}


?>
