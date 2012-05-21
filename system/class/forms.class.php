<?php 

include_once(CLASSDIR."basic.class.php");
include_once(CLASSDIR."tpl.class.php");
include_once(CLASSDIR."images.class.php");
class forms extends basic {

	var $error_msg_empty_field = '{phrases.empty_field}';
	var $default_style = 'txt';
	var $error_style = 'err';
	var $field_style = 'fo';
	var $error = 0;
	var $imgobjects = array();
	var $uploadFiles = true;
	var $formData = array();

	function __construct($module) {
	    
		parent::__construct();

	    $this->imgDir = UPLOADDIR;
	    $this->imgUrl = UPLOADURL;
	    $this->img = & new images($module);
	    $this->img->path = & $this->imgDir;
	    $this->file = & new files($module);
	    $this->file->path = & $this->imgDir;

	    $this->tpl_main = & new template(TPLDIR_."forms/main.tpl");
	    $this->tpl = array();//& new template();
	    
	    $this->max_file_size = 1024*1024;
	    
	}
	
	// uzkraunami visi fieldai
	function setData($fields){
		foreach($fields as $key=>$val){
			if($val['column_name']!='action')
				$this->addField($val['column_name'], $val);
			else{
				echo "Field named '$key' can not be used in form"; exit;
			}
				
		}
	}
	
	// uzkrauna po viena fielda 
	function addField($name, $arr){
		$arr['style'] = $this->default_style;
	    $arr['name'] = $name;
	    $arr['column_name'] = $name;
	    if(!isset($arr['required_field'])) $arr['required_field'] = $arr['require'];
	    if(!isset($arr['error_message'])) $arr['error_message'] = $this->error_msg_empty_field;
        if($arr['elm_type']==FRM_FLOAT) $arr['function'] = 'checkFloat';
        if($arr['elm_type']==FRM_NUMBER) $arr['function'] = 'checkNumber';	    
		if(!isset($arr['value'])) $arr['value'] = "";

        if(!is_array($arr['list_values'])) {
        	$list_values = array();
        	$a1 = explode("::", $arr['list_values']);
        	foreach($a1 as $k => $v){
        		$a2 = explode("||", $v);
        		$list_values[$a2[0]] = $a2[1];
        	}
        	$arr['list_values'] = $list_values;
        }
		
		$this->elements[$name] = $arr;
        if($arr['elm_type']==FRM_IMAGE){// tikrinam ar tai nera image tipo fieldas
            $this->imgobjects[$arr['column_name']] = & new images($arr['column_name']);
        }
    }

	function editField($name, $arr){
	    if(!empty($this->elements[$name])){
		    foreach($arr as $k=>$v){
		    	$this->elements[$name][$k] = $arr[$k];
		    }
	    }
	}

	function set_element_prms($k) {

		global $phrases;
		
		$this->elements[$k]['show_error'] = ($this->elements[$k]['value'] == '' ? 1 : '');
		$this->elements[$k]['ok'] = ($this->elements[$k]['value'] == '' ? 0 : 1);
		$this->elements[$k]['style'] = ($this->elements[$k]['value'] == '' ? $this->error_style : $this->default_style);
		$this->error = ($this->elements[$k]['value'] == '' ? 1 : ($this->error!=1?0:1));
		$this->elements[$k]['error_message'] = "Neteisingai užpildytas laukas";
		
		if(strlen($this->elements[$k]['class_method'])>0){
			$arr = explode("::", $this->elements[$k]['class_method']);
			foreach($arr as $arr_key => $arr_val){
				$_arr = explode("=", $arr_val);
				$par[$_arr[0]] = $_arr[1];
			}
			if(!empty($par)){
				if(is_object($GLOBALS[$par['user_object']]) && method_exists($GLOBALS[$par['user_object']], $par['method'])){
					$error = call_user_method($par['method'], $GLOBALS[$par['user_object']], $this->elements[$k], $this->form_data);
					$this->elements[$k]['show_error'] = ($error || $this->elements[$k]['show_error'] ? 1 : '');
					$this->elements[$k]['ok'] = ($error == 1 ? 0 : 1);
					$this->elements[$k]['style'] = ($error == 1 ? $this->error_style : $this->elements[$k]['style']);
					$this->error = $error == 1 ? 1 : ($this->error==1? 1 : 0);
					$this->elements[$k]['error_message'] = (strlen($this->elements[$k]['error_message'])?$this->elements[$k]['error_message']:$this->default_error_message);
					if($error && strlen($phrases[$par['site_error_msg']])>0)  $this->elements[$k]['error_message'] = $phrases[$par['site_error_msg']];
				}
			}
		}
		
		if (strlen($this->elements[$k]['function'])>0) {
			$arr = explode("::", $this->elements[$k]['function']);
			foreach($arr as $arr_key => $arr_val){
				$_arr = explode("=", $arr_val);
				$par[$_arr[0]] = $_arr[1];
			}
			if(function_exists($par['function'])){
				$error = call_user_func($par['function'], $this->elements[$k]['value']);
				$this->elements[$k]['show_error'] = ($error || $this->elements[$k]['show_error'] ? 1 : '');
				$this->elements[$k]['ok'] = ($error == 1 ? 0 : 1);
				$this->elements[$k]['style'] = ($error == 1 ? $this->error_style : $this->elements[$k]['style']);
				$this->error = $error == 1 ? 1 : ($this->error==1? 1 : 0);
				$this->elements[$k]['error_message'] = (strlen($this->elements[$k]['error_message'])?$this->elements[$k]['error_message']:$this->default_error_message);
				if($error && strlen($phrases[$par['site_error_msg']])>0)  $this->elements[$k]['error_message'] = $phrases[$par['site_error_msg']];
			}
		} 
		
	}

