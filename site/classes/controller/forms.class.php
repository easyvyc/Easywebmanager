<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_forms extends controller {
	
	
	function __construct(){
		parent::__construct("forms");
		$this->phrases = $this->registry->controller->phrases->loadPhrases();
	}
	
        function captcha(){
            
            $def_w = $this->registry->lib->simple_captcha->get('width');
            $def_h = $this->registry->lib->simple_captcha->get('height');

//            if($_GET['w']) $this->registry->lib->simple_captcha->set('width', $_GET['w']);
//            if($_GET['h']) $this->registry->lib->simple_captcha->set('height', $_GET['h']);

            $size1 = $_GET['w'] / $def_w;
            $size2 = $_GET['h'] / $def_h;
            
            $this->registry->lib->simple_captcha->set('size', ($size1 < $size2 ? $size1 : $size2));
            
            $this->registry->lib->simple_captcha->set('transparent', $_GET['t']);
            
            // OPTIONAL Change configuration...
            //$captcha->wordsFile = 'words/es.php';
            $this->registry->lib->simple_captcha->set('session_var', 'securimage_code_value');
            $this->registry->lib->simple_captcha->set('imageFormat', 'png');
            $this->registry->lib->simple_captcha->set('lineWidth', 0);
            
            $this->registry->lib->simple_captcha->set('debug', false);
            
            $this->registry->lib->simple_captcha->set('scale', 3);
            $this->registry->lib->simple_captcha->set('blur', true);
            
            $this->registry->lib->simple_captcha->set('resourcesPath', APP_CLASSDIR . 'lib/cool-php-captcha/resources');

            $this->registry->lib->simple_captcha->CreateImage();
            exit;            
            
        }
	
	function process(){
		
		$formid = $this->get['formid'];
		$form_data = $this->mod->loadItem($formid);
		
                $_GET['ajax'] = 1;
                
		if(!empty($_POST)){
			
			$req_arr = explode("::", $form_data['required_fields']);
			
			$return_html = "<script type=\"text/javascript\">top.enableForm('{$form_data['title']}'); top.resetCaptcha(); </script>";
			
			$error = false;
			foreach($req_arr as $val){
                            if($val == '') continue;
                            $value = str_replace("[]", "", $val);
                            $value_esc = str_replace("[]", '\\\[\\\]', $val);
                            if((!$_POST[$value] || $_POST[$value]=='') && $_POST[$value] !== 0 && $_POST[$value] !== '0'){
                                $error = true;
                                $return_html .= "<script type=\"text/javascript\"> if(top.$('form[name={$form_data['title']}] [name=$value_esc]').attr('type')=='checkbox' || top.$('form[name={$form_data['title']}] [name=$value_esc]').attr('type')=='radio'){ top.$('form[name={$form_data['title']}] [name=$value_esc]').each(function(){ top.$(this).parents('label').addClass('err'); }) }else{ top.$('form[name={$form_data['title']}] [name=$val]').addClass('err'); } </script>";
                            }
			}
			if(in_array('captcha', $req_arr)){
                            if(strtolower($_SESSION['securimage_code_value']) != strtolower($_POST['captcha'])){
                                $error = true;
                                $return_html .= "<script type=\"text/javascript\"> top.$('form[name={$form_data['title']}] [name=captcha]').addClass('err'); </script>";
                            }		
			}	
			if($error) return $return_html;
			
			if($form_data['selType']=='mail'){
		
				load_helpers('validation');
				include_once(CLASSDIR."phpmailer.class.php");
				
				$emails = preg_split("/[;,\s]/", $form_data['targetEmailEmails']);
				foreach($emails as $email){		
					if(!valid_email($email)){
				
						$message = date('Y-m-d H:i')."\r\n";
						foreach($data['post'] as $key=>$val){
							if($key!='action' && $key!='submit') $message .= "$key: $val\r\n";
						}
                                                $attachements = array();
						foreach($_FILES as $key=>$val){
                                                    //$mailer->AddAttachment($val['tmp_name'], $val['name']);
                                                    $attachements[] = array('name'=>$val['name'], 'file'=>$val['tmp_name']);
						}
				
						$body = preg_replace("/\<br \/\>/", "", $form_data['targetEmailTemplate']);
				
						$message = "";
						$targetEmailSubject = $form_data['targetEmailSubject'];
						$targetEmailFromemail = $form_data['targetEmailFromemail'];
						$targetEmailFromname = $form_data['targetEmailFromname'];
						foreach($_POST as $key=>$val){
							$body = str_replace("{".$key."}", $val, $body);
							$targetEmailFromemail = str_replace("{".$key."}", $val, $targetEmailFromemail);
							$targetEmailFromname = str_replace("{".$key."}", $val, $targetEmailFromname);
							$targetEmailSubject = str_replace("{".$key."}", $val, $targetEmailSubject);
							$message .= "$key: $val\r\n";
						}
				
						$body = str_replace("{content}", $message, $body);
                                                if(!$body) $body = $message;
                                                
                                                $body = preg_replace("/\{[a-zA-Z0-9_]{1,}\}/", "", $body);
				
                                                $this->registry->lib->email->set('settings', array('content_type'=>'text/plain', 'charset'=>'UTF-8'));
                                                $this->registry->lib->email->send($email, $targetEmailSubject, $body, $targetEmailFromname, $targetEmailFromemail, $attachements);
                                                
                                                
					}
				}
				
				$response_text = $this->phrases['form_send_success'];
		
				
			}
			
			if($form_data['selType']=='database'){
				$data = $_POST;
				$data['isNew'] = 1;
				$data['parent_id'] = 0;
				$data['id'] = 0;
				$data['language'] = $lng;
				
                                $module_name = $form_data['targetDatabaseModule'];
                                $return_id = $this->registry->model->{$module_name}->saveItem($data);
				//$return_id = call_user_func_array(array($form_data['targetDatabaseModule'], "insert"), array($data));
				
				$response_text = $this->phrases['form_saved_success'];
			}
		
			if($form_data['selType']=='custom'){
				
                                $module_name = $form_data['targetCustomModule'];
                                $method_name = $form_data['targetCustomMethod'];
                                $response_text = $this->registry->controller->{$module_name}->{$method_name}($_POST);
				//$response_text = call_user_func_array(array($form_data[''], ), array($_POST));
			}
			
                        // statistikai uzfiksuojam kad kazka atliko
                        $_SESSION['conversion_id'] = 1;
			
			return "<script type=\"text/javascript\"> top.formSuccess('{$form_data['title']}', '$response_text'); </script>";
		
		}
		
		
	}
	
}

?>