	function validate($data) {
		//pa($this->elements);
	    $this->form_data = $data;
	    foreach ($this->elements as $k => $v) {
	    	if($data[$k]==$v['title']){
	    		$_POST[$k] = $data[$k] = "";
	    	}
	    	switch ($v['elm_type']) {
	    		case FRM_HIDDEN :
	    			$this->elements[$k]['value'] = $data[$k];
	    			break;
	    		case FRM_DATE :
				case FRM_FLOAT :
				case FRM_NUMBER :
				case FRM_TEXT :
					$this->elements[$k]['value'] = $data[$k];
					$this->elements[$k]['value'] = trim($this->elements[$k]['value']);
					$this->elements[$k]['value'] = stripslashes($this->elements[$k]['value']);
					//if($this->elements[$k]['htmlspecialchars'])
					$this->elements[$k]['value'] = htmlspecialchars($this->elements[$k]['value']);
					$this->elements[$k]['value'] = ereg_replace("\'", "&#39;", $this->elements[$k]['value']);
					$this->elements[$k]['default_value'] = $this->elements[$k]['value'];
					if ($v['required_field'] == 1) $this->set_element_prms($k);
					break;
				case FRM_TEXTAREA :
					$this->elements[$k]['value'] = $data[$k];
					$this->elements[$k]['value'] = trim($this->elements[$k]['value']);
					$this->elements[$k]['value'] = stripslashes($this->elements[$k]['value']);
					//if($this->elements[$k]['htmlspecialchars'])
					$this->elements[$k]['value'] = htmlspecialchars($this->elements[$k]['value']);
					$this->elements[$k]['value'] = ereg_replace("\'", "&#39;", $this->elements[$k]['value']);
					$this->elements[$k]['default_value'] = $this->elements[$k]['value'];
					if ($v['required_field'] == 1) $this->set_element_prms($k);
					break;
				case FRM_HTML :
					$this->elements[$k]['value'] = $data[$k];
					$this->elements[$k]['value'] = ereg_replace("\'", "&#39;", $this->elements[$k]['value']);
					if ($v['required_field'] == 1) $this->set_element_prms($k);
					break;
				case FRM_FILE :
					$column_name = $k;
					$this->elements[$k]['value'] = $_FILES[$k]['name'];
					if(is_uploaded_file($_FILES[$column_name]['tmp_name'])){
						$this->file->remove($data[$k]);
						if($this->uploadFiles==true) $this->elements[$k]['value'] = $this->file->save($_FILES[$column_name]);
					} else 
						$this->elements[$k]['value'] = $data[$k];					
					if ($v['required_field'] == 1) {
						if($_FILES[$column_name]['error']==1 || $_FILES[$column_name]['error']==2 || $_FILES[$column_name]['error']==3 || $_FILES[$column_name]['error']==6){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Per didelis failas.";
						}
						if($_FILES[$column_name]['error']==4){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Klaida įkeliant failą.";
						}
						$this->set_element_prms($k);
						if($_FILES[$column_name]['error']!=0)
							$this->file->remove($this->elements[$k]['value']);
					}
					break;
				case FRM_ICON :
				case FRM_IMAGE :
					if(isset($data['delete_'.$k])&&$data['delete_'.$k]==1){
						$this->img->remove($data[$k]);
						$data[$k] = "";
					}
					$column_name = 'file_'.$k;
					if(is_uploaded_file($_FILES[$column_name]['tmp_name'])){
						$filename_arr = explode(".", $_FILES[$column_name]['name']);
						global $valid_images;
						if(in_array(strtolower($filename_arr[(count($filename_arr)-1)]), $valid_images) && filesize($_FILES[$column_name]['tmp_name'])<$this->max_file_size){
							
							$this->img->resize_params = $v['image_extra'];
							$this->img->remove($data[$k]);
							if($this->uploadFiles==true) 
								$this->elements[$k]['value'] = $this->img->save($_FILES[$column_name]);
								
							/*foreach($v['image_extra'] as $image_extra_key => $image_extra_val){
								if(!is_numeric($this->form_data['resize_width_'.$k.'_'.$image_extra_val['prefix']]) || 
								   !is_numeric($this->form_data['resize_height_'.$k.'_'.$image_extra_val['prefix']])){
								   $this->error = 1;
								   $this->elements[$k]['style'] = $this->error_style;
								}else{
									$this->img->resize_params[$image_extra_key]['size_width'] = $this->form_data['resize_width_'.$k.'_'.$image_extra_val['prefix']];
									$this->img->resize_params[$image_extra_key]['size_height'] = $this->form_data['resize_height_'.$k.'_'.$image_extra_val['prefix']];
								}
							}*/
							$this->img->resize_params = $v['image_extra'];

								
						}else{
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							if(filesize($_FILES[$column_name]['tmp_name'])>=$this->max_file_size)
								$this->elements[$k]['error_message'] = "Per didelis failas.";
							else
								$this->elements[$k]['error_message'] = "Neteisingas paveikslÄ—lio formatas.";
						}
					} else 
						$this->elements[$k]['value'] = $data[$k];
					if(strlen($this->elements[$k]['value'])>0)
						$_POST[$k] = $this->elements[$k]['value'];
						
					if ($v['required_field'] == 1) {
						if($_FILES[$column_name]['error']==1 || $_FILES[$column_name]['error']==2 || $_FILES[$column_name]['error']==3 || $_FILES[$column_name]['error']==6){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Per didelis failas.";
						}
						if($_FILES[$column_name]['error']==4){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Klaida įkeliant failą.";
						}
						$this->set_element_prms($k);
						if($_FILES[$column_name]['error']!=0)
							$this->img->remove($this->elements[$k]['value']);
					}
					break;
				case FRM_SELECT :
					if(strlen($data[$k.'_tmp'])>0){
						$this->elements[$k]['value'] = $data[$k.'_tmp'];
					}else{
						$this->elements[$k]['value'] = $data[$k];
					}
					if ($v['required_field'] == 1) //$this->set_element_prms($k);
					{
						if(strlen($this->elements[$k]['value'])==0 || $this->elements[$k]['value']==0){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['checked'] = 0;
							$this->elements[$k]['error_message'] = "Neteisingai užpildytas laukas";							     
						}						
					}
					break;
				case FRM_CHECKBOX :
					if ($v['required_field'] == 1){
						if(!isset($data[$k])){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['checked'] = 0;
							$this->elements[$k]['error_message'] = "Neteisingai užpildytas laukas";							     
						}else{
							$this->elements[$k]['checked'] = 1;
						}
					} 
					if(isset($data[$k])) $this->elements[$k]['value'] = $data[$k];
					break;
				case FRM_CHECKBOX_GROUP :
					foreach($data[$k] as $s_k=>$s_v){
						$this->elements[$k]['checked'][] = $data[$k][$s_k];
					}
					$this->elements[$k]['value'] = implode("::", $data[$k]);
				//case FRM_SELECT :
					if(empty($this->elements[$k]['value'])&&$this->elements[$k]['required_field']==1){
						$this->elements[$k]['show_error'] = 1;
						$this->elements[$k]['ok'] = 0;
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;
						$this->elements[$k]['error_message'] = "Neteisingai užpildytas laukas";							     
					}
					$_POST[$k] = $this->elements[$k]['value'];
					break;
				case FRM_RADIO :
					$this->elements[$k]['value'] = $data[$k];
					if ($v['required_field'] == 1) //$this->set_element_prms($k);
					{
						if(strlen($this->elements[$k]['value'])==0 || $this->elements[$k]['value']==0){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['checked'] = 0;
							$this->elements[$k]['error_message'] = "Neteisingai užpildytas laukas";							     
						}						
					}
					break;
				case FRM_PASSWORD :
					if($this->elements[$k]['required_field'] == 1){
					    if($data[$k."_1"]==$data[$k."_2"] && strlen($data[$k."_1"])>4){
					        $this->elements[$k]['value'] = ($this->elements[$k]['list_values']['md5']==1?md5($data[$k."_1"]):$data[$k."_1"]);
					    //}elseif(strlen($data[$k."_1"])==0 && strlen($data[$k."_2"])==0){
					    	//$this->elements[$k]['value'] = $data[$k."_1"];
					    	//pae($this->elements[$k]);
					    }else{
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Slaptažodžiai turi sutapti. Ilgis ne mažiau nei 5 simboliai";							     
					    }
				    }else{
					    if($data[$k."_1"]==$data[$k."_2"]){
					        $this->elements[$k]['value'] = ($this->elements[$k]['list_values']['md5']==1?md5($data[$k."_1"]):$data[$k."_1"]);
					    }else{
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Slaptažodžiai turi sutapti. Ilgis ne mažiau nei 5 simboliai";
					    }
				    }
				    $_POST[$k] = $this->elements[$k]['value'];
				    break;
				case FRM_LIST:
					if(!empty($_POST[$k])){
						$new_arr = array();
						$new_arr_ = array();
						foreach($_POST[$k] as $post_key=>$post_val){
							foreach($post_val as $post_i=>$post_v){
								$new_arr[$post_i][$post_key] = $post_v;
							}
						}
						foreach($new_arr as $n_i=>$n_val){
							if($n_val['_OK_']==1){
								$new_arr_[] = $n_val;
							}
						}
						$this->elements[$k]['value'] = $new_arr_;
					}
					break;				    
				case FRM_SUBMIT:

					if($this->elements[$k]['captcha'] == 1){
						include_once(SITEDIR_."extra/securimage.php");
						$captcha_obj = new Securimage();
						if(!$captcha_obj->check($data[$k])){
							$this->elements[$k]['show_error'] = 1;
							$this->elements[$k]['ok'] = 0;
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
							$this->elements[$k]['error_message'] = "Neteisingas saugos kodas";
						}
					}

					break;					
				
			}
			$form_data[$this->elements[$k]['column_name']] = $this->elements[$k]['value'];
		}
	    return $form_data;
	}

	function constructForm($formName) {
	    //pae($this->elements);
	    $form = '';
	    foreach ($this->elements as $k => $v) {
		    
		    $this->tpl[$v['column_name']] = & new template(TPLDIR_."forms/".$v['elm_type'].".tpl");
			
			if(strlen($v['field_html'])>0){
				$this->tpl[$v['column_name']]->source = $v['field_html'];
			}
			
			$this->tpl[$v['column_name']]->setVar('form_content', $form);
			$this->tpl[$v['column_name']]->setVar('form_name', $formName);
			$this->tpl[$v['column_name']]->setVar('lng', $GLOBALS['lng']);
			$this->tpl[$v['column_name']]->setVar('base_url', Config::$val['site_url']);
		    $this->tpl[$v['column_name']]->setVar('config', Config::$val);
		    $this->tpl[$v['column_name']]->setVar('phrases', $GLOBALS['phrases']);
		    $v['extra_params'] = ereg_replace("&quot;", "\"", $v['extra_params']);
		    $v['field_extra_params'] = ereg_replace("&quot;", "\"", $v['field_extra_params']);
		    $v['extra_data'] = ereg_replace("&quot;", "\"", $v['extra_data']);
		    $v['extra_data'] = ereg_replace("&lt;", "<", $v['extra_data']);
		    $v['extra_data'] = ereg_replace("&gt;", ">", $v['extra_data']);
		    
		    if(!isset($this->form_data[$v['column_name']]) && isset($v['default_value']) && strlen($v['value'])==0) $v['value'] = $v['default_value'];
		    switch ($v['elm_type']) {
				case FRM_FILE :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_DATE :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_HTML :
				    $v['value'] = str_replace("'", "&#039;", $v['value']);
					
					include_once(FCKDIR_."fckeditor.php");
					
					$sBasePath = $_SERVER['PHP_SELF'] ;
					
					$fck = new FCKeditor($v['name'], '');
					$fck->Value = $v['value'];
					$fck->ToolbarSet = "Basic";
					$fck->BasePath	= FCKBASEPATH_ ;

					$fck->Config['DlgLnkTargetTab'] = 0;
					$fck->Config['DlgLnkUpload'] = false;
					$fck->Config['DlgAdvancedTag'] = 0;
					$fck->Config['LinkDlgHideTarget'] = true;
					$fck->Config['LinkDlgHideAdvanced'] = true;
					$fck->Config['LinkBrowser'] = false;
					$fck->Config['LinkUpload'] = false;
					
				    $v['editor'] = $fck->CreateHTML();
				    
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
				    break;
				case FRM_ICON :
				case FRM_IMAGE :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $this->tpl[$v['column_name']]->setVar('uploadurl', $this->imgUrl);
				    if(strlen($v['value'])>0 && file_exists($this->imgDir.$v['value'])){
				        //echo file_exists(UPLOADDIR.$v['value']);
				        $this->tpl[$v['column_name']]->setVar('is_img', 1);
				    }
					if((int)$this->php_ini_array['upload_max_filesize']['local_value']<(int)$this->php_ini_array['post_max_size']['local_value']){
						$max_post_file_size = (int)$this->php_ini_array['upload_max_filesize']['local_value']*1024*1024;
					}else{
						$max_post_file_size = (int)$this->php_ini_array['post_max_size']['local_value']*1024*1024;
					}
					$max_post_file_size = ($max_post_file_size>$this->max_file_size?$this->max_file_size:$max_post_file_size);
					$max_post_file_size_val = "$max_post_file_size B";
					$max_post_file_size = $max_post_file_size/1024;
					if($max_post_file_size>=1){ $max_post_file_size_val = "$max_post_file_size Kb"; }
					$max_post_file_size = $max_post_file_size/1024;
					if($max_post_file_size>=1){ $max_post_file_size_val = "$max_post_file_size Mb"; }
					$this->tpl[$v['column_name']]->setVar('max_file_size', $max_post_file_size_val);
				    $form .= $this->tpl[$v['column_name']]->parse();
				    break;
				/*case FRM_RADIO :
				    $this->tpl->setVar('elm', $v);
				    $this->tpl->setVar('style', $this->field_style);
				    $elm_list = $this->elm_list->listItemsByCriteria("element_record_id", $v['id']);
					$this->tpl->setLoop('list', $elm_list);
				    $form .= $this->tpl->parse();					
					break;*/
				case FRM_CHECKBOX :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();					
					break;
				case FRM_TEXTAREA :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_RADIO :
				case FRM_CHECKBOX_GROUP :
				case FRM_SELECT :
				    $arr = explode(" ", $v['extra_params']);
				    if(in_array("multiple", $arr)){
				    	$v['multiple'] = 1;
				    }
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
					
					$elm_list = $this->getSelectItems($v);

					$this->tpl[$v['column_name']]->setLoop('list', $elm_list);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
				    break;
				case FRM_FLOAT :
				case FRM_NUMBER :
				case FRM_TEXT :
				    $v['value'] = isset($v['value'])?$v['value']:"";
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_PASSWORD :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_SEPARATOR :
				case FRM_HIDDEN :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_SUBMIT :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_BUTTON :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_CATEGORIES_TREE :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
					
					include_once(CLASSDIR_."pages.class.php");
					$pages_obj = & new pages();
					
					$elm_list = $pages_obj->loadCategoriesTree(Config::$val['default_page']['katalogas'], $this->elements['id']['value']);
					
					$this->tpl[$v['column_name']]->setVar('categoriesCount', CATEGORIES_COUNT);
					
					$this->tpl[$v['column_name']]->setLoop('list', $elm_list);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $form .= $this->tpl[$v['column_name']]->parse();
					break;
				case FRM_LIST :
					if($v['list_values']['source']=="DB"){
						$mod_obj = $this->registry->modules->create($v['list_values']['module']);
						$table_fields = array();
						foreach($mod_obj->table_fields as $val){
							if($val['elm_type']!=FRM_SUBMIT && $val['elm_type']!=FRM_HIDDEN) $table_fields[] = $val;
						}
						if(!empty($this->elements[$k]['value'])){
							$this->tpl[$v['column_name']]->setLoop('items', $this->elements[$k]['value']);
						}elseif(is_numeric($this->elements['id']['value']) && $this->elements['id']['value']!=0){
							$this->tpl[$v['column_name']]->setLoop('items', $mod_obj->getItemsByParams(array('category_id'=>$this->elements['id']['value'])));
						}
						$this->tpl[$v['column_name']]->setFastLoop('fields', $table_fields);
					    $this->tpl[$v['column_name']]->setVar('elm', $v);
					    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
					    $form .= $this->tpl[$v['column_name']]->parse();
					}
					
					break;					
		    }
		}
		
		$this->tpl_main->setVar('form_content', $form);
		$this->tpl_main->setVar('form_data', $this->formData);
		$this->tpl_main->setVar('form_name', $formName);
		$this->tpl_main->setVar('config', Config::$val);
		$this->tpl_main->setVar('lng', $GLOBALS['lng']);
		$this->tpl_main->setVar('base_url', Config::$val['site_url']);
		
		return $this->tpl_main->parse();

	}

	function getSelectItems($v){
	    $arr = array(); $elm_list = array();
	    //$arr__ = split("}}", $v['list_values']);
	    $v['checked'] = explode("::", $v['value']);
	    if($v['list_values']['source']=="DB"){
		    if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('add_new_item_button', 1);
		    $record_obj = $this->registry->modules->create($v['list_values']['module']);
		    if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('select_list_module', $record_obj->module_info['table_name']);

	    	if(strlen($array_params['get_category'])>0){

	    	}
	    	if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('record_data_id', $this->elements['id']['value']);
	    	
		    if(isset($v['list_values']['parent_id'])&&is_numeric($v['list_values']['parent_id'])){
		    	if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('select_list_parent_id', $v['list_values']['parent_id']);
		    	if(strlen($v['list_values']['list_columns'])>0){
		    		$v['list_values']['list_columns'] = explode(",", $v['list_values']['list_columns']);	
		    	}else{
		    		$v['list_values']['list_columns'] = array();
		    	}
		    	//if(count($array_params['list_columns'])==0) $array_params['list_columns'] = array('title');
		    	$elm_list = $record_obj->listItems($v['list_values']['parent_id'], $v['list_values']['is_category']);
		    }
		    
		    $array_relations = $record_obj->getRelations(Config::$val['sb_relations'], $this->elements['id']['value'], $v);
		    foreach($array_relations as $val){
		    	$v['checked'][] = $val['value'];
		    }
		    $n = count($elm_list);
			for($i=0; $i<$n; $i++){
				//if(strlen($elm_list[$i]['value'])==0)
				$elm_list[$i]['value'] = $elm_list[$i]['id'];
				if(in_array($elm_list[$i]['value'], $v['checked'])){
					$elm_list[$i]['checked'] = 1;
				}else{
					$elm_list[$i]['checked'] = 0;
				}
			}

		}elseif($v['list_values']['source']=="CALL"){
		    
		    global $registry;
		    $elm_list = $registry->modules->call($v['list_values']['module'], $v['list_values']['method'], $v['list_values']['params']);
			
		    $n = count($elm_list);
		    for($i=0; $i<$n; $i++){
				//if(strlen($elm_list[$i]['value'])==0)
				$elm_list[$i]['value'] = $elm_list[$i]['id'];
				if(in_array($elm_list[$i]['value'], $v['checked'])){
					$elm_list[$i]['checked'] = 1;
				}else{
					$elm_list[$i]['checked'] = 0;
				}
			}
			
			
		}elseif($v['list_values']['source']=="ARRAY"){
		    global ${$v['list_values']['array']};
		    $arr = ${$v['list_values']['array']};
		    $n = count($arr);
		    foreach($arr as $key=>$val){
				//$arr[$i]['value'] = $arr[$i]['title'];
				if(in_array($arr[$key]['value'], $v['checked'])){
					$arr[$key]['checked'] = 1;
				}else{
					$arr[$key]['checked'] = 0;
				}
				if($arr[$key]['superadmin']!=1){
					$elm_list[] = $arr[$key];
				}
			}
	    }else{		
		    $elm_list = $v['list_values'];
		    $n = count($elm_list);
		    for($i=0; $i<$n; $i++){
				//list($elm_list[$i]['value'], $elm_list[$i]['title']) = explode("||", $arr[$i]);
				if(in_array($elm_list[$i]['value'], $v['checked']) || $elm_list[$i]['checked']==1){
					$elm_list[$i]['checked'] = 1;
				}else{
					$elm_list[$i]['checked'] = 0;
				}
			}
		}
		return $elm_list;
	}


}
?>
